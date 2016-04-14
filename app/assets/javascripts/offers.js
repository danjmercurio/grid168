//$("[data-day='0']").each(function() {total = total + parseFloat($(this).data('audience'));});

var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
var calculateRates;
$(document).ready(function () {
    // Initialize jQuery datepicker
    $('.dp').datepicker();

    // After the ready event fires, watch for changes in mvpd subs
    // and OTA subs, and if they are both filled, use those values to autofill total homes
    var totalHomes = $('input#outlet_total_homes');
    var mvpdSubs = $('input#outlet_subs');
    var otaSubs = $('input#outlet_over_air');

    // Add comma delimiters to rate input boxes
    var weeklyOffer = $("#offer_weekly_offer");
    weeklyOffer.val(weeklyOffer.val());
    var monthlyOffer = $('#offer_monthly_offer');
    monthlyOffer.val(monthlyOffer.val());
    var yearlyOffer = $("#offer_yearly_offer");
    yearlyOffer.val(yearlyOffer.val());

    // Make weeklyRate global because it will be used in other contexts
    var weeklyRate;

    // Do all our calculations here
    calculateRates = function () {

        // First, just gather information
        var currencyFactor = $('#offer_dollar_amount').val().stripAndParse();
        var mvpdSubscribers = $('input#outlet_subs').val().stripAndParse();
        var otaHomes = $('input#outlet_over_air').val().stripAndParse();
        var totalHomes = $('input#outlet_total_homes').val().stripAndParse();

        // Get all selected cells
        var selectedCells = $('.clicked');

        // Hours
        var weeklyHours = selectedCells.length / 2;
        var monthlyHours = weeklyHours * 4;
        var yearlyHours = weeklyHours * 52;

        // Compute the weekly sub rate. This is the sum of the audience numbers of all selected cells, times the currency factor
        var sumOfTimePeriods = 0;
        selectedCells.each(function () {
            sumOfTimePeriods += parseFloat($(this).data('audience'));
        });
        weeklySubRate = (sumOfTimePeriods * currencyFactor) / 52;
        var monthlySubRate = (sumOfTimePeriods * currencyFactor) / 12;
        var annualSubRate = (sumOfTimePeriods * currencyFactor);

        // Compute rates from Sub rates
        var yearlyRate = (annualSubRate * totalHomes);
        var monthlyRate = (annualSubRate * totalHomes) / 12;
        weeklyRate = (annualSubRate * totalHomes) / 52;


        // Set the proper values for display elements and hidden elements
        $('#offer_total_hours').val(weeklyHours);

        $('#weekly_hours').text(weeklyHours);
        $('#offer_weekly_hours').val(weeklyHours);
        $('#offer_weekly_offer').val(weeklyRate.toString().toNearestDollar());

        $('#monthly_hours').text(monthlyHours);
        $('#offer_monthly_hours').val(monthlyHours);
        $('#offer_monthly_offer').val(monthlyRate.toString().toNearestDollar());

        $('#yearly_hours').text(yearlyHours);
        $('#offer_yearly_hours').val(yearlyHours);
        $('#offer_yearly_offer').val(yearlyRate.toString().toNearestDollar());

        var hourlyRate = yearlyRate / yearlyHours;

        $('#hourlyRate').text("Hourly Rate: " + hourlyRate.toString().toNearestDollar());
        
        // Insert selected cells into holder input
        var cellHolder = $('#offer_time_cells');
        cellHolder.val('');
        $(selectedCells).each(function () {
            var day = $(this).data('day');
            var time = $(this).data('time');
            // Append something like this: "0-02:00" meaning Monday, 2:00-2:30 to the hidden field
            cellHolder.val(function (i, val) {
                return val + [day, time].join('-') + ',';
            })
        });
        console.log(cellHolder.val());
    };


    // // Populate the rate fields
    // calculateRates();
    // The 'Invert Selection' button
    $('#invert').click(function () {
        $('.cell').each(function () {
            flipSelected(this);
        });
    });
    // The 'Select All' button
    $('#selectAll').click(function () {
        $('.cell').each(function () {
            if (!$(this).hasClass('clicked')) {
                flipSelected(this);
            }
        });
    });
    // The 'Calculate' button
    $('#calculate').click(function () {
        $('.clicked').length > 0 ? calculateRates() : alert('You must select at least one cell.');
    });

    // The 'reset' button
    $('#reset').click(function () {
        $('.offerInput').each(function () {
            $(this).val('');
        });
        $('span.hours').each(function () {
            $(this).text('');
        });
        $('.cell').each(function () {
            if ($(this).hasClass('clicked')) {
                $(this).removeClass('clicked');
            }
        });
    });
    // On form submit (show offer view has no input of type submit)
    $("input[type='submit']").click(function () {
        // Make sure all our calculations are done before we submit
        // This function also updates the cell holder hidden input
        calculateRates();


    });

    $(document).ready(calculateRates);


});
