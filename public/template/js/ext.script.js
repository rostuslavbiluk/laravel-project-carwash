$(function () {
    $('.phone-mask').mask('+7(999)999-99-99');

    $('table#editableTable td').on('change', function(evt, newValue) {
        var servicePriceId = $(this).attr('data-serviceId');
        if (servicePriceId) {
            ajaxUpdate({id: servicePriceId, cost: newValue});
        }
    });
});

function ajaxUpdate(params) {
    $.post("dashboard/profile/services/price/edit", params);
}