/**
 * Created by dan on 4/14/16.
 */
var grid168;
grid168 = (function () {
    var app;
    app = {
        controller: null,
        action: null,
        flash: null,
        initialize: function () {
            console.log(this);
            if (typeof($) === "undefined") {
                throw new Error('$ is not defined. Did jQuery load?');
            }
            $(document).ready(this.onDocumentReady());
        },
        onDocumentReady: function () {
            console.log("Document ready event fired.");

            // Get the current controller and action
            var body = $('body');
            this.controller = body.data('controller');
            this.action = body.data('action');

            console.log(":controller => " + this.controller + ", :action => " + this.action);

            // Stuff we need to do for every page
            (function () {
                // Define some of our own methods on String and Number prototypes
                (function () {
                    /**
                     * Decimal adjustment of a number.
                     *
                     * @param {String}  type  The type of adjustment.
                     * @param {Number}  value The number.
                     * @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
                     * @returns {Number} The adjusted value.
                     */
                    function decimalAdjust(type, value, exp) {
                        // If the exp is undefined or zero...
                        if (typeof exp === 'undefined' || +exp === 0) {
                            return Math[type](value);
                        }
                        value = +value;
                        exp = +exp;
                        // If the value is not a number or the exp is not an integer...
                        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
                            return NaN;
                        }
                        // Shift
                        value = value.toString().split('e');
                        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
                        // Shift back
                        value = value.toString().split('e');
                        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
                    }

                    // Decimal round
                    if (!Math.round10) {
                        Math.round10 = function (value, exp) {
                            return decimalAdjust('round', value, exp);
                        };
                    }
                    // Decimal floor
                    if (!Math.floor10) {
                        Math.floor10 = function (value, exp) {
                            return decimalAdjust('floor', value, exp);
                        };
                    }
                    // Decimal ceil
                    if (!Math.ceil10) {
                        Math.ceil10 = function (value, exp) {
                            return decimalAdjust('ceil', value, exp);
                        };
                    }
                })();

                String.prototype.stripAndParse = function () {
                    return parseFloat(this.split(',').join('').split('$').join(''));
                };
                String.prototype.toCurrency = function () {
                    // return '$' + Math.round10(parseFloat(this), -2).toString();
                    return '$' + this.stripAndParse().toFixed(2).toString().addCommas();
                };
                String.prototype.addCommas = function () {
                    return this.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                };
                String.prototype.toPercentage = function () {
                    return Math.round10(parseFloat(this), -2).toString() + '%';

                };
                String.prototype.toNearestDollar = function () {
                    return '$' + Math.round(this.stripAndParse()).toString().addCommas();
                };
                Number.prototype.addCommas = function () {
                    return this.toString().addCommas();
                };

                // jQuery helper for Animate.css
                $.fn.extend({
                    animateCSS: function (animationName) {
                        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                        $(this).addClass('animated ' + animationName).one(animationEnd, function () {
                            $(this).removeClass('animated ' + animationName);
                        });
                    }
                });

                // Style all select tags with select2 CSS
                $('select').select2();

                var flash = $('.flash');
                app.flash = flash;

                // If a flash message was rendered, perform its exit animation
                if (flash.length > 0) {
                    // If there was a flash, define this but don't call it (yet)
                    var bounceOut = function () {
                        flash.fadeOut(1000);
                    };
                    // Bounce in from left
                    flash.animateCSS('bounceInLeft');
                    flash.show();
                    window.setTimeout(bounceOut, 1500);
                }

                // Apply styling and comma delimiters to all form inputs
                $('.delimited').each(function () {
                    var v = $(this).val();
                    v == "" ? $(this).val("") : $(this).val(v.stripAndParse().toString().addCommas());

                    $(this).blur(function () {
                        var newVal = $(this).val();
                        newVal.length == 0 ? newVal = "" : newVal = newVal.stripAndParse().toString().addCommas();
                        $(this).val(newVal);
                    });
                });
            })();

            // Controller-specific functionality
            switch (this.controller) {
                case 'offers':
                    if (this.action === 'new' || this.action === 'edit' || this.action === 'show') {
                        // Initialize the jQuery UI date picker
                        $('.dp').datepicker();

                        // Initialize the grid
                        this.grid.paint();

                        // Do the calculations
                        this.calc.doCalc();

                        // Keep a reference to the app object handy
                        var that = this;

                        // Set event handlers on buttons
                        $('#invert').click(function () {
                            $('.cell').each(function () {
                                that.grid.toggleCellState(this);
                            });
                        });

                        // The 'Select All' button
                        $('#selectAll').click(function () {
                            $('.cell').each(function () {
                                if (!$(this).hasClass('clicked')) {
                                    that.grid.toggleCellState(this);
                                }
                            });
                        });
                        // The 'Calculate' button
                        $('#calculate').click(function () {
                            $('.clicked').length > 0 ? that.calc.doCalc() : alert('You must select at least one cell.');
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
                        });
                    }
                    break;
                case 'outlets':
                    if (this.action === 'new' || this.action === 'edit') {
                        // After the ready event fires, watch for changes in mvpd subs
                        // and OTA subs, and if they are both filled, use those values to autofill total homes
                        var totalHomes = $('input#outlet_total_homes');
                        var mvpdSubs = $('input#outlet_subs');
                        var otaSubs = $('input#outlet_over_air');

                        if (mvpdSubs.length && otaSubs.length) {
                            mvpdSubs.val(mvpdSubs.val().stripAndParse().toString().addCommas());
                            otaSubs.val(otaSubs.val().stripAndParse().toString().addCommas());

                            var doAutoFill = function () {
                                if (!!mvpdSubs.val()) mvpdSubs.val(mvpdSubs.val().stripAndParse().toString().addCommas());
                                if (!!otaSubs.val()) otaSubs.val(otaSubs.val().stripAndParse().toString().addCommas());

                                if (!!mvpdSubs.val() && !!otaSubs.val() && !!totalHomes.val()) {
                                    // Auto-calculate the total homes field if these two fields are both non-empty
                                    var totalHomesSum = mvpdSubs.val().stripAndParse() + otaSubs.val().stripAndParse();
                                    totalHomes.val(totalHomesSum.toString().addCommas());
                                    console.log(totalHomesSum);
                                }
                            };

                            doAutoFill();
                            $('form').change(doAutoFill);
                        }
                    }
                    break;

            }
        },
        grid: {
            cellData: "",
            paint: function () {
                var cellHolder = $('#offer_time_cells');
                if (cellHolder.length !== 1 || cellHolder.val().length === 0) {
                    throw new Error('None or too many cell holder elements found. Make sure there is only one input#offer_time_cells on this page. Cannot continue.');
                } else {
                    console.log('Found cell data. Loading...');
                    var selectedCells = cellHolder.val();
                    // Remove trailing comma if there is one
                    if (selectedCells[selectedCells.length - 1] === ',') selectedCells = selectedCells.substr(0, selectedCells.length - 1);

                    this.cellData = selectedCells;
                }

                // For each cell...
                var that = this;
                $.each(this.cellData.split(','), function (index, s) {
                    var day = s.split("-")[0];
                    var time = s.substr(2);
                    var selector = ".cell[data-day='" + day + "'][data-time='" + time + "']";
                    // Flip state of all selected cells so the database value of cells is represented accurately on the page
                    var cell = $(selector)[0];
                    that.toggleCellState(cell);
                });

                var gridArea = this.getGridContainer();
                var cells = $('.cell');
                cells.mousedown(this.onGridChange);
                gridArea.mousedown(function (e) {
                    e.preventDefault();
                    this.grid.onGridChange();
                    cells.mouseenter(this.onGridChange);
                });

                gridArea.mouseup(function () {
                    this.onGridChange();
                    cells.off('mouseenter');
                });

            },
            toggleCellState: function (cell) {
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
            },
            onGridChange: function () {
                // What to do when the grid is clicked.
                this.calc.doCalc();
            },
            getGridContainer: function () {
                var container = $('.gridContainer');
                if (container.length == 1) {
                    return container;
                } else {
                    throw new Error('Duplicate or missing grid container DOM element.');
                }
            },
            getSelectedCells: function () {
                return $('.clicked');
            },
            getHoursSum: function (cells) {
                if (cells.length === 0) return 0;
                var hours = 0;
                cells.each(function () {
                    hours += 0.5;
                });
                runningHoursTotal += hours;
                return hours;
            },
            getAudienceSum: function (cells) {
                var sum = 0;
                cells.each(function () {
                    sum += parseFloat($(this).data('audience'));
                });
                return sum;
            }
        },
        calc: {
            doCalc: function () {
                console.log('Caught signal to recalculate.');
                var offer = this.values.offer;
                offer.mvpdSubscribers = $('#mvpdSubscribers').val().stripAndParse();
                offer.otaHomes = $('#otaHomes').val().stripAndParse();
                offer.totalHomes = offer.mvpdSubscribers + offer.otaHomes;


                offer['247mvpdSubEstimate'] = $('#247mvpdSubEstimate').val().stripAndParse();

                if (app.action === 'new' || app.action === 'edit') {
                    var selectedCells = app.grid.getSelectedCells();
                    offer.weeklyHours = app.grid.getHoursSum(selectedCells);
                    offer.monthlyHours = offer.weeklyHours * 4;
                    offer.yearlyHours = offer.weeklyHours * 12;
                }
                if (app.action === 'show') {
                    // If we are on the show action of the offers controller, weeklyHours will already have been computed
                    offer.weeklyHours = $('#weeklyHours').val();
                    offer.monthlyHours = $('#monthlyHours').val();
                    offer.yearlyHours = $('#yearlyHours').val();
                }


                // Begin filling in values
                $('#totalHomes').val(offer.totalHomes.addCommas());
                //


            },
            values: {
                offer: {
                    "mvpdSubscribers": null,
                    "otaHomes": null,
                    "totalHomes": null,
                    "247mvpdSubEstimate": null,
                    "hourRate": null,
                    "mvpdSubRate": null,
                    "mvpdOtaSubRate": null,
                    "weeklyHours": null,
                    "monthlyHours": null,
                    "yearlyHours": null,
                    "weeklyRate": null,
                    "monthlyRate": null,
                    "yearlyRate": null
                },
                dayParts: {
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
                }
            }
        }
    };

    app.initialize();
    return app;
})();