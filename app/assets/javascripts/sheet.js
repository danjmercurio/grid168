/**
 * Created by dan on 4/5/16.
 */
// Javascript for the display offers view (financial programming worksheet)

// Do initial calculations and populate fields with this function
var recalculate = function () {
    var mvpdSubscribers = $('#mvpdSubscribers').val().stripAndParse();
    var otaHomes = $('#otaHomes').val().stripAndParse();
    var totalHomes = mvpdSubscribers + otaHomes;
    $('#totalHomes').val(totalHomes.toString().addCommas());

    var yearlyRate = $('#yearlyRate').val().stripAndParse();
    var yearlyHours = $('#yearlyHours').val().stripAndParse();

    var hourRate = yearlyRate / yearlyHours;
    $('#hourRate').val(hourRate.toString().toCurrency());

    var halfHourRate = hourRate / 2;
    $('#halfHourRate').val(halfHourRate.toString().toCurrency());

    var mvpdSubscriberRate = yearlyRate / mvpdSubscribers;
    $('#mvpdSubscriberRate').val(mvpdSubscriberRate.toString().toCurrency());

    var mvpdOTASubRate = yearlyRate / totalHomes;
    $('#mvpdOTASubRate').val(mvpdOTASubRate.toString().toCurrency());
};
// Calculate on page load (this just happens once)
$(document).ready(recalculate);

//
// $('input.delimited').blur(function() {
//     $(this).val($(this).val().toString().addCommas());
// });
// Recalculate any time a form value changes
$('form#displayForm').change(recalculate);