<?php
/*
 * Plugin Name: Stereo redirection
 * Description: Plugin de redirections
 * Author: Stereo
 * Author URI: https://www.stereo.ca/
 * Text Domain: stereo-redirection
 * Domain Path: /languages
 * Version: 2.0.17
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

        class ST_ContactForm
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
                    'parent_slug' => 'options-general',
                ));
            }
        }
}