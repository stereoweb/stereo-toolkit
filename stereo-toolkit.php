<?php
/*
 * Plugin Name: Stereo Toolkit
 * Description: Stereo plugin to handle redirections, site tags & more
 * Author: Stereo
 * Author URI: https://www.stereo.ca/
 * Version: 1.0.1
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
            add_filter('pre_handle_404',[$this, 'process_redirects'],1000,1); // Priority is 1000, so you can hook there BEFORE

        }

        public function process_redirects($return) {
            $url = $_SERVER['REQUEST_URI'];

            if ($csvid = get_field('stereo_redirect_csv','option')) {
                $csvfile = get_attached_file($csvid);
                if ($csv = fopen($csvfile,'r')) {
                    $hasCSV = true;
                }
            }
            $rows = get_field('stereo_redirection','option');
            if ($rows && count($rows)) {
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
            $tags = get_field('stereo_sitetags','option');
            if ($tags && count($tags)) {
                $this->tags = [];
                foreach($tags as $row) {
                    $this->tags[$row['stereo_location']][] = $row['stereo_tag'];
                }
                if ($this->tags['head'] && count($this->tags['head'])) {

                    add_action('wp_head', [$this, 'wp_head']);
                }
                if ($this->tags['footer'] && count($this->tags['footer'])) {
                    add_action('wp_footer', [$this, 'wp_footer']);
                }
                if ($this->tags['body'] && count($this->tags['body'])) {
                    add_action('wp_body_open', [$this, 'wp_body_open']);
                }
            }
        }

        public function wp_head() {
            echo implode("\r\n",$this->tags['head']);
        }

        public function wp_footer() {
            echo implode("\r\n",$this->tags['footer']);
        }

        public function wp_body_open() {
            echo implode("\r\n",$this->tags['body']);
        }


        public function show_warnings() {
            $basepath = get_template_directory();
            $notices = [];
            if (!strstr(file_get_contents($basepath.'/footer.php'),'wp_footer')) {
                $notices[] = '<div class="notice notice-error is-dismissible">
                     <p><strong>Erreur dans le thème : </strong> Votre fichier footer.php n\'inclut pas la fonction wp_footer!</p>
                 </div>';
            }
            if (!strstr(file_get_contents($basepath.'/header.php'),'wp_head')) {
                $notices[] = '<div class="notice notice-error is-dismissible">
                     <p><strong>Erreur dans le thème : </strong> Votre fichier header.php n\'inclut pas la fonction wp_head!</p>
                 </div>';
            }
            if (!strstr(file_get_contents($basepath.'/header.php'),'wp_body_open')) {
                $notices[] = '<div class="notice notice-error is-dismissible">
                     <p><strong>Erreur dans le thème : </strong> Votre fichier header.php n\'inclut pas la fonction wp_body_open!</p>
                 </div>';
            }
            if (defined('WP_ENV') && WP_ENV == 'production') {
                if (!get_field('blog_public','option')) {
                    $notices[] = '<div class="notice notice-error is-dismissible">
                         <p><strong>Erreur d\'indexation : </strong> Votre site n\'est pas indexable présentement!</p>
                     </div>';
                 }
            }
            if (defined('WP_ENV') && WP_ENV != 'development') {
                $tags = get_field('stereo_sitetags','option');
                if (!$tags || count($tags) == 0) {
                    $notices[] = '<div class="notice notice-error is-dismissible">
                         <p><strong>Erreur d\'indexation : </strong> Votre site n\'a aucun tracker présentement!</p>
                     </div>';
                 }
            }

            if (count($notices)) echo implode("\r\n",$notices);

        }


        public function init()
        {
            $this->register_option_pages();
            if (!wp_doing_ajax() && !is_admin() && !wp_is_json_request()) {
                $this->hook_sitetags();
            }
            if (is_admin() && !wp_doing_ajax() && !wp_is_json_request()) {
                add_action('admin_notices',[$this,'show_warnings']);
            }
        }

        public function register_option_pages()
        {
            acf_add_options_sub_page(array(
                'page_title'  => __('Stereo Toolkit'),
                'menu_title'  => __('Stereo Toolkit'),
                'parent_slug' => 'tools.php',
                'capability'  => 'unfiltered_html'
            ));
        }
    }
    new ST_Toolkit();

}
