/**
 * Filename: nh-configurations-functions.js
 * Description:
 * User: NINJA MASTER - Mustafa Shaaban
 * Date: 1/18/2022
 */

(function ($) {
    'use strict';

    $.fn.isValid = function () {
        return this[0].checkValidity();
    };

    $.fn.serializeObject = function () {
        let a = {},
            b = function (b, c) {
                let d = a[c.name];
                'undefined' !== typeof d && d !== null ? $.isArray(d) ? d.push(c.value) : a[c.name] = [
                    d,
                    c.value,
                ] : a[c.name] = c.value;
            };
        return $.each(this.serializeArray(), b), a;
    };

})(jQuery);
