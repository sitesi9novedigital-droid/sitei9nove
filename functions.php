<?php
/** Theme assets and block editor support. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
add_action( 'after_setup_theme', function () {
    add_theme_support( 'wp-block-styles' );
    add_editor_style( 'assets/theme.css' );
} );
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'i9nove-theme', get_theme_file_uri( 'assets/theme.css' ), array(), wp_get_theme()->get( 'Version' ) );
} );
add_action( 'init', function () {
    register_block_pattern_category( 'i9nove', array( 'label' => __( 'i9nove Digital', 'i9nove' ) ) );
} );
