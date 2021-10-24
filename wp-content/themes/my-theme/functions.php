<?php
use Inc\Admin;
use Inc\Enqueue;
use Inc\ThemeSupport;

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) { require_once dirname( __FILE__ ) . '/vendor/autoload.php'; }

// all classes 
$classes = [ 
    Enqueue::class,
    Admin::class,
    ThemeSupport::class
];


foreach ( $classes as $class ) {
    $class::getInstance();
}