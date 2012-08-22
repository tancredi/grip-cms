/*globals app */

app.implement(function () {
    'use strict';

    var self = {};

    function hex2rgb (hex) {
        var i, temp, triplets;

        if (hex[0] === "#") {
            hex = hex.substr(1);
        }
        if (hex.length === 3) {
            temp = hex;
            hex = '';
            temp = /^([a-f0-9])([a-f0-9])([a-f0-9])$/i.exec(temp).slice(1);
            for (i = 0; i < 3; i += 1) {
                hex += temp[i] + temp[i];
            }
        }
        triplets = /^([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})$/i.exec(hex).slice(1);

        return [ parseInt(triplets[0],16), parseInt(triplets[1],16), parseInt(triplets[2],16) ];
    }

    function darkenLighten (col, amt) {
        /*jshint bitwise:false */

        var usePound = false, num, r, b, g;

        if (col[0] === "#") {
            col = col.slice(1);
            usePound = true;
        }

        num = parseInt(col, 16);

        r = (num >> 16) + amt;
        if ( r > 255 ) {
           r = 255;
        } else if (r < 0) {
            r = 0;
        }

        b = ((num >> 8) & 0x00FF) + amt;
        if ( b > 255 ) {
           b = 255;
        } else if (b < 0) {
            b = 0;
        }

        g = (num & 0x0000FF) + amt;
        if ( g > 255 ) {
            g = 255;
        } else if ( g < 0 ) {
            g = 0;
        }

        return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16);
    }

    function lighten (col, amt) {
        amt = (amt < 0) ? 0 : amt;
        return darkenLighten(col, amt);
    }

    function darken (col, amt) {
        amt = -amt;
        amt = (amt > 0) ? 0 : amt;
        return darkenLighten(col, amt);
    }

    self.hex2rgb = hex2rgb;
    self.darkenLighten = darkenLighten;
    self.darken = darken;
    self.lighten = lighten;

    return self;
}, [ 'utils', 'color' ], true);
