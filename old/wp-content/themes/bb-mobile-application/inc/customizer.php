<?php
/**
 * BB Mobile Application Theme Customizer
 *
 * @package BB Mobile Application
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function bb_mobile_application_customize_register( $wp_customize ) {
	//add home page setting pannel
	$wp_customize->add_panel( 'bb_mobile_application_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'bb-mobile-application' ),
	    'description' => __( 'Description of what this panel does.', 'bb-mobile-application' ),
	) );

	// font array
	$bb_mobile_application_font_array = array(
        '' => 'No Fonts',
        'Abril Fatface' => 'Abril Fatface',
        'Acme' => 'Acme',
        'Anton' => 'Anton',
        'Architects Daughter' => 'Architects Daughter',
        'Arimo' => 'Arimo',
        'Arsenal' => 'Arsenal', 
        'Arvo' => 'Arvo',
        'Alegreya' => 'Alegreya',
        'Alfa Slab One' => 'Alfa Slab One',
        'Averia Serif Libre' => 'Averia Serif Libre',
        'Bangers' => 'Bangers', 
        'Boogaloo' => 'Boogaloo',
        'Bad Script' => 'Bad Script',
        'Bitter' => 'Bitter',
        'Bree Serif' => 'Bree Serif',
        'BenchNine' => 'BenchNine', 
        'Cabin' => 'Cabin', 
        'Cardo' => 'Cardo',
        'Courgette' => 'Courgette',
        'Coming Soon' => 'Coming Soon',
        'Cherry Swash' => 'Cherry Swash',
        'Cormorant Garamond' => 'Cormorant Garamond',
        'Crimson Text' => 'Crimson Text',
        'Cuprum' => 'Cuprum', 
        'Cookie' => 'Cookie', 
        'Chewy' => 'Chewy', 
        'Days One' => 'Days One', 
        'Dosis' => 'Dosis',
        'Droid Sans' => 'Droid Sans',
        'Economica' => 'Economica',
        'Fredoka One' => 'Fredoka One',
        'Fjalla One' => 'Fjalla One',
        'Francois One' => 'Francois One',
        'Frank Ruhl Libre' => 'Frank Ruhl Libre',
        'Gloria Hallelujah' => 'Gloria Hallelujah',
        'Great Vibes' => 'Great Vibes',
        'Handlee' => 'Handlee', 
        'Hammersmith One' => 'Hammersmith One',
        'Inconsolata' => 'Inconsolata', 
        'Indie Flower' => 'Indie Flower', 
        'IM Fell English SC' => 'IM Fell English SC', 
        'Julius Sans One' => 'Julius Sans One',
        'Josefin Slab' => 'Josefin Slab', 
        'Josefin Sans' => 'Josefin Sans', 
        'Kanit' => 'Kanit', 
        'Lobster' => 'Lobster', 
        'Lato' => 'Lato',
        'Lora' => 'Lora', 
        'Libre Baskerville' =>'Libre Baskerville',
        'Lobster Two' => 'Lobster Two',
        'Merriweather' =>'Merriweather', 
        'Monda' => 'Monda',
        'Montserrat' => 'Montserrat',
        'Muli' => 'Muli', 
        'Marck Script' => 'Marck Script',
        'Noto Serif' => 'Noto Serif',
        'Noto Sans' => 'Noto Sans',
        'Open Sans' => 'Open Sans', 
        'Overpass' => 'Overpass',
        'Overpass Mono' => 'Overpass Mono',
        'Oxygen' => 'Oxygen', 
        'Orbitron' => 'Orbitron', 
        'Patua One' => 'Patua One', 
        'Pacifico' => 'Pacifico',
        'Padauk' => 'Padauk', 
        'Playball' => 'Playball',
        'Playfair Display' => 'Playfair Display', 
        'PT Sans' => 'PT Sans',
        'Philosopher' => 'Philosopher',
        'Permanent Marker' => 'Permanent Marker',
        'Poiret One' => 'Poiret One', 
        'Poppins' => 'Poppins',
        'Quicksand' => 'Quicksand', 
        'Quattrocento Sans' => 'Quattrocento Sans', 
        'Raleway' => 'Raleway', 
        'Rubik' => 'Rubik', 
        'Rokkitt' => 'Rokkitt', 
        'Roboto' => 'Roboto',
        'Roboto Condensed' => 'Roboto Condensed',
        'Russo One' => 'Russo One', 
        'Righteous' => 'Righteous', 
        'Slabo' => 'Slabo', 
        'Satisfy' => 'Satisfy',
        'Source Sans Pro' => 'Source Sans Pro', 
        'Shadows Into Light Two' =>'Shadows Into Light Two',
        'Shadows Into Light' => 'Shadows Into Light', 
        'Sacramento' => 'Sacramento', 
        'Shrikhand' => 'Shrikhand', 
        'Tangerine' => 'Tangerine',
        'Unica One' => 'Unica One',
        'Ubuntu' => 'Ubuntu', 
        'VT323' => 'VT323', 
        'Varela Round' => 'Varela Round', 
        'Vampiro One' => 'Vampiro One',
        'Vollkorn' => 'Vollkorn',
        'Volkhov' => 'Volkhov', 
        'Yanone Kaffeesatz' => 'Yanone Kaffeesatz'
    );

	//Typography
	$wp_customize->add_section( 'bb_mobile_application_typography', array(
    	'title' => __( 'Typography', 'bb-mobile-application' ),
		'panel' => 'bb_mobile_application_panel_id'
	) );

	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'bb_mobile_application_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_paragraph_color', array(
		'label' => __('Paragraph Color', 'bb-mobile-application'),
		'section' => 'bb_mobile_application_typography',
		'settings' => 'bb_mobile_application_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('bb_mobile_application_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control(
	    'bb_mobile_application_paragraph_font_family', array(
	    'section'  => 'bb_mobile_application_typography',
	    'label'    => __( 'Paragraph Fonts','bb-mobile-application'),
	    'type'     => 'select',
	    'choices'  => $bb_mobile_application_font_array,
	));

	// paragraph font size
	$wp_customize->add_setting('bb_mobile_application_paragraph_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','bb-mobile-application'),
		'section'	=> 'bb_mobile_application_typography',
		'setting'	=> 'bb_mobile_application_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'bb_mobile_application_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_atag_color', array(
		'label' => __('"a" Tag Color', 'bb-mobile-application'),
		'section' => 'bb_mobile_application_typography',
		'settings' => 'bb_mobile_application_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('bb_mobile_application_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control(
	    'bb_mobile_application_atag_font_family', array(
	    'section'  => 'bb_mobile_application_typography',
	    'label'    => __( '"a" Tag Fonts','bb-mobile-application'),
	    'type'     => 'select',
	    'choices'  => $bb_mobile_application_font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'bb_mobile_application_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_li_color', array(
		'label' => __('"li" Tag Color', 'bb-mobile-application'),
		'section' => 'bb_mobile_application_typography',
		'settings' => 'bb_mobile_application_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('bb_mobile_application_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control(
	    'bb_mobile_application_li_font_family', array(
	    'section'  => 'bb_mobile_application_typography',
	    'label'    => __( '"li" Tag Fonts','bb-mobile-application'),
	    'type'     => 'select',
	    'choices'  => $bb_mobile_application_font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'bb_mobile_application_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_h1_color', array(
		'label' => __('H1 Color', 'bb-mobile-application'),
		'section' => 'bb_mobile_application_typography',
		'settings' => 'bb_mobile_application_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('bb_mobile_application_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control(
	    'bb_mobile_application_h1_font_family', array(
	    'section'  => 'bb_mobile_application_typography',
	    'label'    => __( 'H1 Fonts','bb-mobile-application'),
	    'type'     => 'select',
	    'choices'  => $bb_mobile_application_font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('bb_mobile_application_h1_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_h1_font_size',array(
		'label'	=> __('H1 Font Size','bb-mobile-application'),
		'section'	=> 'bb_mobile_application_typography',
		'setting'	=> 'bb_mobile_application_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'bb_mobile_application_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_h2_color', array(
		'label' => __('h2 Color', 'bb-mobile-application'),
		'section' => 'bb_mobile_application_typography',
		'settings' => 'bb_mobile_application_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('bb_mobile_application_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control(
	    'bb_mobile_application_h2_font_family', array(
	    'section'  => 'bb_mobile_application_typography',
	    'label'    => __( 'h2 Fonts','bb-mobile-application'),
	    'type'     => 'select',
	    'choices'  => $bb_mobile_application_font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('bb_mobile_application_h2_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_h2_font_size',array(
		'label'	=> __('h2 Font Size','bb-mobile-application'),
		'section'	=> 'bb_mobile_application_typography',
		'setting'	=> 'bb_mobile_application_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'bb_mobile_application_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_h3_color', array(
		'label' => __('h3 Color', 'bb-mobile-application'),
		'section' => 'bb_mobile_application_typography',
		'settings' => 'bb_mobile_application_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('bb_mobile_application_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control(
	    'bb_mobile_application_h3_font_family', array(
	    'section'  => 'bb_mobile_application_typography',
	    'label'    => __( 'h3 Fonts','bb-mobile-application'),
	    'type'     => 'select',
	    'choices'  => $bb_mobile_application_font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('bb_mobile_application_h3_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_h3_font_size',array(
		'label'	=> __('h3 Font Size','bb-mobile-application'),
		'section'	=> 'bb_mobile_application_typography',
		'setting'	=> 'bb_mobile_application_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'bb_mobile_application_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_h4_color', array(
		'label' => __('h4 Color', 'bb-mobile-application'),
		'section' => 'bb_mobile_application_typography',
		'settings' => 'bb_mobile_application_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('bb_mobile_application_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control(
	    'bb_mobile_application_h4_font_family', array(
	    'section'  => 'bb_mobile_application_typography',
	    'label'    => __( 'h4 Fonts','bb-mobile-application'),
	    'type'     => 'select',
	    'choices'  => $bb_mobile_application_font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('bb_mobile_application_h4_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_h4_font_size',array(
		'label'	=> __('h4 Font Size','bb-mobile-application'),
		'section'	=> 'bb_mobile_application_typography',
		'setting'	=> 'bb_mobile_application_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'bb_mobile_application_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_h5_color', array(
		'label' => __('h5 Color', 'bb-mobile-application'),
		'section' => 'bb_mobile_application_typography',
		'settings' => 'bb_mobile_application_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('bb_mobile_application_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control(
	    'bb_mobile_application_h5_font_family', array(
	    'section'  => 'bb_mobile_application_typography',
	    'label'    => __( 'h5 Fonts','bb-mobile-application'),
	    'type'     => 'select',
	    'choices'  => $bb_mobile_application_font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('bb_mobile_application_h5_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_h5_font_size',array(
		'label'	=> __('h5 Font Size','bb-mobile-application'),
		'section'	=> 'bb_mobile_application_typography',
		'setting'	=> 'bb_mobile_application_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'bb_mobile_application_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_h6_color', array(
		'label' => __('h6 Color', 'bb-mobile-application'),
		'section' => 'bb_mobile_application_typography',
		'settings' => 'bb_mobile_application_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('bb_mobile_application_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control(
	    'bb_mobile_application_h6_font_family', array(
	    'section'  => 'bb_mobile_application_typography',
	    'label'    => __( 'h6 Fonts','bb-mobile-application'),
	    'type'     => 'select',
	    'choices'  => $bb_mobile_application_font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('bb_mobile_application_h6_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_h6_font_size',array(
		'label'	=> __('h6 Font Size','bb-mobile-application'),
		'section'	=> 'bb_mobile_application_typography',
		'setting'	=> 'bb_mobile_application_h6_font_size',
		'type'	=> 'text'
	));	

	$wp_customize->add_setting('bb_mobile_application_background_skin_mode',array(
        'default' => 'Transparent Background',
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_background_skin_mode',array(
        'type' => 'select',
        'label' => __('Background Type','bb-mobile-application'),
        'section' => 'background_image',
        'choices' => array(
            'With Background' => __('With Background','bb-mobile-application'),
            'Transparent Background' => __('Transparent Background','bb-mobile-application'),
        ),
	) );

	// woocommerce section
	$wp_customize->add_setting('bb_mobile_application_show_related_products',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_show_related_products',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Related Product','bb-mobile-application'),
       'section' => 'woocommerce_product_catalog',
    ));

	$wp_customize->add_setting('bb_mobile_application_show_wooproducts_border',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_show_wooproducts_border',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Product Border','bb-mobile-application'),
       'section' => 'woocommerce_product_catalog',
    ));

    $wp_customize->add_setting( 'bb_mobile_application_wooproducts_per_columns' , array(
		'default'           => 3,
		'transport'         => 'refresh',
		'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
	) );
	$wp_customize->add_control( 'bb_mobile_application_wooproducts_per_columns', array(
		'label'    => __( 'Display Product Per Columns', 'bb-mobile-application' ),
		'section'  => 'woocommerce_product_catalog',
		'type'     => 'select',
		'choices'  => array(
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		),
	)  );

	$wp_customize->add_setting('bb_mobile_application_wooproducts_per_page',array(
		'default'	=> 9,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));	
	$wp_customize->add_control('bb_mobile_application_wooproducts_per_page',array(
		'label'	=> __('Display Product Per Page','bb-mobile-application'),
		'section'	=> 'woocommerce_product_catalog',
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'bb_mobile_application_top_bottom_wooproducts_padding',array(
		'default' => 10,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control( 'bb_mobile_application_top_bottom_wooproducts_padding',	array(
		'label' => esc_html__( 'Top Bottom Product Padding','bb-mobile-application' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'bb_mobile_application_left_right_wooproducts_padding',array(
		'default' => 10,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control( 'bb_mobile_application_left_right_wooproducts_padding',	array(
		'label' => esc_html__( 'Right Left Product Padding','bb-mobile-application' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'bb_mobile_application_wooproducts_border_radius',array(
		'default' => 0,
		'sanitize_callback'    => 'bb_mobile_application_sanitize_number_range',
	));
	$wp_customize->add_control('bb_mobile_application_wooproducts_border_radius',array(
		'label' => esc_html__( 'Product Border Radius','bb-mobile-application' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'range'
	));

	$wp_customize->add_setting( 'bb_mobile_application_wooproducts_box_shadow',array(
		'default' => 0,
		'sanitize_callback'    => 'bb_mobile_application_sanitize_number_range',
	));
	$wp_customize->add_control('bb_mobile_application_wooproducts_box_shadow',array(
		'label' => esc_html__( 'Product Box Shadow','bb-mobile-application' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'range'
	));

	$wp_customize->add_setting('bb_mobile_application_products_navigation',array(
       'default' => 'Yes',
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_choices'
    ));
    $wp_customize->add_control('bb_mobile_application_products_navigation',array(
       'type' => 'radio',
       'label' => __('Woocommerce Products Navigation','bb-mobile-application'),
       'choices' => array(
            'Yes' => __('Yes','bb-mobile-application'),
            'No' => __('No','bb-mobile-application'),
        ),
       'section' => 'woocommerce_product_catalog',
    ));

	$wp_customize->add_section('bb_mobile_application_product_button_section', array(
		'title'    => __('Product Button Settings', 'bb-mobile-application'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	$wp_customize->add_setting( 'bb_mobile_application_top_bottom_product_button_padding',array(
		'default' => 12,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_top_bottom_product_button_padding',	array(
		'label' => esc_html__( 'Product Button Top Bottom Padding','bb-mobile-application' ),
		'section' => 'bb_mobile_application_product_button_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type' => 'number',
	));

	$wp_customize->add_setting( 'bb_mobile_application_left_right_product_button_padding',array(
		'default' => 12,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_left_right_product_button_padding',array(
		'label' => esc_html__( 'Product Button Right Left Padding','bb-mobile-application' ),
		'section' => 'bb_mobile_application_product_button_section',
		'type'		=> 'number',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'bb_mobile_application_product_button_border_radius',array(
		'default' => 0,
		'sanitize_callback'    => 'bb_mobile_application_sanitize_number_range',
	));
	$wp_customize->add_control('bb_mobile_application_product_button_border_radius',array(
		'label' => esc_html__( 'Product Button Border Radius','bb-mobile-application' ),
		'section' => 'bb_mobile_application_product_button_section',
		'type'		=> 'range',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_section('bb_mobile_application_product_sale_section', array(
		'title'    => __('Product Sale Button Settings', 'bb-mobile-application'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	$wp_customize->add_setting('bb_mobile_application_align_product_sale',array(
        'default' => 'Right',
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_align_product_sale',array(
        'type' => 'radio',
        'label' => __('Product Sale Button Alignment','bb-mobile-application'),
        'section' => 'bb_mobile_application_product_sale_section',
        'choices' => array(
            'Right' => __('Right','bb-mobile-application'),
            'Left' => __('Left','bb-mobile-application'),
        ),
	) );

	$wp_customize->add_setting( 'bb_mobile_application_border_radius_product_sale',array(
		'default' => 50,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_border_radius_product_sale', array(
        'label'  => __('Product Sale Button Border Radius','bb-mobile-application'),
        'section'  => 'bb_mobile_application_product_sale_section',
        'type'        => 'number',
        'input_attrs' => array(
        	'step'=> 1,
            'min' => 0,
            'max' => 50,
        )
    ) );

	$wp_customize->add_setting('bb_mobile_application_product_sale_font_size',array(
		'default'=> 14,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float'
	));
	$wp_customize->add_control('bb_mobile_application_product_sale_font_size',array(
		'label'	=> __('Product Sale Button Font Size','bb-mobile-application'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'bb_mobile_application_product_sale_section',
		'type'=> 'number'
	));

	// sale button padding
	$wp_customize->add_setting( 'bb_mobile_application_sale_padding_top',array(
		'default' => 0,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control( 'bb_mobile_application_sale_padding_top',	array(
		'label' => esc_html__( ' Product Sale Top Bottom Padding','bb-mobile-application' ),
		'section' => 'bb_mobile_application_product_sale_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'bb_mobile_application_sale_padding_left',array(
		'default' => 0,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control( 'bb_mobile_application_sale_padding_left',	array(
		'label' => esc_html__( ' Product Sale Left Right Padding','bb-mobile-application' ),
		'section' => 'bb_mobile_application_product_sale_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	// sale button margin
	$wp_customize->add_setting( 'bb_mobile_application_sale_margin_top',array(
		'default' => 0,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control( 'bb_mobile_application_sale_margin_top',	array(
		'label' => esc_html__( 'Product Sale Top Bottom Margin','bb-mobile-application' ),
		'section' => 'bb_mobile_application_product_sale_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'bb_mobile_application_sale_margin_left',array(
		'default' => 0,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control( 'bb_mobile_application_sale_margin_left',	array(
		'label' => esc_html__( 'Product Sale Left Right Margin','bb-mobile-application' ),
		'section' => 'bb_mobile_application_product_sale_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	// Add the Theme Color Option section.
	$wp_customize->add_section( 'bb_mobile_application_theme_color_option', array( 
		'panel' => 'bb_mobile_application_panel_id', 
		'title' => esc_html__( 'Theme Color Option', 'bb-mobile-application' ) 
	) );

  	$wp_customize->add_setting( 'bb_mobile_application_theme_color', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_theme_color', array(
  		'label' => 'Color Option',
	    'description' => __('One can change complete theme color on just one click.', 'bb-mobile-application'),
	    'section' => 'bb_mobile_application_theme_color_option',
	    'settings' => 'bb_mobile_application_theme_color',
  	)));

	//Layouts
	$wp_customize->add_section( 'bb_mobile_application_left_right', array(
    	'title'      => __( 'General Settings', 'bb-mobile-application' ),
		'panel' => 'bb_mobile_application_panel_id'
	) );

	$wp_customize->add_setting('bb_mobile_application_preloader_option',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_preloader_option',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Preloader','bb-mobile-application'),
       'section' => 'bb_mobile_application_left_right'
    ));

    $wp_customize->add_setting('bb_mobile_application_preloader_option',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_preloader_option',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Preloader','bb-mobile-application'),
       'section' => 'bb_mobile_application_left_right'
    ));

    $wp_customize->add_setting('bb_mobile_application_preloader_type_options', array(
		'default'           => 'Preloader 1',
		'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
	));
	$wp_customize->add_control('bb_mobile_application_preloader_type_options',array(
		'type'           => 'radio',
		'label'          => __('Preloader Type', 'bb-mobile-application'),
		'section'        => 'bb_mobile_application_left_right',
		'choices'        => array(
			'Preloader 1'  => __('Preloader 1', 'bb-mobile-application'),
			'Preloader 2' => __('Preloader 2', 'bb-mobile-application'),
		),
	));

    $wp_customize->add_setting( 'bb_mobile_application_loader_background_color_settings', array(
	    'default' => '#222',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_loader_background_color_settings', array(
  		'label' => __('Preloader Background Color', 'bb-mobile-application'),
	    'section' => 'bb_mobile_application_left_right',
	    'settings' => 'bb_mobile_application_loader_background_color_settings',
  	)));

	$wp_customize->add_setting( 'bb_mobile_application_sticky_header',array(
		'default' => false,
      	'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ) );
    $wp_customize->add_control('bb_mobile_application_sticky_header',array(
    	'type' => 'checkbox',
        'label' => __( 'Sticky Header','bb-mobile-application' ),
        'section' => 'bb_mobile_application_left_right'
    ));

    $wp_customize->add_setting( 'bb_mobile_application_sticky_header_padding_settings', array(
		'default'=> '',
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	) );
	$wp_customize->add_control( 'bb_mobile_application_sticky_header_padding_settings', array(
		'label'       => esc_html__( 'Sticky Header Padding','bb-mobile-application' ),
		'section'     => 'bb_mobile_application_left_right',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting( 'bb_mobile_application_shop_page_sidebar',array(
		'default' => true,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ) );
    $wp_customize->add_control('bb_mobile_application_shop_page_sidebar',array(
    	'type' => 'checkbox',
       	'label' => __('Show / Hide Woocommerce Page Sidebar','bb-mobile-application'),
		'section' => 'bb_mobile_application_left_right'
    ));

    // shop page sidebar alignment
    $wp_customize->add_setting('bb_mobile_application_shop_page_layout', array(
		'default'           => 'Right Sidebar',
		'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
	));
	$wp_customize->add_control('bb_mobile_application_shop_page_layout',array(
		'type'           => 'radio',
		'label'          => __('Shop Page layout', 'bb-mobile-application'),
		'section'        => 'bb_mobile_application_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'bb-mobile-application'),
			'Right Sidebar' => __('Right Sidebar', 'bb-mobile-application'),
		),
	));

	$wp_customize->add_setting( 'bb_mobile_application_wocommerce_single_page_sidebar',array(
		'default' => true,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ) );
    $wp_customize->add_control('bb_mobile_application_wocommerce_single_page_sidebar',array(
    	'type' => 'checkbox',
       	'label' => __('Show / Hide Single Product Page Sidebar','bb-mobile-application'),
		'section' => 'bb_mobile_application_left_right'
    ));

    // single product page sidebar alignment
    $wp_customize->add_setting('bb_mobile_application_single_product_page_layout', array(
		'default'           => 'Right Sidebar',
		'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
	));
	$wp_customize->add_control('bb_mobile_application_single_product_page_layout',array(
		'type'           => 'radio',
		'label'          => __('Single product Page layout', 'bb-mobile-application'),
		'section'        => 'bb_mobile_application_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'bb-mobile-application'),
			'Right Sidebar' => __('Right Sidebar', 'bb-mobile-application'),
		),
	));

    $wp_customize->add_setting( 'bb_mobile_application_single_page_breadcrumb',array(
		'default' => true,
      	'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ) );
    $wp_customize->add_control('bb_mobile_application_single_page_breadcrumb',array(
    	'type' => 'checkbox',
        'label' => __( 'Show / Hide Single Page Breadcrumb','bb-mobile-application' ),
        'section' => 'bb_mobile_application_left_right'
    ));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('bb_mobile_application_theme_options',array(
        'default'           => 'Right Sidebar', 
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_theme_options',array(
	    'type' => 'radio',
	    'label' => __( 'Sidebar Layouts', 'bb-mobile-application' ),
	    'section' => 'bb_mobile_application_left_right',
	    'choices' => array(
	        'Left Sidebar' => __('Left Sidebar','bb-mobile-application'),
	        'Right Sidebar' => __('Right Sidebar','bb-mobile-application'),
	        'One Column' => __('One Column','bb-mobile-application'),
	        'Three Columns' => __('Three Columns','bb-mobile-application'),
	        'Four Columns' => __('Four Columns','bb-mobile-application'),
	        'Grid Layout' => __('Grid Layout','bb-mobile-application')
	    ),
	));

    $wp_customize->add_setting('bb_mobile_application_single_page_sidebar_layout', array(
		'default'           => 'One Column', 
		'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
	));
	$wp_customize->add_control('bb_mobile_application_single_page_sidebar_layout',array(
		'type'           => 'radio',
		'label'          => __('Single Page Layouts', 'bb-mobile-application'),
		'section'        => 'bb_mobile_application_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'bb-mobile-application'),
			'Right Sidebar' => __('Right Sidebar', 'bb-mobile-application'),
			'One Column'    => __('One Column', 'bb-mobile-application'),
		),
	));

	$wp_customize->add_setting('bb_mobile_application_single_post_sidebar_layout', array(
		'default'           => 'Right Sidebar', 
		'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
	));
	$wp_customize->add_control('bb_mobile_application_single_post_sidebar_layout',array(
		'type'           => 'radio',
		'label'          => __('Single Post Layouts', 'bb-mobile-application'),
		'section'        => 'bb_mobile_application_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'bb-mobile-application'),
			'Right Sidebar' => __('Right Sidebar', 'bb-mobile-application'),
			'One Column'    => __('One Column', 'bb-mobile-application'),
		),
	));

	$wp_customize->add_setting('bb_mobile_application_width_theme_options',array(
        'default' => 'Default',
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_width_theme_options',array(
        'type' => 'radio',
        'label' => __('Container Box','bb-mobile-application'),
        'description' => __('Here you can change the Width layout. ','bb-mobile-application'),
        'section' => 'bb_mobile_application_left_right',
        'choices' => array(
            'Default' => __('Default','bb-mobile-application'),
            'Container' => __('Container','bb-mobile-application'),
            'Box Container' => __('Box Container','bb-mobile-application'),
        ),
	) );

    // Button
	$wp_customize->add_section( 'bb_mobile_application_theme_button', array(
		'title' => __('Button Option','bb-mobile-application'),
		'panel' => 'bb_mobile_application_panel_id',
	));

	$wp_customize->add_setting('bb_mobile_application_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_button_padding_top_bottom',array(
		'label'	=> __('Top and Bottom Padding','bb-mobile-application'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'bb_mobile_application_theme_button',
		'type'=> 'number'
	));

	$wp_customize->add_setting('bb_mobile_application_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_button_padding_left_right',array(
		'label'	=> __('Left and Right Padding','bb-mobile-application'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'bb_mobile_application_theme_button',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'bb_mobile_application_button_border_radius', array(
		'default'=> '',
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	) );
	$wp_customize->add_control( 'bb_mobile_application_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','bb-mobile-application' ),
		'section'     => 'bb_mobile_application_theme_button',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	// Menu settings
	$wp_customize->add_section('bb_mobile_application_menu_settings',array(
		'title'	=> __('Menu Settings','bb-mobile-application'),
		'priority'	=> null,
		'panel' => 'bb_mobile_application_panel_id',
	));

	$wp_customize->add_setting('bb_mobile_application_menu_weight',array(
		'default'=> '',
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_choices',
	));
	$wp_customize->add_control('bb_mobile_application_menu_weight',array(
		'label'	=> __('Menus Weight ','bb-mobile-application'),
		'section'=> 'bb_mobile_application_menu_settings',
		'type' => 'select',
		'choices' => array(
            '100' => __('100','bb-mobile-application'),
            '200' => __('200','bb-mobile-application'),
            '300' => __('300','bb-mobile-application'),
            '400' => __('400','bb-mobile-application'),
            '500' => __('500','bb-mobile-application'),
            '600' => __('600','bb-mobile-application'),
            '700' => __('700','bb-mobile-application'),
            '800' => __('800','bb-mobile-application'),
            '900' => __('900','bb-mobile-application'),
        ),
	));

	$wp_customize->add_setting( 'bb_mobile_application_menu_color_settings', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_menu_color_settings', array(
  		'label' => __('Menu Color', 'bb-mobile-application'),
	    'section' => 'bb_mobile_application_menu_settings',
	    'settings' => 'bb_mobile_application_menu_color_settings',
  	)));

  	$wp_customize->add_setting( 'bb_mobile_application_menu_hover_color_settings', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_menu_hover_color_settings', array(
  		'label' => __('Menu Hover Color', 'bb-mobile-application'),
	    'section' => 'bb_mobile_application_menu_settings',
	    'settings' => 'bb_mobile_application_menu_hover_color_settings',
  	)));
 
  	$wp_customize->add_setting( 'bb_mobile_application_submenu_color_settings', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_submenu_color_settings', array(
  		'label' => __('Sub-menu Color', 'bb-mobile-application'),
	    'section' => 'bb_mobile_application_menu_settings',
	    'settings' => 'bb_mobile_application_submenu_color_settings',
  	)));

  	$wp_customize->add_setting( 'bb_mobile_application_submenu_hover_color_settings', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_submenu_hover_color_settings', array(
  		'label' => __('Sub-menu Hover Color', 'bb-mobile-application'),
	    'section' => 'bb_mobile_application_menu_settings',
	    'settings' => 'bb_mobile_application_submenu_hover_color_settings',
  	)));

	//home page slider
	$wp_customize->add_section( 'bb_mobile_application_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'bb-mobile-application' ),
		'panel' => 'bb_mobile_application_panel_id'
	) );

	$wp_customize->add_setting('bb_mobile_application_slider_hide_show',array(
      'default' => false,
      'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
	));
	$wp_customize->add_control('bb_mobile_application_slider_hide_show',array(
	  'type' => 'checkbox',
	  'label' => __('Show / Hide slider','bb-mobile-application'),
	  'section' => 'bb_mobile_application_slidersettings',
	));

	$wp_customize->add_setting('bb_mobile_application_slider_title_Show_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_slider_title_Show_hide',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Title','bb-mobile-application'),
       'section' => 'bb_mobile_application_slidersettings'
    ));

    $wp_customize->add_setting('bb_mobile_application_slider_content_Show_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_slider_content_Show_hide',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Content','bb-mobile-application'),
       'section' => 'bb_mobile_application_slidersettings'
    ));

	for ( $count = 1; $count <= 4; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'bb_mobile_application_slider'.$count, array(
			'default'           => '',
			'sanitize_callback' => 'bb_mobile_application_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'bb_mobile_application_slider'.$count, array(
			'label'    => __( 'Select Slide Image Page', 'bb-mobile-application' ),
			'section'  => 'bb_mobile_application_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting('bb_mobile_application_slider_overlay',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_slider_overlay',array(
       'type' => 'checkbox',
       'label' => __('Home Page Slider Overlay','bb-mobile-application'),
		'description'    => __('This option will add colors over the slider.','bb-mobile-application'),
       'section' => 'bb_mobile_application_slidersettings'
    ));

    $wp_customize->add_setting('bb_mobile_application_slider_image_overlay_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bb_mobile_application_slider_image_overlay_color', array(
		'label'    => __('Home Page Slider Overlay Color', 'bb-mobile-application'),
		'section'  => 'bb_mobile_application_slidersettings',
		'description'    => __('It will add the color overlay of the slider. To make it transparent, use the below option.','bb-mobile-application'),
		'settings' => 'bb_mobile_application_slider_image_overlay_color',
	)));

	//content layout
    $wp_customize->add_setting('bb_mobile_application_slider_content_alignment',array(
    'default' => 'Center',
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_slider_content_alignment',array(
        'type' => 'radio',
        'label' => __('Slider Content Alignment','bb-mobile-application'),
        'section' => 'bb_mobile_application_slidersettings',
        'choices' => array(
            'Center' => __('Center','bb-mobile-application'),
            'Left' => __('Left','bb-mobile-application'),
            'Right' => __('Right','bb-mobile-application'),
        ),
	) );

    //Slider excerpt
	$wp_customize->add_setting( 'bb_mobile_application_slider_excerpt_length', array(
		'default'              => 10,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	) );
	$wp_customize->add_control( 'bb_mobile_application_slider_excerpt_length', array(
		'label'       => esc_html__( 'Slider Excerpt length','bb-mobile-application' ),
		'section'     => 'bb_mobile_application_slidersettings',
		'type'        => 'number',
		'settings'    => 'bb_mobile_application_slider_excerpt_length',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Opacity
	$wp_customize->add_setting('bb_mobile_application_slider_image_opacity',array(
      'default'              => 0.3,
      'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control( 'bb_mobile_application_slider_image_opacity', array(
	'label'       => esc_html__( 'Slider Image Opacity','bb-mobile-application' ),
	'section'     => 'bb_mobile_application_slidersettings',
	'type'        => 'select',
	'settings'    => 'bb_mobile_application_slider_image_opacity',
	'choices' => array(
		'0' =>  esc_attr('0','bb-mobile-application'),
		'0.1' =>  esc_attr('0.1','bb-mobile-application'),
		'0.2' =>  esc_attr('0.2','bb-mobile-application'),
		'0.3' =>  esc_attr('0.3','bb-mobile-application'),
		'0.4' =>  esc_attr('0.4','bb-mobile-application'),
		'0.5' =>  esc_attr('0.5','bb-mobile-application'),
		'0.6' =>  esc_attr('0.6','bb-mobile-application'),
		'0.7' =>  esc_attr('0.7','bb-mobile-application'),
		'0.8' =>  esc_attr('0.8','bb-mobile-application'),
		'0.9' =>  esc_attr('0.9','bb-mobile-application')
	),
	));

	$wp_customize->add_setting( 'bb_mobile_application_slider_speed_option',array(
		'default' => 3000,
		'sanitize_callback'    => 'bb_mobile_application_sanitize_number_range',
	));
	$wp_customize->add_control( 'bb_mobile_application_slider_speed_option',array(
		'label' => esc_html__( 'Slider Speed Option','bb-mobile-application' ),
		'section' => 'bb_mobile_application_slidersettings',
		'type'        => 'range',
		'input_attrs' => array(
			'min' => 1000,
			'max' => 5000,
			'step' => 500,
		),
	));

	$wp_customize->add_setting('bb_mobile_application_slider_image_height',array(
		'default'=> __('550','bb-mobile-application'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_slider_image_height',array(
		'label'	=> __('Slider Image Height','bb-mobile-application'),
		'section'=> 'bb_mobile_application_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('bb_mobile_application_slider_button',array(
		'default'=> __('KNOW MORE','bb-mobile-application'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_slider_button',array(
		'label'	=> __('Slider Button','bb-mobile-application'),
		'section'=> 'bb_mobile_application_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('bb_mobile_application_top_bottom_slider_content_space',array(
		'default'=> '',
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_top_bottom_slider_content_space',array(
		'label'	=> __('Top Bottom Slider Content Space','bb-mobile-application'),
		'section'=> 'bb_mobile_application_slidersettings',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('bb_mobile_application_left_right_slider_content_space',array(
		'default'=> '',
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_left_right_slider_content_space',array(
		'label'	=> __('Left Right Slider Content Space','bb-mobile-application'),
		'section'=> 'bb_mobile_application_slidersettings',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	//Creative Feature
	$wp_customize->add_section('bb_mobile_application_creative_section',array(
		'title'	=> __('Creative Features Section','bb-mobile-application'),
		'panel' => 'bb_mobile_application_panel_id',
	));
	
	$wp_customize->add_setting('bb_mobile_application_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	$wp_customize->add_control('bb_mobile_application_title',array(
		'label'	=> __('Title','bb-mobile-application'),
		'section'	=> 'bb_mobile_application_creative_section',
		'type'	=> 'text'
	));

	// category left
	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('bb_mobile_application_blogcategory_left_setting',array(
		'default'	=> 'select',
		'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
	));
	$wp_customize->add_control('bb_mobile_application_blogcategory_left_setting',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => __('Select Category to display Latest Post','bb-mobile-application'),
		'section' => 'bb_mobile_application_creative_section',
	));

	//middle image
	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
	$i = 0;
	$pst[]='Select';  
	foreach($post_list as $post){
		$pst[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('bb_mobile_application_middle_image_setting',array(
		'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
	));
	$wp_customize->add_control('bb_mobile_application_middle_image_setting',array(
		'type'    => 'select',
		'choices' => $pst,
		'label' => __('Select post to display featured image','bb-mobile-application'),
		'section' => 'bb_mobile_application_creative_section',
	));

	// category right
	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post1[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post1[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('bb_mobile_application_blogcategory_right_setting',array(
		'default'	=> 'select',
		'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
	));
	$wp_customize->add_control('bb_mobile_application_blogcategory_right_setting',array(
		'type'    => 'select',
		'choices' => $cat_post1,
		'label' => __('Select Category to display Latest Post','bb-mobile-application'),
		'section' => 'bb_mobile_application_creative_section',
	));

	//404 Page Setting
	$wp_customize->add_section('bb_mobile_application_404_page_setting',array(
		'title'	=> __('404 Page','bb-mobile-application'),
		'panel' => 'bb_mobile_application_panel_id',
	));	

	$wp_customize->add_setting('bb_mobile_application_title_404_page',array(
		'default'=> __('404 Not Found','bb-mobile-application'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_title_404_page',array(
		'label'	=> __('404 Page Title','bb-mobile-application'),
		'section'=> 'bb_mobile_application_404_page_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('bb_mobile_application_content_404_page',array(
		'default'=> __('Looks like you have taken a wrong turn&hellip. Dont worry&hellip it happens to the best of us.','bb-mobile-application'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_content_404_page',array(
		'label'	=> __('404 Page Content','bb-mobile-application'),
		'section'=> 'bb_mobile_application_404_page_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('bb_mobile_application_button_404_page',array(
		'default'=> __('Back to Home Page','bb-mobile-application'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_button_404_page',array(
		'label'	=> __('404 Page Button','bb-mobile-application'),
		'section'=> 'bb_mobile_application_404_page_setting',
		'type'=> 'text'
	));

	//Responsive Media Settings
	$wp_customize->add_section('bb_mobile_application_responsive_setting',array(
		'title'	=> __('Responsive Settings','bb-mobile-application'),
		'panel' => 'bb_mobile_application_panel_id',
	));

	// taggle button color
  	$wp_customize->add_setting( 'bb_mobile_application_taggle_menu_bg_color_settings', array(
	    'default' => '#222',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bb_mobile_application_taggle_menu_bg_color_settings', array(
  		'label' => __('Toggle Button Bg Color', 'bb-mobile-application'),
	    'section' => 'bb_mobile_application_responsive_setting',
	    'settings' => 'bb_mobile_application_taggle_menu_bg_color_settings',
  	)));

	$wp_customize->add_setting('bb_mobile_application_mobile_search_option',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_mobile_search_option',array(
       'type' => 'checkbox',
       'label' => __('Search','bb-mobile-application'),
       'section' => 'bb_mobile_application_responsive_setting'
    ));

    $wp_customize->add_setting('bb_mobile_application_responsive_sticky_header',array(
       'default' => false,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_responsive_sticky_header',array(
       'type' => 'checkbox',
       'label' => __('Sticky Header','bb-mobile-application'),
       'section' => 'bb_mobile_application_responsive_setting'
    ));

    $wp_customize->add_setting('bb_mobile_application_responsive_slider',array(
       'default' => false,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_responsive_slider',array(
       'type' => 'checkbox',
       'label' => __('Slider','bb-mobile-application'),
       'section' => 'bb_mobile_application_responsive_setting'
    ));

    $wp_customize->add_setting('bb_mobile_application_responsive_scroll',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_responsive_scroll',array(
       'type' => 'checkbox',
       'label' => __('Scroll To Top','bb-mobile-application'),
       'section' => 'bb_mobile_application_responsive_setting'
    ));

    $wp_customize->add_setting('bb_mobile_application_responsive_sidebar',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_responsive_sidebar',array(
       'type' => 'checkbox',
       'label' => __('Sidebar','bb-mobile-application'),
       'section' => 'bb_mobile_application_responsive_setting'
    ));

    $wp_customize->add_setting('bb_mobile_application_responsive_preloader',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_responsive_preloader',array(
       'type' => 'checkbox',
       'label' => __('Preloader','bb-mobile-application'),
       'section' => 'bb_mobile_application_responsive_setting'
    ));

	//Blog Post
	$wp_customize->add_section('bb_mobile_application_blog_post',array(
		'title'	=> __('Blog Page Settings','bb-mobile-application'),
		'panel' => 'bb_mobile_application_panel_id',
	));	

	$wp_customize->add_setting('bb_mobile_application_date_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_date_hide',array(
       'type' => 'checkbox',
       'label' => __('Post Date','bb-mobile-application'),
       'section' => 'bb_mobile_application_blog_post'
    ));

    $wp_customize->add_setting('bb_mobile_application_comment_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_comment_hide',array(
       'type' => 'checkbox',
       'label' => __('Comments','bb-mobile-application'),
       'section' => 'bb_mobile_application_blog_post'
    ));

    $wp_customize->add_setting('bb_mobile_application_author_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_author_hide',array(
       'type' => 'checkbox',
       'label' => __('Author','bb-mobile-application'),
       'section' => 'bb_mobile_application_blog_post'
    ));

    $wp_customize->add_setting('bb_mobile_application_time_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_time_hide',array(
       'type' => 'checkbox',
       'label' => __('Time','bb-mobile-application'),
       'section' => 'bb_mobile_application_blog_post'
    ));

    $wp_customize->add_setting('bb_mobile_application_show_featured_image_post',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_show_featured_image_post',array(
       'type' => 'checkbox',
       'label' => __('Blog Post Image','bb-mobile-application'),
       'section' => 'bb_mobile_application_blog_post'
    ));

    $wp_customize->add_setting( 'bb_mobile_application_featured_img_border_radius', array(
		'default'=> 0,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	) );
	$wp_customize->add_control( 'bb_mobile_application_featured_img_border_radius', array(
		'label'       => esc_html__( 'Blog Post Image Border Radius','bb-mobile-application' ),
		'section'     => 'bb_mobile_application_blog_post',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 100,
		),
	) );

	$wp_customize->add_setting( 'bb_mobile_application_featured_img_box_shadow',array(
		'default' => 0,
		'sanitize_callback'    => 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_featured_img_box_shadow',array(
		'label' => esc_html__( 'Blog Post Image Shadow','bb-mobile-application' ),
		'section' => 'bb_mobile_application_blog_post',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type' => 'number'
	));

    $wp_customize->add_setting('bb_mobile_application_blog_post_description_option',array(
    	'default'   => 'Excerpt Content', 
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_blog_post_description_option',array(
        'type' => 'radio',
        'label' => __('Post Description Length','bb-mobile-application'),
        'section' => 'bb_mobile_application_blog_post',
        'choices' => array(
            'No Content' => __('No Content','bb-mobile-application'),
            'Excerpt Content' => __('Excerpt Content','bb-mobile-application'),
            'Full Content' => __('Full Content','bb-mobile-application'),
        ),
	) );

    $wp_customize->add_setting( 'bb_mobile_application_excerpt_number', array(
		'default'              => 20,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	) );
	$wp_customize->add_control( 'bb_mobile_application_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','bb-mobile-application' ),
		'section'     => 'bb_mobile_application_blog_post',
		'type'        => 'number',
		'settings'    => 'bb_mobile_application_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'bb_mobile_application_post_suffix_option', array(
		'default'   => __('...','bb-mobile-application'), 
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'bb_mobile_application_post_suffix_option', array(
		'label'       => esc_html__( 'Post Excerpt Indicator Option','bb-mobile-application' ),
		'section'     => 'bb_mobile_application_blog_post',
		'type'        => 'text',
		'settings'    => 'bb_mobile_application_post_suffix_option',
	) );

	$wp_customize->add_setting('bb_mobile_application_button_text',array(
		'default'=> __('Read More','bb-mobile-application'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_button_text',array(
		'label'	=> __('Add Button Text','bb-mobile-application'),
		'section'=> 'bb_mobile_application_blog_post',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'bb_mobile_application_metabox_separator_blog_post', array(
		'default'   => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'bb_mobile_application_metabox_separator_blog_post', array(
		'label'       => esc_html__( 'Meta Box Separator','bb-mobile-application' ),
		'input_attrs' => array(
            'placeholder' => __( 'Add Meta Separator. e.g.: "|", "/", etc.', 'bb-mobile-application' ),
        ),
		'section'     => 'bb_mobile_application_blog_post',
		'type'        => 'text',
		'settings'    => 'bb_mobile_application_metabox_separator_blog_post',
	) );

	$wp_customize->add_setting('bb_mobile_application_display_blog_page_post',array(
        'default' => 'In Box',
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_display_blog_page_post',array(
        'type' => 'radio',
        'label' => __('Display Blog Page Post :','bb-mobile-application'),
        'section' => 'bb_mobile_application_blog_post',
        'choices' => array(
            'In Box' => __('In Box','bb-mobile-application'),
            'Without Box' => __('Without Box','bb-mobile-application'),
        ),
	) );

	$wp_customize->add_setting('bb_mobile_application_blog_post_pagination',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_blog_post_pagination',array(
       'type' => 'checkbox',
       'label' => __('Pagination in Blog Page','bb-mobile-application'),
       'section' => 'bb_mobile_application_blog_post'
    ));

	//Single Post Settings
	$wp_customize->add_section('bb_mobile_application_single_post',array(
		'title'	=> __('Single Post Settings','bb-mobile-application'),
		'panel' => 'bb_mobile_application_panel_id',
	));

	$wp_customize->add_setting('bb_mobile_application_tags_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_tags_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Tags','bb-mobile-application'),
       'section' => 'bb_mobile_application_single_post'
    ));

    $wp_customize->add_setting('bb_mobile_application_show_featured_image_single_post',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_show_featured_image_single_post',array(
       'type' => 'checkbox',
       'label' => __('Single Post Image','bb-mobile-application'),
       'section' => 'bb_mobile_application_single_post'
    ));
 	
    $wp_customize->add_setting( 'bb_mobile_application_show_related_post',array(
		'default' => true,
      	'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ) );
    $wp_customize->add_control('bb_mobile_application_show_related_post',array(
    	'type' => 'checkbox',
        'label' => __( 'Related Post','bb-mobile-application' ),
        'section' => 'bb_mobile_application_single_post'
    ));

    $wp_customize->add_setting( 'bb_mobile_application_post_comment',array(
		'default' => true,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
		) );
	$wp_customize->add_control('bb_mobile_application_post_comment',array(
		'type' => 'checkbox',
		'label' => __('Single Post Comment Box','bb-mobile-application'),
		'section' => 'bb_mobile_application_single_post'
		));

	$wp_customize->add_setting( 'bb_mobile_application_single_post_breadcrumb',array(
		'default' => true,
		'transport' => 'refresh',
      	'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ) );
    $wp_customize->add_control('bb_mobile_application_single_post_breadcrumb',array(
    	'type' => 'checkbox',
        'label' => __( 'Show / Hide Single Post Breadcrumb','bb-mobile-application' ),
        'section' => 'bb_mobile_application_single_post'
    ));

    $wp_customize->add_setting('bb_mobile_application_related_posts_taxanomies_options',array(
        'default' => 'categories',
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_related_posts_taxanomies_options',array(
        'type' => 'radio',
        'label' => __('Related Post Taxonomies','bb-mobile-application'),
        'section' => 'bb_mobile_application_single_post',
        'choices' => array(
            'categories' => __('Categories','bb-mobile-application'),
            'tags' => __('Tags','bb-mobile-application'),
        ),
	) );

	$wp_customize->add_setting('bb_mobile_application_related_post_title',array(
		'default'=> __('Related Posts','bb-mobile-application'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_related_post_title',array(
		'label'	=> __('Related Post Title','bb-mobile-application'),
		'section'=> 'bb_mobile_application_single_post',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('bb_mobile_application_related_posts_number',array(
		'default'=> 3,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_related_posts_number',array(
		'label'	=> __('Related Post Number','bb-mobile-application'),
		'section'=> 'bb_mobile_application_single_post',
		'type'=> 'number',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
	));

	//no Result Found
	$wp_customize->add_section('bb_mobile_application_noresult_found',array(
		'title'	=> __('No Result Found','bb-mobile-application'),
		'panel' => 'bb_mobile_application_panel_id',
	));	

	$wp_customize->add_setting('bb_mobile_application_nosearch_found_title',array(
		'default'=> __('Nothing Found','bb-mobile-application'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_nosearch_found_title',array(
		'label'	=> __('No Result Found Title','bb-mobile-application'),
		'section'=> 'bb_mobile_application_noresult_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('bb_mobile_application_nosearch_found_content',array(
		'default'=> __('Sorry, but nothing matched your search terms. Please try again with some different keywords.','bb-mobile-application'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('bb_mobile_application_nosearch_found_content',array(
		'label'	=> __('No Result Found Content','bb-mobile-application'),
		'section'=> 'bb_mobile_application_noresult_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('bb_mobile_application_show_noresult_search',array(
       'default' => true,
       'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
    ));
    $wp_customize->add_control('bb_mobile_application_show_noresult_search',array(
       'type' => 'checkbox',
       'label' => __('No Result search','bb-mobile-application'),
       'section' => 'bb_mobile_application_noresult_found'
    ));
	
	//Footer
	$wp_customize->add_section('bb_mobile_application_footer_section',array(
		'title'	=> __('Footer Text','bb-mobile-application'),
		'panel' => 'bb_mobile_application_panel_id',
	));

	$wp_customize->add_setting('bb_mobile_application_footer_widget_areas',array(
        'default'           => 4,
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices',
    ));
    $wp_customize->add_control('bb_mobile_application_footer_widget_areas',array(
        'type'        => 'select',
        'label'       => __('Footer widget area', 'bb-mobile-application'),
        'section'     => 'bb_mobile_application_footer_section',
        'description' => __('Select the number of widget areas you want in the footer. After that, go to Appearance > Widgets and add your widgets.', 'bb-mobile-application'),
        'choices' => array(
            '1'     => __('One', 'bb-mobile-application'),
            '2'     => __('Two', 'bb-mobile-application'),
            '3'     => __('Three', 'bb-mobile-application'),
            '4'     => __('Four', 'bb-mobile-application')
        ),
    ));

    $wp_customize->add_setting('bb_mobile_application_footer_widget_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bb_mobile_application_footer_widget_bg_color', array(
		'label'    => __('Footer Widget Background Color', 'bb-mobile-application'),
		'section'  => 'bb_mobile_application_footer_section',
	)));

	$wp_customize->add_setting('bb_mobile_application_footer_widget_bg_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'bb_mobile_application_footer_widget_bg_image',array(
        'label' => __('Footer Widget Background Image','bb-mobile-application'),
        'section' => 'bb_mobile_application_footer_section'
	)));

	$wp_customize->add_setting('bb_mobile_application_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field',
	));	
	$wp_customize->add_control('bb_mobile_application_footer_copy',array(
		'label'	=> __('Copyright Text','bb-mobile-application'),
		'section'	=> 'bb_mobile_application_footer_section',
		'type'		=> 'text'
	));	

	$wp_customize->add_setting('bb_mobile_application_copyright_bg_color_settings', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bb_mobile_application_copyright_bg_color_settings', array(
		'label'    => __('Copyright Background Color', 'bb-mobile-application'),
		'section'  => 'bb_mobile_application_footer_section',
	)));

	$wp_customize->add_setting('bb_mobile_application_copyright_content_align',array(
        'default' => 'center',
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_copyright_content_align',array(
        'type' => 'select',
        'label' => __('Copyright Text Alignment ','bb-mobile-application'),
        'section' => 'bb_mobile_application_footer_section',
        'choices' => array(
            'left' => __('Left','bb-mobile-application'),
            'right' => __('Right','bb-mobile-application'),
            'center' => __('Center','bb-mobile-application'),
        ),
	) );

	$wp_customize->add_setting('bb_mobile_application_footer_content_font_size',array(
		'default'=> 16,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_footer_content_font_size',array(
		'label' => esc_html__( 'Copyright Font Size','bb-mobile-application' ),
		'section'=> 'bb_mobile_application_footer_section',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
        'type' => 'number',
	));

	$wp_customize->add_setting('bb_mobile_application_copyright_padding',array(
		'default'=> 15,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_copyright_padding',array(
		'label'	=> __('Copyright Padding','bb-mobile-application'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'bb_mobile_application_footer_section',
		'type'=> 'number'
	));

	$wp_customize->add_setting('bb_mobile_application_enable_disable_scroll',array(
        'default' => true,
        'sanitize_callback'	=> 'bb_mobile_application_sanitize_checkbox'
	));
	$wp_customize->add_control('bb_mobile_application_enable_disable_scroll',array(
     	'type' => 'checkbox',
      	'label' => __('Show / Hide Scroll Top Button','bb-mobile-application'),
      	'section' => 'bb_mobile_application_footer_section',
	));

	$wp_customize->add_setting('bb_mobile_application_scroll_setting',array(
        'default' => 'Right',
        'sanitize_callback' => 'bb_mobile_application_sanitize_choices'
	));
	$wp_customize->add_control('bb_mobile_application_scroll_setting',array(
        'type' => 'select',
        'label' => __('Scroll Back to Top Position','bb-mobile-application'),
        'section' => 'bb_mobile_application_footer_section',
        'choices' => array(
            'Left' => __('Left','bb-mobile-application'),
            'Right' => __('Right','bb-mobile-application'),
            'Center' => __('Center','bb-mobile-application'),
        ),
	) );

	$wp_customize->add_setting('bb_mobile_application_scroll_font_size_icon',array(
		'default'=> 20,
		'sanitize_callback'	=> 'bb_mobile_application_sanitize_float',
	));
	$wp_customize->add_control('bb_mobile_application_scroll_font_size_icon',array(
		'label'	=> __('Scroll Icon Font Size','bb-mobile-application'),
		'section'=> 'bb_mobile_application_footer_section',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
        'type' => 'number',
	) );
}
add_action( 'customize_register', 'bb_mobile_application_customize_register' );	

// logo resize
load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );


/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class BB_Mobile_Application_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'BB_Mobile_Application_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new BB_Mobile_Application_Customize_Section_Pro(
				$manager,
				'bb_mobile_application_example_1',
				array(
					'priority'	=> 9,
					'title'    => esc_html__( 'Upgrade to Pro', 'bb-mobile-application' ),
					'pro_text' => esc_html__( 'Go Pro',         'bb-mobile-application' ),
					'pro_url'  => esc_url( 'https://www.themeshopy.com/themes/bb-mobile-application-theme/' ),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'bb-mobile-application-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'bb-mobile-application-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
BB_Mobile_Application_Customize::get_instance();