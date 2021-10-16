<?php 
/*
@package mytheme

=========================
    ADMIN PAGE
=========================     
*/
namespace Inc;


class Admin {

    private static $instance = null;


   private function __construct() {
     add_action( 'admin_menu', [$this, 'mytheme_add_admin_page'] );
   }

    public function mytheme_add_admin_page() {

        // generate menu page
        add_menu_page( 'Mytheme Theme Options', 'Mytheme', 'manage_options', 'mytheme', [ $this, 'mytheme_create_page' ], 'dashicons-admin-customizer', 110 );
    
        // generate menu sub pages
        add_submenu_page( 'mytheme', 'Mytheme Theme Options', 'General', 'manage_options', 'mytheme', [ $this, 'mytheme_create_page' ] );
        add_submenu_page( 'mytheme', 'Mytheme Css Options', 'Custom CSS', 'manage_options', 'mytheme_css', [ $this, 'mytheme_settings_page' ] );
    
        // generate custom settings
        add_action( 'admin_init', [$this, 'mytheme_custom_settings'] );
    
    }

    public function mytheme_custom_settings() {
        // register custom settings
        register_setting( 'mytheme_settings_group', 'first_name' );
        register_setting( 'mytheme_settings_group', 'last_name' );
        register_setting( 'mytheme_settings_group', 'user_description' );
        register_setting( 'mytheme_settings_group', 'twitter_handler', [ $this, 'mytheme_sanitize_twitter_handler' ] );
        register_setting( 'mytheme_settings_group', 'facebook_handler' );
        register_setting( 'mytheme_settings_group', 'gplus_handler' );


        add_settings_section( 'mytheme_sidebar_options', 'Sidebar Option', [ $this, 'mytheme_sidebar_options' ], 'mytheme' );
        add_settings_field( 'sidebar_name', 'Full name', [ $this, 'mytheme_sidebar_name' ], 'mytheme', 'mytheme_sidebar_options' );
        add_settings_field( 'sidebar_description', 'Description', [ $this, 'mytheme_sidebar_description' ], 'mytheme', 'mytheme_sidebar_options' );
        add_settings_field( 'sidebar_twitter', 'Twitter handler', [ $this, 'mytheme_sidebar_twitter' ], 'mytheme', 'mytheme_sidebar_options' );
        add_settings_field( 'sidebar_facebook', 'Facebook handler', [ $this, 'mytheme_sidebar_facebook' ], 'mytheme', 'mytheme_sidebar_options' );
        add_settings_field( 'sidebar_gplus', 'Google+ handler', [ $this, 'mytheme_sidebar_gplus' ], 'mytheme', 'mytheme_sidebar_options' );
    }
    
    public function mytheme_sidebar_options() {
        echo 'Customize your Sidebar Information';
    }
    
    public function mytheme_sidebar_name() {
        $first_name = esc_attr( get_option( 'first_name' ) );
        $last_name = esc_attr( get_option( 'last_name' ) );
        echo '<input type="text" name="first_name" value="'.$first_name.'" placeholder="First Name" >
         <input type="text" name="last_name" value="'.$last_name.'" placeholder="Last Name" >';
    }

    public function mytheme_sidebar_description() {
        $user_description = esc_attr( get_option( 'user_description' ) );
        echo '<input type="text" name="user_description" value="'.$user_description.'" placeholder="Description" >';
    }


    public function mytheme_sidebar_twitter() {
        $twitter = esc_attr( get_option( 'twitter_handler' ) );
        echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter handler" ><p class="description">Input your twitter name without @ character.</p>';
    }

    public function mytheme_sidebar_facebook() {
        $facebook = esc_attr( get_option( 'facebook_handler' ) );
        echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook handler" >';
    }

    public function mytheme_sidebar_gplus() {
        $gplus = esc_attr( get_option( 'gplus_handler' ) );
        echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Gplus handler" >';
    }
    
    public function mytheme_create_page() {
        // generation of admin page
        require_once( get_template_directory(). '/inc/templates/mytheme-admin.php' );
    }
    
    public function mytheme_settings_page() {
        // generation of settings subpage
    }

    // Settings sanitization
    function mytheme_sanitize_twitter_handler( $input ) {
        $output = sanitize_text_field( $input );
        return str_replace( '@', '', $output );
    }


    public static function getInstance() {
        if ( !isset( $instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}

