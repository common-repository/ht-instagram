<?php
namespace HtFeed\Admin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

class HTinstagram_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new \HTinstagram_Settings_API;

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 220 );
        add_action( 'wsa_form_bottom_htinstagram_shortcodeopt_tabs', array( $this, 'htinstagram_shortcode_opt_table' ) );
        $this->plugin_recommendations();
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->htinstagram_admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->htinstagram_admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    // Plugins menu Register
    function admin_menu() {
        add_menu_page( 
            __( 'WP Instagram', 'ht-instagram' ),
            __( 'WP Instagram', 'ht-instagram' ),
            'manage_options',
            'htinstagram',
            array ( $this, 'plugin_page' ),
            HTINSTA_PL_URL.'assests/images/menu-logo.png',
            100
        );
    }

    /**
     * [plugin_recommendations]
     * @return [void]
     */
    public function plugin_recommendations(){

        $get_instance = Recommended_Plugins::instance( 
            array( 
                'text_domain'       => 'ht-instagram', 
                'parent_menu_slug'  => 'htinstagram', 
                'menu_capability'   => 'manage_options', 
                'menu_page_slug'    => 'htfeed-recommendations',
                'priority'          => 221,
                'assets_url'        => HTINSTA_PL_URL.'admin/assets',
                'hook_suffix'       => ''
            )
        );

        $get_instance->add_new_tab( array(

        'title' => esc_html__( 'Recommended', 'ht-instagram' ),
        'active' => true,
        'plugins' => array(

            array(
                'slug'      => 'woolentor-addons',
                'location'  => 'woolentor_addons_elementor.php',
                'name'      => esc_html__( 'WooLentor', 'ht-instagram' )
            ),

            array(
                'slug'      => 'ht-mega-for-elementor',
                'location'  => 'htmega_addons_elementor.php',
                'name'      => esc_html__( 'HT Mega', 'ht-instagram' )
            ),

            array(
                'slug'      => 'hashbar-wp-notification-bar',
                'location'  => 'init.php',
                'name'      => esc_html__( 'HashBar', 'ht-instagram' )
            ),

            array(
                'slug'      => 'ht-slider-for-elementor',
                'location'  => 'ht-slider-for-elementor.php',
                'name'      => esc_html__( 'HT Slider For Elementor', 'ht-instagram' )
            ),

            array(
                'slug'      => 'ht-contactform',
                'location'  => 'contact-form-widget-elementor.php',
                'name'      => esc_html__( 'HT Contact Form 7', 'ht-instagram' )
            ),

            array(
                'slug'      => 'extensions-for-cf7',
                'location'  => 'extensions-for-cf7.php',
                'name'      => esc_html__( 'Extensions For CF7', 'ht-instagram' )
            ),

            array(
                'slug'      => 'ht-wpform',
                'location'  => 'wpform-widget-elementor.php',
                'name'      => esc_html__( 'HT WPForms', 'ht-instagram' )
            ),

            array(
                'slug'      => 'ht-menu-lite',
                'location'  => 'ht-mega-menu.php',
                'name'      => esc_html__( 'HT Menu', 'ht-instagram' )
            ),

            array(
                'slug'      => 'insert-headers-and-footers-script',
                'location'  => 'init.php',
                'name'      => esc_html__( 'HT Script', 'ht-instagram' )
            ),

            array(
                'slug'      => 'wp-plugin-manager',
                'location'  => 'plugin-main.php',
                'name'      => esc_html__( 'WP Plugin Manager', 'ht-instagram' )
            ),

            array(
                'slug'      => 'wc-builder',
                'location'  => 'wc-builder.php',
                'name'      => esc_html__( 'WC Builder', 'ht-instagram' )
            ),

            array(
                'slug'      => 'whols',
                'location'  => 'whols.php',
                'name'      => esc_html__( 'Whols', 'ht-instagram' )
            ),

            array(
                'slug'      => 'just-tables',
                'location'  => 'just-tables.php',
                'name'      => esc_html__( 'JustTables', 'ht-instagram' )
            ),

            array(
                'slug'      => 'wc-multi-currency',
                'location'  => 'wcmilticurrency.php',
                'name'      => esc_html__( 'Multi Currency', 'ht-instagram' )
            )
        )

    ) );

    $get_instance->add_new_tab(array(
        'title' => esc_html__( 'You May Also Like', 'ht-instagram' ),
        'plugins' => array(

            array(
                'slug'      => 'woolentor-addons-pro',
                'location'  => 'woolentor_addons_pro.php',
                'name'      => esc_html__( 'WooLentor Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/woolentor-pro-woocommerce-page-builder/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'WooLentor is one of the most popular WooCommerce Elementor Addons on WordPress.org. It has been downloaded more than 672,148 times and 60,000 stores are using WooLentor plugin. Why not you?', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'htmega-pro',
                'location'  => 'htmega_pro.php',
                'name'      => esc_html__( 'HT Mega Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/ht-mega-pro/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'HTMega is an absolute addon for elementor that includes 80+ elements & 360 Blocks with unlimited variations. HT Mega brings limitless possibilities. Embellish your site with the elements of HT Mega.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'swatchly-pro',
                'location'  => 'swatchly-pro.php',
                'name'      => esc_html__( 'Product Variation Swatches', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/swatchly-product-variation-swatches-for-woocommerce-products/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'Are you getting frustrated with WooCommerce’s current way of presenting the variants for your products? Well, say goodbye to dropdowns and start showing the product variations in a whole new light with Swatchly.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'whols-pro',
                'location'  => 'whols-pro.php',
                'name'      => esc_html__( 'Whols Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/whols-woocommerce-wholesale-prices/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'Whols is an outstanding WordPress plugin for WooCommerce that allows store owners to set wholesale prices for the products of their online stores. This plugin enables you to show special wholesale prices to the wholesaler. Users can easily request to become a wholesale customer by filling out a simple online registration form. Once the registration is complete, the owner of the store will be able to review the request and approve the request either manually or automatically.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'just-tables-pro',
                'location'  => 'just-tables-pro.php',
                'name'      => esc_html__( 'JustTables Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/wp/justtables/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'JustTables is an incredible WordPress plugin that lets you showcase all your WooCommerce products in a sortable and filterable table view. It allows your customers to easily navigate through different attributes of the products and compare them on a single page. This plugin will be of great help if you are looking for an easy solution that increases the chances of landing a sale on your online store.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'multicurrencypro',
                'location'  => 'multicurrencypro.php',
                'name'      => esc_html__( 'Multi Currency Pro for WooCommerce', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/multi-currency-pro-for-woocommerce/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'Multi-Currency Pro for WooCommerce is a prominent currency switcher plugin for WooCommerce. This plugin allows your website or online store visitors to switch to their preferred currency or their country’s currency.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'cf7-extensions-pro',
                'location'  => 'cf7-extensions-pro.php',
                'name'      => esc_html__( 'Extensions For CF7 Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/cf7-extensions/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'Contact Form7 Extensions plugin is a fantastic WordPress plugin that enriches the functionalities of Contact Form 7.This all-in-one WordPress plugin will help you turn any contact page into a well-organized, engaging tool for communicating with your website visitors by providing tons of advanced features like drag and drop file upload, repeater field, trigger error for already submitted forms, popup form response, country flags and dial codes with a telephone input field and acceptance field, etc. in addition to its basic features.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'hashbar-pro',
                'location'  => 'init.php',
                'name'      => esc_html__( 'HashBar Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/wordpress-notification-bar-plugin/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'HashBar is a WordPress Notification / Alert / Offer Bar plugin which allows you to create unlimited notification bars to notify your customers. This plugin has option to show email subscription form (sometimes it increases up to 500% email subscriber), Offer text and buttons about your promotions. This plugin has the options to add unlimited background colors and images to make your notification bar more professional.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'wp-plugin-manager-pro',
                'location'  => 'plugin-main.php',
                'name'      => esc_html__( 'WP Plugin Manager Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/wp-plugin-manager-pro/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'WP Plugin Manager Pro is a specialized WordPress Plugin that helps you to deactivate unnecessary WordPress Plugins page wise and boosts the speed of your WordPress site to improve the overall site performance.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'ht-script-pro',
                'location'  => 'plugin-main.php',
                'name'      => esc_html__( 'HT Script Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/insert-headers-and-footers-code-ht-script/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'Insert Headers and Footers Code allows you to insert Google Analytics, Facebook Pixel, custom CSS, custom HTML, JavaScript code to your website header and footer without modifying your theme code.This plugin has the option to add any custom code to your theme in one place, no need to edit the theme code. It will save your time and remove the hassle for the theme update.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'ht-menu',
                'location'  => 'ht-mega-menu.php',
                'name'      => esc_html__( 'HT Menu Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/ht-menu-pro/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'WordPress Mega Menu Builder for Elementor', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'ht-slider-addons-pro',
                'location'  => 'ht-slider-addons-pro.php',
                'name'      => esc_html__( 'HT Slider Pro For Elementor', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/ht-slider-pro-for-elementor/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'HT Slider Pro is a plugin to create a slider for WordPress websites easily using the Elementor page builder. 80+ prebuild slides/templates are included in this plugin. There is the option to create a post slider, WooCommerce product slider, Video slider, image slider, etc. Fullscreen, full width and box layout option are included.', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'ht-google-place-review',
                'location'  => 'ht-google-place-review.php',
                'name'      => esc_html__( 'Google Place Review', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/google-place-review-plugin-for-wordpress/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( 'If you are searching for a modern and excellent google places review WordPress plugin to showcase reviews from Google Maps and strengthen trust between you and your site visitors, look no further than HT Google Place Review', 'ht-instagram' ),
            ),

            array(
                'slug'      => 'was-this-helpful',
                'location'  => 'was-this-helpful.php',
                'name'      => esc_html__( 'Was This Helpful?', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/was-this-helpful/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( "Was this helpful? is a WordPress plugin that allows you to take visitors' feedback on your post/pages or any article. A visitor can share his feedback by like/dislike/yes/no", 'ht-instagram' ),
            ),

            array(
                'slug'      => 'ht-click-to-call',
                'location'  => 'ht-click-to-call.php',
                'name'      => esc_html__( 'HT Click To Call', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/ht-click-to-call/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( "HT – Click to Call is a lightweight WordPress plugin that allows you to add a floating click to call button on your website. It will offer your website visitors an opportunity to call your business immediately at the right moment, especially when they are interested in your products or services and seeking more information.", 'ht-instagram' ),
            ),

            array(
                'slug'      => 'docus-pro',
                'location'  => 'docus-pro.php',
                'name'      => esc_html__( 'Docus Pro', 'ht-instagram' ),
                'link'      => 'https://hasthemes.com/plugins/docus-pro-youtube-video-playlist/',
                'author_link'=> 'https://hasthemes.com/',
                'description'=> esc_html__( "Embedding a YouTube playlist into your website plays a vital role to curate your content into several categories and make your web content more engaging and popular by keeping the visitors on your website for a longer period.", 'ht-instagram' ),
            ),

        )
    ));

    $get_instance->add_new_tab(array(
        'title' => esc_html__( 'Others', 'ht-instagram' ),
        'plugins' => array(

            array(
                'slug'      => 'ht-easy-google-analytics',
                'location'  => 'ht-easy-google-analytics.php',
                'name'      => esc_html__( 'HT Easy GA4 ( Google Analytics 4 )', 'ht-instagram' )
            ),

            array(
                'slug'      => 'really-simple-google-tag-manager',
                'location'  => 'really-simple-google-tag-manager.php',
                'name'      => esc_html__( 'Really Simple Google Tag Manager', 'ht-instagram' )
            ),

            array(
                'slug'      => 'faster-youtube-embed',
                'location'  => 'faster-youtube-embed.php',
                'name'      => esc_html__( 'Faster YouTube Embed', 'ht-instagram' )
            ),

            array(
                'slug'      => 'wc-sales-notification',
                'location'  => 'wc-sales-notification.php',
                'name'      => esc_html__( 'WC Sales Notification', 'ht-instagram' )
            ),

            array(
                'slug'      => 'preview-link-generator',
                'location'  => 'preview-link-generator.php',
                'name'      => esc_html__( 'Preview Link Generator', 'ht-instagram' )
            ),

            array(
                'slug'      => 'quickswish',
                'location'  => 'quickswish.php',
                'name'      => esc_html__( 'QuickSwish', 'ht-instagram' )
            ),

            array(
                'slug'      => 'docus',
                'location'  => 'docus.php',
                'name'      => esc_html__( 'Docus – YouTube Video Playlist', 'ht-instagram' )
            ),

            array(
                'slug'      => 'data-captia',
                'location'  => 'data-captia.php',
                'name'      => esc_html__( 'DataCaptia', 'ht-instagram' )
            ),

            array(
                'slug'      => 'coupon-zen',
                'location'  => 'coupon-zen.php',
                'name'      => esc_html__( 'Coupon Zen', 'ht-instagram' )
            ),

            array(
                'slug'      => 'sirve',
                'location'  => 'sirve.php',
                'name'      => esc_html__( 'Sirve – Simple Directory Listing', 'ht-instagram' )
            ),

            array(
                'slug'      => 'ht-social-share',
                'location'  => 'ht-social-share.php',
                'name'      => esc_html__( 'HT Social Share', 'ht-instagram' )
            ),

        )
    ));

    }

    // Options page Section register
    function htinstagram_admin_get_settings_sections() {
        $sections = array(
            
            array(
                'id'    => 'htinstagram_general_tabs',
                'title' => esc_html__( 'General', 'ht-instagram' )
            ),

            array(
                'id'    => 'htinstagram_widgets_style_tabs',
                'title' => esc_html__( 'Widgets', 'ht-instagram' )
            ),

            array(
                'id'    => 'htinstagram_shortcodeopt_tabs',
                'title' => esc_html__( 'Shortcode ', 'ht-instagram' )
            ),

        );
        return $sections;
    }

    // Options page field register
    protected function htinstagram_admin_fields_settings() {

        $settings_fields = array(

            'htinstagram_general_tabs'=>array(

                array(
                    'name'  => 'instagram_access_token',
                    'label' => __( 'Access Token', 'ht-instagram' ),
                    'placeholder' => __( 'Access Token', 'ht-instagram' ),
                    'type' => 'text',
                    'sanitize_callback' => 'sanitize_text_field',
                     'desc'   => wp_kses_post( '(<a href="'.esc_url('https://developers.facebook.com/docs/instagram-basic-display-api/getting-started').'" target="_blank">Lookup your Access Token</a>)', 'ht-instagram' ),
                ),

            ),

            'htinstagram_widgets_style_tabs'=>array(

                array(
                    'name'  => 'widgets_style_title',
                    'label'  => __( '<h2 class="htinstaop-headding">Style</h2>', 'ht-instagram' ),
                    'type'  => 'title',
                    'class'=>'htoptions_headding_table_row',
                ),

                array(
                    'name'  => 'likecommentbg',
                    'label' => __( 'Caption Background', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle caption area background.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'commentlike_color',
                    'label' => __( 'Caption Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can caption color.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'commentlike_font_size',
                    'label' => __( 'Caption Font Size', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle caption font size.', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'follow_background',
                    'label' => __( 'Follow Button Background Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button background.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'follow_buttoncolor',
                    'label' => __( 'Follow Button Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button color.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'follow_button_f_s',
                    'label' => __( 'Follow Button Font Size', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button font size.', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'follow_icon_color',
                    'label' => __( 'Follow Button Icon Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button icon color.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'follow_icon_background',
                    'label' => __( 'Follow Button Icon Background Color', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'You can handle follow button icon background color.', 'ht-instagram' ),
                    'type' => 'color',
                ),

                array(
                    'name'  => 'widgets_slideroptions_title',
                    'label'  => __( '<h2 class="htinstaop-headding">Slider Options</h2>', 'ht-instagram' ),
                    'type'  => 'title',
                    'class'=>'htoptions_headding_table_row htseperator',
                ),

                array(
                    'name'  => 'slider_on',
                    'label' => __( 'On', 'ht-instagram' ),
                    'desc'  => __( 'Slider: On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'slitems',
                    'label' => __( 'Number Of item', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'Number Of item to show', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'slrows',
                    'label' => __( 'Number Of item Row', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'Number Of item row to show', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 50,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'sltablet_display_columns',
                    'label' => __( 'Number Of item On Tablet', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'Number Of item show on Tablet', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 50,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'slmobile_display_columns',
                    'label' => __( 'Number Of item On Mobile', 'ht-instagram' ),
                    'desc' => wp_kses_post( 'Number Of item show on Mobile', 'ht-instagram' ),
                    'min'               => 0,
                    'max'               => 50,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'  => 'slarrows',
                    'label' => __( 'Navigation', 'ht-instagram' ),
                    'desc'  => __( 'Navigation: On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'sldots',
                    'label' => __( 'Pagination', 'ht-instagram' ),
                    'desc'  => __( 'Pagination: On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'slautolay',
                    'label' => __( 'Auto Play', 'ht-instagram' ),
                    'desc'  => __( 'Auto Play: On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'slautoplay_speed',
                    'label' => __( 'Auto Play Speed', 'ht-instagram' ),
                    'desc'  => __( 'Auto Play Speed', 'ht-instagram' ),
                    'placeholder' => __( '3000', 'ht-instagram' ),
                    'type' => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

                array(
                    'name'  => 'slanimation_speed',
                    'label' => __( 'Animation Speed', 'ht-instagram' ),
                    'desc'  => __( 'Animation Speed', 'ht-instagram' ),
                    'placeholder' => __( '300', 'ht-instagram' ),
                    'type' => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

                array(
                    'name'  => 'slcentermode',
                    'label' => __( 'Center Mode', 'ht-instagram' ),
                    'desc'  => __( 'Center Mode : On / off', 'ht-instagram' ),
                    'type'  => 'checkbox'
                ),

                array(
                    'name'  => 'slcenterpadding',
                    'label' => __( 'Center Padding', 'ht-instagram' ),
                    'desc'  => __( 'Center Padding', 'ht-instagram' ),
                    'placeholder' => __( '50', 'ht-instagram' ),
                    'type' => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

            ),

            'htinstagram_shortcodeopt_tabs'=>array(

            ),

        );
        
        return array_merge( $settings_fields );
    }


    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'HT Instagram Settings','ht-instagram' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', 'ht-instagram') ?></strong></p>
            </div>
            <?php
        }
    }

    // Short Code table
    function htinstagram_shortcode_opt_table() {
        $output = '<input type="text" title="Click the field then press Ctrl + C." onclick="this.focus();this.select()" style="text-align: center; margin-bottom:10px;" readonly="readonly" size="15" value="[htinstagram]">';
        $output .= '<table class="htinstagram_widgets_opt"><tr><th scope="row">Shortcode option</th><th scope="row">Description</th><th scope="row">Example</th></tr>';
        $output .='<tr class="httablehedding"><td colspan="3">Configure Options</td></tr>';
        $output .='<tr><td>limit</td><td>Show Number Of item.</td><td>[htinstagram limit="8"]</td></tr>';
        $output .='<tr><td>column</td><td>Show Number Of item column.</td><td>[htinstagram column="4"]</td></tr>';
        $output .='<tr><td>space</td><td>Item Space</td><td>[htinstagram space="5"]</td></tr>';
        $output .='<tr><td>showcaption</td><td>Control the caption</td><td>[htinstagram showcaption="yes"]</td></tr>';
        $output .='<tr><td>caption_pos</td><td>Control the caption position</td><td>[htinstagram caption_pos="top"]</td></tr>';
        $output .='<tr><td>showfollowbtn</td><td>Control the follow button</td><td>[htinstagram showfollowbtn="yes"]</td></tr>';
        $output .='<tr><td>followbtnpos</td><td>Control the follow button position</td><td>[htinstagram followbtnpos="yes"]</td></tr>';
        $output .='<tr><td>target</td><td>Control the follow button position</td><td>[htinstagram target="_self"]</td></tr>';
        $output .='<tr class="httablehedding"><td colspan="3">Slider Options</td></tr>';
        $output .='<tr><td>slider_on</td><td>Control the slider enable disable.</td><td>[htinstagram slider_on="yes"]</td></tr>';
        $output .='<tr><td>slarrows</td><td>Control the slider arrow enable disable.</td><td>[htinstagram slarrows="yes"]</td></tr>';

        $output .='<tr><td>slprevicon</td><td>You can change the slider previous arrow icon.</td><td>[htinstagram slprevicon="fa fa-angle-left"]</td></tr>';
        $output .='<tr><td>slnexticon</td><td>You can change the slider next arrow icon.</td><td>[htinstagram slnexticon="fa fa-angle-right"]</td></tr>';
        $output .='<tr><td>sldots</td><td>Control The slider pagination.</td><td>[htinstagram sldots="no"]</td></tr>';
        $output .='<tr><td>slautolay</td><td>Control The slider autoplay.</td><td>[htinstagram slautolay="no"]</td></tr>';
        $output .='<tr><td>slautoplay_speed</td><td>Control The slider autoplay speed.</td><td>[htinstagram slautoplay_speed="3000"]</td></tr>';
        $output .='<tr><td>slanimation_speed</td><td>Control The slider animation speed.</td><td>[htinstagram slanimation_speed="300"]</td></tr>';
        $output .='<tr><td>slcentermode</td><td>Control The slider center mode.</td><td>[htinstagram slcentermode="yes"]</td></tr>';
        $output .='<tr><td>slcenterpadding</td><td>Control The slider center mode padding.</td><td>[htinstagram slcenterpadding="15"]</td></tr>';
        $output .='<tr><td>slitems</td><td>Control The slider number of item visible.</td><td>[htinstagram slitems="4"]</td></tr>';
        $output .='<tr><td>slitems</td><td>Control The slider number of item visible.</td><td>[htinstagram slitems="4"]</td></tr>';
        $output .='<tr><td>slrows</td><td>Control The slider number of row visible.</td><td>[htinstagram slrows="1"]</td></tr>';
        $output .='<tr><td>slscroll_columns</td><td>Control slide to scroll.</td><td>[htinstagram slscroll_columns="2"]</td></tr>';
        $output .='<tr><td>sltablet_width</td><td>Control slider tablet layout width.</td><td>[htinstagram sltablet_width="750"]</td></tr>';
        $output .='<tr><td>sltablet_display_columns</td><td>Control slider display on tablet layout.</td><td>[htinstagram sltablet_display_columns="2"]</td></tr>';
        $output .='<tr><td>sltablet_display_columns</td><td>Control slider scroll amount on tablet layout.</td><td>[htinstagram sltablet_scroll_columns="2"]</td></tr>';
        $output .='<tr><td>slmobile_width</td><td>Control slider mobile layout width.</td><td>[htinstagram slmobile_width="480"]</td></tr>';
        $output .='<tr><td>slmobile_display_columns</td><td>Control slider display on mobile layout.</td><td>[htinstagram slmobile_display_columns="2"]</td></tr>';
        $output .='<tr><td>slmobile_scroll_columns</td><td>Control slider scroll amount on mobile layout.</td><td>[htinstagram slmobile_scroll_columns="2"]</td></tr>';
         $output .='<tr class="httablehedding"><td colspan="3">Styling Options</td></tr>';
         $output .='<tr><td>captionbg</td><td>Control caption area backgound color.</td><td>[htinstagram captionbg="#dddddd"]</td></tr>';
         $output .='<tr><td>caption_color</td><td>Control caption color.</td><td>[htinstagram caption_color="#ffffff"]</td></tr>';
         $output .='<tr><td>caption_font_size</td><td>Control caption font size.</td><td>[htinstagram caption_font_size="14"]</td></tr>';
         $output .='<tr><td>follow_background</td><td>Control follow button background color.</td><td>[htinstagram follow_background="#dddddd"]</td></tr>';
         $output .='<tr><td>follow_buttoncolor</td><td>Control follow button text color.</td><td>[htinstagram follow_buttoncolor="#fffff"]</td></tr>';
         $output .='<tr><td>follow_button_f_s</td><td>Control follow button font size.</td><td>[htinstagram follow_button_f_s="14"]</td></tr>';
         $output .='<tr><td>follow_icon_color</td><td>Control follow button icon color.</td><td>[htinstagram follow_icon_color="#dddddd"]</td></tr>';
         $output .='<tr><td>follow_icon_background</td><td>Control follow button icon backgound color.</td><td>[htinstagram follow_icon_background="#ffffff"]</td></tr>';
        $output .= '</table>';
        echo $output;
    }
    

}

new HTinstagram_Admin_Settings();