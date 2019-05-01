<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Theme functions
 *
 * Function definition for use in different areas of our child theme
 ** 
 ** 
 *
 * @version     1.0
 * @package     Child theme
 * @subpackage  Includes
 * @author      Digitally Cultured
 */

/**** Actions, hooks & filters ****/

/**** end Actions, hooks & filters ****/

/**** Function overrides (typically from Parent Theme) ****/

/**** end Function overrides (typically from Parent Theme) ****/

/**** Function definitions ****/

	/*** Section: Navigation Elements
	 *
	 *
	 ***/
		function dc_display_social_nav( $services=[] ) {
			if ( !empty( $services ) ) {
				$return = '';

				foreach ( $services as $service ) {
					$url = dc_get_social_link( $service );

					if ( $url )
						echo "<a href=\"" . $url . "\" class=\"dc-social-icon\" ><i class=\"tcfa tcfa-" . $service . " tcfa-3x\"></i></a>";
				}

			}
			
		}

		function dc_display_header_social_nav( $services=[] ) {

			if ( !empty( $services ) ) {
				$return = '';
				
				foreach ( $services as $service ) {
					$url = dc_get_social_link( $service );
					
					if ( $url )
					echo "<a href=\"" . $url . "\" class=\"dc-social-icon dc-$service\" ><i class=\"tcfa tcfa-" . $service . " tcfa-3x\"></i></a>";
					
					if ( $service == 'phone' && $url ) {

							echo "<div class=\"dc-social-links\" >$url</div>";

					}
				}

			}
			
		}


	/** end navigation elements **/ 

	function dc_display_logo( $which_logo="primary") {
		if ( get_theme_mod($which_logo . '-logo') ) {
			$logo_id = get_theme_mod($which_logo . '-logo');

			$img_src = wp_get_attachment_image_url($logo_id, 'large');
			$img_srcset = wp_get_attachment_image_srcset( $logo_id, 'large' ); ?>
			
				<div id="logo">
					<a href="<?php echo esc_url(home_url( '/' )); ?>">
						<img src="<?php echo esc_url( $img_src ); ?>" srcset="<?php echo esc_attr( $img_srcset ); ?>" sizes="(max-width: 50em) 87vw, 680px" alt="">
					</a>
				</div><!-- end of #logo -->

			<?php 
		} else {
			?>
				<div id="logo">
					<span class="site-name"><a href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
					<span class="site-description"><?php bloginfo( 'description' ); ?></span>
				</div><!-- end of #logo -->
			<?php
		}

	}

	function dc_get_social_link( $service ) {

		$responsive_options = responsive_get_options();
   
		$social_link = $responsive_options[$service . '_uid'];
   
		if ( $social_link ) 
			return $social_link;
	   else 
		   return false;
   
	}
   
	function dc_get_nap_address() {
		$responsive_options = responsive_get_options();
   
		$return['company'] = isset( $responsive_options['company_uid'] ) ? $responsive_options['company_uid'] : false;
		$return['address_1'] = isset( $responsive_options['address_1'] ) ? $responsive_options['address_1'] : false;
		$return['address_city'] = isset( $responsive_options['address_city'] ) ? $responsive_options['address_city'] : false;
		$return['address_state'] = isset( $responsive_options['address_state'] ) ? $responsive_options['address_state'] : false;
		$return['address_zip'] = isset( $responsive_options['address_zip'] ) ? $responsive_options['address_zip'] : false;
	
		return $return;
	}

/**** end Function definitions ****/