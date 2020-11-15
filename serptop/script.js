$(document).ready(function () {
    $('.btn-buy').click(function (e) {
        var parameters = {
            PARAMS: {
                id: $(this).attr('data-id'),
                action: "add2Basket",
            }
        };

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType: 'json',
            data: parameters,
            success: function (data) {
                if (data['SUCCESS'] === true) {
                    $("#basket_body").html("");

                    data['BASKET'].forEach(function (item, i, arr) {
                        let htmlElement = "<tr>"
                            + "<td>" + item['NAME'] + "</td>"
                            + "<td>" + item['PRICE_BY_ONE'] + "</td>"
                            + "<td>" + item['QUANTITY'] + "</td>"
                            + "<td>" + item['ALL_PRICE'] + "</td>"
                            + "</tr>";
                        $("#basket_body").append(htmlElement);
                    });
                }
            }
        });
    });
});
