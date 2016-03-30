var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$(document).ready(function () {
    // Initialize jQuery datepicker
    $('.dp').datepicker();
    // Generic function to invert a cell's select state
    var flipSelected = function (cell) {
        $(cell).hasClass('clicked') ? $(cell).removeClass('clicked') : $(cell).addClass('clicked');
    };
    // Handle selecting and un-selecting
    $(window).mousedown(function () {
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
    $('.cell').click(function () {
        flipSelected(this);
    });
    // On page load, get selected cells from hidden element
    var cellHolder = $('#offer_time_cells');
    var selectedCells = cellHolder.val();
    $.each(selectedCells.split(','), function (index, s) {
        var day = s.split("-")[0];
        var time = s.substr(2);
        console.log(day, time);
        var selector = ".cell[data-day='" + day + "'][data-time='" + time + "']";
        var cell = $(selector);
        flipSelected(cell);
    });
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
    // On form submit
    $("input[type='submit']").click(function () {
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
