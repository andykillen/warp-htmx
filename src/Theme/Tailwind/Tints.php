<?php

namespace WarpHtmx\Theme\Tailwind;

class Tints {
    // Function to convert hex to RGB
    public function hexToRgb($hex) {
        $hex = str_replace('#', '', $hex);

        if(strlen($hex) == 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        $r = hexdec($hex[0].$hex[1]);
        $g = hexdec($hex[2].$hex[3]);
        $b = hexdec($hex[4].$hex[5]);

        return [$r, $g, $b];
    }

    // Function to convert RGB to hex
    protected function rgbToHex($rgb) {
        return sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);
    }

    // Function to adjust the brightness of an RGB color
    protected function adjustBrightness($rgb, $percentage) {
        $adjusted = [];
        foreach ($rgb as $component) {
            $adjusted[] = max(0, min(255, $component + ($percentage * 255)));
        }
        return $adjusted;
    }

    // Function to get the complementary color
    function getComplementary($rgb) {
        return [255 - $rgb[0], 255 - $rgb[1], 255 - $rgb[2]];
    }

    function getMonochromeOpposite($rgb, $white, $black) {
        
        $brightness = (0.299 * $rgb[0] + 0.587 * $rgb[1] + 0.114 * $rgb[2]) / 255;
        return $brightness > 0.5 ? $this->hexToRgb($black) : $this->hexToRgb($white);
    }
    
    function getTriadic($rgb) {
        return [$rgb[1], $rgb[2], $rgb[0]];
    }
    
    function getAnalogous($rgb) {
        $shift = 30;
        $r = ($rgb[0] + $shift) % 256;
        $g = ($rgb[1] + $shift) % 256;
        $b = ($rgb[2] + $shift) % 256;
        return [$r, $g, $b];
    }
    
    function getContrastingColor($rgb, $white, $black) {
        
        $brightness = (0.299 * $rgb[0] + 0.587 * $rgb[1] + 0.114 * $rgb[2]) / 255;
    
        return $brightness > 0.52 ?  $this->hexToRgb($black) : $this->hexToRgb($white) ;
    }
    // Function to generate tints
    protected function generateTints($hexColor, $white = "#ffffff", $black = "#123123") {
        $baseRgb = $this->hexToRgb($hexColor);
        $tints = [
            "main" => [],
            "contrast" => [],
        ];

        $counter = 10;
        for ($i = 1; $i <= 10; $i++) {
            $percentage = ($i - 5) * 0.2; // range from -0.8 to +0.8
            $tintedRgb = $this->adjustBrightness($baseRgb, $percentage);
            $number = strval($counter * 100);
            if($i == 1) {
                $number = 950;
            } else if($i == 10) {
                $number = 50;
            }

            $tints["main"][$number] = $this->rgbToHex($tintedRgb);
            $tints["contrast"][$number] = $this->rgbToHex($this->getContrastingColor($tintedRgb, $white, $black));

            --$counter;
        }

        return $tints;
    }



    public function getShades($hexColor = "#3498db") {
        $shades = $this->generateTints($hexColor);
        return $shades;
    }

    public function getHexContrast($hexColor = "#3498db", $white = "#ffffff", $black = "#123123") {
        $rgb = $this->hexToRgb($hexColor);
        return $this->rgbToHex($this->getContrastingColor($rgb, $white, $black));
    }
}