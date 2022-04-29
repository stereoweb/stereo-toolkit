<?php
/*
 * Plugin Name: Stereo Toolkit
 * Description: Stereo plugin to handle redirections, site tags & more
 * Author: Stereo
 * Author URI: https://www.stereo.ca/
 * Text Domain: stereo-redirection
 * Version: 1.0.0
 * License:     0BSD
 *
 * Copyright (c) 2022 Stereo
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ST_Toolkit')) {

        if( class_exists('ACF') ) {
            include 'acf.php';
        }

        class ST_Toolkit
        {
            var $version = "1.0.0";

            public function __construct()
            {
                add_action('init', [$this, 'init']);
                add_filter('pre_handle_404',[$this, 'process_redirects']);

            }

            public function process_redirects($return) {
                $url = $_SERVER['REQUEST_URI'];

                if ($csvid = get_field('stereo_redirect_csv','option')) {
                    $csvfile = get_attached_file($csvid);
                    if ($csv = fopen($csvfile,'r')) {
                        $hasCSV = true;
                    }
                }
                if ($rows = get_field('stereo_redirection','option') && count($rows)) {
                    $hasRepeater = true;
                }

                if ($hasCSV || $hasRepeater) {
                    if ($hasRepeater) {
                        foreach($rows as $row) {
                            if ($_SERVER['REQUEST_URI'] == $row['stereo_old_url']) {
                                wp_redirect($row['stereo_new_url'],301);
                                die();
                            }
                        }
                    }
                    if ($hasCSV) {
                        while($row=fgetcsv($csv)) {
                            if ($_SERVER['REQUEST_URI'] == $row[0]) {
                                wp_redirect($row[1],301);
                                die();
                            }
                        }
                        rewind($csv);
                    }

                    if ($hasRepeater) {
                        foreach($rows as $row) {
                            if (strstr($_SERVER['REQUEST_URI'],$row['stereo_old_url'])) {
                                wp_redirect($row['stereo_new_url'],301);
                                die();
                            }
                        }
                    }
                    if ($hasCSV) {
                        while($row=fgetcsv($csv)) {
                            if (strstr($_SERVER['REQUEST_URI'],$row[0])) {
                                wp_redirect($row[1],301);
                                die();
                            }
                        }
                        fclose($csv);
                    }
                }
                return $return;
            }

            public function hook_sitetags() {
                // TODO

            }

            public function hook_warnings() {
                // TODO
            }


            public function init()
            {
                $this->register_option_pages();
                if (!wp_doing_ajax() && !is_admin() && !wp_is_json_request()) {
                    $this->hook_sitetags();
                }
                if (is_admin() && !wp_doing_ajax()) {
                    $this->hook_warnings();
                }
            }

            public function register_option_pages()
            {
                acf_add_options_sub_page(array(
                    'page_title'  => __('Stereo Toolkit'),
                    'menu_title'  => __('Stereo Toolkit'),
                    'parent_slug' => 'tools.php',
                ));
            }
        }
        new ST_Toolkit();

}
