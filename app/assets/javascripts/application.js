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
// Given a string, return the string as a float with no commas or dollar signs
String.prototype.stripAndParse = function () {
    return parseFloat(this.split(',').join('').split('$').join(''));
};
String.prototype.toCurrency = function () {
    return '$' + this.toString();
};
String.prototype.addCommas = function () {
    return parseFloat(this).toLocaleString().toString();
};

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
