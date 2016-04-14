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
        var audience = 0;
        cells.each(function () {
            audience += $(this).data('audience');
        });
        return audience;
    };

    var calculateHoursSum = function (cells) {
        var hours = 0;
        cells.each(function () {
            hours += 0.5;
        });
        return hours;
    };
    //
    //
    // $('#morningAudience').text(filterCells("06:00", "10:00"));
    // $('#daytimeAudience').text(filterCells("10:00", "16:30"));
    // $('#eveningNewsAudience').text(filterCells("16:30", "19:00"));
    // $('#localPrimeTimeAudience').text(filterCells("19:00", "20:00"));
    // $('#nationalPrimeTimeAudience').text(filterCells("20:00", "23:00"));
    // $('#lateNewsAudience').text(filterCells("23:00", "23:30"));
    // $('#lateNightAudience').text(filterCells("23:30", "01:00"));
    // $('#overnightsAudience').text(filterCells("1:00", "06:00"));
    //
    // $('#runningAudienceTotal').text((runningAudienceTotal.toString().toPercentage()));
    //
    //
    //
    // var morningHours = getTotalHours("06:00", "10:00");
    // $('#morningHours').text(morningHours);
    // var morningRate = morningHours * hourRate;
    // $('#morningRate').text(morningRate.toString().toNearestDollar());
    // var morningWeeklyRate = morningRate * morningHours;
    // $('#morningWeeklyRate').text(morningWeeklyRate.toString().toNearestDollar());
    //
    // var daytimeHours = getTotalHours("10:00", "16:30");
    // $('#daytimeHours').text(daytimeHours);
    // var daytimeRate = daytimeHours * hourRate;
    // $('#daytimeRate').text(daytimeRate.toString().toNearestDollar());
    // var daytimeWeeklyRate = daytimeRate * daytimeHours;
    // $('#daytimeWeeklyRate').text(daytimeWeeklyRate.toString().toNearestDollar());
    //
    // var eveningNewsHours = getTotalHours("16:30", "19:00");
    // $('#eveningNewsHours').text(eveningNewsHours);
    // var eveningNewsRate = eveningNewsHours * hourRate;
    // $('#eveningNewsRate').text(eveningNewsRate.toString().toNearestDollar());
    // var eveningNewsWeeklyRate = eveningNewsRate * eveningNewsHours;
    // $('#eveningNewsWeeklyRate').text(eveningNewsWeeklyRate.toString().toNearestDollar());
    //
    // var localPrimeTimeHours = getTotalHours("19:00", "20:00");
    // $('#localPrimeTimeHours').text(localPrimeTimeHours);
    // var localPrimeTimeRate = localPrimeTimeHours * hourRate;
    // $('#localPrimeTimeRate').text(localPrimeTimeRate.toString().toNearestDollar());
    // var localPrimeTimeWeeklyRate = localPrimeTimeHours * localPrimeTimeRate;
    // $('#localPrimeTimeWeeklyRate').text(localPrimeTimeWeeklyRate.toString().toNearestDollar());
    //
    // var nationalPrimeTimeHours = getTotalHours("20:00", "23:00");
    // $('#nationalPrimeTimeHours').text(nationalPrimeTimeHours);
    // var nationalPrimeTimeRate = nationalPrimeTimeHours * hourRate;
    // $('#nationalPrimeTimeRate').text(nationalPrimeTimeRate.toString().toNearestDollar());
    // var nationalPrimeTimeWeeklyRate = nationalPrimeTimeRate * nationalPrimeTimeHours;
    // $('#nationalPrimeTimeWeeklyRate').text(nationalPrimeTimeWeeklyRate.toString().toNearestDollar());
    //
    // var lateNewsHours = getTotalHours("23:00", "23:30");
    // $('#lateNewsHours').text(lateNewsHours);
    // var lateNewsRate = lateNewsHours * hourRate;
    // $('#lateNewsRate').text(lateNewsRate.toString().toNearestDollar());
    // var lateNewsWeeklyRate = lateNewsRate * lateNewsHours;
    // $('#lateNewsWeeklyRate').text(lateNewsWeeklyRate.toString().toNearestDollar());
    //

    //
    // var overnightsHours = getTotalHours("01:00", "06:00");
    // $('#overnightsHours').text(overnightsHours);
    // var overnightsRate = overnightsHours * hourRate;
    // $('#overnightsRate').text(overnightsRate.toString().toNearestDollar());
    // var overnightsWeeklyRate = overnightsHours * overnightsRate;
    // $('#overnightsWeeklyRate').text(overnightsWeeklyRate.toString().toNearestDollar());
    //
    // $('#runningHoursTotal').text(runningHoursTotal);
    //
    // var averageHourRate = $('#weeklyRate').val().stripAndParse() / runningHoursTotal;
    // $('#weeklyRateTotal').text(averageHourRate.toString().toNearestDollar());

    var dayParts = {
        "morning": {
            start: "06:00",
            end: "10:00",
            color: "255, 0, 0, 0.5",
            audience: null,
            hours: null,
            rate: null,
            weeklyRate: null
        },
        "daytime": {
            start: "10:00",
            end: "16:30",
            color: "82, 255, 0, 0.5",
            audience: null,
            hours: null,
            rate: null,
            weeklyRate: null
        },
        "eveningNews": {
            start: "16:30",
            end: "19:00",
            color: "0, 245, 255, 0.5",
            audience: null,
            hours: null,
            rate: null,
            weeklyRate: null
        },
        "localPrimeTime": {
            start: "19:00",
            end: "20:00",
            color: "255, 0, 235, 0.5",
            audience: null,
            hours: null,
            rate: null,
            weeklyRate: null
        },
        "nationalPrimeTime": {
            start: "20:00",
            end: "23:00",
            audience: null,
            hours: null,
            rate: null,
            weeklyRate: null
        },
        "lateNews": {
            start: "23:00",
            end: "23:30",
            audience: null,
            hours: null,
            rate: null,
            weeklyRate: null
        },
        "lateNight": {
            start: "23:30",
            end: "01:00",
            audience: null,
            hours: null,
            rate: null,
            weeklyRate: null
        },
        "overnights": {
            start: "01:00",
            end: "06:00",
            audience: null,
            hours: null,
            rate: null,
            weeklyRate: null
        }
    };

    var selectedCells = $('.clicked');

    jQuery.each(dayParts, function (dayPartName, dayPart) {
        // First just get all of the selected cells corresponding to the current daypart. This should never be empty.
        var selected = getSelectedDayPartCells(dayPartName);
        if (selected.length == 0) throw new Error('Unable to find all Daypart cells. Did the document load completely?');

        // Do some calculations
        dayPart.audience = calculateAudienceSum(selected);
        dayPart.hours = calculateHoursSum(selected);
        dayPart.rate = dayPart.hours * hourRate;
        dayPart.weeklyRate = dayPart.rate * dayPart.hours;

        // Fill in the blanks
        $('#' + dayPartName + 'Audience').text(dayPart.audience.toString().toPercentage());
        $('#' + dayPartName + 'Hours').text(dayPart.hours);
        $('#' + dayPartName + 'Rate').text(dayPart.rate.toString().toNearestDollar());
        $('#' + dayPartName + 'WeeklyRate').text(dayPart.weeklyRate.toString().toNearestDollar());

    });
};

// Calculate on page load (this just happens once)
$(document).ready(recalculate);

// Recalculate any time a form value changes
$('form#displayForm').change(recalculate);
