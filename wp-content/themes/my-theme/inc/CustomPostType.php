<?php

namespace Inc;

class CustomPostType
{
    private static $instance = null;

    public function __construct() {
        $this->add_cpt();
    }

    public function add_cpt() {
        $contact = get_option( 'activate_contact' );
        if ( @$contact === '1' ) {
            add_action( 'init', [ $this, 'mytheme_contact_cpt' ] );

            add_filter( 'manage_mytheme-contact_posts_columns', [ $this, 'mytheme_set_contact_columns' ] );
            add_filter( 'manage_mytheme-contact_posts_custom_column', [ $this, 'mytheme_set_contact_column' ], 10, 2 );
        }
    }


    public function mytheme_contact_cpt() {
        $labels = [
            'name'           => 'Messages',
            'singular_name'  => 'Message',
            'menu_name'      => 'Messages',
            'name_admin_bar' => 'Message'
        ];

        $args = [
            'labels'          => $labels,
            'show_ui'         => true,
            'show_in_menu'    => true,
            'capability_type' => 'post',
            'hierarchical'    => false,
            'menu_position'   => 26,
            'menu_icon'       => 'dashicons-email-alt',
            'supports'        => [ 'title', 'editor', 'author' ]
        ];

        register_post_type( 'mytheme-contact', $args );
    }

    public function mytheme_set_contact_columns( $columns ) {
        return [
            'title' => 'Full Name',
            'message' => 'Message',
            'email' => 'Email',
            'date' => 'Date'
        ];
    }

    public function mytheme_set_contact_column( $column, $post_id ) {
        switch ( $column ) {
            case 'message' :
                echo get_the_excerpt();
                break;

            case 'email' :
                echo 'email address';
                break;
        }
    }

    public static function getInstance() {
        if ( !isset( $instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}