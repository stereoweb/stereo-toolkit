<?php
if (!class_exists('ST_SEO_Listing')) {

    class ST_SEO_Listing
    {
        public function __construct()
        {
            add_action('init', [$this, 'init']);
        }

        public function init()
        {
            add_action('admin_menu', [$this, 'add_admin_menu']);
            add_action('admin_head', [$this, 'custom_admin_css']);
            add_action('admin_enqueue_scripts', [$this, 'custom_admin_js'] );
            add_action('wp_ajax_stereo_update_meta', [$this, 'update_meta']);
        }

        public function add_admin_menu()
        {
            if (defined('WPSEO_VERSION') || defined('THE_SEO_FRAMEWORK_VERSION')) {
                add_submenu_page(
                    'tools.php',
                    'SEO Listing',
                    'SEO Listing',
                    'manage_options',
                    'stereo-seo-listing',
                    [$this, 'render_admin_page']
                );
            }
        }

        public function custom_admin_css()
        {
            echo '<style>';
            include 'assets/css/custom-admin.css';
            echo '</style>';

        }

        public function custom_admin_js()
        {
            if ( ! did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }
            wp_enqueue_script('stereo-seo-listing', plugin_dir_url(__FILE__) . 'assets/js/custom-admin.js', ['jquery'], '1.0.0', true);
            wp_localize_script('stereo-seo-listing', 'stereo_seo_listing', [
                'ajaxurl' => admin_url('admin-ajax.php')
            ]);
        }

        public function render_admin_page()
        {
            $default_tab = 'page';
            $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

            $types = [];
            foreach (get_post_types(['public' => true], 'objects') as $post_type => $object) {
                if ($object->public === false) continue;
                if ($post_type === 'attachment') continue;
                $types[$post_type] = $object;
            }

            $args = [
                'post_type' => $tab,
                'posts_per_page' => -1,
            ];
            $query = new WP_Query($args);

            include 'templates/seo.php';
        }

        public function get_seo_metas($post_id)
        {
            $metas = [];
            if (defined('WPSEO_VERSION')) {
                $metas = [
                    'title' => YoastSEO()->meta->for_post($post_id)->title,
                    'description' => YoastSEO()->meta->for_post($post_id)->description,
                    'facebook_title' => YoastSEO()->meta->for_post($post_id)->open_graph_title,
                    'facebook_description' => YoastSEO()->meta->for_post($post_id)->open_graph_description,
                    'facebook_image' => '',
                    'twitter_title' => YoastSEO()->meta->for_post($post_id)->twitter_title,
                    'twitter_description' => YoastSEO()->meta->for_post($post_id)->twitter_description,
                    'twitter_image' => '',
                ];
                if ($image = YoastSEO()->meta->for_post($post_id)->open_graph_image) {
                    $metas['facebook_image'] = $image[0]['url'];
                }
                if ($image = YoastSEO()->meta->for_post($post_id)->twitter_image) {
                    $metas['twitter_image'] = $image;
                }
            } else if (defined('THE_SEO_FRAMEWORK_VERSION')) {
                $metas = [
                    'title' => the_seo_framework()->get_title($post_id),
                    'description' => the_seo_framework()->get_description($post_id),
                    'facebook_title' => the_seo_framework()->get_open_graph_title($post_id),
                    'facebook_description' => the_seo_framework()->get_open_graph_description($post_id),
                    'facebook_image' => get_post_meta($post_id,'_social_image_url',true),
                    'twitter_title' => the_seo_framework()->get_twitter_title($post_id),
                    'twitter_description' => the_seo_framework()->get_twitter_description($post_id),
                ];
            }
            return $metas;
        }

        public function update_meta()
        {
            $post_id = $_POST['post_id'];
            $meta = $_POST['meta'];
            $value = $_POST['value'];

            if (defined('WPSEO_VERSION')) {
                switch ($meta) {
                    case 'meta_title':
                        update_post_meta($post_id, '_yoast_wpseo_title', $value);
                        break;
                    case 'meta_description':
                        update_post_meta($post_id, '_yoast_wpseo_metadesc', $value);
                        break;
                    case 'facebook_title':
                        update_post_meta($post_id, '_yoast_wpseo_opengraph-title', $value);
                        break;
                    case 'facebook_description':
                        update_post_meta($post_id, '_yoast_wpseo_opengraph-description', $value);
                        break;
                    case 'facebook_image':
                        update_post_meta($post_id, '_yoast_wpseo_opengraph-image', wp_get_attachment_url($value));
                        break;
                    case 'twitter_title':
                        update_post_meta($post_id, '_yoast_wpseo_twitter-title', $value);
                        break;
                    case 'twitter_description':
                        update_post_meta($post_id, '_yoast_wpseo_twitter-description', $value);
                        break;
                    case 'twitter_image':
                        update_post_meta($post_id, '_yoast_wpseo_twitter-image', wp_get_attachment_url($value));
                        break;
                }
            } else if (defined('THE_SEO_FRAMEWORK_VERSION')) {
                switch ($meta) {
                    case 'meta_title':
                        update_post_meta($post_id, '_genesis_title', $value);
                        break;
                    case 'meta_description':
                        update_post_meta($post_id, '_genesis_description', $value);
                        break;
                    case 'facebook_title':
                        update_post_meta($post_id, '_open_graph_title', $value);
                        break;
                    case 'facebook_description':
                        update_post_meta($post_id, '_open_graph_description', $value);
                        break;
                    case 'facebook_image':
                        update_post_meta($post_id, '_social_image_id', $value);
                        update_post_meta($post_id, '_social_image_url', wp_get_attachment_url($value));
                        break;
                    case 'twitter_title':
                        update_post_meta($post_id, '_twitter_title', $value);
                        break;
                    case 'twitter_description':
                        update_post_meta($post_id, '_twitter_description', $value);
                        break;
                }
            }

            if ($meta == 'post_name') {
                $post = get_post($post_id);
                $post->post_name = sanitize_title($value);
                wp_update_post($post);
            }

            wp_send_json_success();
        }
    }

    new ST_SEO_Listing();
}