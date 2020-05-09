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
        calculate(0, 0);
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
                calculate(0, 0);
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
                calculate(0, 0);
            }
        }
    });

    function calculate(discount_amount, paid_amount) {
        let sub_total = 0;
        let gst = 0;
        let net_total = 0;
        let discount = Number(discount_amount);
        let paid = Number(paid_amount);
        let due =  0;

        $('.amt').each(function () {
            sub_total += Number($(this).html());
        })

        gst = 0.18 * sub_total;
        net_total = gst + sub_total - discount;
        due = net_total - paid_amount;

        $('#sub_total').val(sub_total);
        $('#gst').val(gst);
        $('#discount').val(discount);
        $('#net_total').val(net_total);
        // $('#paid')
        $('#due').val(due);
    }

    $('#discount').keyup(function () {
        let discount = $(this).val();
        calculate(discount, 0);
    })

    $('#paid').keyup(function () {
        let paid = $(this).val();
        let discount = $('#discount').val();
        calculate(discount, paid);
    })
});
