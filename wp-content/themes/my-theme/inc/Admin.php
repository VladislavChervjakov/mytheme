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
        add_submenu_page( 'mytheme', 'Mytheme Theme Options', 'Sidebar', 'manage_options', 'mytheme', [ $this, 'mytheme_create_page' ] );
        add_submenu_page( 'mytheme', 'Mytheme Theme Options', 'Theme Options', 'manage_options', 'mytheme_theme', [ $this, 'mytheme_support_page' ] );
        add_submenu_page( 'mytheme', 'Mytheme Contact Form', 'Contact Form', 'manage_options', 'mytheme_contact', [ $this, 'mytheme_contact_form_page' ] );
        add_submenu_page( 'mytheme', 'Mytheme Css Options', 'Custom CSS', 'manage_options', 'mytheme_css', [ $this, 'mytheme_settings_page' ] );
    
        // generate custom settings
        add_action( 'admin_init', [$this, 'mytheme_custom_settings'] );
    
    }

    public function mytheme_custom_settings() {
        // register custom settings

        // Sidebar Options
        register_setting( 'mytheme_settings_group', 'profile_picture' );
        register_setting( 'mytheme_settings_group', 'first_name' );
        register_setting( 'mytheme_settings_group', 'last_name' );
        register_setting( 'mytheme_settings_group', 'user_description' );
        register_setting( 'mytheme_settings_group', 'twitter_handler', [ $this, 'mytheme_sanitize_twitter_handler' ] );
        register_setting( 'mytheme_settings_group', 'facebook_handler' );
        register_setting( 'mytheme_settings_group', 'gplus_handler' );


        add_settings_section( 'mytheme_sidebar_options', 'Sidebar Option', [ $this, 'mytheme_sidebar_options' ], 'mytheme' );

        add_settings_field( 'sidebar_profile_picture', 'Profile picture', [ $this, 'mytheme_sidebar_profile_picture' ], 'mytheme', 'mytheme_sidebar_options' );
        add_settings_field( 'sidebar_name', 'Full name', [ $this, 'mytheme_sidebar_name' ], 'mytheme', 'mytheme_sidebar_options' );
        add_settings_field( 'sidebar_description', 'Description', [ $this, 'mytheme_sidebar_description' ], 'mytheme', 'mytheme_sidebar_options' );
        add_settings_field( 'sidebar_twitter', 'Twitter handler', [ $this, 'mytheme_sidebar_twitter' ], 'mytheme', 'mytheme_sidebar_options' );
        add_settings_field( 'sidebar_facebook', 'Facebook handler', [ $this, 'mytheme_sidebar_facebook' ], 'mytheme', 'mytheme_sidebar_options' );
        add_settings_field( 'sidebar_gplus', 'Google+ handler', [ $this, 'mytheme_sidebar_gplus' ], 'mytheme', 'mytheme_sidebar_options' );


        // Theme Support Options
        register_setting( 'mytheme_theme_support', 'post_formats' );
        register_setting( 'mytheme_theme_support', 'custom_header' );
        register_setting( 'mytheme_theme_support', 'custom_background' );

        add_settings_section( 'mytheme_theme_options', 'Theme Options', [ $this, 'mytheme_theme_options_callback' ], 'mytheme_support_page' );

        add_settings_field( 'post_formats', 'Post Formats', [ $this, 'mytheme_post_formats' ], 'mytheme_support_page', 'mytheme_theme_options' );
        add_settings_field( 'custom_header', 'Custom Header', [ $this, 'mytheme_custom_header' ], 'mytheme_support_page', 'mytheme_theme_options' );
        add_settings_field( 'custom_background', 'Custom Background', [ $this, 'mytheme_custom_background' ], 'mytheme_support_page', 'mytheme_theme_options' );

        // Contact Form Options
        register_setting( 'mytheme_contact_options', 'activate_contact' );

        add_settings_section( 'mytheme_contact_section', 'Contact Form', [ $this, 'mytheme_contact_section' ], 'mytheme_theme_contact' );

        add_settings_field( 'activate_form', 'Activate Contact Form', [ $this, 'mytheme_activate_form' ], 'mytheme_theme_contact', 'mytheme_contact_section' );


    }


    public function mytheme_sidebar_options() {
        echo 'Customize your Sidebar Information';
    }

    public function mytheme_theme_options_callback() {
        echo 'Activate and Deactivate specific Theme Support Options';
    }

    public function mytheme_contact_section() {
        echo 'Activate and Deactivate the Built-in Contact Form';
    }

    public function mytheme_post_formats() {
        $options = get_option( 'post_formats' );
        $formats = [ 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ];
        $output = '';
        foreach ( $formats as $format ) {
            $checked = @$options[$format] === '1' ? 'checked' : '';
            $output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.'> '.$format.'</label><br>';
        }

        echo $output;
    }

    public function mytheme_custom_header() {
        $options = get_option( 'custom_header' );
        $checked = @$options === '1' ? 'checked' : '';
        echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.'>Activate the Custom Header</label>';
    }

    public function mytheme_activate_form() {
        $options = get_option( 'activate_contact' );
        $checked = @$options === '1' ? 'checked' : '';
        echo '<label><input type="checkbox" id="custom_header" name="activate_contact" value="1" '.$checked.'></label>';
    }

    public function mytheme_custom_background() {
        $options = get_option( 'custom_background' );
        $checked = @$options === '1' ? 'checked' : '';
        echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.'>Activate the Custom Background</label>';

    }

    // Sidebar Options Functions

    public function mytheme_sidebar_profile_picture() {
        $profile_picture = esc_url( get_option( 'profile_picture' ) );
        if ( empty( $profile_picture ) ) {
            echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button">
            <input type="hidden" name="profile_picture" value="" id="profile-picture" >';
        } else {
            echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button">
            <input type="hidden" name="profile_picture" value="'.$profile_picture.'" id="profile-picture" ><input type="button" 
                class="button button-secondary" value="Remove" id="remove-picture">';
        }
    
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

    public function mytheme_support_page() {
        require_once( get_template_directory() . '/inc/templates/mytheme-support.php' );
    }

    public function mytheme_contact_form_page() {
        require_once( get_template_directory() . '/inc/templates/mytheme-contact.php' );
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

