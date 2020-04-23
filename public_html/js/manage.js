$(document).ready(function () {
    let DOMAIN = 'http://localhost/inventory/public_html/';
    manageCategory();
    function manageCategory() {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: { manageCategory: 1 },
            success: data => {
                console.log(data);
                $('#get_category').html(data);
            }
        });
    }
});