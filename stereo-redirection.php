<?php
/*
 * Plugin Name: Stereo redirection
 * Description: Plugin de redirections
 * Author: Stereo
 * Author URI: https://www.stereo.ca/
 * Text Domain: stereo-redirection
 * Domain Path: /languages
 * Version: 1.0.0
 * License:     0BSD
 *
 * Copyright (c) 2022 Stereo
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ST_Redirection')) {

        if( class_exists('ACF') ) {
            include 'acf.php';
        }

        class ST_Redirection
        {
            var $version = "1.0.0";

            public function __construct()
            {

            }

            public function init()
            {
                $this->register_option_pages();
            }

            public function register_option_pages()
            {
                acf_add_options_sub_page(array(
                    'page_title'  => __('Stereo redirection plugin'),
                    'menu_title'  => __('Stereo redirection'),
                    'parent_slug' => 'tools.php',
                ));
            }
        }
        new ST_Redirection();

        function stereo_redirection_load_plugin_textdomain() {
            load_plugin_textdomain( 'stereo-redirection', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
        }
        add_action( 'plugins_loaded', 'stereo_redirection_load_plugin_textdomain' );
}