/**
 * Created by dan on 4/5/16.
 */
$(document).ready(function () {
    // After the ready event fires, watch for changes in mvpd subs
    // and OTA subs, and if they are both filled, use those values to autofill total homes
    var totalHomes = $('input#outlet_total_homes');
    var mvpdSubs = $('input#outlet_subs');
    var otaSubs = $('input#outlet_over_air');

    mvpdSubs.val(mvpdSubs.val().stripAndParse().toString().addCommas());
    otaSubs.val(otaSubs.val().stripAndParse().toString().addCommas());

    var doAutoFill = function() {
        if (!!mvpdSubs.val()) mvpdSubs.val(mvpdSubs.val().stripAndParse().toString().addCommas());
        if (!!otaSubs.val()) otaSubs.val(otaSubs.val().stripAndParse().toString().addCommas());

        if (!!mvpdSubs.val() && !! otaSubs.val()) {
            // Auto-calculate the total homes field if these two fields are both non-empty
            var totalHomesSum = mvpdSubs.val().stripAndParse() + otaSubs.val().stripAndParse();
            totalHomes.val(totalHomesSum.toString().addCommas());
        }
    };

    doAutoFill();
    $('form').change(doAutoFill);

});
