// This is a manifest file that'll be compiled into including all the files listed below.
// Add new JavaScript/Coffee code in separate files in this directory and they'll automatically
// be included in the compiled file accessible from http://example.com/assets/application.js
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// the compiled file.
//
//= require jquery
//= require jquery_ujs
//= require jquery-ui
//= require bootstrap-sprockets
//= require jquery-tablesorter
//= require tables
//= require select2
//= require vanilla-masker.min
// Given a string, return the string as a float with no commas or dollar signs
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
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    return numberWithCommas(parseFloat(this)).toString();
};
String.prototype.toPercentage = function () {
    return Math.round10(parseFloat(this), -2).toString() + '%';

};
String.prototype.toNearestDollar = function() {
    return '$' + Math.round(this.stripAndParse()).toString().addCommas();
};
// Input masks

// jQuery helper for Animate.css
$.fn.extend({
    animateCSS: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $(this).addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});

var onDocumentReady = function() {
// Selector for flash message DOM element
    var flash = $('.flash');

    // Style all select tags with select2 CSS
  $('select').select2();

  // If a flash message was rendered, perform its exit animation
  if (flash.length > 0) {
    // If there was a flash, define this but don't call it (yet)
    var bounceOut = function() {
      flash.fadeOut(1000);
    };
    // Bounce in from left
    flash.animateCSS('bounceInLeft');
    flash.show();
    var flashTimeOut = window.setTimeout(bounceOut, 1500);
  }
};

$(document).ready(onDocumentReady);
