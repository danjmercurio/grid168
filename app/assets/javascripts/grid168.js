/**
 * Created by dan on 4/14/16.
 */
var grid168;
grid168 = (function () {
    var app;
    app = {
        controller: null,
        action: null,
        development: false,
        flash: null,
        initialize: function () {
            // Check for jQuery dependency
            if ($ === "undefined") {
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
            this.development = body.data('development');

            console.log(":controller => " + this.controller + ", :action => " + this.action + ", :development => " + this.development);

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
                    return '$' + Math.round10(this.stripAndParse(), -2).addCommas();
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
                Number.prototype.toPercentage = function () {
                    return (parseFloat(this) * 100).toFixed(2).toString() + '%';
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

                // Holder for flash element
                app.flash = $('.flash');
                var flash = app.flash;

                // If a flash message was rendered, perform its exit animation
                if (app.flash.length > 0) {
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
                    v === "" ? $(this).val("") : $(this).val(v.stripAndParse().toString().addCommas());

                    $(this).blur(function () {
                        var newVal = $(this).val();
                        newVal.length == 0 ? newVal = "" : newVal = newVal.stripAndParse().toString().addCommas();
                        $(this).val(newVal);
                    });
                });
                // Initialize menus and effects

                // Add body-small class if window less than 768px
                if ($(this).width() < 769) {
                    $('body').addClass('body-small');
                } else {
                    $('body').removeClass('body-small');
                }

                // MetsiMenu
                $('#side-menu').metisMenu();

                // Minimalize menu
                $('.navbar-minimalize').click(function () {
                    $("body").toggleClass("mini-navbar");


                });

                // $(".nano").nanoScroller(); (disabled)

                // Panels
                (function ($) {

                    $(function () {
                        $('.panel')
                            .on('panel:toggle', function () {
                                var $this,
                                    direction;

                                $this = $(this);
                                direction = $this.hasClass('panel-collapsed') ? 'Down' : 'Up';

                                $this.find('.panel-body, .panel-footer')[ 'slide' + direction ](200, function () {
                                    $this[ (direction === 'Up' ? 'add' : 'remove') + 'Class' ]('panel-collapsed')
                                });
                            })
                            .on('panel:dismiss', function () {
                                var $this = $(this);

                                if (!!($this.parent('div').attr('class') || '').match(/col-(xs|sm|md|lg)/g) && $this.siblings().length === 0) {
                                    $row = $this.closest('.row');
                                    $this.parent('div').remove();
                                    if ($row.children().length === 0) {
                                        $row.remove();
                                    }
                                } else {
                                    $this.remove();
                                }
                            })
                            .on('click', '[data-panel-toggle]', function (e) {
                                e.preventDefault();
                                $(this).closest('.panel').trigger('panel:toggle');
                            })
                            .on('click', '[data-panel-dismiss]', function (e) {
                                e.preventDefault();
                                $(this).closest('.panel').trigger('panel:dismiss');
                            })
                            /* Deprecated */
                            .on('click', '.panel-actions a.fa-caret-up', function (e) {
                                e.preventDefault();
                                var $this = $(this);

                                $this
                                    .removeClass('fa-caret-up')
                                    .addClass('fa-caret-down');

                                $this.closest('.panel').trigger('panel:toggle');
                            })
                            .on('click', '.panel-actions a.fa-caret-down', function (e) {
                                e.preventDefault();
                                var $this = $(this);

                                $this
                                    .removeClass('fa-caret-down')
                                    .addClass('fa-caret-up');

                                $this.closest('.panel').trigger('panel:toggle');
                            })
                            .on('click', '.panel-actions a.fa-times', function (e) {
                                e.preventDefault();
                                var $this = $(this);

                                $this.closest('.panel').trigger('panel:dismiss');
                            });
                    });

                }(jQuery));

                // // Tooltips (disabled)
                // $(function () {
                //     $('[data-toggle="tooltip"]').tooltip();
                //     $('[data-toggle="popover"]').popover();
                // });

            })();

            // Waves effects
            Waves.attach('.button-wave', ['waves-button', 'waves-light']);
            Waves.init();

            // If there are tables...
            if ($('table').length > 0) {
                // Make sortable tables sort
                $('.sortable').tablesorter();

                // Make filterable tables filter
                $('.filterable').filterTable({
                minRows: 0,
                inputSelector: 'input.filterText',
                autofocus: true, // Not working for some reason? Done manually below
                ignoreColumns: [$('th').length -1] // Always ignore the column at last index
                    // (because it's just the actions menu button)
                });
                // Focus filter element so the user can just start typing
                var f = function() {
                    $('input.filterText').focus();
                };
                f();
                // Bind Tab (key #9) to focus the filter text element
                $('body').keyup(function (e) {
                    if (e.keyCode === 9) {
                        f();
                    }
                });
            }

            // TODO: Perform self tests for show view when in development mode
            if (app.controller === 'offers' && app.action === 'show' && app.development) {
                // app.test.doTests();
            }

            // Add event handlers for zoho contact search forms
            app.zoho.initialize();

            // Controller-specific functionality
            switch (this.controller) {
                case 'offers':
                    if (app.action === 'new' || app.action === 'edit' || app.action === 'show') {
                        // Initialize the jQuery UI date picker
                        $('.dp').datepicker();

                        // Initialize the grid
                        this.grid.paint();

                        // Do the calculations
                        this.calc.doCalc(app.calc.values);

                        // Set a global event handler for the page
                        $('form').change(function () {
                            app.calc.doCalc(app.calc.values);
                        });
                    }
                    if (app.action === 'edit') {
                        $('#copyLinkButton').click(function () {
                            var url = $(this).data('url');
                            window.prompt('Copy to clipboard: Ctrl-C, Enter', url);
                        });
                    }
                    break;
                case 'outlets':
                    if (app.action === 'new' || app.action === 'edit') {
                        // After the ready event fires, watch for changes in mvpd subs
                        // and OTA subs, and if they are both filled, use those values to autofill total homes
                        var totalHomes = $('input#outlet_total_homes');
                        var mvpdSubs = $('input#outlet_subs');
                        var otaSubs = $('input#outlet_over_air');

                        var autoFillTotalHomes = function () {
                            var total, i, j;
                            i = mvpdSubs.val();
                            j = otaSubs.val();

                            if (i && j) {
                                total = (i.stripAndParse() + j.stripAndParse()).addCommas();
                                totalHomes.val(total.addCommas());
                            }

                        };
                        mvpdSubs.blur(autoFillTotalHomes);
                        otaSubs.blur(autoFillTotalHomes);
                    }
                    break;
                case 'programmers':
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
                },
                clear: function () {
                    this.list.each(function () {
                        if ($(this).hasClass('clicked')) {
                            app.grid.toggleCellState(this);
                        }
                    });
                    return this;
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
                // Set event handlers on grid cells to allow them to be selected and deselected
                var cells = app.grid.cells.all().fetch();

                var gridArea = this.getGridContainer();

                var that = this;

                var clickCallback = function (cell) {
                    that.toggleCellState(cell);
                };

                // This causes problems in Safari
                // // jQuery UI's .selectable method
                // $('.gridContainerHeader').selectable({
                //     filter: '.cell',
                //     selecting: function (event, ui) {
                //         clickCallback(ui.selecting);
                //         that.onGridChange();
                //     }
                // });

                cells.each(function () {
                    var cell = this;
                    $(cell).mousedown(function () {
                        clickCallback(cell);
                        that.onGridChange();
                    });
                });

                gridArea.mousedown(function (e) {
                    e.preventDefault();
                    that.onGridChange();
                    cells.mouseenter(function () {
                        clickCallback(this);
                    });
                });

                gridArea.mouseup(function () {
                    that.onGridChange();
                    cells.off('mouseenter');
                });


                // Only the new and edit views have these buttons
                if (app.action === 'edit' || app.action === 'new') {
                    // Set event handlers on buttons
                    $('#invert').click(function () {
                        app.grid.cells.all().fetch().each(function () {
                            clickCallback(this);
                        });
                    });

                    // The 'Select All' button
                    $('#selectAll').click(function () {
                        cells.each(function () {
                            if (!$(this).hasClass('clicked')) {
                                clickCallback(this);
                            }
                        });
                        that.onGridChange();
                    });
                    // The 'Calculate' button
                    $('#calculate').click(function () {
                        that.cells.selected().fetch().length > 0 ? app.calc.doCalc(app.calc.values) : alert('You must select at least one cell.');
                    });

                    // The 'reset' button
                    $('#reset').click(function () {
                        $("div.rate_info input[type='text']").each(function () {
                            $(this).val(0);
                        });
                        app.grid.cells.all().clear();
                    });

                    $('#clear').click(function () {
                        app.grid.cells.all().clear();
                        $("div.rate_info input[type='text']").each(function () {
                            $(this).val('');
                        });
                    });

                    // On form submit (show offer view has no input of type submit)
                    $("input[type='submit']").click(function (e) {
                        // Make sure all our calculations are done before we submit
                        if (app.grid.cells.selected().fetch().length === 0) {
                            e.preventDefault();
                            alert('You must select at least one cell.');
                        } else {
                            app.calc.doCalc(app.calc.values);
                        }
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
                app.calc.doCalc(app.calc.values);

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
            }
        },
        calc: {
            doCalc: function (values) {
                console.log('Caught signal to [re]calculate.');
                var offer = values.offer;
                offer.mvpdSubscribers = $('#mvpdSubscribers').val().stripAndParse();
                offer.otaHomes = $('#otaHomes').val().stripAndParse();
                offer.totalHomes = offer.mvpdSubscribers + offer.otaHomes;


                offer['247mvpdSubEstimate'] = $('#247mvpdSubEstimate').val().stripAndParse();

                var selectedCells = app.grid.cells.selected().fetch();
                if (selectedCells.length < 1) {
                    // If there are no cells selected just set everything to zero and return
                    $("div.rate_info input[type='text']").each(function () {
                        $(this).val(0);
                    });
                    return;
                }

                offer.weeklyHours = this.calculateHoursSum(selectedCells);  // 168 when all cells are selected
                offer.yearlyHours = offer.weeklyHours * 52; // 168 * 52 = 8736 when all cells are selected
                offer.monthlyHours = offer.yearlyHours / 12; // 8736 / 12 when all cells are selected


                var audienceSum = this.calculateAudienceSum(selectedCells);

                var annualSubRate = audienceSum * offer['247mvpdSubEstimate'];
                var weeklySubRate = annualSubRate / 52;
                var monthlySubRate = annualSubRate / 12;

                offer.yearlyRate = annualSubRate * offer.totalHomes;
                offer.monthlyRate = offer.yearlyRate / 12;
                offer.weeklyRate = offer.yearlyRate / 52;

                offer.hourRate = offer.yearlyRate / offer.yearlyHours;
                offer.halfHourRate = offer.hourRate / 2;

                offer.mvpdSubRate = (offer.mvpdSubscribers * offer.yearlyRate) / offer.totalHomes;
                offer.mvpdOtaSubRate = (offer.otaHomes * offer.yearlyRate) / offer.totalHomes;

                // Daypart calculations
                var dayParts = values.dayParts;

                // Initialize values for running sums
                offer.weeklyAudienceSum = 0;
                offer.weeklyRateSum = 0;
                offer.weeklyHoursSum = 0;

                // Daypart-specific calculations
                console.log('Calculating dayparts...');
                var that = this;
                jQuery.each(dayParts, function (dayPartName, dayPart) {
                    var cells = app.grid.cells.selected().dayPart(dayPartName).fetch();

                    // Get the audience sum for the selected cells that fall under this daypart, and add it to the running total for the offer
                    var audienceTemp = that.calculateAudienceSum(cells);
                    offer.weeklyAudienceSum += audienceTemp;
                    dayPart.audience = audienceTemp;

                    dayPart.weeklyRate = (dayPart.audience / audienceSum) * offer.weeklyRate;

                    var hoursTemp = that.calculateHoursSum(cells);
                    offer.weeklyHoursSum += hoursTemp;
                    dayPart.hours = hoursTemp;

                    dayPart.hours === 0 ? dayPart.rate = 0 : dayPart.rate = dayPart.weeklyRate / dayPart.hours;

                    offer.weeklyRateSum += dayPart.weeklyRate;
                });
                
                // Now update the values on the page
                this.updateValues(this.values);

            },
            updateValues: function (values) {
                var offer = values.offer;
                // Begin filling in values
                $('input#totalHomes').val(offer.totalHomes.addCommas());
                $('#totalHomesHero').text(offer.totalHomes.addCommas());
                $('#hourlyRate').val(function () {
                    return offer.hourRate.toCurrency();
                });
                $('#weeklyRate').val(offer.weeklyRate.toCurrency());
                $('#monthlyRate').val(offer.monthlyRate.toCurrency());
                $('#yearlyRate').val(offer.yearlyRate.toCurrency());
                $('#totalHours').val(offer.weeklyHours);
                if (app.action == 'show') {
                    $('#totalHoursHero').text(offer.weeklyHours);
                    $('#hourlyRateHero').text(Math.round10(offer.hourRate, -2).toCurrency());
                    $('#grossMonthlyRateHero').text(offer.monthlyRate.toCurrency().toNearestDollar());
                }

                $('#weeklyHours').val(Math.round10(offer.weeklyHours, -1).addCommas());
                $('#monthlyHours').val(Math.round10(offer.monthlyHours, -1).addCommas());
                $('#yearlyHours').val(Math.round10(offer.yearlyHours, -1).addCommas());

                $('#halfHourRate').val(offer.halfHourRate.toCurrency());

                $('#mvpdSubscriberRate').val(offer.mvpdSubRate.toCurrency());
                $('#mvpdOTASubRate').val(offer.mvpdOtaSubRate.toCurrency());

                $('#247mvpdSubEstimate').val('$' + offer['247mvpdSubEstimate'].toFixed(3).toString());

                // Now the daypart section...
                jQuery.each(this.values.dayParts, function (dayPartName, dayPart) {
                    // Fill in the blanks
                    $('#' + dayPartName + 'Audience').setText(dayPart.audience.toPercentage());
                    $('#' + dayPartName + 'Hours').setText(dayPart.hours);
                    $('#' + dayPartName + 'Rate').setText(dayPart.rate.toCurrency());
                    $('#' + dayPartName + 'WeeklyRate').setText(dayPart.weeklyRate.toCurrency());
                });

                $('#runningAudienceTotal').setText(offer.weeklyAudienceSum.toPercentage());
                $('#runningHoursTotal').setText(offer.weeklyHoursSum);
                $('#runningWeeklyRateTotal').setText(offer.weeklyRateSum.toCurrency());
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
                    "weeklyAudienceSum": 0,
                    "weeklyRateSum": 0,
                    "weeklyHoursSum": 0
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
        },
        test: {
            doTests: function () {
                var failure = false;
                $.each(this.tests, function(index, testObject) {
                   if (!testObject.testFunction()) {
                       failure = true;
                       alert('Test #' + index + ' (' + testObject.name + ') failed.');
                       throw new Error('Test #' + index + ' (' + testObject.name + ') failed.');
                   }
                });
                if (!failure) console.log('All tests passed.');
            },
            tests: [
                // Tests live as objects with name and testFunction attributes in this array.
                // If testFunction returns false, it indicates a failed test. testFunctions should do all comparisons & assertions in their own closures and always return a boolean
                {
                    name: 'Simple test',
                    testFunction: function() {
                        // A placeholder test that always returns true
                        return true;
                    }
                },
                {
                    name: 'Get correct number of selected hours',
                    testFunction: function() {
                        // Get every time cell on the page
                        var allCells = app.grid.cells.all().fetch();
                        // Select every one
                        allCells.each(function() {
                            app.grid.toggleCellState(this);
                        });
                        // The number of hours should equal 168
                        var result1 = (app.calc.calculateHoursSum(app.grid.cells.selected().fetch()) === 168);

                        // De-select all cells
                        app.grid.cells.all().clear();

                        // Hours should equal 0 with no cells selected
                        var result2 = (app.calc.calculateHoursSum(app.grid.cells.selected().fetch()) === 0);

                        // Select just one cell
                        var firstCell = [app.grid.cells.all().fetch()[0]];
                        app.grid.toggleCellState(firstCell);
                        var result3 = (app.calc.calculateHoursSum(app.grid.cells.selected().fetch()) === 0.5);

                        // Unselect the first cell
                        app.grid.cells.all().clear();

                        return result1 && result2 && result3;
                    }
                }, {
                    name: 'Calculate the correct audience sum',
                    testFunction: function() {
                        // Select all cells
                        var cells = app.grid.cells.all().fetch();
                        cells.each(function() {
                            app.grid.toggleCellState(this);
                        });

                        var selected = app.grid.cells.selected().fetch();
                        var result1 = Math.round(app.calc.calculateAudienceSum(selected)) === 1;

                        // Clear all cells
                        app.grid.cells.all().clear();

                        // Select the very first cell
                        var firstCell = [app.grid.cells.all().fetch()[0]];
                        app.grid.toggleCellState(firstCell);
                        // The audience sum of the first cell should be 0.002975
                        var result2 = (app.calc.calculateAudienceSum(app.grid.cells.selected().fetch()) === 0.002975);

                        // Clear all cells
                        app.grid.cells.all().clear();

                        return result1 && result2;
                    }
                }
            ]
        },
        zoho: {
            initialize: function () {
                // Prepare the page for the Zoho contact search. Add event handler on click button
                if ($('#zohoSearch').length === 1) {
                    // If there is a Zoho search button on this page...

                    // Reference to the container, eventual destination of contacts
                    var container = $('#zohoContactsContainer');

                    $('#zohoSearch').click(function () {
                        var searchTerm = $('#zohoSearchTerm').val();
                        var searchBy = $('#zohoSearchBy').val();
                        container.empty();
                        if (!searchTerm || searchTerm === '' || searchTerm.length <= 2) {
                            container.text('You must enter a search term of at least 3 characters');
                        } else {
                            container.text('Loading...');
                            var contacts = app.zoho.getContacts(searchTerm, searchBy);
                        }

                    });
                }
            },
            getContacts: function (searchTerm, searchBy) {
                // Assemble an AJAX request for our Zoho controller
                var container = $('#zohoContactsContainer');
                console.log("Calling Zoho API...");
                var request = $.ajax({
                    url: '/zoho/getContacts',
                    method: 'GET',
                    data: {searchTerm: searchTerm, searchBy: searchBy},
                    dataType: 'json',
                    success: function (data) {
                        container.empty();
                        if (data && data.length > 0) {
                            $.each(data, function (index, element) {
                                var contactBlock = document.createElement('div');

                                $(contactBlock).addClass('contact');
                                $(contactBlock).append("<h2>" + element.first_name + " " + element.last_name + "</h2>");
                                var leftDiv = document.createElement('div');
                                $(leftDiv).addClass('col-sm-6 contact-details');
                                if (element.email) $(leftDiv).append('<span>' + element.email + '</span>');
                                if (element.company) $(leftDiv).append('<span>Company: ' + element.company + '</span>');
                                if (element.media_type) $(leftDiv).append('<span>Media Type: ' + element.media_type + '</span>');
                                if (element.market) $(leftDiv).append('<span>Market: ' + element.market + '</span>');
                                contactBlock.appendChild(leftDiv);

                                var rightDiv = document.createElement('div');
                                $(rightDiv).addClass('col-sm-6');
                                $(rightDiv).css("text-align", "right");

                                // Initialize a button and set data attributes thereon
                                var fillButton = document.createElement('button');
                                $(fillButton).addClass('contactFillButton btn btn-default');
                                $(fillButton).attr('type', 'button');
                                $(fillButton).text('AutoFill');
                                if (element.company) $(fillButton).attr('data-name', element.company);
                                if (element.email) $(fillButton).attr('data-email', element.email);
                                if (element.phone) $(fillButton).attr('data-phone', element.phone);
                                if (element.first_name) $(fillButton).attr('data-first-name', element.first_name);
                                if (element.last_name) $(fillButton).attr('data-last-name', element.last_name);
                                if (element.website) $(fillButton).attr('data-website', element.website);
                                if (element.mvpd_subs) $(fillButton).attr('data-mvpd-subs', element.mvpd_subs);
                                if (element.media_type) $(fillButton).attr('data-media-type', element.media_type);
                                if (element.ota_homes) $(fillButton).attr('data-ota-homes', element.ota_homes);

                                if (element.market) $(fillButton).attr('data-market', element.market.split(',')[0]);


                                // depluralize the current controller (outlets -> outlet)
                                var currentController = app.controller.substr(0, app.controller.length - 1);

                                $(fillButton).click(function () {



                                    // Insert values
                                    $('#' + currentController + '_name').val($(this).attr('data-name'));
                                    $('#' + currentController + '_email').val($(this).attr('data-email'));
                                    $('#' + currentController + '_phone').val($(this).attr('data-phone'));
                                    $('#' + currentController + '_first_name').val($(this).attr('data-first-name'));
                                    $('#' + currentController + '_last_name').val($(this).attr('data-last-name'));
                                    $('#' + currentController + '_website').val($(this).attr('data-website'));

                                    var totalHomes = 0;
                                    if ($(this).attr('data-mvpd-subs')) {
                                        $('#' + currentController + '_subs').val($(this).attr('data-mvpd-subs').addCommas());
                                        totalHomes += parseInt($(this).attr('data-mvpd-subs'));
                                    } else {
                                        $('#' + currentController + '_subs').val('');
                                    }
                                    if ($(this).attr('data-ota-homes')) {
                                        $('#' + currentController + '_over_air').val($(this).attr('data-ota-homes').addCommas());
                                        totalHomes += parseInt($(this).attr('data-ota-homes'));

                                    } else {
                                        $('#' + currentController + '_over_air').val('');
                                    }

                                    if (totalHomes > 0) {
                                        $('#' + currentController + '_total_homes').val(totalHomes.addCommas());
                                    } else {
                                        $('#' + currentController + '_total_homes').val('');
                                    }


                                    var type = $(this).attr('data-media-type');
                                    var typeOption = $("option:contains(" + type + ")").val();

                                    $("#outlet_outlet_type_id").val(typeOption).trigger('change');

                                    // get id of dma option tag
                                    var market = $(this).attr('data-market');
                                    var dmaOption = $("option:contains(" + market  + ")").val();
                                    $("#outlet_dma_id").val(dmaOption).trigger('change');
                                    $('#' + currentController + '_dma_id').val(market);

                                    $("html, body").animate({ scrollTop: 0 }, "slow");
                                    return false;
                                });

                                rightDiv.appendChild(fillButton);
                                contactBlock.appendChild(rightDiv);

                                container.append(contactBlock);
                            });

                        } else {
                            container.append("<b>No results found</b>");
                        }
                    },
                    error: function () {
                        container.empty();
                        container.append("<b>Error: Lost connection to server.</b>");
                    }
                });
            }
        }
    };

    app.initialize();
    return app;
})();
