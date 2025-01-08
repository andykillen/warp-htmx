<?php

use Warp\Admin\Fields\Text;
use WarpHtmx\Theme\Filters as WarpFilters;

/**
 * Warp add html class attribute.
 * 
 * For use inside a bit of html, such as a div or a span, to add a class attribute.
 * 
 * <a href="#" <?php warp_add_class('buttons.primary', ['default'=> 'bg-primary text-secondary'] ); ?>>Click me</a>
 * 
 * @param string $filter_name The filter name to use. This is made in dot notation. i.e. "buttons.primary" would find the 
 * button.primary element in the design.json in the root of the theme.  
 * @param string $default_css_class_value The default CSS class value to use if the filter is not found.
 * @param bool $echo Whether to echo the class or return it.
 * 
 * @return string the class if it is not echoed.
 */
function warp_add_class( $filter_name, $options = [] ) {
    $options = wp_parse_args($options, 
        [
            'echo'      => true,
            'append'    => '',
            'prepend'   => '',
            'default'   => '',
        ]
    );
    
    if( $options['echo'] ) {
        echo WarpFilters::addClass($filter_name, $options);
    } else {
        return WarpFilters::addClass($filter_name, $options);
    }
}

/**
 * Warp get class attribute.
 * 
 * For use inside a bit of html, such as a div or a span, to get a class attribute.
 * 
 * <a href="#" class="<?php echo warp_get_class('buttons.primary'); ?>">Click me</a>
 * 
 * This will return the class attribute for the buttons.primary element in the design.json file.
 * 
 * It is optional to use comma separated values to get multiple classes.
 * 
 * echo warp_get_class('buttons.primary,font.sans');
 * 
 * @param string $filter_name The filter name to use. This is made in dot notation. i.e. "buttons.primary" would find the 
 * button.primary element in the design.json in the root of the theme.  
 * 
 * @return mixed bool/string the class if it exists, false if not there.
 */
function warp_get_class( $filter_name, $options = [] ) {
    $options = wp_parse_args($options, 
        [
            'echo'      => false,
            'append'    => '',
            'prepend'   => '',
            'default'   => '',
        ]
    );
    if( $options['echo'] ) {
        echo WarpFilters::getClass($filter_name, $options);
    } else {
        return WarpFilters::getClass($filter_name, $options);
    }
}


/** 
 * Warp post link creates a link to a post based on the ID with htmx attributes.
 * 
 * @param int $post_id The ID of the post to link to.
 * @param string $htmx_url The URL to fetch the content from.
 * @param string $method The HTTP method to use.
 * @param string $swap The swap method to use.
 * @param string $class The CSS class to use
 * @param bool $echo Whether to echo the link or return it.
 * 
 * @return string the link if it is not echoed.
 */
function warp_post_link($post_id, $htmx_request = '', $attributes = []) {

    $permalink = get_permalink($post_id);
    $content = get_the_title($post_id);
    $attributes = wp_parse_args($attributes, 
        [
            'class' => warp_get_class('html.a'),
            'hx-push-url' => esc_url($permalink),
            'method' =>  'get',
            'echo' => true
        ]
    );
    if( $attributes['echo'] ) {
        warp_link($permalink, $content, $htmx_request, $attributes);
    } else {
        return warp_link($permalink, $content, $htmx_request, $attributes);
    }
}

/**
 * Warp allowed html tags that are in a WordPress excerpt.
 *
 * use the filter 'warp_allowed_excerpt_tags' to add or remove tags.
 * 
 * It does not contain the p tag, as the p tag is added by the warp_the_excerpt function.
 *
 * @return string the allowed tags.
 */
function warp_allowed_excerpt_tags() {
    return apply_filters('warp_allowed_excerpt_tags', '<p><a><abbr><b><blockquote><cite><code><em><i><q><strong><strike><sub><sup>');
}

/**
 * warp adapt html tags to have tailwind classes.
 */
function warp_adapt_html($content, $replace = false,  $allowed_tags = []) {
    
    if( empty($allowed_tags) ) {
        // defaults to most used tags.
        // does not include form elements.
        $allowed_tags = [
            'a',        // Anchor
            'abbr',     // Abbreviation
            'b',        // Bold text
            'bdo',      // Bidirectional override
            'br',       // Line break
            'button',   // Button
            'cite',     // Citation
            'code',     // Inline code
            'del',      // Deleted text
            'dfn',      // Definition term
            'em',       // Emphasized text
            'i',        // Italic text
            'input',    // Input field
            'ins',      // Inserted text
            'kbd',      // Keyboard input
            'label',    // Label for form elements
            'mark',     // Marked (highlighted) text
            'meter',    // Measurement
            'progress', // Progress bar
            'p',        // Paragraph
            'q',        // Short inline quotation
            's',        // Strikethrough text
            'small',    // Small text
            'strong',   // Strong emphasis
            'sub',      // Subscript
            'sup',      // Superscript
            'time',     // Time value
            'u',        // Underlined text
            'h1',       // headings
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'ul',       // lists
            'ol',
            
            ];
    }

    $tags_pattern = implode('|', array_map('preg_quote', $allowed_tags));
    $regex = "/<($tags_pattern)(\s[^>]*)?>/u";

    // preg_replace_callback to process each tag
    $content = preg_replace_callback($regex, function ($matches) use ($replace) {
        $tag = $matches[1]; 
        $attributes = isset($matches[2]) ? $matches[2] : '';

        // Get the CSS class for the tag
        $class_to_add = warp_get_class("html.$tag");

        if (preg_match('/class\s*=\s*["\']([^"\']*)["\']/', $attributes, $class_match)) {
            $existing_classes = $class_match[1];
            // append to or replace the existing class attribute, defaults to append.
            $new_classes = ($replace) ? $class_to_add : trim("$existing_classes $class_to_add");
            $attributes = preg_replace('/class\s*=\s*["\']([^"\']*)["\']/', "class=\"$new_classes\"", $attributes);
        } else {
            // when no class attribute is present, add it
            $attributes = trim("$attributes class=\"$class_to_add\"");
        }

        return "<$tag $attributes>";
    }, $content);

    return $content;
}