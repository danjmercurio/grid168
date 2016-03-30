var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$(document).ready(function () {
    // Initialize jQuery datepicker
    $('.dp').datepicker();
    // Generic function to invert a cell's select state
    var flipSelected = function (cell) {
        $(cell).hasClass('clicked') ? $(cell).removeClass('clicked') : $(cell).addClass('clicked');
    };
    // Do all our calculations here
    var calculateRates = function () {
        var hourlyRate = parseFloat($('#offer_dollar_amount').val());
        var selected = $('.clicked');
        var numSelected = selected.length;
        var weeklyHours = numSelected / 2;
        $('#offer_total_hours').val(weeklyHours);
        $('#weekly_hours').text(weeklyHours);
        $('#offer_weekly_hours').val(weeklyHours.toString());
        var weeklyOffer = weeklyHours * hourlyRate;
        $('#offer_weekly_offer').val(weeklyOffer.toString());
        var monthlyHours = weeklyHours * 4;
        $('#monthly_hours').text(monthlyHours);
        $('#offer_monthly_hours').val(monthlyHours.toString());
        var monthlyOffer = monthlyHours * hourlyRate;
        $('#offer_monthly_offer').val(monthlyOffer.toString());
        var yearlyHours = monthlyHours * 12;
        $('#yearly_hours').text(yearlyHours);
        $('#offer_yearly_hours').val(yearlyHours.toString());
        var yearlyOffer = yearlyHours * hourlyRate;
        $('#offer_yearly_offer').val(yearlyOffer.toString());
    };
    // Handle selecting and un-selecting
    $('.gridContainer').mousedown(function (e) {
        e.preventDefault();
        $('.cell').mouseenter(function () {
            var day = $(this).data('day');
            var time = $(this).data('time');
            console.log(day, time);
            // Change the cell's state
            flipSelected(this);
        });
    });
    $(window).mouseup(function () {
        $('.cell').off('mouseenter');
    });
    $('.cell').mousedown(function () {
        flipSelected(this);
    });
    // On page load, get selected cells from hidden element
    var cellHolder = $('#offer_time_cells');
    var selectedCells = cellHolder.val();
    // Remove trailing comma
    selectedCells = selectedCells.substr(0, selectedCells.length - 1);
    $.each(selectedCells.split(','), function (index, s) {
        var day = s.split("-")[0];
        var time = s.substr(2);
        console.log(day, time);
        var selector = ".cell[data-day='" + day + "'][data-time='" + time + "']";
        var cell = $(selector);
        flipSelected(cell);
    });
    // Populate the rate fields
    calculateRates();
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
        calculateRates();
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
    // On form submit
    $("input[type='submit']").click(function () {
        // Make sure all our calculations are done
        calculateRates();
        // Select our hidden field to store selected cells
        var cellHolder = $('#offer_time_cells');
        // First, clear the value of cellHolder
        cellHolder.val('');
        // Get  all selected cells
        var selected = $('.clicked');
        $(selected).each(function () {
            var day = $(this).data('day');
            var time = $(this).data('time');
            // Append something like this: "0-02:00" meaning Monday, 2:00-2:30 to the hidden field
            cellHolder.val(function (i, val) {
                return val + [day, time].join('-') + ',';
            })
        });
        console.log(cellHolder.val());
    });

});
