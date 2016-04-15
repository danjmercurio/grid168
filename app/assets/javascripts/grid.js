/**
 * Created by dan on 4/5/16.
 */
// Javascript for the grid used on new offer, edit offer, and display offer pages
// Generic function to invert a cell's select state
var flipSelected = function (cell) {
    // If the cell is clicked, apply its special coloring based on its dayPart attribute, and vice versa if it is not
    var cell = $(cell);
    var dayPart = cell.data('daypart');
    if (cell.hasClass('clicked')) {
        cell.removeClass('clicked');
        cell.removeClass(dayPart);
    } else {
        cell.addClass('clicked');
        cell.addClass(dayPart);
    }
};
var logAndFlip = function (cell) {
    var day = $(cell).data('day');
    var time = $(cell).data('time');
    console.log(day, time);
    // Change the cell's state
    flipSelected(cell);
};

    $(document).ready(function () {

        // On page load, get selected cells from hidden element
        var cellHolder = $('#offer_time_cells');
        cellHolder.length > 0 ? console.log('Found cell holder element input#offer_time_cells') : alert('Error: Selected cells could not be retrieved from the database.');
        var selectedCells = cellHolder.val();

        // Remove trailing comma
        if (selectedCells[selectedCells.length - 1] === ',') selectedCells = selectedCells.substr(0, selectedCells.length - 1);

        // For each cell...
        $.each(selectedCells.split(','), function (index, s) {
            var day = s.split("-")[0];
            var time = s.substr(2);
            console.log(day, time);
            var selector = ".cell[data-day='" + day + "'][data-time='" + time + "']";
            // Flip state of all selected cells so the database value of cells is represented accurately on the page
            var cell = $(selector)[0];
            flipSelected(cell);
        });

        // Register event handlers to handle selecting and un-selecting
        var gridArea = $('.gridContainer');
        var cells = $('.cell');
        cells.mousedown(function () {
            logAndFlip(this);
        });
        gridArea.mousedown(function (e) {
            recalculate();
            e.preventDefault();

            cells.mouseenter(function () {
                logAndFlip(this);
            });
        });

        gridArea.mouseup(function () {
            recalculate();
            cells.off('mouseenter');
        });

        // $('.cell').mousedown(function () {
        //     flipSelected(this);
        // });

        // Finally, calculate all the rates and update inputs and spans with values
        // calculateRates();
    });