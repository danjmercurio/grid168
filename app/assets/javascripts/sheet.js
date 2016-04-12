/**
 * Created by dan on 4/5/16.
 */
// Javascript for the display offers view (financial programming worksheet)

// Do initial calculations and populate fields with this function
var hourRate;
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

    hourRate = yearlyRate / yearlyHours;
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
        return totalAudience.toString().toPercentage();
    };


    $('#morningAudience').text(filterCells("06:00", "10:00"));
    $('#daytimeAudience').text(filterCells("10:00", "16:30"));
    $('#eveningNewsAudience').text(filterCells("16:30", "19:00"));
    $('#localPrimeTimeAudience').text(filterCells("19:00", "20:00"));
    $('#nationalPrimeTimeAudience').text(filterCells("20:00", "23:00"));
    $('#lateNewsAudience').text(filterCells("23:00", "23:30"));
    $('#lateNightAudience').text(filterCells("23:30", "01:00"));
    $('#overnightsAudience').text(filterCells("1:00", "06:00"));

    $('#runningAudienceTotal').text((runningAudienceTotal.toString().toPercentage()));

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

    var morningHours = getTotalHours("06:00", "10:00");
    $('#morningHours').text(morningHours);
    var morningRate = morningHours * hourRate;
    $('#morningRate').text(morningRate.toString().toCurrency());
    var morningWeeklyRate = morningRate * morningHours;
    $('#morningWeeklyRate').text(morningWeeklyRate.toString().toCurrency());

    var daytimeHours = getTotalHours("10:00", "16:30");
    $('#daytimeHours').text(daytimeHours);
    var daytimeRate = daytimeHours * hourRate;
    $('#daytimeRate').text(daytimeRate.toString().toCurrency());
    var daytimeWeeklyRate = daytimeRate * daytimeHours;
    $('#daytimeWeeklyRate').text(daytimeWeeklyRate.toString().toCurrency());

    var eveningNewsHours = getTotalHours("16:30", "19:00");
    $('#eveningNewsHours').text(eveningNewsHours);
    var eveningNewsRate = eveningNewsHours * hourRate;
    $('#eveningNewsRate').text(eveningNewsRate.toString().toCurrency());
    var eveningNewsWeeklyRate = eveningNewsRate * eveningNewsHours;
    $('#eveningNewsWeeklyRate').text(eveningNewsWeeklyRate.toString().toCurrency());

    var localPrimeTimeHours = getTotalHours("19:00", "20:00");
    $('#localPrimeTimeHours').text(localPrimeTimeHours);
    var localPrimeTimeRate = localPrimeTimeHours * hourRate;
    $('#localPrimeTimeRate').text(localPrimeTimeRate.toString().toCurrency());
    var localPrimeTimeWeeklyRate = localPrimeTimeHours * localPrimeTimeRate;
    $('#localPrimeTimeWeeklyRate').text(localPrimeTimeWeeklyRate.toString().toCurrency());

    var nationalPrimeTimeHours = getTotalHours("20:00", "23:00");
    $('#nationalPrimeTimeHours').text(nationalPrimeTimeHours);
    var nationalPrimeTimeRate = nationalPrimeTimeHours * hourRate;
    $('#nationalPrimeTimeRate').text(nationalPrimeTimeRate.toString().toCurrency());
    var nationalPrimeTimeWeeklyRate = nationalPrimeTimeRate * nationalPrimeTimeHours;
    $('#nationalPrimeTimeWeeklyRate').text(nationalPrimeTimeWeeklyRate.toString().toCurrency());

    var lateNewsHours = getTotalHours("23:00", "23:30");
    $('#lateNewsHours').text(lateNewsHours);
    var lateNewsRate = lateNewsHours * hourRate;
    $('#lateNewsRate').text(lateNewsRate.toString().toCurrency());
    var lateNewsWeeklyRate = lateNewsRate * lateNewsHours;
    $('#lateNewsWeeklyRate').text(lateNewsWeeklyRate.toString().toCurrency());

    var lateNightHours = getTotalHours("23:30", "01:00");
    $('#lateNightHours').text(lateNightHours);
    var lateNightRate = lateNightHours * hourRate;
    $('#lateNightRate').text(lateNightRate.toString().toCurrency());
    var lateNightWeeklyRate = lateNightRate * lateNightHours;
    $('#lateNightWeeklyRate').text(lateNightWeeklyRate.toString().toCurrency());

    var overnightsHours = getTotalHours("01:00", "06:00");
    $('#overnightsHours').text(overnightsHours);
    var overnightsRate = overnightsHours * hourRate;
    $('#overnightsRate').text(overnightsRate.toString().toCurrency());
    var overnightsWeeklyRate = overnightsHours * overnightsRate;
    $('#overnightsWeeklyRate').text(overnightsWeeklyRate.toString().toCurrency());

    $('#runningHoursTotal').text(runningHoursTotal);
};

// Calculate on page load (this just happens once)
$(document).ready(recalculate);

// Recalculate any time a form value changes
$('form#displayForm').change(recalculate);