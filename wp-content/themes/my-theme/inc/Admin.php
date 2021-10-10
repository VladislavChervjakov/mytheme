<?php 
/*
@package mytheme

=========================
    ADMIN PAGE
=========================     
*/
namespace Inc;


class Admin{

   public function __construct() {
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
        add_settings_section( 'mytheme_sidebar_options', 'Sidebar Option', [ $this, 'mytheme_sidebar_options' ], 'mytheme' );
        add_settings_field( 'sidebar_name', 'First name', [ $this, 'mytheme_sidebar_name' ], 'mytheme', 'mytheme_sidebar_options' );
    }
    
    public function mytheme_sidebar_options() {
        echo 'Customize your Sidebar Information';
    }
    
    public function mytheme_sidebar_name() {
        $first_name = esc_attr( get_option( 'first_name' ) );
        echo '<input type="text" name="first_name" value="'.$first_name.'" placeholder="First Name" >';
    }
    
    public function mytheme_create_page() {
        // generation of admin page
        require_once( get_template_directory(). '/inc/templates/mytheme-admin.php' );
    }
    
    public function mytheme_settings_page() {
        // generation of settings subpage
    }

}

