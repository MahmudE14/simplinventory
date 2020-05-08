$(document).ready(function () {
    let DOMAIN = 'http://localhost/inventory/public_html/';

    addNewRow();

    $('#add').on('click', addNewRow);

    //  add new row in make order list
    function addNewRow() {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: {getNewOrderItem: 1},
            success: data => {
                $('#invoice_item').append(data);
            }
        });
    }

    // remove row from make order list
    $('#remove').on('click', function () {
        $('#invoice_item').children('tr:last').remove();
    })

    // on select product
    $('#invoice_item').delegate('.pid', 'change', function () {
        let pid = $(this).val();
        let tr = $(this).parent().parent()

        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            dataType: 'json',
            data: {
                getPriceAndQty: 1, 
                id: pid
            },
            success: data => {
                console.log(data);
                tr.find('.tqty').val(data['product_stock']);
                tr.find('.pro_name').val(data['product_name']);
                tr.find('.qty').val(1);
                tr.find('.price').val(data['product_price']);
                let amount = tr.find('.qty').val() * tr.find('.price').val();
                tr.find('.amt').html(amount);
            }
        });
    });
});
