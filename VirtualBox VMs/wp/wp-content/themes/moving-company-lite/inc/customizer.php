<?php
/**
 * Moving Company Lite Theme Customizer
 *
 * @package Moving Company Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function moving_company_lite_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'moving_company_lite_custom_controls' );

function moving_company_lite_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage'; 
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array( 
		'selector' => '.logo .site-title a', 
	 	'render_callback' => 'moving_company_lite_customize_partial_blogname', 
	)); 

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
		'selector' => 'p.site-description', 
		'render_callback' => 'moving_company_lite_customize_partial_blogdescription', 
	));

	//add home page setting pannel
	$MovingCompanyLiteParentPanel = new Moving_Company_Lite_WP_Customize_Panel( $wp_customize, 'moving_company_lite_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__( 'VW Settings', 'moving-company-lite' ),
		'priority' => 10,
	));

	$wp_customize->add_panel( $MovingCompanyLiteParentPanel );

	$HomePageParentPanel = new Moving_Company_Lite_WP_Customize_Panel( $wp_customize, 'moving_company_lite_homepage_panel', array(
		'title' => __( 'Homepage Settings', 'moving-company-lite' ),
		'panel' => 'moving_company_lite_panel_id',
	));

	$wp_customize->add_panel( $HomePageParentPanel );

	//Top Bar
	$wp_customize->add_section( 'moving_company_lite_topbar', array(
    	'title'      => __( 'Top Bar Settings', 'moving-company-lite' ),
		'panel' => 'moving_company_lite_homepage_panel'
	) );

	$wp_customize->add_setting( 'moving_company_lite_header_background_color_first', array(
	    'default' => '#0c3c8e',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'moving_company_lite_header_background_color_first', array(
  		'label' => __('Header First Color', 'moving-company-lite'),
	    'section' => 'moving_company_lite_topbar',
	    'settings' => 'moving_company_lite_header_background_color_first',
  	)));

  	$wp_customize->add_setting( 'moving_company_lite_header_background_color_second', array(
	    'default' => '#14b5f0',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'moving_company_lite_header_background_color_second', array(
  		'label' => __('Header Second Color', 'moving-company-lite'),
	    'section' => 'moving_company_lite_topbar',
	    'settings' => 'moving_company_lite_header_background_color_second',
  	)));

	//Sticky Header
	$wp_customize->add_setting( 'moving_company_lite_sticky_header',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_sticky_header',array(
        'label' => esc_html__( 'Show / Hide Sticky Header','moving-company-lite' ),
        'section' => 'moving_company_lite_topbar'
    )));

    $wp_customize->add_setting('moving_company_lite_sticky_header_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_sticky_header_padding',array(
		'label'	=> __('Sticky Header Padding','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'moving_company_lite_header_search',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_header_search',array(
      	'label' => esc_html__( 'Show / Hide Search','moving-company-lite' ),
      	'section' => 'moving_company_lite_topbar'
    )));

    $wp_customize->add_setting('moving_company_lite_search_icon',array(
		'default'	=> 'fas fa-search',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_search_icon',array(
		'label'	=> __('Add Search Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_topbar',
		'setting'	=> 'moving_company_lite_search_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('moving_company_lite_search_close_icon',array(
		'default'	=> 'fa fa-window-close',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_search_close_icon',array(
		'label'	=> __('Add Search Close Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_topbar',
		'setting'	=> 'moving_company_lite_search_close_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('moving_company_lite_search_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_search_font_size',array(
		'label'	=> __('Search Font Size','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_search_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_search_padding_top_bottom',array(
		'label'	=> __('Search Padding Top Bottom','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_search_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_search_padding_left_right',array(
		'label'	=> __('Search Padding Left Right','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'moving_company_lite_search_border_radius', array(
		'default'              => "",
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_search_border_radius', array(
		'label'       => esc_html__( 'Search Border Radius','moving-company-lite' ),
		'section'     => 'moving_company_lite_topbar',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting( 'moving_company_lite_social_media',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_social_media',array(
      	'label' => esc_html__( 'Show / Hide Social Media','moving-company-lite' ),
      	'section' => 'moving_company_lite_topbar'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('moving_company_lite_calling_text', array( 
		'selector' => '.call-info h6', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_calling_text', 
	));

    $wp_customize->add_setting('moving_company_lite_phone_icon',array(
		'default'	=> 'fas fa-phone',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_phone_icon',array(
		'label'	=> __('Add Phone Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_topbar',
		'setting'	=> 'moving_company_lite_phone_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('moving_company_lite_calling_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_calling_text',array(
		'label'	=> __('Add Phone Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Call us Now', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'moving_company_lite_sanitize_phone_number'
	));
	$wp_customize->add_control('moving_company_lite_phone_number',array(
		'label'	=> __('Add Phone Number','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '+00 1234 567 890', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('moving_company_lite_email_text', array( 
		'selector' => '.info-box h2', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_email_text', 
	));

	$wp_customize->add_setting('moving_company_lite_email_icon',array(
		'default'	=> 'fas fa-paper-plane',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_email_icon',array(
		'label'	=> __('Add Email Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_topbar',
		'setting'	=> 'moving_company_lite_email_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('moving_company_lite_email_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_email_text',array(
		'label'	=> __('Add Email Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Email us Now', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));
	$wp_customize->add_control('moving_company_lite_email_address',array(
		'label'	=> __('Add Email Address','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'example@gmail.com', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_timing_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_timing_icon',array(
		'label'	=> __('Add Timing Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_topbar',
		'setting'	=> 'moving_company_lite_timing_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('moving_company_lite_opening_time_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_opening_time_text',array(
		'label'	=> __('Add Opening Time Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Open Hours', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_opening_time',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_opening_time',array(
		'label'	=> __('Add Opening Time','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Mon - Fri 8:00am to 9:00am Sat - Closed', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_topbar',
		'type'=> 'text'
	));

	//Menus Settings
	$wp_customize->add_section( 'moving_company_lite_menu_section' , array(
    	'title' => __( 'Menus Settings', 'moving-company-lite' ),
		'panel' => 'moving_company_lite_homepage_panel'
	) );

	$wp_customize->add_setting('moving_company_lite_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_navigation_menu_font_size',array(
		'label'	=> __('Menus Font Size','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_menu_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_navigation_menu_font_weight',array(
        'default' => 700,
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_navigation_menu_font_weight',array(
        'type' => 'select',
        'label' => __('Menus Font Weight','moving-company-lite'),
        'section' => 'moving_company_lite_menu_section',
        'choices' => array(
        	'100' => __('100','moving-company-lite'),
            '200' => __('200','moving-company-lite'),
            '300' => __('300','moving-company-lite'),
            '400' => __('400','moving-company-lite'),
            '500' => __('500','moving-company-lite'),
            '600' => __('600','moving-company-lite'),
            '700' => __('700','moving-company-lite'),
            '800' => __('800','moving-company-lite'),
            '900' => __('900','moving-company-lite'),
        ),
	) );

	// text trasform
	$wp_customize->add_setting('moving_company_lite_menu_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_menu_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Menus Text Transform','moving-company-lite'),
		'choices' => array(
            'Uppercase' => __('Uppercase','moving-company-lite'),
            'Capitalize' => __('Capitalize','moving-company-lite'),
            'Lowercase' => __('Lowercase','moving-company-lite'),
        ),
		'section'=> 'moving_company_lite_menu_section',
	));

	$wp_customize->add_setting('moving_company_lite_menus_item_style',array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_menus_item_style',array(
        'type' => 'select',
        'section' => 'moving_company_lite_menu_section',
		'label' => __('Menu Item Hover Style','moving-company-lite'),
		'choices' => array(
            'None' => __('None','moving-company-lite'),
            'Zoom In' => __('Zoom In','moving-company-lite'),
        ),
	) );

	$wp_customize->add_setting('moving_company_lite_header_menus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_header_menus_color', array(
		'label'    => __('Menus Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_menu_section',
	)));

	$wp_customize->add_setting('moving_company_lite_header_menus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_header_menus_hover_color', array(
		'label'    => __('Menus Hover Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_menu_section',
	)));

	$wp_customize->add_setting('moving_company_lite_header_submenus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_header_submenus_color', array(
		'label'    => __('Sub Menus Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_menu_section',
	)));

	$wp_customize->add_setting('moving_company_lite_header_submenus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_header_submenus_hover_color', array(
		'label'    => __('Sub Menus Hover Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_menu_section',
	)));

	//Social links
	$wp_customize->add_section(
		'moving_company_lite_social_links', array(
			'title'		=>	__('Social Links', 'moving-company-lite'),
			'priority'	=>	null,
			'panel'		=>	'moving_company_lite_homepage_panel'
		)
	);

	$wp_customize->add_setting('moving_company_lite_social_icons',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_social_icons',array(
		'label' =>  __('Steps to setup social icons','moving-company-lite'),
		'description' => __('<p>1. Go to Dashboard >> Appearance >> Widgets</p>
			<p>2. Add Vw Social Icon Widget in Social Icon Widget area.</p>
			<p>3. Add social icons url and save.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_social_links',
		'type'=> 'hidden'
	));
	$wp_customize->add_setting('moving_company_lite_social_icon_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_social_icon_btn',array(
		'description' => "<a target='_blank' href='". admin_url('widgets.php') ." '>Setup Social Icons</a>",
		'section'=> 'moving_company_lite_social_links',
		'type'=> 'hidden'
	));
    
	//Slider
	$wp_customize->add_section( 'moving_company_lite_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'moving-company-lite' ),
    	'description' => __('Free theme has 3 slides options, For unlimited slides and more options <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/themes/moving-company-wordpress-theme/">GO PRO</a>','moving-company-lite'),
		'panel' => 'moving_company_lite_homepage_panel'
	) );

	$wp_customize->add_setting( 'moving_company_lite_slider_arrows',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_slider_arrows',array(
      	'label' => esc_html__( 'Show / Hide Slider','moving-company-lite' ),
      	'section' => 'moving_company_lite_slidersettings'
    )));

    $wp_customize->add_setting('moving_company_lite_slider_type',array(
        'default' => 'Default slider',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	) );
	$wp_customize->add_control('moving_company_lite_slider_type', array(
        'type' => 'select',
        'label' => __('Slider Type','moving-company-lite'),
        'section' => 'moving_company_lite_slidersettings',
        'choices' => array(
            'Default slider' => __('Default slider','moving-company-lite'),
            'Advance slider' => __('Advance slider','moving-company-lite'),
        ),
	));

	$wp_customize->add_setting('moving_company_lite_advance_slider_shortcode',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_advance_slider_shortcode',array(
		'label'	=> __('Add Slider Shortcode','moving-company-lite'),
		'section'=> 'moving_company_lite_slidersettings',
		'type'=> 'text',
		'active_callback' => 'moving_company_lite_advance_slider'
	));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('moving_company_lite_slider_arrows',array(
		'selector'        => '#slider .inner_carousel h1',
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_slider_arrows',
	));

	for ( $count = 1; $count <= 3; $count++ ) {
		$wp_customize->add_setting( 'moving_company_lite_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'moving_company_lite_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'moving_company_lite_slider_page' . $count, array(
			'label'    => __( 'Select Slider Page', 'moving-company-lite' ),
			'description' => __('Slider image size (1600 x 600)','moving-company-lite'),
			'section'  => 'moving_company_lite_slidersettings',
			'type'     => 'dropdown-pages',
			'active_callback' => 'moving_company_lite_default_slider'
		) );
	}

	$wp_customize->add_setting('moving_company_lite_slider_button_text',array(
		'default'=> 'Read More',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_slider_button_text',array(
		'label'	=> __('Add Slider Button Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Read More', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_slidersettings',
		'type'=> 'text',
		'active_callback' => 'moving_company_lite_default_slider'
	));

	//content layout
	$wp_customize->add_setting('moving_company_lite_slider_content_option',array(
        'default' => 'Left',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control(new Moving_Company_Lite_Image_Radio_Control($wp_customize, 'moving_company_lite_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','moving-company-lite'),
        'section' => 'moving_company_lite_slidersettings',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/slider-content1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/slider-content2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/slider-content3.png',
    ),
    	'active_callback' => 'moving_company_lite_default_slider'
	)));

	 //Slider content padding
    $wp_customize->add_setting('moving_company_lite_slider_content_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_slider_content_padding_top_bottom',array(
		'label'	=> __('Slider Content Padding Top Bottom','moving-company-lite'),
		'description'	=> __('Enter a value in %. Example:20%','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_slidersettings',
		'type'=> 'text',
		'active_callback' => 'moving_company_lite_default_slider'
	));

	$wp_customize->add_setting('moving_company_lite_slider_content_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_slider_content_padding_left_right',array(
		'label'	=> __('Slider Content Padding Left Right','moving-company-lite'),
		'description'	=> __('Enter a value in %. Example:20%','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_slidersettings',
		'type'=> 'text',
		'active_callback' => 'moving_company_lite_default_slider'
	));

	//Slider excerpt
	$wp_customize->add_setting( 'moving_company_lite_slider_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','moving-company-lite' ),
		'section'     => 'moving_company_lite_slidersettings',
		'type'        => 'range',
		'settings'    => 'moving_company_lite_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 15,
			'max'              => 50,
		),'active_callback' => 'moving_company_lite_default_slider'
	) );

	//Slider height
	$wp_customize->add_setting('moving_company_lite_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_slider_height',array(
		'label'	=> __('Slider Height','moving-company-lite'),
		'description'	=> __('Specify the slider height (px).','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_slidersettings',
		'type'=> 'text',
		'active_callback' => 'moving_company_lite_default_slider'
	));

	$wp_customize->add_setting( 'moving_company_lite_slider_speed', array(
		'default'  => 4000,
		'sanitize_callback'	=> 'moving_company_lite_sanitize_float'
	) );
	$wp_customize->add_control( 'moving_company_lite_slider_speed', array(
		'label' => esc_html__('Slider Transition Speed','moving-company-lite'),
		'section' => 'moving_company_lite_slidersettings',
		'type'  => 'number',
		'active_callback' => 'moving_company_lite_default_slider'
	) );

	//Opacity
	$wp_customize->add_setting('moving_company_lite_slider_opacity_color',array(
      'default'              => 0.8,
      'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));

	$wp_customize->add_control( 'moving_company_lite_slider_opacity_color', array(
	'label'       => esc_html__( 'Slider Image Opacity','moving-company-lite' ),
	'section'     => 'moving_company_lite_slidersettings',
	'type'        => 'select',
	'settings'    => 'moving_company_lite_slider_opacity_color',
	'choices' => array(
      '0' =>  esc_attr('0','moving-company-lite'),
      '0.1' =>  esc_attr('0.1','moving-company-lite'),
      '0.2' =>  esc_attr('0.2','moving-company-lite'),
      '0.3' =>  esc_attr('0.3','moving-company-lite'),
      '0.4' =>  esc_attr('0.4','moving-company-lite'),
      '0.5' =>  esc_attr('0.5','moving-company-lite'),
      '0.6' =>  esc_attr('0.6','moving-company-lite'),
      '0.7' =>  esc_attr('0.7','moving-company-lite'),
      '0.8' =>  esc_attr('0.8','moving-company-lite'),
      '0.9' =>  esc_attr('0.9','moving-company-lite')
	),'active_callback' => 'moving_company_lite_default_slider'
	));

	$wp_customize->add_setting( 'moving_company_lite_slider_image_overlay',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'moving_company_lite_switch_sanitization'
   	));
   	$wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_slider_image_overlay',array(
      	'label' => esc_html__( 'Show / Hide Slider Image Overlay','moving-company-lite' ),
      	'section' => 'moving_company_lite_slidersettings',
      	'active_callback' => 'moving_company_lite_default_slider'
   	)));

   	$wp_customize->add_setting('moving_company_lite_slider_image_overlay_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_slider_image_overlay_color', array(
		'label'    => __('Slider Image Overlay Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_slidersettings',
		'active_callback' => 'moving_company_lite_default_slider'
	)));

	//About us Section
	$wp_customize->add_section('moving_company_lite_about', array(
		'title'       => __('About US Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_about_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_about_text',array(
		'description' => __('<p>1. More options for about us section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for about us section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_about',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_about_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_about_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_about',
		'type'=> 'hidden'
	));
 
	//Our Services section
	$wp_customize->add_section( 'moving_company_lite_services_section' , array(
    	'title'      => __( 'Our Services', 'moving-company-lite' ),
    	'description' => __('For more options of service section <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/themes/moving-company-wordpress-theme/">GO PRO</a>','moving-company-lite'),
		'priority'   => null,
		'panel' => 'moving_company_lite_homepage_panel'
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'moving_company_lite_section_title', array( 
		'selector' => '#serv-section h3', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_section_title',
	));

	$wp_customize->add_setting('moving_company_lite_section_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_section_title',array(
		'label'	=> __('Add Section Title','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Packers & Movers Services', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_services_section',
		'type'=> 'text'
	));

	$categories = get_categories();
	$cat_post = array();
	$cat_post[]= 'select';
	$i = 0;	
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('moving_company_lite_our_services',array(
		'default'	=> 'select',
		'sanitize_callback' => 'moving_company_lite_sanitize_choices',
	));
	$wp_customize->add_control('moving_company_lite_our_services',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => __('Select Category to display Services','moving-company-lite'),
		'description' => __('Image Size (280 x 180)','moving-company-lite'),
		'section' => 'moving_company_lite_services_section',
	));

	//Services excerpt
	$wp_customize->add_setting( 'moving_company_lite_services_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_services_excerpt_number', array(
		'label'       => esc_html__( 'Services Excerpt length','moving-company-lite' ),
		'section'     => 'moving_company_lite_services_section',
		'type'        => 'range',
		'settings'    => 'moving_company_lite_services_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 15,
			'max'              => 50,
		),
	) );

	//partners Section
	$wp_customize->add_section('moving_company_lite_partners', array(
		'title'       => __('Partners Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_partners_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_partners_text',array(
		'description' => __('<p>1. More options for partners section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for partners section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_partners',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_partners_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_partners_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_partners',
		'type'=> 'hidden'
	));

	//projects Section
	$wp_customize->add_section('moving_company_lite_projects', array(
		'title'       => __('Projects Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_projects_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_projects_text',array(
		'description' => __('<p>1. More options for projects section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for projects section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_projects',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_projects_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_projects_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_projects',
		'type'=> 'hidden'
	));


	//choose us Section
	$wp_customize->add_section('moving_company_lite_choose_us', array(
		'title'       => __('Choose Us Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_choose_us_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_choose_us_text',array(
		'description' => __('<p>1. More options for choose us section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for choose us section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_choose_us',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_choose_us_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_choose_us_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_choose_us',
		'type'=> 'hidden'
	));

	//moving tips Section
	$wp_customize->add_section('moving_company_lite_moving_tips', array(
		'title'       => __('Moving Tips Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_moving_tips_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_moving_tips_text',array(
		'description' => __('<p>1. More options for moving tips section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for moving tips section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_moving_tips',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_moving_tips_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_moving_tips_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_moving_tips',
		'type'=> 'hidden'
	));

	//records Section
	$wp_customize->add_section('moving_company_lite_records', array(
		'title'       => __('Records Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_records_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_records_text',array(
		'description' => __('<p>1. More options for records section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for records section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_records',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_records_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_records_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_records',
		'type'=> 'hidden'
	));

	//how we work Section
	$wp_customize->add_section('moving_company_lite_how_we_work', array(
		'title'       => __('How We Work Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_how_we_work_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_how_we_work_text',array(
		'description' => __('<p>1. More options for how we work section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for how we work section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_how_we_work',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_how_we_work_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_how_we_work_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_how_we_work',
		'type'=> 'hidden'
	));

	//appointment Section
	$wp_customize->add_section('moving_company_lite_appointment', array(
		'title'       => __('Appointment Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_appointment_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_appointment_text',array(
		'description' => __('<p>1. More options for appointment section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for appointment section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_appointment',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_appointment_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_appointment_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_appointment',
		'type'=> 'hidden'
	));

	//team Section
	$wp_customize->add_section('moving_company_lite_team', array(
		'title'       => __('Team Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_team_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_team_text',array(
		'description' => __('<p>1. More options for team section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for team section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_team',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_team_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_team_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_team',
		'type'=> 'hidden'
	));

	//testimonial Section
	$wp_customize->add_section('moving_company_lite_testimonial', array(
		'title'       => __('Testimonial Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_testimonial_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_testimonial_text',array(
		'description' => __('<p>1. More options for testimonial section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for testimonial section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_testimonial',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_testimonial_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_testimonial_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_testimonial',
		'type'=> 'hidden'
	));

	//latest news Section
	$wp_customize->add_section('moving_company_lite_latest_news', array(
		'title'       => __('Latest News Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_latest_news_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_latest_news_text',array(
		'description' => __('<p>1. More options for latest news section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for latest news section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_latest_news',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_latest_news_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_latest_news_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_latest_news',
		'type'=> 'hidden'
	));

	//call us Section
	$wp_customize->add_section('moving_company_lite_call_us', array(
		'title'       => __('Call Us Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_call_us_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_call_us_text',array(
		'description' => __('<p>1. More options for call us section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for call us section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_call_us',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_call_us_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_call_us_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_call_us',
		'type'=> 'hidden'
	));

	//video faq Section
	$wp_customize->add_section('moving_company_lite_video_faq', array(
		'title'       => __('Video Faq Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_video_faq_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_video_faq_text',array(
		'description' => __('<p>1. More options for video faq section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for video faq section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_video_faq',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_video_faq_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_video_faq_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_video_faq',
		'type'=> 'hidden'
	));

	//home contact Section
	$wp_customize->add_section('moving_company_lite_home_contact', array(
		'title'       => __('Home Contact Section', 'moving-company-lite'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','moving-company-lite'),
		'priority'    => null,
		'panel'       => 'moving_company_lite_homepage_panel',
	));

	$wp_customize->add_setting('moving_company_lite_home_contact_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_home_contact_text',array(
		'description' => __('<p>1. More options for home contact section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for home contact section.</p>','moving-company-lite'),
		'section'=> 'moving_company_lite_home_contact',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('moving_company_lite_home_contact_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_home_contact_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url('themes.php?page=moving_company_lite_guide') ." '>More Info</a>",
		'section'=> 'moving_company_lite_home_contact',
		'type'=> 'hidden'
	));

	//Footer Text
	$wp_customize->add_section('moving_company_lite_footer',array(
		'title'	=> __('Footer Settings','moving-company-lite'),
		'description' => __('For more options of footer section <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/themes/moving-company-wordpress-theme/">GO PRO</a>','moving-company-lite'),
		'panel' => 'moving_company_lite_homepage_panel',
	));	

	$wp_customize->add_setting( 'moving_company_lite_footer_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));
    $wp_customize->add_control( new moving_company_lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_footer_hide_show',array(
      'label' => esc_html__( 'Show / Hide Footer','moving-company-lite' ),
      'section' => 'moving_company_lite_footer'
    )));

	$wp_customize->add_setting('moving_company_lite_footer_background_color', array(
		'default'           => '#0c3c8e',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_footer_background_color', array(
		'label'    => __('Footer Background Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_footer',
	)));

	$wp_customize->add_setting('moving_company_lite_footer_background_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'moving_company_lite_footer_background_image',array(
        'label' => __('Footer Background Image','moving-company-lite'),
        'section' => 'moving_company_lite_footer'
	)));

	$wp_customize->add_setting('moving_company_lite_footer_img_position',array(
	  'default' => 'center center',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_footer_img_position',array(
		'type' => 'select',
		'label' => __('Footer Image Position','moving-company-lite'),
		'section' => 'moving_company_lite_footer',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'moving-company-lite' ),
			'center top'   => esc_html__( 'Top', 'moving-company-lite' ),
			'right top'   => esc_html__( 'Top Right', 'moving-company-lite' ),
			'left center'   => esc_html__( 'Left', 'moving-company-lite' ),
			'center center'   => esc_html__( 'Center', 'moving-company-lite' ),
			'right center'   => esc_html__( 'Right', 'moving-company-lite' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'moving-company-lite' ),
			'center bottom'   => esc_html__( 'Bottom', 'moving-company-lite' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'moving-company-lite' ),
		),
	));

	// Footer
	$wp_customize->add_setting('moving_company_lite_img_footer',array(
		'default'=> 'scroll',
		'sanitize_callback'	=> 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_img_footer',array(
		'type' => 'select',
		'label'	=> __('Footer Background Attatchment','moving-company-lite'),
		'choices' => array(
            'fixed' => __('fixed','moving-company-lite'),
            'scroll' => __('scroll','moving-company-lite'),
        ),
		'section'=> 'moving_company_lite_footer',
	));

	// footer padding
	$wp_customize->add_setting('moving_company_lite_footer_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_footer_padding',array(
		'label'	=> __('Footer Top Bottom Padding','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'moving-company-lite' ),
    ),
		'section'=> 'moving_company_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_footer_widgets_heading',array(
        'default' => 'Left',
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_footer_widgets_heading',array(
        'type' => 'select',
        'label' => __('Footer Widget Heading','moving-company-lite'),
        'section' => 'moving_company_lite_footer',
        'choices' => array(
        	'Left' => __('Left','moving-company-lite'),
            'Center' => __('Center','moving-company-lite'),
            'Right' => __('Right','moving-company-lite')
        ),
	) );

	$wp_customize->add_setting('moving_company_lite_footer_widgets_content',array(
        'default' => 'Left',
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_footer_widgets_content',array(
        'type' => 'select',
        'label' => __('Footer Widget Content','moving-company-lite'),
        'section' => 'moving_company_lite_footer',
        'choices' => array(
        	'Left' => __('Left','moving-company-lite'),
            'Center' => __('Center','moving-company-lite'),
            'Right' => __('Right','moving-company-lite')
        ),
	) );

    // footer social icon
  	$wp_customize->add_setting( 'moving_company_lite_footer_icon',array(
		'default' => false,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
  	$wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_footer_icon',array(
		'label' => esc_html__( 'Show / Hide Footer Social Icon','moving-company-lite' ),
		'section' => 'moving_company_lite_footer'
    ))); 

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('moving_company_lite_footer_text', array( 
		'selector' => '.copyright p', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_footer_text', 
	));

	$wp_customize->add_setting( 'moving_company_lite_copyright_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));
    $wp_customize->add_control( new moving_company_lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_copyright_hide_show',array(
      'label' => esc_html__( 'Show / Hide Copyright','moving-company-lite' ),
      'section' => 'moving_company_lite_footer'
    )));

	$wp_customize->add_setting('moving_company_lite_copyright_background_color', array(
		'default'           => '#14b5f0',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_copyright_background_color', array(
		'label'    => __('Copyright Background Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_footer',
	)));
	
	$wp_customize->add_setting('moving_company_lite_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('moving_company_lite_footer_text',array(
		'label'	=> __('Copyright Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Copyright 2019, .....', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_footer',
		'type'=> 'text'
	));	

	$wp_customize->add_setting('moving_company_lite_copyright_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_copyright_font_size',array(
		'label'	=> __('Copyright Font Size','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_copyright_padding_top_bottom',array(
		'label'	=> __('Copyright Padding Top Bottom','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_copyright_alignment',array(
        'default' => 'center',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control(new Moving_Company_Lite_Image_Radio_Control($wp_customize, 'moving_company_lite_copyright_alignment', array(
        'type' => 'select',
        'label' => __('Copyright Alignment','moving-company-lite'),
        'section' => 'moving_company_lite_footer',
        'settings' => 'moving_company_lite_copyright_alignment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
    ))));

	$wp_customize->add_setting( 'moving_company_lite_hide_show_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_hide_show_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','moving-company-lite' ),
      	'section' => 'moving_company_lite_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('moving_company_lite_scroll_top_icon', array( 
		'selector' => '.scrollup i', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_scroll_top_icon', 
	));

    $wp_customize->add_setting('moving_company_lite_scroll_top_icon',array(
		'default'	=> 'fas fa-angle-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_scroll_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_footer',
		'setting'	=> 'moving_company_lite_scroll_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('moving_company_lite_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_scroll_to_top_width',array(
		'label'	=> __('Icon Width','moving-company-lite'),
		'description'	=> __('Enter a value in pixels Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_scroll_to_top_height',array(
		'label'	=> __('Icon Height','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'moving_company_lite_scroll_to_top_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','moving-company-lite' ),
		'section'     => 'moving_company_lite_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('moving_company_lite_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control(new Moving_Company_Lite_Image_Radio_Control($wp_customize, 'moving_company_lite_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','moving-company-lite'),
        'section' => 'moving_company_lite_footer',
        'settings' => 'moving_company_lite_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
    ))));

    //Blog Post
	$wp_customize->add_panel( $MovingCompanyLiteParentPanel );

	$BlogPostParentPanel = new Moving_Company_Lite_WP_Customize_Panel( $wp_customize, 'blog_post_parent_panel', array(
		'title' => __( 'Blog Post Settings', 'moving-company-lite' ),
		'panel' => 'moving_company_lite_panel_id',
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'moving_company_lite_post_settings', array(
		'title' => __( 'Post Settings', 'moving-company-lite' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Blog layout
    $wp_customize->add_setting('moving_company_lite_blog_layout_option',array(
        'default' => 'Default',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
    ));
    $wp_customize->add_control(new Moving_Company_Lite_Image_Radio_Control($wp_customize, 'moving_company_lite_blog_layout_option', array(
        'type' => 'select',
        'label' => __('Blog Layouts','moving-company-lite'),
        'section' => 'moving_company_lite_post_settings',
        'choices' => array(
            'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
    ))));

	$wp_customize->add_setting('moving_company_lite_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_theme_options',array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','moving-company-lite'),
        'description' => __('Here you can change the sidebar layout for posts. ','moving-company-lite'),
        'section' => 'moving_company_lite_post_settings',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','moving-company-lite'),
            'Right Sidebar' => __('Right Sidebar','moving-company-lite'),
            'One Column' => __('One Column','moving-company-lite'),
            'Three Columns' => __('Three Columns','moving-company-lite'),
            'Four Columns' => __('Four Columns','moving-company-lite'),
            'Grid Layout' => __('Grid Layout','moving-company-lite')
        ),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('moving_company_lite_toggle_postdate', array( 
		'selector' => '.post-main-box h2 a', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_toggle_postdate', 
	));

  	$wp_customize->add_setting('moving_company_lite_toggle_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_toggle_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_post_settings',
		'setting'	=> 'moving_company_lite_toggle_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'moving_company_lite_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_toggle_postdate',array(
        'label' => esc_html__( 'Show / Hide Post Date','moving-company-lite' ),
        'section' => 'moving_company_lite_post_settings'
    )));

	$wp_customize->add_setting('moving_company_lite_toggle_author_icon',array(
		'default'	=> 'far fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_toggle_author_icon',array(
		'label'	=> __('Add Author Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_post_settings',
		'setting'	=> 'moving_company_lite_toggle_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'moving_company_lite_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_toggle_author',array(
		'label' => esc_html__( 'Show / Hide Author','moving-company-lite' ),
		'section' => 'moving_company_lite_post_settings'
    )));

    $wp_customize->add_setting('moving_company_lite_toggle_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_toggle_comments_icon',array(
		'label'	=> __('Add Comments Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_post_settings',
		'setting'	=> 'moving_company_lite_toggle_comments_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'moving_company_lite_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','moving-company-lite' ),
		'section' => 'moving_company_lite_post_settings'
    )));

  	$wp_customize->add_setting('moving_company_lite_toggle_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_toggle_time_icon',array(
		'label'	=> __('Add Time Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_post_settings',
		'setting'	=> 'moving_company_lite_toggle_time_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'moving_company_lite_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','moving-company-lite' ),
		'section' => 'moving_company_lite_post_settings'
    )));

    $wp_customize->add_setting( 'moving_company_lite_featured_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
	));
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_featured_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','moving-company-lite' ),
		'section' => 'moving_company_lite_post_settings'
    )));

    $wp_customize->add_setting( 'moving_company_lite_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_featured_image_border_radius', array(
		'label'       => esc_html__( 'Featured Image Border Radius','moving-company-lite' ),
		'section'     => 'moving_company_lite_post_settings',
		'type'        => 'range',
		'settings'    => 'moving_company_lite_featured_image_border_radius',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'moving_company_lite_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Featured Image Box Shadow','moving-company-lite' ),
		'section'     => 'moving_company_lite_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Featured Image
	$wp_customize->add_setting('moving_company_lite_blog_post_featured_image_dimension',array(
       'default' => 'default',
       'sanitize_callback'	=> 'moving_company_lite_sanitize_choices'
	));
  	$wp_customize->add_control('moving_company_lite_blog_post_featured_image_dimension',array(
		'type' => 'select',
		'label'	=> __('Blog Post Featured Image Dimension','moving-company-lite'),
		'section'	=> 'moving_company_lite_post_settings',
		'choices' => array(
		'default' => __('Default','moving-company-lite'),
		'custom' => __('Custom Image Size','moving-company-lite'),
      ),
  	));

	$wp_customize->add_setting('moving_company_lite_blog_post_featured_image_custom_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		));
	$wp_customize->add_control('moving_company_lite_blog_post_featured_image_custom_width',array(
		'label'	=> __('Featured Image Custom Width','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'moving-company-lite' ),),
		'section'=> 'moving_company_lite_post_settings',
		'type'=> 'text',
		'active_callback' => 'moving_company_lite_blog_post_featured_image_dimension'
		));

	$wp_customize->add_setting('moving_company_lite_blog_post_featured_image_custom_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_blog_post_featured_image_custom_height',array(
		'label'	=> __('Featured Image Custom Height','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'moving-company-lite' ),),
		'section'=> 'moving_company_lite_post_settings',
		'type'=> 'text',
		'active_callback' => 'moving_company_lite_blog_post_featured_image_dimension'
	));

    $wp_customize->add_setting( 'moving_company_lite_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','moving-company-lite' ),
		'section'     => 'moving_company_lite_post_settings',
		'type'        => 'range',
		'settings'    => 'moving_company_lite_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('moving_company_lite_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','moving-company-lite'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','moving-company-lite'),
		'section'=> 'moving_company_lite_post_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('moving_company_lite_blog_page_posts_settings',array(
        'default' => 'Into Blocks',
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_blog_page_posts_settings',array(
        'type' => 'select',
        'label' => __('Display Blog Posts','moving-company-lite'),
        'section' => 'moving_company_lite_post_settings',
        'choices' => array(
        	'Into Blocks' => __('Into Blocks','moving-company-lite'),
            'Without Blocks' => __('Without Blocks','moving-company-lite')
        ),
	) );

    $wp_customize->add_setting('moving_company_lite_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_excerpt_settings',array(
        'type' => 'select',
        'label' => __('Post Content','moving-company-lite'),
        'section' => 'moving_company_lite_post_settings',
        'choices' => array(
        	'Content' => __('Content','moving-company-lite'),
            'Excerpt' => __('Excerpt','moving-company-lite'),
            'No Content' => __('No Content','moving-company-lite')
        ),
	) );

	$wp_customize->add_setting('moving_company_lite_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'moving_company_lite_blog_pagination_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_blog_pagination_hide_show',array(
      'label' => esc_html__( 'Show / Hide Blog Pagination','moving-company-lite' ),
      'section' => 'moving_company_lite_post_settings'
    )));

	$wp_customize->add_setting( 'moving_company_lite_blog_pagination_type', array(
        'default'			=> 'blog-page-numbers',
        'sanitize_callback'	=> 'moving_company_lite_sanitize_choices'
    ));
    $wp_customize->add_control( 'moving_company_lite_blog_pagination_type', array(
        'section' => 'moving_company_lite_post_settings',
        'type' => 'select',
        'label' => __( 'Blog Pagination', 'moving-company-lite' ),
        'choices'		=> array(
            'blog-page-numbers'  => __( 'Numeric', 'moving-company-lite' ),
            'next-prev' => __( 'Older Posts/Newer Posts', 'moving-company-lite' ),
    )));

    // Button Settings
	$wp_customize->add_section( 'moving_company_lite_button_settings', array(
		'title' => __( 'Button Settings', 'moving-company-lite' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('moving_company_lite_button_text', array( 
		'selector' => '.post-main-box .more-btn a', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_button_text', 
	));

    $wp_customize->add_setting('moving_company_lite_button_text',array(
		'default'=> esc_html__( 'Read More', 'moving-company-lite' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_button_text',array(
		'label'	=> __('Add Button Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Read More', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_button_padding_top_bottom',array(
		'label'	=> __('Padding Top Bottom','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_button_padding_left_right',array(
		'label'	=> __('Padding Left Right','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_button_settings',
		'type'=> 'text'
	));

	// font size button
	$wp_customize->add_setting('moving_company_lite_button_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_button_font_size',array(
		'label'	=> __('Button Font Size','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'moving-company-lite' ),
    ),
    	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'moving_company_lite_button_settings',
	));

	$wp_customize->add_setting( 'moving_company_lite_button_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','moving-company-lite' ),
		'section'     => 'moving_company_lite_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('moving_company_lite_button_letter_spacing',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_button_letter_spacing',array(
		'label'	=> __('Button Letter Spacing','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'moving-company-lite' ),
    ),
    	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'moving_company_lite_button_settings',
	));

	// text trasform
	$wp_customize->add_setting('moving_company_lite_button_text_transform',array(
		'default'=> 'Uppercase',
		'sanitize_callback'	=> 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_button_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Button Text Transform','moving-company-lite'),
		'choices' => array(
            'Uppercase' => __('Uppercase','moving-company-lite'),
            'Capitalize' => __('Capitalize','moving-company-lite'),
            'Lowercase' => __('Lowercase','moving-company-lite'),
        ),
		'section'=> 'moving_company_lite_button_settings',
	));


	// Related Post Settings
	$wp_customize->add_section( 'moving_company_lite_related_posts_settings', array(
		'title' => __( 'Related Posts Settings', 'moving-company-lite' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('moving_company_lite_related_post_title', array( 
		'selector' => '.related-post h3', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_related_post_title', 
	));

    $wp_customize->add_setting( 'moving_company_lite_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_related_post',array(
		'label' => esc_html__( 'Show / Hide Related Post','moving-company-lite' ),
		'section' => 'moving_company_lite_related_posts_settings'
    )));

    $wp_customize->add_setting('moving_company_lite_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_related_post_title',array(
		'label'	=> __('Add Related Post Title','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Related Post', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('moving_company_lite_related_posts_count',array(
		'default'=> '3',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_related_posts_count',array(
		'label'	=> __('Add Related Post Count','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '3', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_related_posts_settings',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'moving_company_lite_related_posts_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_related_posts_excerpt_number', array(
		'label'       => esc_html__( 'Related Posts Excerpt length','moving-company-lite' ),
		'section'     => 'moving_company_lite_related_posts_settings',
		'type'        => 'range',
		'settings'    => 'moving_company_lite_related_posts_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	// Single Posts Settings
	$wp_customize->add_section( 'moving_company_lite_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'moving-company-lite' ),
		'panel' => 'blog_post_parent_panel',
	));

  	$wp_customize->add_setting('moving_company_lite_single_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new moving_company_lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_single_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_single_blog_settings',
		'setting'	=> 'moving_company_lite_single_postdate_icon',
		'type'		=> 'icon'
	)));

 	$wp_customize->add_setting( 'moving_company_lite_single_postdate',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'moving_company_lite_switch_sanitization'
	) );
	$wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_single_postdate',array(
	    'label' => esc_html__( 'Show / Hide Date','moving-company-lite' ),
	   'section' => 'moving_company_lite_single_blog_settings'
	)));

	$wp_customize->add_setting('moving_company_lite_single_author_icon',array(
		'default'	=> 'far fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new moving_company_lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_single_author_icon',array(
		'label'	=> __('Add Author Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_single_blog_settings',
		'setting'	=> 'moving_company_lite_single_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'moving_company_lite_single_author',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'moving_company_lite_switch_sanitization'
	) );
	$wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_single_author',array(
	    'label' => esc_html__( 'Show / Hide Author','moving-company-lite' ),
	    'section' => 'moving_company_lite_single_blog_settings'
	)));

   	$wp_customize->add_setting('moving_company_lite_single_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new moving_company_lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_single_comments_icon',array(
		'label'	=> __('Add Comments Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_single_blog_settings',
		'setting'	=> 'moving_company_lite_single_comments_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'moving_company_lite_single_comments',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'moving_company_lite_switch_sanitization'
	) );
	$wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_single_comments',array(
	    'label' => esc_html__( 'Show / Hide Comments','moving-company-lite' ),
	    'section' => 'moving_company_lite_single_blog_settings'
	)));

  	$wp_customize->add_setting('moving_company_lite_single_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new moving_company_lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_single_time_icon',array(
		'label'	=> __('Add Time Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_single_blog_settings',
		'setting'	=> 'moving_company_lite_single_time_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'moving_company_lite_single_time',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'moving_company_lite_switch_sanitization'
	) );

	$wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_single_time',array(
	    'label' => esc_html__( 'Show / Hide Time','moving-company-lite' ),
	    'section' => 'moving_company_lite_single_blog_settings'
	)));

	$wp_customize->add_setting( 'moving_company_lite_single_post_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_single_post_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Breadcrumb','moving-company-lite' ),
		'section' => 'moving_company_lite_single_blog_settings'
    )));

     // Single Posts Category
  	$wp_customize->add_setting( 'moving_company_lite_single_post_category',array(
		'default' => true,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
  	$wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_single_post_category',array(
		'label' => esc_html__( 'Show / Hide Category','moving-company-lite' ),
		'section' => 'moving_company_lite_single_blog_settings'
    )));

	$wp_customize->add_setting( 'moving_company_lite_toggle_tags',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
	));
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_toggle_tags', array(
		'label' => esc_html__( 'Show / Hide Tags','moving-company-lite' ),
		'section' => 'moving_company_lite_single_blog_settings'
    )));

	$wp_customize->add_setting( 'moving_company_lite_single_blog_post_navigation_show_hide',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
	));
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_single_blog_post_navigation_show_hide', array(
		'label' => esc_html__( 'Show / Hide Post Navigation','moving-company-lite' ),
		'section' => 'moving_company_lite_single_blog_settings'
    )));

	$wp_customize->add_setting('moving_company_lite_single_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_single_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','moving-company-lite'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','moving-company-lite'),
		'section'=> 'moving_company_lite_single_blog_settings',
		'type'=> 'text'
	));

	//navigation text
	$wp_customize->add_setting('moving_company_lite_single_blog_prev_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_single_blog_prev_navigation_text',array(
		'label'	=> __('Post Navigation Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'PREVIOUS', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_single_blog_next_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_single_blog_next_navigation_text',array(
		'label'	=> __('Post Navigation Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'NEXT', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_single_blog_comment_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('moving_company_lite_single_blog_comment_title',array(
		'label'	=> __('Add Comment Title','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Leave a Reply', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_single_blog_comment_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('moving_company_lite_single_blog_comment_button_text',array(
		'label'	=> __('Add Comment Button Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Post Comment', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_single_blog_comment_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_single_blog_comment_width',array(
		'label'	=> __('Comment Form Width','moving-company-lite'),
		'description'	=> __('Enter a value in %. Example:50%','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '100%', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_single_blog_settings',
		'type'=> 'text'
	));

	// Grid layout setting
	$wp_customize->add_section( 'moving_company_lite_grid_layout_settings', array(
		'title' => __( 'Grid Layout Settings', 'moving-company-lite' ),
		'panel' => 'blog_post_parent_panel',
	));

  	$wp_customize->add_setting('moving_company_lite_grid_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new moving_company_lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_grid_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_grid_layout_settings',
		'setting'	=> 'moving_company_lite_grid_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'moving_company_lite_grid_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_grid_postdate',array(
        'label' => esc_html__( 'Show / Hide Post Date','moving-company-lite' ),
        'section' => 'moving_company_lite_grid_layout_settings'
    )));

	$wp_customize->add_setting('moving_company_lite_grid_author_icon',array(
		'default'	=> 'far fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new moving_company_lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_grid_author_icon',array(
		'label'	=> __('Add Author Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_grid_layout_settings',
		'setting'	=> 'moving_company_lite_grid_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'moving_company_lite_grid_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_grid_author',array(
		'label' => esc_html__( 'Show / Hide Author','moving-company-lite' ),
		'section' => 'moving_company_lite_grid_layout_settings'
    )));

   	$wp_customize->add_setting('moving_company_lite_grid_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new moving_company_lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_grid_comments_icon',array(
		'label'	=> __('Add Comments Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_grid_layout_settings',
		'setting'	=> 'moving_company_lite_grid_comments_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'moving_company_lite_grid_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_grid_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','moving-company-lite' ),
		'section' => 'moving_company_lite_grid_layout_settings'
    )));

   // other settings
	$OtherParentPanel = new Moving_Company_Lite_WP_Customize_Panel( $wp_customize, 'moving_company_lite_other_panel_id', array(
		'title' => __( 'Others Settings', 'moving-company-lite' ),
		'panel' => 'moving_company_lite_panel_id',
	));

	$wp_customize->add_panel( $OtherParentPanel );

	// Layout
	$wp_customize->add_section( 'moving_company_lite_left_right', array(
    	'title'      => esc_html__( 'General Settings', 'moving-company-lite' ),
		'panel' => 'moving_company_lite_other_panel_id'
	) );

	$wp_customize->add_setting('moving_company_lite_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control(new Moving_Company_Lite_Image_Radio_Control($wp_customize, 'moving_company_lite_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','moving-company-lite'),
        'description' => __('Here you can change the width layout of Website.','moving-company-lite'),
        'section' => 'moving_company_lite_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
        ))));

	$wp_customize->add_setting('moving_company_lite_page_layout',array(
        'default' => 'One Column',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','moving-company-lite'),
        'description' => __('Here you can change the sidebar layout for pages. ','moving-company-lite'),
        'section' => 'moving_company_lite_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','moving-company-lite'),
            'Right Sidebar' => __('Right Sidebar','moving-company-lite'),
            'One Column' => __('One Column','moving-company-lite')
        ),
	) );

	$wp_customize->add_setting( 'moving_company_lite_single_page_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_single_page_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Breadcrumb','moving-company-lite' ),
		'section' => 'moving_company_lite_left_right'
    )));

	//Wow Animation
	$wp_customize->add_setting( 'moving_company_lite_animation',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_animation',array(
        'label' => esc_html__( 'Show / Hide Animation ','moving-company-lite' ),
        'description' => __('Here you can disable overall site animation effect','moving-company-lite'),
        'section' => 'moving_company_lite_left_right'
    )));

    $wp_customize->add_setting('moving_company_lite_reset_all_settings',array(
      'sanitize_callback'	=> 'sanitize_text_field',
   	));
   	$wp_customize->add_control(new Moving_Company_Lite_Reset_Custom_Control($wp_customize, 'moving_company_lite_reset_all_settings',array(
      'type' => 'reset_control',
      'label' => __('Reset All Settings', 'moving-company-lite'),
      'description' => 'moving_company_lite_reset_all_settings',
      'section' => 'moving_company_lite_left_right'
   	)));

	//Pre-Loader
	$wp_customize->add_setting( 'moving_company_lite_loader_enable',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_loader_enable',array(
        'label' => esc_html__( 'Show / Hide Pre-Loader','moving-company-lite' ),
        'section' => 'moving_company_lite_left_right'
    )));

	$wp_customize->add_setting('moving_company_lite_preloader_bg_color', array(
		'default'           => '#14b5f0',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_preloader_bg_color', array(
		'label'    => __('Pre-Loader Background Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_left_right',
	)));

	$wp_customize->add_setting('moving_company_lite_preloader_border_color', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_preloader_border_color', array(
		'label'    => __('Pre-Loader Border Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_left_right',
	)));

	$wp_customize->add_setting('moving_company_lite_preloader_bg_img',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'moving_company_lite_preloader_bg_img',array(
        'label' => __('Preloader Background Image','moving-company-lite'),
        'section' => 'moving_company_lite_left_right'
	)));

    //404 Page Setting
	$wp_customize->add_section('moving_company_lite_404_page',array(
		'title'	=> __('404 Page Settings','moving-company-lite'),
		'panel' => 'moving_company_lite_other_panel_id',
	));	

	$wp_customize->add_setting('moving_company_lite_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('moving_company_lite_404_page_title',array(
		'label'	=> __('Add Title','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('moving_company_lite_404_page_content',array(
		'label'	=> __('Add Text','moving-company-lite'),
		'input_attrs' => array(
         'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_404_page_button_text',array(
		'label'	=> __('Add Button Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'GO BACK', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_404_page',
		'type'=> 'text'
	));

	//No Result Page Setting
	$wp_customize->add_section('moving_company_lite_no_results_page',array(
		'title'	=> __('No Results Page Settings','moving-company-lite'),
		'panel' => 'moving_company_lite_other_panel_id',
	));	

	$wp_customize->add_setting('moving_company_lite_no_results_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('moving_company_lite_no_results_page_title',array(
		'label'	=> __('Add Title','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Nothing Found', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_no_results_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_no_results_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('moving_company_lite_no_results_page_content',array(
		'label'	=> __('Add Text','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_no_results_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('moving_company_lite_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','moving-company-lite'),
		'panel' => 'moving_company_lite_other_panel_id',
	));	

	$wp_customize->add_setting('moving_company_lite_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_social_icon_padding',array(
		'label'	=> __('Icon Padding','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_social_icon_width',array(
		'label'	=> __('Icon Width','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_social_icon_height',array(
		'label'	=> __('Icon Height','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'moving_company_lite_social_icon_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','moving-company-lite' ),
		'section'     => 'moving_company_lite_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('moving_company_lite_responsive_media',array(
		'title'	=> __('Responsive Media','moving-company-lite'),
		'panel' => 'moving_company_lite_other_panel_id',
	));

    $wp_customize->add_setting( 'moving_company_lite_stickyheader_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_stickyheader_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sticky Header','moving-company-lite' ),
      'section' => 'moving_company_lite_responsive_media'
    )));

    $wp_customize->add_setting( 'moving_company_lite_resp_slider_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','moving-company-lite' ),
      'section' => 'moving_company_lite_responsive_media'
    )));

    $wp_customize->add_setting( 'moving_company_lite_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','moving-company-lite' ),
      'section' => 'moving_company_lite_responsive_media'
    )));

    $wp_customize->add_setting( 'moving_company_lite_resp_scroll_top_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','moving-company-lite' ),
      'section' => 'moving_company_lite_responsive_media'
    )));

    $wp_customize->add_setting('moving_company_lite_res_menu_open_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_res_menu_open_icon',array(
		'label'	=> __('Add Open Menu Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_responsive_media',
		'setting'	=> 'moving_company_lite_res_menu_open_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('moving_company_lite_res_close_menus_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Moving_Company_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'moving_company_lite_res_close_menus_icon',array(
		'label'	=> __('Add Close Menu Icon','moving-company-lite'),
		'transport' => 'refresh',
		'section'	=> 'moving_company_lite_responsive_media',
		'setting'	=> 'moving_company_lite_res_close_menus_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('moving_company_lite_resp_menu_toggle_btn_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'moving_company_lite_resp_menu_toggle_btn_color', array(
		'label'    => __('Toggle Button Color', 'moving-company-lite'),
		'section'  => 'moving_company_lite_responsive_media',
	)));

    //Woocommerce settings
	$wp_customize->add_section('moving_company_lite_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'moving-company-lite'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

    //Shop Page Featured Image
	$wp_customize->add_setting( 'moving_company_lite_shop_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_shop_featured_image_border_radius', array(
		'label'       => esc_html__( 'Shop Page Featured Image Border Radius','moving-company-lite' ),
		'section'     => 'moving_company_lite_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'moving_company_lite_shop_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_shop_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Shop Page Featured Image Box Shadow','moving-company-lite' ),
		'section'     => 'moving_company_lite_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'moving_company_lite_woocommerce_shop_page_sidebar', array( 'selector' => '.post-type-archive-product #sidebar', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_woocommerce_shop_page_sidebar', ) );

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'moving_company_lite_woocommerce_shop_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide Shop Page Sidebar','moving-company-lite' ),
		'section' => 'moving_company_lite_woocommerce_section'
    )));

    $wp_customize->add_setting('moving_company_lite_shop_page_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_shop_page_layout',array(
        'type' => 'select',
        'label' => __('Shop Page Sidebar Layout','moving-company-lite'),
        'section' => 'moving_company_lite_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','moving-company-lite'),
            'Right Sidebar' => __('Right Sidebar','moving-company-lite'),
        ),
	) );

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'moving_company_lite_woocommerce_single_product_page_sidebar', array( 'selector' => '.single-product #sidebar', 
		'render_callback' => 'moving_company_lite_customize_partial_moving_company_lite_woocommerce_single_product_page_sidebar', ) );

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'moving_company_lite_woocommerce_single_product_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide Single Product Sidebar','moving-company-lite' ),
		'section' => 'moving_company_lite_woocommerce_section'
    )));

   	$wp_customize->add_setting('moving_company_lite_single_product_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_single_product_layout',array(
        'type' => 'select',
        'label' => __('Single Product Sidebar Layout','moving-company-lite'),
        'section' => 'moving_company_lite_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','moving-company-lite'),
            'Right Sidebar' => __('Right Sidebar','moving-company-lite'),
        ),
	) );

    //Products per page
    $wp_customize->add_setting('moving_company_lite_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'moving_company_lite_sanitize_float'
	));
	$wp_customize->add_control('moving_company_lite_products_per_page',array(
		'label'	=> __('Products Per Page','moving-company-lite'),
		'description' => __('Display on shop page','moving-company-lite'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'moving_company_lite_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('moving_company_lite_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_products_per_row',array(
		'label'	=> __('Products Per Row','moving-company-lite'),
		'description' => __('Display on shop page','moving-company-lite'),
		'choices' => array(
            '2' => '2',
			'3' => '3',
			'4' => '4',
        ),
		'section'=> 'moving_company_lite_woocommerce_section',
		'type'=> 'select',
	));

	//Products padding
	$wp_customize->add_setting('moving_company_lite_products_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_products_padding_top_bottom',array(
		'label'	=> __('Products Padding Top Bottom','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_products_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_products_padding_left_right',array(
		'label'	=> __('Products Padding Left Right','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_woocommerce_section',
		'type'=> 'text'
	));

	//Products box shadow
	$wp_customize->add_setting( 'moving_company_lite_products_box_shadow', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_products_box_shadow', array(
		'label'       => esc_html__( 'Products Box Shadow','moving-company-lite' ),
		'section'     => 'moving_company_lite_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products border radius
    $wp_customize->add_setting( 'moving_company_lite_products_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_products_border_radius', array(
		'label'       => esc_html__( 'Products Border Radius','moving-company-lite' ),
		'section'     => 'moving_company_lite_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('moving_company_lite_products_btn_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_products_btn_padding_top_bottom',array(
		'label'	=> __('Products Button Padding Top Bottom','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_products_btn_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_products_btn_padding_left_right',array(
		'label'	=> __('Products Button Padding Left Right','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'moving_company_lite_products_button_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_products_button_border_radius', array(
		'label'       => esc_html__( 'Products Button Border Radius','moving-company-lite' ),
		'section'     => 'moving_company_lite_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products Sale Badge
	$wp_customize->add_setting('moving_company_lite_woocommerce_sale_position',array(
        'default' => 'right',
        'sanitize_callback' => 'moving_company_lite_sanitize_choices'
	));
	$wp_customize->add_control('moving_company_lite_woocommerce_sale_position',array(
        'type' => 'select',
        'label' => __('Sale Badge Position','moving-company-lite'),
        'section' => 'moving_company_lite_woocommerce_section',
        'choices' => array(
            'left' => __('Left','moving-company-lite'),
            'right' => __('Right','moving-company-lite'),
        ),
	) );

	$wp_customize->add_setting('moving_company_lite_woocommerce_sale_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_woocommerce_sale_font_size',array(
		'label'	=> __('Sale Font Size','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_woocommerce_sale_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_woocommerce_sale_padding_top_bottom',array(
		'label'	=> __('Sale Padding Top Bottom','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('moving_company_lite_woocommerce_sale_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('moving_company_lite_woocommerce_sale_padding_left_right',array(
		'label'	=> __('Sale Padding Left Right','moving-company-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','moving-company-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'moving-company-lite' ),
        ),
		'section'=> 'moving_company_lite_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'moving_company_lite_woocommerce_sale_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'moving_company_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'moving_company_lite_woocommerce_sale_border_radius', array(
		'label'       => esc_html__( 'Sale Border Radius','moving-company-lite' ),
		'section'     => 'moving_company_lite_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

  	// Related Product
    $wp_customize->add_setting( 'moving_company_lite_related_product_show_hide',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'moving_company_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Moving_Company_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'moving_company_lite_related_product_show_hide',array(
        'label' => esc_html__( 'Show / Hide Related product','moving-company-lite' ),
        'section' => 'moving_company_lite_woocommerce_section'
    )));


    // Has to be at the top
	$wp_customize->register_panel_type( 'Moving_Company_Lite_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'Moving_Company_Lite_WP_Customize_Section' );
}

add_action( 'customize_register', 'moving_company_lite_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class Moving_Company_Lite_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'moving_company_lite_panel';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class Moving_Company_Lite_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'moving_company_lite_section';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function moving_company_lite_customize_controls_scripts() {
  wp_enqueue_script( 'customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'moving_company_lite_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Moving_Company_Lite_Customize {

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
		$manager->register_section_type( 'Moving_Company_Lite_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new Moving_Company_Lite_Customize_Section_Pro( $manager,'moving_company_lite_upgrade_pro_link', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Moving Company Pro', 'moving-company-lite' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'moving-company-lite' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/themes/moving-company-wordpress-theme/'),
		) )	);

		// Register sections.
		$manager->add_section(new Moving_Company_Lite_Customize_Section_Pro($manager,'moving_company_lite_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'DOCUMENTATION', 'moving-company-lite' ),
			'pro_text' => esc_html__( 'DOCS', 'moving-company-lite' ),
			'pro_url'  => esc_url('https://www.vwthemesdemo.com/docs/free-moving-company-lite/'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'moving-company-lite-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'moving-company-lite-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );

		wp_localize_script(
		'moving-company-lite-customize-controls',
		'moving_company_lite_customizer_params',
		array(
			'ajaxurl' =>	admin_url( 'admin-ajax.php' )
		));
	}
}

// Doing this customizer thang!
Moving_Company_Lite_Customize::get_instance();