<?php
/**
 * Plugin Name:       Tiny Slider
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       This is a books review custome post type plugin
 * Version:           1.01
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Abdullah Al Mahi
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tiny-slider
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ){
    exit;
}

/**
 * Class Tiny_Slider
 */

final class Tiny_Slider{

    /**
     *  plugin version
     */
    const version = 1.01;

    /**
     * Tiny_Slider constructor.
     */

    public function __construct() {
        $this->defined_constant();
        add_shortcode( 'tiny_slider', [ $this , 'tinys_shortcode_slider' ] );
        add_shortcode( 'tiny_slide', [ $this , 'tinys_shortcode_slide' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'tiny_assets' ] );
        add_action( 'init', [ $this, 'tiny_init' ] );
    }

    /**
     * initialize a singleton instance
     *
     * @return false|Tiny_Slider
     */

    public static function init() {
        static $instance = false;
        if ( ! $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * defined basic constant of plugin
     */
    public function defined_constant() {
        define( 'TS_VERSION', self::version );
        define( 'TS_FILE', __FILE__ );
        define( 'TS_PATH', __DIR__ );
        define( 'TS_URL', plugins_url( '', TS_FILE ) );
        define( 'TS_ASSETS', TS_URL .'/assets' );
    }

    /**
     *  main plugin initialize
     */

    public function init_plugin() {

    }

    public function tiny_init() {
        add_image_size( 'tiny-slider', '600', '480' );
    }

    /**
     * Tines shortcode slider
     *
     * @param $argument
     * @param $content
     */
    public function tinys_shortcode_slider( $arguments, $content ) {
        $defaults   = array(
            'width'  => 800,
            'height' => 600,
        );
        $attributes = shortcode_atts( $defaults, $arguments );
        $content    = do_shortcode( $content );

        $shortcode_output = <<<EOD
        <div style="width:{$attributes['width']};height:{$attributes['height']}">
	        <div class="slider">
	            {$content}
	        </div>
        </div>
EOD;
        return $shortcode_output;

    }

    public function tinys_shortcode_slide( $arguments ) {
        $defaults   = array(
            'caption'   => '',
            'id'        => '',
            'size'      =>'tiny-slider'
        );
        $attributes = shortcode_atts( $defaults, $arguments );

        $image_src  = wp_get_attachment_image_src( $attributes['id'], $attributes['size'] );

//        var_dump($image_src);

        $shorcode_output = <<<EOD
            <div class='slide'>
                <p><img src="{$image_src[0]}" alt="{$attributes['caption']}"></p>
                <p>{$attributes['caption']}</p>
            </div>
EOD;
        return $shorcode_output;
    }


    /**
     *  tiny slider assets file load
     */

    public function tiny_assets() {
        wp_enqueue_style( 'tiny-slider-css', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css', null, 1.0 );
        wp_enqueue_script( 'tiny-slider-js', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', null, '1.0',true );
        wp_enqueue_script( 'tiny-slider-main-js', plugin_dir_url(  __FILE__ ).'/assets/js/main.js',  array( 'jquery' ), '1.0',true );
    }
}

/**
 * main plugin function
 * @return false|Tiny_Slider
 */

function tiny_slider() {
    return Tiny_Slider::init();
}

/*
 * call the function
 */
tiny_slider();