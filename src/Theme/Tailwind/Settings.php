<?php

namespace WarpHtmx\Theme\Tailwind;

class Settings {

    protected $set_name = "warp_theme_custom_settings";
    protected $section_name = "custom-settings-section";


    function __construct() {
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue'] );
        add_action( 'admin_menu', [$this, 'settings_page'] );
        add_action( 'admin_init', [$this, 'settings_init'] );
    }

    function enqueue() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-slider' );

        // Enqueue custom script for color picker functionality
        wp_enqueue_script( 'my-custom-script', get_template_directory_uri() . '/disti/js/custom-color-picker.js', array( 'wp-color-picker', 'jquery-ui-core', 'jquery-ui-slider' ), false, true );
    }



    function settings_page() {
        add_menu_page(
            'Custom Settings',
            'Custom Settings',
            'manage_options',
            'custom-settings',
            [$this, 'settings_page_html']
        );
    }
    

    function settings_page_html() {
        ?>
        <div class="wrap">
            <h1>Custom Settings</h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( $this->set_name );
                do_settings_sections( $this->section_name );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    function settings_init() {
        register_setting( $this->set_name, 'custom_color' );
        register_setting( $this->set_name, 'custom_mode' );

        add_settings_section(
            'custom_settings_section',
            'Color Picker Settings',
            [$this, 'custom_settings_section_cb'],
            $this->section_name
        );

        add_settings_field(
            'custom_color_field',
            'Pick a color',
            [$this, 'custom_color_field_cb'],
            $this->section_name,
            'custom_settings_section'
        );

        add_settings_field(
            'custom_mode_field',
            'Mode',
            [$this,'custom_mode_field_cb' ],
            $this->section_name,
            'custom_settings_section'
        );
    }
    

    function custom_settings_section_cb() {
        echo '<p>Select a color and mode.</p>';
    }

    function custom_color_field_cb($info) {
        $color = get_option( 'custom_color', '#ffffff' );
        echo '<input type="text" id="custom_color" name="custom_color" class="color-field" value="' . esc_attr( $color ) . '" class="my-color-field" data-default-color="#ffffff" />';
    }

    function custom_mode_field_cb() {
        $mode = get_option( 'custom_mode', 'standard' );
        ?>
        <select id="custom_mode" name="custom_mode">
            <option value="standard" <?php selected( $mode, 'standard' ); ?>>Standard</option>
            <option value="tints" <?php selected( $mode, 'tints' ); ?>>Tints</option>
        </select>
        <?php
    }

}