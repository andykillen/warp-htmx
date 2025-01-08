<?php 

namespace WarpHtmx\Theme\Theming;

use WarpHtmx\Theme\Tailwind\Tints;

/**
 * ColorMode creates the CSS VARS to be used by Tailwind CSS.
 */

class ColorMode {

    protected $lightTheme = null;
    protected $darkTheme = null;
    protected $tints;

    public function __construct() {
        $this->tints = new Tints();
    }

    public function getColors() {
        $complexColors = [
            'body-background' => '#ffffff',
            'text-body' => '#030712',
            'heading' => '#111111',
            'heading-link' => '#676767',
            'heading-link-hover' => '#030712',
            'heading-link-visited' => '#030712',
            'link-color' => '#676767',
            'link-hover' => '#676767',
            'link-visitied' => '#676767',
            
            // Surfaces... modals, cards, etc.
            'surface-background' => '#ffffff',
            'surface-text' => '#111111',
            'surface-heading' => '#676767',
            'surface-link' => '#676767',
            'surface-link-hover' => '#676767',
            'surface-link-visited' => '#676767',
        ];

        // Simple colors are only plain hex, and do not have tints. 
        $simpleColors = [
            // Theme colors
            'white' => '#ffffff',
            'black' => '#030712',
            // messaging
            'error' => '#d21950',
            'success' => '#84cc16',
            'info' => '#3498db',
            'warning' => '#ff6842',
            'danger' => '#f31212',
            'light' => '#f8f9fa',
            'dark' => '#343a40',        
        ];

        // theme colors are setup with tints from 50 --> 950
        $themeColors = [
            'primary' => '#3949ab', // indigo
            'secondary' => '#66bb6a', // green
            'tertiary' => '#673ab7', // purple
            'cta' => '#ff9800', // orange
        ];

        $output = ':where(body) { ';
            $output .= $this->getLightTheme($simpleColors,$complexColors, $themeColors);
        $output .= '}';
        $output .= ':where(body.dark) { ';
            $output .= $this->getDarkTheme($simpleColors,$complexColors, $themeColors);
        $output .= '}';
        $output .= ':where(body[data-theme="dark"] { ';
            $output .= $this->getDarkTheme($simpleColors,$complexColors, $themeColors);
        $output .= '}';

        return $output;
    }

    function getLightTheme($simpleColors,$complexColors, $themeColors) {
        
        if($this->lightTheme) {
            return $this->lightTheme;
        }
        $output = '';
        foreach ($simpleColors as $colorName => $hexColor) {
            $output .= '--'. $colorName . ': ' . $hexColor . ';';
        }
        foreach ($complexColors as $colorName => $hexColor) {
            $output .= '--'. $colorName . ': ' . $hexColor . ';';
            $output .= '--'. $colorName . '-inv: ' . $this->tints->getHexContrast($hexColor, $simpleColors['white'], $simpleColors['black'] ) . ';';
        }
        foreach($themeColors as $colorName => $hexColor) {
            $colorValues = $this->tints->getShades($hexColor, $simpleColors['white'], $simpleColors['black']);
            foreach($colorValues as $type => $details) {
                foreach($details as $shadeName => $shadeHex) {
                    $inv = ($type == 'main') ? '' : '-inv';
                    $output .= '--'. $colorName . '-' . $shadeName . $inv .': ' . $shadeHex . ';';
                }
            }
        }
        $this->lightTheme = $output;
        return $output;
    }

    function getDarkTheme($simpleColors,$complexColors, $themeColors) {
        if($this->darkTheme) {
            return $this->darkTheme;
        }
        $output = '';
        foreach ($simpleColors as $colorName => $hexColor) {
            $output .= '--'. $colorName . ': ' . $this->tints->getHexContrast($hexColor, $simpleColors['white'], $simpleColors['black'] ). ';';
         
        }
        foreach ($complexColors as $colorName => $hexColor) {
            $output .= '--'. $colorName . ': ' . $this->tints->getHexContrast($hexColor, $simpleColors['white'], $simpleColors['black'] ). ';';
            $output .= '--'. $colorName . '-inv: ' . $hexColor . ';';
        }
        foreach($themeColors as $colorName => $hexColor) {
            $hexColor = $this->tints->getHexContrast($hexColor, $simpleColors['white'], $simpleColors['black'] );
            $colorValues = $this->tints->getShades($hexColor, $simpleColors['white'], $simpleColors['black']);
            foreach($colorValues as $type => $details) {
                foreach($details as $shadeName => $shadeHex) {
                    $inv = ($type == 'main') ? '' : '-inv';
                    $output .= '--'. $colorName . '-' . $shadeName . $inv .': ' . $shadeHex . ';';
                }
            }
        }
        $this->lightTheme = $output;
        return $output;
    }
}