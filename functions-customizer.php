<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Customizer
 *
 * Adding functionality to the WP Customizer:
 ** Logo
 ** Alternate logo
 *
 * @version     0.5
 * @package     Child theme
 * @subpackage  Includes
 * @author      Digitally Cultured
 */

/**** Actions ****/

    add_action( 'customize_register', 'dc_customize_register' );

/**** end Actions ****/

add_theme_support( 'custom-logo', array(
	'height'      => 100,
	'width'       => 400,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
) );

/**** Function definitions ****/

    function dc_customize_register( $wp_customize ) {
        $wp_customize->add_section( 'title-box_section', array(
            'title'                 => __( 'Logo', 'responsive-digitallycultured' ),
            'priority'              => 30,
            'description'		=>	'Logo(s) for the site.'
        ) );

        $wp_customize->add_setting('primary-logo');
        $wp_customize->add_control( new WP_Customize_Media_control( $wp_customize, 'primary-logo', array(
            'label'		=>		__( 'Add a Logo', 'digitallycultured' ),
            'section'		=>		'title-box_section',
            'settings'	=>	'primary-logo',
            'description'	=>	'This logo will be used as the primary logo for the site.'
        ) ) );
        
        //alternate logo
        $wp_customize->add_setting( 'alternate-logo' );
        $wp_customize->add_control( new WP_Customize_Media_control( $wp_customize, 'alternate-logo', array(
            'label'		=>		__( 'Add an alternate logo', 'digitallycultured' ),
            'section'		=>		'title-box_section',
            'settings'	=>	'alternate-logo',
            'description'	=>	'This logo will be used on top of a colored background, so you may want to chose an image that\'s white.'
        ) ) );

    }

/**** end Function definitions ****/