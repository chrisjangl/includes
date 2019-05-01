<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Widgets
 *
 * Handle class definitions for theme specific widgets:
 * ****dc_linked_image
 * ****dc_widget_link_text

 *
 * @version     1.0
 * @package     Child theme
 * @subpackage  Includes
 * @author      Digitally Cultured
 */

/**** Actions ****/

	add_action( 'widgets_init', 'register_dc_widget' );
	
/**** end Actions ****/

/**** Function definitions ****/

	function register_dc_widget() {
		register_widget( 'dc_linked_image' );
		register_widget( 'dc_widget_link_text' );
	}

	/**
	 * DC Text Widget
	 * This class handles everything that needs to be handled with the widget:
	 * the settings, form, display, and update
	 *
	 * Text widget class
	 *
	 * @since 2.8.0
	 */
	class dc_linked_image extends WP_Widget {

		public function __construct() {
			$widget_ops = array('classname' => 'grid col-220', 'description' => __('link images.'));
			$control_ops = array('width' => 400, 'height' => 350);
			parent::__construct('dc-linked_image', __('DC - Linked Image'), $widget_ops, $control_ops);
			add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
		}
		
		public function upload_scripts() {
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('upload_media_widget', get_stylesheet_directory_uri() . '/assets/js/upload-media.js', array('jquery'));
			wp_enqueue_media();
			wp_enqueue_style('thickbox');
		}

		public function widget( $args, $instance ) {


			/**
			 * Filter the content of the Text widget.
			 *
			 * @since 2.3.0
			 *
			 * @param string    $widget_text The widget content.
			 * @param WP_Widget $instance    WP_Widget instance.
			 */
			$image_id = apply_filters( 'dc-linked_image', empty( $instance['image_id'] ) ? '' : $instance['image_id'], $instance );
			$link = apply_filters( 'dc-linked_image', empty( $instance['link'] ) ? '' : $instance['link'], $instance );
			
			echo $args['before_widget'];
			if ( ! empty( $image_id ) ) {
				echo (empty( $args['before_link'] ) ? '' : $args['before_link'] ) . '<a href="' . $link . '"' . ( empty( $args['link_class'] ) ? '' : 'class="' . $args['link_class'] . '" ' ) . ' >';
				echo (empty( $args['before_image'] ) ? '' : $args['before_image']) . wp_get_attachment_image ($image_id, 'large' );
				echo '</a>';
				echo (empty( $args['after_link'] ) ? '' : $args['after_link'] );
			}
			
			echo $args['after_widget'];
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['link'] = $new_instance['link'];
			$instance['image_id'] = $new_instance['image_id'];

			return $instance;
		}

		public function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array( 'link' => '', 'image_id' => '' ) );
			$link = $instance['link'];
			$image_id = $instance['image_id'];
		?>

		<?php if ( !empty( $image_id ) ) {
				?>
			<p>
				<?php echo wp_get_attachment_image($image_id, array('150', 'auto')); ?>
			</p>
		<?php
			}
		?>
			<p>
				<input class="widefat" id="<?php echo $this->get_field_id('image_id'); ?>" name="<?php echo $this->get_field_name('image_id'); ?>" type="hidden" value="<?php echo esc_attr($image_id); ?>" />
				<input class="upload_image_button button button-primary" type="button" value="Upload/Change Image" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('link') ?>"><?php _e('URL:'); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" value="<?php echo $link; ?>"/>
			</p>

		<?php
		}
	}

	class dc_widget_link_text extends WP_Widget {

		public function __construct() {
			$widget_ops = array('classname' => 'widget_text-DC ', 'description' => __('A revamp of the classic text widget to allow a cudstom link.'));
			$control_ops = array('width' => 400, 'height' => 350);
			parent::__construct('dc-link-text', __('DC - Text with Link'), $widget_ops, $control_ops);
		}

		public function widget( $args, $instance ) {

			/** This filter is documented in wp-includes/default-widgets.php */
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			/**
			 * Filter the content of the Text widget.
			 *
			 * @since 2.3.0
			 *
			 * @param string    $widget_text The widget content.
			 * @param WP_Widget $instance    WP_Widget instance.
			 */
			$link = apply_filters( 'dc_text_widget_link', empty( $instance['link'] ) ? '' : $instance['link'], $instance );
			$link_text = apply_filters( 'dc_text_widget_link_text', empty( $instance['link_text'] ) ? '' : $instance['link_text'], $instance );
			$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
			echo $args['before_widget'];
			if ( ! empty( $image ) ) {
				echo (empty( $args['before_image'] ) ? '' : $args['before_image']) . '<img src="' . $image . '" class="' . ( empty( $args['image_class'] ) ? '' : $args['image_class'] ) . '" />';
			}
			
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			} ?>
				<div class="textwidget grid col-700" style="float: none; margin: 0 auto;"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
			
		<?php
			if ( ! empty( $link ) ) {
		?>
				<a href="<?php echo $link; ?>" ><?php echo ( empty( $link_text ) ? $link : $link_text ); ?></a>
		<?php
			}
			
			echo $args['after_widget'];
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;    
			$instance['link'] = $new_instance['link'];
			$instance['link_text'] = $new_instance['link_text'];
			$instance['image'] = $new_instance['image'];
			$instance['title'] = strip_tags($new_instance['title']);
			if ( current_user_can('unfiltered_html') )
				$instance['text'] =  $new_instance['text'];
			else
				$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
			$instance['filter'] = ! empty( $new_instance['filter'] );
			return $instance;
		}

		public function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'image' => '', 'link' => '', 'link_text' => '' ) );
			$title = strip_tags($instance['title']);
			$text = esc_textarea($instance['text']);
			$image = $instance['image'];
			$link = $instance['link'];
			$link_text = $instance['link_text'];
			
		?>
			<p>
				<label for="<?php echo $this->get_field_id('image') ?>"><?php _e('Image:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo esc_attr($image); ?>" />
			</p>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

			<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>

			<p>
				<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="url" value="<?php echo esc_attr($link); ?>" />
				<label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Link Text:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo esc_attr($link_text); ?>" />
			</p>
		<?php
		}
	}

/**** end Function definitions ****/
