<?php

namespace post_intro_disclaimer_announcement_widget\main;

class PIDA_Widget extends \WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'pida_widget',
			'description' => 'Place a disclaimer widget into a custom widget area, which will display on all posts or in specific categories.',
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'my_widget', 'Post Intro Disclaimer Announcements', $widget_ops, $control_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */

		$widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';
		$pida_highlight = ! empty( $instance['pida_highlight'] ) ? $instance['highlight'] : '';
		$pida_text = ! empty( $instance['pida_text'] ) ? $instance['pida_text'] : '';
		$pida_background = ! empty( $instance['pida_background'] ) ? $instance['pida_background'] : '';

		/**
		 * Filters the content of the Text widget.
		 *
		 * @since 2.3.0
		 * @since 4.4.0 Added the `$this` parameter.
		 *
		 * @param string         $widget_text The widget content.
		 * @param array          $instance    Array of settings for the current widget.
		 * @param WP_Widget_Text $this        Current Text widget instance.
		 */
		$text = apply_filters( 'widget_text', $widget_text, $instance, $this );
		$pida_highlight = $instance['pida_highlight'];
		$pida_text = $instance['pida_text'];
		$pida_background = $instance['pida_background'];

		//Set defaults if variables are empty
		( $pida_highlight == '' ) ? $pida_highlight = '#D2403F' : null;
		( $pida_text == '' ) ? $pida_text = '#000' : null;
		( $pida_background == '' ) ? $pida_background = '#ddd' : null;

		echo $args['before_widget'];
		?>
		<div class="textwidget pida-widget" style="padding: 10px 10px 10px 20px; margin-bottom: 20px; background-color: <?php echo $pida_background; ?>; color: <?php echo $pida_text; ?>; border-left: 3px solid <?php echo $pida_highlight; ?>;"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
		<?php
		echo $args['after_widget'];


	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {

		$pida_highlight = esc_attr($instance['pida_highlight']);
		$pida_text = esc_attr($instance['pida_text']);
		$pida_background = esc_attr($instance['pida_background']);
		?>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function()
			{
				// colorpicker field
				jQuery('.cw-color-picker').each(function(){
					var $this = jQuery(this),
						id = $this.attr('rel');

					$this.farbtastic('#' + id);
				});
			});
			//]]>
		</script>

		<?php
		$instance = wp_parse_args( (array) $instance, array( 'text' => '' ) );
		$filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
		?>
		<!--PIDA Text Box-->
		<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:' ); ?></label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>

		<!--Highlight Color Picker-->
		<p>
			<label for="<?php echo $this->get_field_id('pida_highlight'); ?>"><?php _e('Highlight Color:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('pida_highlight'); ?>" name="<?php echo $this->get_field_name('pida_highlight'); ?>" type="text" value="<?php if($pida_highlight) { echo $pida_highlight; } else { echo '#D2403F'; } ?>" />
		<div class="cw-color-picker" rel="<?php echo $this->get_field_id('pida_highlight'); ?>"></div>
		</p>
		<!--Text Color Picker-->
		<p>
			<label for="<?php echo $this->get_field_id('pida_text'); ?>"><?php _e('Text Color:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('pida_text'); ?>" name="<?php echo $this->get_field_name('pida_text'); ?>" type="text" value="<?php if($pida_text) { echo $pida_text; } else { echo '#000'; } ?>" />
		<div class="cw-color-picker" rel="<?php echo $this->get_field_id('pida_text'); ?>"></div>
		</p>
		<!--Background Color Picker-->
		<p>
			<label for="<?php echo $this->get_field_id('pida_background'); ?>"><?php _e('Background Color:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('pida_background'); ?>" name="<?php echo $this->get_field_name('pida_background'); ?>" type="text" value="<?php if($pida_background) { echo $pida_background; } else { echo '#ddd'; } ?>" />
		<div class="cw-color-picker" rel="<?php echo $this->get_field_id('pida_background'); ?>"></div>
		</p>



		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['pida_highlight'] = strip_tags($new_instance['pida_highlight']);
		$instance['pida_text'] = strip_tags($new_instance['pida_text']);
		$instance['pida_background'] = strip_tags($new_instance['pida_background']);
		return $instance;
	}
} //end PIDA Widget Class









/**
 * Register the Widget
 */
add_action( 'widgets_init', function() {
	register_widget( __NAMESPACE__ . '\PIDA_Widget' );
});

/**
 * Add Farbtastic Color Picker Styles and Scripts
 */
function pida_load_color_picker_script() {
	wp_enqueue_script('farbtastic');
}
function pida_load_color_picker_style() {
	wp_enqueue_style('farbtastic');
}
add_action('admin_print_scripts-widgets.php', 'sample_load_color_picker_script');
add_action('admin_print_styles-widgets.php', 'sample_load_color_picker_style');
