<?php
/*
Plugin Name: Post Intro Disclaimer Announcements
Plugin URI:  https://github.com/n8finch/post-intro-disclaimer-announcement-widget
Description: Allows users to place a disclaimer widget into a custom widget area, which will display on all posts or in specific categories.
Version:     1.0.0
Author:      Nate Finch
Author URI:  https://n8finch.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: post-intro-disclaimer-announcement-widget
*/

namespace post_intro_disclaimer_announcement_widget;

require_once plugin_dir_path( __FILE__ ) . 'inc/main.php';

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\add_these_plugin_styles_and_scripts' );

function add_these_plugin_styles_and_scripts() {

	wp_enqueue_style( 'included-styles', plugin_dir_url( __FILE__ ) . 'css/included_styles.css' );

	wp_enqueue_script( 'included-js', plugin_dir_url( __FILE__ ) . 'js/included_js.js', array( 'jquery' ), false, false );

}



