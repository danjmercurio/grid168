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
                Number.prototype.toCurrency = function () {
                    return this.toString().toCurrency();
                };
                Number.prototype.toNearestDollar = function () {
                    return this.toString().toNearestDollar();
                };

                // jQuery helper for Animate.css
                $.fn.extend({
                    animateCSS: function (animationName) {
                        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                        $(this).addClass('animated ' + animationName).one(animationEnd, function () {
                            $(this).removeClass('animated ' + animationName);
                        });
                    },
                    // Set the text on an input or standard html tag with this one function, rather than val() or text()
                    setText: function (text) {
                        var tagName = this.prop('tagName');
                        if (tagName.toLowerCase() === 'input') {
                            $(this).val(text);
                        } else {
                            $(this).text(text);
                        }
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
                    if (app.action === 'new' || app.action === 'edit' || app.action === 'show') {
                        // Initialize the jQuery UI date picker
                        $('.dp').datepicker();

                        // Initialize the grid
                        this.grid.paint();

                        // Do the calculations
                        this.calc.doCalc();
                    }
                    break;
                case 'outlets':
                    if (app.action === 'new' || app.action === 'edit') {
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
                    this.calc.doCalc();
                    break;

            }
        },
        grid: {
            cellData: "",
            getCellHolder: function () {
                var holder = $('#offer_time_cells');
                if (holder.length === 1) {
                    return holder;
                } else {
                    throw new Error('Cell holder element not found.');
                }
            },
            updateHiddenField: function () {
                // In order for the backend to know which cells are selected on the form submit event, we have to update the hidden field #offer_time_cells
                var holder = this.getCellHolder();
                var selectedCells = this.cells.selected().fetch();
                var that = this;

                // Clear the cell holder element and JS cell holder values
                holder.val('');
                this.cellData = '';
                
                $(selectedCells).each(function () {
                    var day = $(this).data('day');
                    var time = $(this).data('time');

                    // Append something like this: "0-02:00" meaning Monday, 2:00-2:30 to the hidden field
                    that.cellData += [day, time].join('-') + ',';
                });
                holder.val(this.cellData);
            },
            cells: {
                list: null,
                all: function () {
                    this.list = $('.cell');
                    return this;
                },
                selected: function () {
                    this.list = $('.clicked');
                    return this;
                },
                dayPart: function (dayPartName) {
                    var selector = "[data-daypart='" + dayPartName + "']";
                    this.list = this.list.filter(selector);
                    return this;
                },
                fetch: function () {
                    return this.list;
                }
            },
            paint: function () {
                var cellHolder = this.getCellHolder();
                if (cellHolder.length !== 1) {
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

                this.registerEventHandlers();

            },
            registerEventHandlers: function () {
                var gridArea = this.getGridContainer();
                var cells = app.grid.cells.all().fetch();

                var that = this;

                var clickCallback = function (cell) {
                    console.log(cell);
                    that.toggleCellState(cell);

                };

                // TODO: event handler on grid mouseup, etc

                cells.each(function () {
                    var cell = this;
                    $(cell).click(function () {
                        clickCallback(cell);
                        that.onGridChange();
                    });
                });

                // Only the new and edit views have these buttons
                if (app.action === 'edit' || app.action === 'new') {
                    // Set event handlers on buttons
                    $('#invert').click(function () {
                        cells.each(function () {
                            that.toggleCellState(this);

                        });
                        that.updateHiddenField();
                        app.calc.doCalc();
                    });

                    // The 'Select All' button
                    $('#selectAll').click(function () {
                        cells.each(function () {
                            if (!$(this).hasClass('clicked')) {
                                that.toggleCellState(this);
                            }
                        });
                        that.updateHiddenField();
                        app.calc.doCalc();
                    });
                    // The 'Calculate' button
                    $('#calculate').click(function () {
                        that.cells.selected().fetch().length > 0 ? app.calc.doCalc() : alert('You must select at least one cell.');
                    });

                    // The 'reset' button
                    $('#reset').click(function () {
                        $('input').each(function () {
                            $(this).val('');
                        });

                        cells.each(function () {
                            if ($(this).hasClass('clicked')) {
                                $(this).removeClass('clicked');
                            }
                        });
                        app.calc.doCalc();
                    });
                    // On form submit (show offer view has no input of type submit)
                    $("input[type='submit']").click(function () {
                        // Make sure all our calculations are done before we submit
                        app.calc.doCalc();
                    });
                }


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

                // Update the calculations
                app.calc.doCalc();

                // Update the hidden element that holds cell data
                this.updateHiddenField();
            },
            getGridContainer: function () {
                var container = $('.gridContainer');
                if (container.length == 1) {
                    return container;
                } else {
                    throw new Error('Duplicate or missing grid container DOM element.');
                }
            },
        },
        calc: {
            doCalc: function () {
                console.log('Caught signal to recalculate.');
                var offer = this.values.offer;
                offer.mvpdSubscribers = $('#mvpdSubscribers').val().stripAndParse();
                offer.otaHomes = $('#otaHomes').val().stripAndParse();
                offer.totalHomes = offer.mvpdSubscribers + offer.otaHomes;


                offer['247mvpdSubEstimate'] = $('#247mvpdSubEstimate').val().stripAndParse();

                var selectedCells = app.grid.cells.selected().fetch();
                if (selectedCells.length < 1) throw new Error('No cells selected');

                offer.weeklyHours = this.calculateHoursSum(selectedCells);
                offer.monthlyHours = offer.weeklyHours * 4;
                offer.yearlyHours = offer.monthlyHours * 12;

                var audienceSum = this.calculateAudienceSum(selectedCells);

                var annualSubRate = audienceSum * offer['247mvpdSubEstimate'];
                var weeklySubRate = annualSubRate / 52;
                var monthlySubRate = annualSubRate / 12;

                offer.yearlyRate = annualSubRate * offer.totalHomes;
                offer.monthlyRate = offer.yearlyRate / 12;
                offer.weeklyRate = offer.monthlyRate / 4;

                offer.hourRate = offer.yearlyRate / offer.yearlyHours;
                offer.halfHourRate = offer.hourRate / 2;

                offer.mvpdSubRate = offer.yearlyRate / offer.mvpdSubscribers;
                offer.mvpdOtaSubRate = offer.yearlyRate / offer.totalHomes;

                // Daypart calculations
                var dayParts = this.values.dayParts;

                // Initialize values for running sums
                offer.weeklyAudienceSum, offer.weeklyRateSum, offer.weeklyHoursSum = 0;

                // Daypart-specific calculations
                var that = this;
                jQuery.each(dayParts, function (dayPartName, dayPart) {
                    var cells = app.grid.cells.selected().dayPart(dayPartName).fetch();

                    // Get the audience sum for the selected cells that fall under this daypart, and add it to the running total for the offer
                    var audienceTemp = that.calculateAudienceSum(cells);
                    offer.weeklyAudienceSum += audienceTemp;
                    dayPart.audience = audienceTemp;

                    var hoursTemp = that.calculateHoursSum(cells);
                    offer.weeklyHoursSum += hoursTemp;
                    dayPart.hours = hoursTemp;

                    var weeklyRateTemp = dayPart.hours * offer.hourRate;
                    offer.weeklyRateSum += weeklyRateTemp;
                    dayPart.weeklyRate = weeklyRateTemp;
                    dayPart.hours === 0 ? dayPart.rate = 0 : dayPart.rate = dayPart.weeklyRate / dayPart.hours;
                });


                // Now update the values on the page
                this.updateValues(this.values);

            },
            updateValues: function (values) {
                var offer = values.offer;
                // Begin filling in values
                $('#totalHomes').val(offer.totalHomes.addCommas());
                $('#hourlyRate').val(function () {
                    return offer.hourRate.toCurrency();
                });
                $('#weeklyRate').val(offer.weeklyRate.toCurrency());
                $('#monthlyRate').val(offer.monthlyRate.toCurrency());
                $('#yearlyRate').val(offer.yearlyRate.toCurrency());
                $('#totalHours').val(offer.weeklyHours);
                if (app.action == 'show') {
                    $('#totalHoursHero').text(offer.weeklyHours);
                    $('#hourlyRateHero').text(offer.hourRate);
                    $('#grossMonthlyRateHero').text(offer.monthlyRate);
                }

                $('#weeklyHours').val(offer.weeklyHours);
                $('#monthlyHours').val(offer.monthlyHours);
                $('#yearlyHours').val(offer.yearlyHours);

                $('#halfHourRate').val(offer.halfHourRate.toCurrency());

                $('#mvpdSubscriberRate').val(offer.mvpdSubRate);
                $('#mvpdOTASubRate').val(offer.mvpdOtaSubRate);

                $('#247mvpdSubEstimate').val(offer['247mvpdSubEstimate']);

                // Now the daypart section...
                jQuery.each(this.values.dayParts, function (dayPartName, dayPart) {
                    // Fill in the blanks
                    $('#' + dayPartName + 'Audience').setText(dayPart.audience);
                    $('#' + dayPartName + 'Hours').setText(dayPart.hours);
                    $('#' + dayPartName + 'Rate').setText(dayPart.rate);
                    $('#' + dayPartName + 'WeeklyRate').setText(dayPart.weeklyRate);
                });

                $('#runningAudienceTotal').text(offer.weeklyAudienceSum);
                $('#runningHoursTotal').text(offer.weeklyHoursSum);
                $('#runningWeeklyRateTotal').text(offer.weeklyRateSum);
            },
            calculateAudienceSum: function (cells) {
                if (cells.length === 0) return 0;
                var audience = 0;
                cells.each(function () {
                    var temp = parseFloat($(this).data('audience'));
                    if (!temp || temp <= 0 || typeof(temp) != "number") throw new Error('Unable to load audience value from cell: ' + this);
                    audience += temp;
                });
                return audience;
            },
            calculateHoursSum: function (cells) {
                return cells.length / 2;
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
                    "yearlyRate": null,
                    "weeklyAudienceSum": null,
                    "weeklyRateSum": null,
                    "weeklyHoursSum": null
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