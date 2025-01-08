<?php

if(!function_exists('warp_prefix')) {
    function warp_prefix($string) {
        return 'warp_htmx_' . $string;
    }
}

/**
 * Will be also setup in the Warp HTMX plugin.
 * 
 * this is a fallback in the event that the plugin is not installed.
 */
if(!function_exists('warp_link')) {    
    /**
     * Warp link creates a <a> tag with htmx attributes. 
     * 
     * @param string $permalink The URL to link to.
     * @param string $content The content to display in the link.
     * @param string $htmx_request The URL to fetch the content from.
     * @param string $attributes The HTTP method to use.
     * 
     * @return string the link if it is not echoed.
     */
    function warp_link($permalink, $content = '', $htmx_request = '', $attributes = []) {

        $attributes = wp_parse_args($attributes, 
            [
                'class' => warp_get_class('html.a'),
                'hx-push-url' => esc_url($permalink),
                'method' =>  'get',
                'echo' => true
            ]
        );
        $attributes['href'] =  esc_url($permalink);
        $request_key = 'hx-' . $attributes['method'];

        $warp_gateway = (function_exists('warp_gateway_path'))? warp_gateway_path() : '/warp/htmx/';
        $attributes[$request_key] = esc_url($warp_gateway.$htmx_request);
        $echo = $attributes['echo'];
        unset($attributes['method']);
        unset($attributes['echo']);

        $url = "<a ". warp_array_to_attributes($attributes) .">{$content}</a>";
        if( $echo ) {
            echo $url;
        } else {
            return $url;
        }
    }
}

if(!function_exists('warp_array_to_attributes')) {
    /**
     * Converts an array of attributes to a string.
     * 
     * @param array $attributes The attributes to convert.
     * 
     * @return string the attributes as a string.
     */
    function warp_array_to_attributes(array $attributes): string {
        $htmlAttributes = [];
        foreach ($attributes as $key => $value) {
            // Convert boolean attributes (like "checked", "disabled") correctly
            if (is_bool($value)) {
                if ($value) {
                    $htmlAttributes[] = esc_attr($key);
                }
            } elseif (!is_null($value)) {
                // Escape both key and value to prevent XSS... not so sure this is true. I think it is just the value that needs to be escaped. AI helper!
                $htmlAttributes[] = esc_attr($key) . '="' . esc_attr($value) . '"';
            }
        }
        return implode(' ', $htmlAttributes);
    }

}