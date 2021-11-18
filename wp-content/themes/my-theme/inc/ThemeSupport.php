<?php
/*
@package mytheme

=========================
    Theme Support
=========================     
*/

namespace Inc;

class ThemeSupport{

    private static $instance = null;

    public function __construct() {
        $this->add_theme_support();
    }

    public function add_theme_support() {
        $options = get_option( 'post_formats' );
        $formats = [ 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ];
        $output = [];
        foreach ( $formats as $format ) {
            $output[] = @$options[$format] === '1' ? $format : '';
        }
        if( !empty( $options ) ) {
            add_theme_support( 'post-formats', $output );
        }

        $header = get_option( 'custom_header' );
        if ( @$header === '1' ) {
            add_theme_support( 'custom-header' );
        }

        $background = get_option( 'custom_background' );
        if ( @$background === '1' ) {
            add_theme_support( 'custom-background' );
        }
    }

    public static function getInstance() {
        if ( !isset( $instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}