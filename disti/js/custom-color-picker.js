jQuery(document).ready(function($) {




    $('.color-field').wpColorPicker({
        change: function(event, ui) {
            if ($('#my_custom_mode').val() === 'tints') {
                generateTints(ui.color.toString());
            }
        }
    });

    $('.color-field').on('change', function(event) {
        if ($(this).val() === 'tints') {
            generateTints($('.color-field').wpColorPicker('color'));
        } else {
            event.target.parent().find('.tints-container').remove();
        }
    });

    $('.color-field').on('input', function(event) { 
        generateTints($('.color-field').wpColorPicker('color'));

    })

    function generateTints(color) {
        const tints = [];
        const baseRgb = hexToRgb(color);

        for (let i = 10; i >= 1; i--) {
            const percentage = (i - 5.5) * 0.2; // range from -1.0 to +0.8
            const tintedRgb = adjustBrightness(baseRgb, percentage);
            tints.push(rgbToHex(tintedRgb));
        }

        if ($('.tints-container').length === 0) {
            $('<div class="tints-container" style="display: flex; gap: 10px; margin-top: 10px;"></div>').insertAfter('.color-field');
        }

        $('.tints-container').empty();
        tints.forEach(tint => {
            const textColor = getContrastingColor(hexToRgb(tint), '#ffffff', '#000000');
            $('.tints-container').append('<div style="width: 50px; height: 50px; background-color: ' + tint + '; color: '+textColor+'; "></div>');
        });
    }

    function getContrastingColor($rgb, $white, $black) {
        
        $brightness = (0.299 * $rgb[0] + 0.587 * $rgb[1] + 0.114 * $rgb[2]) / 255;
    
        return $brightness > 0.52 ?  hexToRgb($black) : hexToRgb($white) ;
    }


    function hexToRgb(hex) {
        hex = hex.replace('#', '');

        if (hex.length === 3) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }

        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);

        return [r, g, b];
    }

    function rgbToHex(rgb) {
        return `#${((1 << 24) + (rgb[0] << 16) + (rgb[1] << 8) + rgb[2]).toString(16).slice(1)}`;
    }

    function adjustBrightness(rgb, percentage) {
        return rgb.map(component => Math.max(0, Math.min(255, component + Math.round(percentage * 255))));
    }
});
