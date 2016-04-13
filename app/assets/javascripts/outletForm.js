/**
 * Created by dan on 4/5/16.
 */
$(document).ready(function () {
    // After the ready event fires, watch for changes in mvpd subs
    // and OTA subs, and if they are both filled, use those values to autofill total homes
    var totalHomes = $('input#outlet_total_homes');
    var mvpdSubs = $('input#outlet_subs');
    var otaSubs = $('input#outlet_over_air');

    // Our function to get the field values, check their contents, and finally do the autofill
    var getCheckFill = function () {
        // First, add comma delimiters to mvpd subs and ota subs if they are non-empty
        if (!!mvpdSubs.val()) mvpdSubs.val(mvpdSubs.val().stripAndParse().toString().addCommas());
        if (!!otaSubs.val()) otaSubs.val(otaSubs.val().stripAndParse().toString().addCommas());

        if (!!mvpdSubs.val() && !!otaSubs.val()) {
            var fillValue = mvpdSubs.val().stripAndParse() + otaSubs.val().stripAndParse();
            totalHomes.val(fillValue.toString().addCommas());
        }
    };

    // Register event handlers
    mvpdSubs.blur(getCheckFill);
    otaSubs.blur(getCheckFill);

});
