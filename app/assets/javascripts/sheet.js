/**
 * Created by dan on 4/5/16.
 */
// Javascript for the display offers view (financial programming worksheet)

// Do initial calculations and populate fields with this function
var recalculate = function () {
    var mvpdSubscribersSelector = $('#mvpdSubscribers');
    mvpdSubscribers =  mvpdSubscribersSelector.val().stripAndParse();
    mvpdSubscribersSelector.val((mvpdSubscribers.toString().addCommas()));

    var otaHomesSelector = $('#otaHomes');
    var otaHomes = otaHomesSelector.val().stripAndParse();
    otaHomesSelector.val(otaHomes.toString().addCommas());

    var totalHomes = mvpdSubscribers + otaHomes;
    $('#totalHomes').text(totalHomes.toString().addCommas());

    var yearlyRate = $('#yearlyRate').val().stripAndParse();
    var yearlyHours = $('#yearlyHours').val().stripAndParse();

    $('#totalHoursHero').text(yearlyHours / 52);

    var hourRate = yearlyRate / yearlyHours;
    $('#hourRate').val(hourRate.toString().toCurrency());

    $('#grossMonthlyRate').text((yearlyRate / 12).toString().toCurrency());

    $('#grossHourlyRate').text(hourRate.toString().toCurrency());

    var halfHourRate = hourRate / 2;
    $('#halfHourRate').val(halfHourRate.toString().toCurrency());

    var mvpdSubscriberRate = yearlyRate / mvpdSubscribers;
    $('#mvpdSubscriberRate').val(mvpdSubscriberRate.toString().toCurrency());

    var mvpdOTASubRate = yearlyRate / totalHomes;
    $('#mvpdOTASubRate').val(mvpdOTASubRate.toString().toCurrency());

    recalculateDayParts();
};

var recalculateDayParts = function () {
    // grid.js must be loaded and executed before this function runs
    // otherwise the audience values will be wrong

    var selectedCells = $('.clicked');

    var runningAudienceTotal = 0;

    var isBetween = function (time, min, max) {
        var p = function (element) {
            return parseFloat(element);
        };
        var time = time.split(':').map(p);
        var min = min.split(':').map(p);
        var max = max.split(':').map(p);

        var decimal = [];
        $.each([time, min, max], function (index, element) {
            if (element[1] === 30) {
                element[0] += 0.5;
            }
            decimal.push(element[0]);
        });

        if (decimal[1] >= decimal[2]) {
            decimal[0] += 12;
            decimal[2] += 24;
        }

        return ((decimal[0] >= decimal[1]) && (decimal[0] < decimal[2]));
    };

    var filterCells = function (min, max) {
        // only add to the total audience percentage if the time falls between min and max
        var totalAudience = 0;
        selectedCells.each(function () {
            var time = $(this).data('time');
            var audience = parseFloat($(this).data('audience')) * 100;
            if (isBetween(time, min, max)) {
                totalAudience += audience;
            }
        });
        runningAudienceTotal += totalAudience;
        return totalAudience;
    };


    $('#morningAudience').text(filterCells("06:00", "10:00").toFixed(2));
    $('#daytimeAudience').text(filterCells("10:00", "16:30").toFixed(2));
    $('#eveningNewsAudience').text(filterCells("16:30", "19:00").toFixed(2));
    $('#localPrimeTimeAudience').text(filterCells("19:00", "20:00").toFixed(2));
    $('#nationalPrimeTimeAudience').text(filterCells("20:00", "23:00").toFixed(2));
    $('#lateNewsAudience').text(filterCells("23:00", "23:30").toFixed(2));
    $('#lateNightAudience').text(filterCells("23:30", "01:00").toFixed(2));
    $('#overnightsAudience').text(filterCells("1:00", "06:00").toFixed(2));

    $('#runningAudienceTotal').text((runningAudienceTotal).toFixed(2));

    var runningHoursTotal = 0;

    var getTotalHours = function (min, max) {
        var hours = 0;
        selectedCells.each(function () {
            var time = $(this).data('time');
            if (isBetween(time, min, max)) {
                hours += 0.5;
            }
        });
        runningHoursTotal += hours;
        return hours;
    };

    $('#morningHours').text(getTotalHours("06:00", "10:00"));
    $('#daytimeHours').text(getTotalHours("10:00", "16:30"));
    $('#eveningNewsHours').text(getTotalHours("16:30", "19:00"));
    $('#localPrimeTimeHours').text(getTotalHours("19:00", "20:00"));
    $('#nationalPrimeTimeHours').text(getTotalHours("20:00", "23:00"));
    $('#lateNewsHours').text(getTotalHours("23:00", "23:30"));
    $('#lateNightHours').text(getTotalHours("23:30", "01:00"));
    $('#overnightsHours').text(getTotalHours("01:00", "06:00"));

    $('#runningHoursTotal').text(runningHoursTotal);
};

// Calculate on page load (this just happens once)
$(document).ready(recalculate);

// Recalculate any time a form value changes
$('form#displayForm').change(recalculate);