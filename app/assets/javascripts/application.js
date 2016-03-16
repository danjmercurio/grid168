// This is a manifest file that'll be compiled into including all the files listed below.
// Add new JavaScript/Coffee code in separate files in this directory and they'll automatically
// be included in the compiled file accessible from http://example.com/assets/application.js
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// the compiled file.
//
//= require jquery-ui
//= require jquery_ujs
//= require jquery.tablesorter
//= require app_assets
//= require bootstrap
//= require regLink

$(document).ready(function() {

	$('.delete_child').bind('ajax:success', function() {
	    $(this).closest('tr').fadeOut();
	});

	$('.delete_child_div').bind('ajax:success', function() {
		var parent = $(this).parent('div');
		parent.parent('div').fadeOut();
	});

	var isMouseDown = false;
	var isHighlighted = false;
	// display view
	$('#weekly_rate').text(formatCurrency($('#weekly_rate').text()));
	$('#monthly_rate').text(formatCurrency($('#monthly_rate').text()));
	$('#yearly_rate').text(formatCurrency($('#yearly_rate').text()));

	$('#hourly_rate').text(formatCurrency($('#hourly_rate').text()));

	// multiple select cell
	$('table#form_table div')
		.mousedown(function() {
			isMouseDown = true;
			$(this).toggleClass('clicked_cell');
			isHighlighted = $(this).hasClass('clicked_cell');
			if (isHighlighted) {
				$(this).find(">:first-child").val("1");
			} else {
				$(this).find(">:first-child").val("0");
			}
			return false;
		})
		.mouseover(function() {
			if (isMouseDown) {
				$(this).toggleClass('clicked_cell', isHighlighted);
				if ($(this).hasClass('clicked_cell')) {
					$(this).find(">:first-child").val("1");
				} else {
					$(this).find(">:first-child").val("0");
				}
			}
        });

		$(document)
			.mouseup(function() {
				isMouseDown = false;
		});

		// for checkbox 24 hours offer
		$('#all_week').click(function() {
			if ($(this).is(':checked')) {
				$('table.table div').addClass('clicked_cell');
				$('table.table div input').val("1");
			} else {
				$('table.table div').removeClass('clicked_cell');
				$('table.table div input').val("0");
			}
		});

		// for calculate button offer
		$('#calculate').click(function() {
			var subs = removeComma($('#subs').text());
			var total_percent = 0;
			var weekly_hours = 0;
			var weekly_rate = 0;
			var monthly_rate = 0;
			var yearly_rate = 0;
			var hourly_rate = 0;
			var value_per_subscribe = 0;
			// if on sub_channel_offer page
			var dollar_amount;
			if ($('#offer_dollar_amount').val() == null) {
				dollar_amount = $('#sub_channel_offer_dollar_amount').val();
			} else {
				dollar_amount = $('#offer_dollar_amount').val();
			}

			if (parseFloat(dollar_amount) == 0.0) {
				alert("Dollar amount must be inserted\nfor calculation");
			} else {

				$('table.table div').each(function() {
					if ($(this).hasClass('clicked_cell')) {
						var arr = $(this).attr('id').split('_');
						total_percent += parseFloat(arr[arr.length - 1]) * 1000;
						weekly_hours += 0.5;
					}
				});

				// calculate value_per_subscribe
				value_per_subscribe = (total_percent * 	dollar_amount / 1000);

				yearly_rate = (value_per_subscribe * subs).toFixed(2);
				monthly_rate = (yearly_rate / 12).toFixed(2);
				weekly_rate = (monthly_rate / 4).toFixed(2);
				hourly_rate = (weekly_rate / weekly_hours).toFixed(2);

				// display to view
				$('#weekly_hours').text(weekly_hours);
				$('#monthly_hours').text(weekly_hours * 4);
				$('#yearly_hours').text(weekly_hours * 52);
				$('#weekly_rate').text(formatCurrency(weekly_rate));
				$('#monthly_rate').text(formatCurrency(monthly_rate));
				$('#yearly_rate').text(formatCurrency(yearly_rate));

				$('#hourly_rate').text(formatCurrency(hourly_rate));

				// for hidden field
				if ($('#offer_hourly_rate').val() == null) {
					// on sub_channel_offer page
					$('#sub_channel_offer_hourly_rate').val(hourly_rate);
					$('#sub_channel_offer_total_hours').val(weekly_hours);
					$('#sub_channel_offer_weekly_offer').val(weekly_rate);
					$('#sub_channel_offer_monthly_offer').val(monthly_rate);
					$('#sub_channel_offer_yearly_offer').val(yearly_rate);
				} else {
					$('#offer_total_hours').val(weekly_hours);
					$('#offer_weekly_offer').val(weekly_rate);
					$('#offer_monthly_offer').val(monthly_rate);
					$('#offer_yearly_offer').val(yearly_rate);
					$('#offer_hourly_rate').val(hourly_rate);
				}
			}
			return false;
		});

		// for reset button offer
		$('#reset').click(function() {

			// reset view calculation
			$('#weekly_hours').text("0");
			$('#monthly_hours').text("0");
			$('#yearly_hours').text("0");
			$('#weekly_rate').text("0");
			$('#monthly_rate').text("0");
			$('#yearly_rate').text("0");

			$('#hourly_rate').text("0");

			$('#offer_hourly_rate').val("0");
			$('#offer_total_hours').val("0");
			$('#offer_weekly_offer').val("0");
			$('#offer_monthly_offer').val("0");
			$('#offer_yearly_offer').val("0");
			$('#offer_value_per_subscribe').val("0");

			// reset time table
			$('table.table div').removeClass('clicked_cell');
			$('table.table div input').val("0");

			return false;
		});

		// $('#_outlet_id').change(function(){
		// 	window.location.replace("http://"+window.location.hostname + ":" + window.location.port + "/outlets/" + 		this.value);
		// });

		// table sorter
		$('#list_users').tablesorter({
			headers: {
				3: {
					sorter: false
				}
			}
		});

		$('table[id^="list_programmers"]').tablesorter({
			headers: {
				3: {
					sorter: false
				}
			}
        });

		$('table[id^="list_offers"]').tablesorter({
			headers: {
				3: {
					sorter: false
				}
			}
        });

		//programmer table sorter
		$('#table_my_deals').tablesorter({
			headers: {
				9: {
					sorter: false
				}
			}
        });

		// table programmer show sorter
		$('#table_programmer_show').tablesorter({
			headers: {
				5: {
					sorter: false
				}
			}
        });

		// table outlet sorter
		$('#table_outlet').tablesorter({
			headers: {
				5: {
					sorter: false
				}
			}
        });

		// table outlet show sorter
		$('#table_outlet_show').tablesorter({
			headers: {
				3: {
					sorter: false
				}
			}
        });

		//table programmer outlets sorter
		$('#table_programmer_outlet').tablesorter({
			headers: {
				7: {
					sorter: false
				}
			}
        });

		// admin view
		$('#all_deals_table').tablesorter({
			headers: {
				10: { sorter: false }
			},
			sortList: [[0, 0]]
        });

		$('#table_admin').tablesorter({
			headers: { 9: {sorter: false} }
        });

    // Display Devise gem error messages with Bootstrap error notis
    $('#error_explanation').addClass('alert alert-warning');

    // Fade out info-only alerts, don't make the user click to close them
    $('.alert-info').fadeOut(1500);
});

function displayError(){
	alert("Please Create New Programmer first");
}

// for display currency
function formatCurrency(num) {
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
		num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
		cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	num = num.substring(0,num.length-(4*i+3))+','+
	num.substring(num.length-(4*i+3));
	return (((sign)?'':'-') + '$' + num + '.' + cents);
}

// remove comma in number
function removeComma(num) {
	var str = num.replace(/,/g, "");
	return str;
}

// check number
function isInteger(s){
	var i;
	for (i = 0; i < s.length; i++){
		// Check that current character is number.
		var c = s.charAt(i);
		if (((c < "0") || (c > "9"))) return false;
	}
	// All characters are numbers.
	return true;
}
