<?php
/**
 * triperone Theme Customizer
 *
 * @package triperone
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function triper_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    
    /**
     * Custom Logo hinzugefügt
     * @Author Andreas Hecht
     */ 
	$wp_customize->add_section( 'triper_logo', array(
		'title'       => esc_html__( 'Logo', 'triperone' ),
		'description' => esc_html__( 'Wenn Du ein Retina-Logo nutzen möchtest, dann muss es in doppelter Auflösung vorhanden sein.', 'triperone' ),
		'priority'    => 55,
	) );
	$wp_customize->add_setting( 'triper_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'triper_logo', array(
		'label'    => esc_html__( 'Logo hochladen', 'triperone' ),
		'section'  => 'triper_logo',
		'priority' => 11,
	) ) );
	$wp_customize->add_setting( 'triper_replace_blogname', array(
		'default'           => '',
		'sanitize_callback' => 'triper_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'triper_replace_blogname', array(
		'label'    => esc_html__( 'Ersetze den Titel', 'triperone' ),
		'section'  => 'triper_logo',
		'type'     => 'checkbox',
		'priority' => 12,
	) );
	$wp_customize->add_setting( 'triper_retina_logo', array(
		'default'           => '',
		'sanitize_callback' => 'triper_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'triper_retina_logo', array(
		'label'    => esc_html__( 'Retina Ready', 'triperone' ),
		'section'  => 'triper_logo',
		'type'     => 'checkbox',
		'priority' => 13,
	) );
	$wp_customize->add_setting( 'triper_add_border_radius', array(
		'default'           => '',
		'sanitize_callback' => 'triper_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'triper_add_border_radius', array(
		'label'    => esc_html__( 'Füge Border Radius hinzu', 'triperone' ),
		'section'  => 'triper_logo',
		'type'     => 'checkbox',
		'priority' => 14,
	) );
	$wp_customize->add_setting( 'triper_top_margin', array(
		'default'           => '0',
		'sanitize_callback' => 'triper_sanitize_margin',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'triper_top_margin', array(
		'label'    => esc_html__( 'Margin Top (px)', 'triperone' ),
		'section'  => 'triper_logo',
		'type'     => 'text',
		'priority' => 15,
	));
	$wp_customize->add_setting( 'triper_bottom_margin', array(
		'default'           => '0',
		'sanitize_callback' => 'triper_sanitize_margin',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'triper_bottom_margin', array(
		'label'    => esc_html__( 'Margin Bottom (px)', 'triper' ),
		'section'  => 'triper_logo',
		'type'     => 'text',
		'priority' => 16,
	));
    
}
add_action( 'customize_register', 'triper_customize_register' );


/**
 * Sanitize Checkbox und Margins
 * @Author Andreas Hecht
 */
function triper_sanitize_checkbox( $value ) {
	if ( $value == 1 ) {
		return 1;
	} else {
		return '';
	}
}
function triper_sanitize_margin( $value ) {
	if ( preg_match("/^-?[0-9]+$/", $value) ) {
		return $value;
	} else {
		return '0';
	}
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function triperone_customize_preview_js() {
	wp_enqueue_script( 'triperone_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'triperone_customize_preview_js' );
