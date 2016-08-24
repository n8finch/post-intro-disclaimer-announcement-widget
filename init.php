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
Text Domain: pida-widget
*/

namespace post_intro_disclaimer_announcement_widget;

require_once plugin_dir_path( __FILE__ ) . 'inc/main.php';

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\add_these_plugin_styles_and_scripts' );

function add_these_plugin_styles_and_scripts() {

	wp_enqueue_style( 'included-styles', plugin_dir_url( __FILE__ ) . 'css/included_styles.css' );

	wp_enqueue_script( 'included-js', plugin_dir_url( __FILE__ ) . 'js/included_js.js', array( 'jquery' ), false, false );

}


/**
 * Register Post Intro Disclaimer Announcements Custom Widget Area
 */

add_action( 'widgets_init', __NAMESPACE__ . '\add_pida_widget_area_to_widgets' );
function add_pida_widget_area_to_widgets() {

	register_sidebar( array(
		'name'          => __( 'Post Intro Disclaimer Announcements', 'pida-widget' ),
		'id'            => 'pida-widget-area',
		'description'   => 'Add the Post Intro Disclaimer Announcements Widget to this area (or any widget you would like at the beginning of all posts or specific post categories',
		'class'         => '',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	) );
}


add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\add_pida_widget_to_post' );


function add_pida_widget_to_post() {

	if ( is_active_sidebar( 'pida-widget-area' ) ) :
		?>
		<div id="pida-widget-area" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'pida-widget-area' );
			?>
		</div><!-- #pida-widget-area-sidebar -->
	<?php endif;
}

