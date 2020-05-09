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
                // increase the serial and set it
                let n = 0;
                $('.number').each(function () {
                    $(this).html(++n);
                })
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

    // on quantity change calculate price
    $('#invoice_item').delegate('.qty', 'keyup', function () {
        let qty = $(this);
        let tr = $(this).parent().parent();

        if (isNaN(qty.val())) {
            alert('Please enter valid quantity.');
            qty.val(1);
        } else {
            if ( Number(qty.val()) > Number(tr.find('.tqty').val()) ) {
                alert('Sorry! This much quantity is not available!');
                qty.val(1);
            } else {
                let total_price = Number(qty.val()) * Number(tr.find('.price').val());
                tr.find('.amt').html(total_price);
            }
        }
    });
});
