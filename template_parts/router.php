
<?php
    // grabs the masthead and menu
    do_action( 'warp_theme_before_main_content' );
    /**
     * Setup two varaibles to handle the template part and extension
     * 
     * ie. get_template_part($templage_path, $template_extension);
     * 
     * @var string $template_path
     * @var string $template_extension
     * @var string $template_loader
     * 
     */
    $template_path = false;
    $templage_extension = '';
    $template_loader = 'get_template_part';
   // Handle 404 pages
    if (is_404()) {
        $template_path = 'template_parts/errors/404';
    } elseif (class_exists('WooCommerce')) {
        // in theory this should never be called as WooCommerce should be loaded before this
        // and load its own templates but just in case
        $woo_templates = [
            'is_cart' => 'cart/cart',
            'is_product' => 'single-product',
            'is_shop' => 'archive-product',
            'is_product_category' => 'archive-product',
            'is_product_tag' => 'archive-product',
            'is_account_page' => 'myaccount/my-account',
            'is_checkout' => 'checkout/form-checkout',
        ];
        foreach ($woo_templates as $condition => $template) {
            if (function_exists($condition) && $condition()) {
                $template_path = $template;
                $template_loader = 'wc_get_template_part';
                break;
            }
        }
    } elseif (is_archive()) {
        $archive_templates = [
            'is_category' => 'taxonomy',
            'is_tag' => 'taxonomy',
            'is_tax' => 'taxonomy',
            'is_author' => 'author',
            'is_date' => 'date',
            'is_post_type_archive' => 'post_type',
        ];
        foreach ($archive_templates as $condition => $template) {
            if (function_exists($condition) && $condition()) {
                $extra = $condition === 'is_post_type_archive' ? get_post_type() : get_queried_object()->taxonomy ?? '';
                $template_path = "template_parts/archive/{$template}";
                if (!empty($extra)) {
                    $templage_extension .= $extra;
                }
                break;
            }
        }
    } elseif (is_search()) {
        $template_path = 'template_parts/archive/search';
    } elseif (is_front_page()) {
        $template_path = 'template_parts/front_page';
    } elseif (is_home()) {
        $template_path = 'template_parts/home';
    } elseif (is_singular()) {
        $template_path = 'template_parts/singular/content';
        $templage_extension = get_post_type();
    }

    // Fallback template
    if (!$template_path) {
        $template_path = 'template_parts/archive/post_type';
    }

    // Load the determined template using the selected function
    if ($template_loader === 'wc_get_template_part') {
        wc_get_template_part($template_path);
    } else {
        get_template_part($template_path, $templage_extension);
    }
    // closes the global and main container
    do_action( 'warp_theme_after_main_content' );
