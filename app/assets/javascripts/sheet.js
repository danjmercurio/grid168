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
    $(yearlyRate).val(0);
    var yearlyHours = $('#yearlyHours').val().stripAndParse();

    $('#totalHoursHero').text(yearlyHours / 52);

    hourRate = yearlyRate / yearlyHours;
    $('#hourRate').val(hourRate.toString().toCurrency());

    $('#grossMonthlyRate').text((yearlyRate / 12).toString().toNearestDollar());

    $('#grossHourlyRate').text(hourRate.toString().toNearestDollar());

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

    console.log('Beginning Dayparts calculations...');

    var getDayPartCells = function (name) {
        return $(".cell[data-daypart=" + name + "]");
    };

    var getSelectedDayPartCells = function (name) {
        return $(".clicked[data-daypart=" + name + "]");
    };


    var runningAudienceTotal = 0;
    var runningHoursTotal = 0;
    var runningWeeklyRateTotal = 0;
    var runningAverageRateTotal = 0;

    // only add to the total audience percentage if the time falls between min and max
    var totalAudience = 0;



    var filterCells = function (min, max) {
        // Return true if this cell is between min and max hours irrespective of the day
        var isBetween = function (time, min, max) {
            if (time === min) return true;

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
                decimal[0] += 24;
                decimal[2] += 24;
            }

            return ((decimal[0] >= decimal[1]) && (decimal[0] < decimal[2]));
        };

        var cells = [];

        $('.cell').each(function () {
            var time = $(this).data('time');
            var audience = parseFloat($(this).data('audience')) * 100;
            if (!audience || typeof(audience) != "number") {
                throw new Error('Unable to load audience proportion value from cell');
            }
            if (!time || typeof(time) != "string") {
                throw new Error('Unable to load time value from cell');
            }
            if (isBetween(time, min, max)) {
                cells.push(this);
            }
        });
        return cells;
    };

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

    var calculateAudienceSum = function (cells) {
        if (cells.length === 0) return 0;
        var audience = 0;
        cells.each(function () {
            var temp = parseFloat($(this).data('audience')) * 100;
            if (!temp || temp <= 0 || typeof(temp) != "number") throw new Error('Unable to load audience value from cell');
            audience += temp;
            runningAudienceTotal += temp;
        });
        return audience;
    };

    var calculateHoursSum = function (cells) {
        if (cells.length === 0) return 0;
        var hours = 0;
        cells.each(function () {
            hours += 0.5;
        });
        runningHoursTotal += hours;
        return hours;
    };

    
    var selectedCells = $('.clicked');

    jQuery.each(dayParts, function (dayPartName, dayPart) {
        // First just get all of the selected cells corresponding to the current daypart. This should never be empty.
        var selected = getSelectedDayPartCells(dayPartName);

        // Do some calculations
        dayPart.audience = calculateAudienceSum(selected);
        dayPart.hours = calculateHoursSum(selected);
        dayPart.weeklyRate = dayPart.hours * hourRate;

        dayPart.hours === 0 ? dayPart.rate = 0 : dayPart.rate = dayPart.weeklyRate / dayPart.hours;
        runningWeeklyRateTotal += dayPart.weeklyRate;


    });

    $('#runningAudienceTotal').text(runningAudienceTotal.toString().toPercentage());
    $('#runningHoursTotal').text(runningHoursTotal);
    $('#totalHoursHero').text(runningHoursTotal.toString());
    $('#monthlyRate').val((runningWeeklyRateTotal * 4).toString().toCurrency());
    $('#weeklyRate').val(runningWeeklyRateTotal.toString().toCurrency());
    $('#yearlyRate').val((runningWeeklyRateTotal * 52).toString().toCurrency());
    $('#grossMonthlyRate').text((runningWeeklyRateTotal * 4).toString().toCurrency().toNearestDollar());
    $('#runningWeeklyRateTotal').text(runningWeeklyRateTotal.toString().toCurrency());
    var runningAverageRateTotal = $('#weeklyRate').val().stripAndParse() / runningHoursTotal;
    $('#runningAverageRateTotal').text(runningAverageRateTotal.toString().toCurrency());
};

// Calculate on page load (this just happens once)
$(document).ready(recalculate);

// Recalculate any time a form value changes
$('form#displayForm').change(recalculate);
