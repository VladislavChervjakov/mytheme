<?php 
/*
@package mytheme

=========================
    Enqueue Functions
=========================     
*/

namespace Inc;

final class Enqueue {

    private static $instance = null;


    private function __construct() {
       add_action( 'admin_enqueue_scripts', [ $this, 'mytheme_load_admin_scripts' ] );
        
    }


    public function mytheme_load_admin_scripts( $hook ) {

        if ( 'toplevel_page_mytheme' !== $hook ) { return; }
 
        wp_register_style( 'mytheme_admin', get_template_directory_uri() . '/css/mytheme.admin.css', [], '1.0.0', 'all' );
        wp_enqueue_style( 'mytheme_admin' );

        wp_enqueue_media();

        wp_register_script( 'mytheme_admin_script', get_template_directory_uri() . '/js/mytheme.admin.js', [ 'jquery' ], '1.0.0', true );
        wp_enqueue_script( 'mytheme_admin_script' );
    }


    public static function getInstance() {
        if ( !isset( $instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}