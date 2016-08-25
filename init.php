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

//* If Genesis is being used, add the box to the post.
//add_action( 'genesis_before_entry_content', __NAMESPACE__ . '\add_pida_widget_to_post_in_genesis' );
function add_pida_widget_to_post_in_genesis() {
	if ( is_single()  && is_active_sidebar( 'pida-widget-area' ) ) :
		?>
		<div id="pida-widget-area" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'pida-widget-area' );
			?>
		</div><!-- #pida-widget-area-sidebar -->
	<?php endif;
}

//* Otherwise, use a filter for standard WordPress themes.
add_filter( 'the_content', __NAMESPACE__ . '\add_pida_widget_to_post_in_wp', 1, 1 );
function add_pida_widget_to_post_in_wp( $content ) {

	if ( is_single()  && is_active_sidebar( 'pida-widget-area' ) ) :

		//Get the options for the pida_widget
		$pida_options = get_option('widget_pida_widget');

		//Get assign the pida_widget options to variables
		$current_key = key($pida_options);
		$pida_text = $pida_options[$current_key]['pida_text'];
		$pida_categories = explode(',', str_replace(' ', '', $pida_options[$current_key]['pida_categories']));
		$pida_highlight = $pida_options[$current_key]['pida_highlight'];
		$pida_text_color = $pida_options[$current_key]['pida_text_color'];
		$pida_background = $pida_options[$current_key]['pida_background'];

		//If options are blank, provide defaults
		( $pida_highlight == '' ) ? $pida_highlight = '#D2403F' : null;
		( $pida_text_color == '' ) ? $pida_text_color = '#000' : null;
		( $pida_background == '' ) ? $pida_background = '#ddd' : null;

		//Build the pida_widget_block
		if ( in_category( $pida_categories ) ) {

			//Build the pida_widget_block
			$pida_widget_block = '<div id="pida-widget-area" class="widget-area" role="complementary">';


			$pida_widget_block .= '<div class="textwidget pida-widget" style="padding: 10px 10px 10px 20px; margin-bottom: 20px; background-color: ' . $pida_background . '; color: ' . $pida_text_color . '; border-left: 3px solid ' . $pida_highlight . ';"">' . $pida_text . '</div>';

			$pida_widget_block .= '</div><!-- #pida-widget-area-sidebar -->';

			$content = $pida_widget_block . $content;
		}

		endif;

	return $content;
}

