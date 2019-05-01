<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Widget Areas
 *
 * Instantiate/remove areas to which widgets can be added
 *
 * @version     1.0
 * @package     Child theme
 * @subpackage  Includes
 * @author      Digitally Cultured
 */

 /**** Actions, hooks, filters ****/

    // add_action( 'widgets_init', 'dc_widget_areas_init', 10 );
    // add_action( 'widgets_init', 'dc_remove_sidebars', 99 );

 /**** end Actions, hooks, filters ****/

 /**** Function definitions ****/

    // register our widget areas, to be displayed across theme
    function dc_widget_areas_init() {

        register_sidebar( array(
            'name'                  => __( '', 'digitallycultured' ),
            'description'           => __( '', 'digitallycultured' ),
            'id'                    => '',
            'before_title'          => '',
            'after_title'           => '',
            'before_widget'         => '',
            'after_widget'          => '',
            'text_container_class'	=>	'',
            'text_content_class'	=>	'',
            'form_container_id'		=>	'',
            'form_container_class'	=>	'',
            'submit_button_class'	=>	''
        ) );

    }

    function dc_remove_sidebars() {
        unregister_sidebar( '<widget_to_remove>' );
    }

/**** end Function definitions ****/