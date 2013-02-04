<?php/** * Church Theme Framework * by churchthemes.com * * The framework provides code and assets common to multiple themes for more organized and efficient development/updates. * It is intended for use in themes that use the Church Content Manager plugin. *//******************************************** * CONSTANTS ********************************************/ /** * Universal Constants * * These are used by both the theme and the framework itself. */ add_action( 'after_setup_theme', 'ctc_fw_define_constants', 1 ); // very earlyfunction ctc_fw_define_constants() {	$theme_data = wp_get_theme();	// Framework Data	define( 'CTC_FW_VERSION', 		'0.5' ); 							// February 4, 2013		// Theme Data	define( 'CTC_VERSION', 			$theme_data->Version );				// specified in style.css (child theme version if used)	define( 'CTC_TEMPLATE', 		$theme_data->template );			// parent theme's folder (theme slug)	// Parent/Child Theme Constants	define( 'CTC_THEME_PATH', 		get_template_directory() );			// parent theme path	define( 'CTC_THEME_URL', 		get_template_directory_uri() );		// parent theme URI	define( 'CTC_CHILD_PATH', 		get_stylesheet_directory() );		// child theme path	define( 'CTC_CHILD_URL', 		get_stylesheet_directory_uri() );	// child theme URI	// Theme Directories	// (theme and framework structure mirror each other)	define( 'CTC_INC_DIR',			'includes' );						// includes directory	define( 'CTC_ADMIN_DIR',		CTC_INC_DIR . '/admin' );			// admin directory	define( 'CTC_CLASS_DIR', 		CTC_INC_DIR . '/classes' );			// classes directory	define( 'CTC_LIB_DIR', 			CTC_INC_DIR . '/libraries' );		// libraries directory	define( 'CTC_PARTS_DIR', 		'template-parts' );					// template parts directory	define( 'CTC_WIDGET_DIR', 		'widget-templates' );				// widget templates directory	define( 'CTC_CSS_DIR', 			'css' );							// stylesheets directory	define( 'CTC_JS_DIR', 			'js' );								// JavaScript directory	define( 'CTC_IMG_DIR', 			'images' );							// images directory	define( 'CTC_COLOR_DIR',		'color-schemes' );					// color schemes directory	define( 'CTC_LANG_DIR', 		'languages' );						// languages directory		// Framework Directories	// (theme and framework structure mirror each other)	define( 'CTC_FW_DIR',			basename( dirname( __FILE__) ) );	// framework directory (where this file is)	define( 'CTC_FW_INC_DIR',		CTC_FW_DIR . '/' . CTC_INC_DIR );	// framework includes directory	define( 'CTC_FW_ADMIN_DIR',		CTC_FW_DIR . '/' . CTC_ADMIN_DIR );	// framework admin directory	define( 'CTC_FW_CLASS_DIR',		CTC_FW_DIR . '/' . CTC_CLASS_DIR );	// framework classes directory	define( 'CTC_FW_LIB_DIR',		CTC_FW_DIR . '/' . CTC_LIB_DIR );	// framework libraries directory	define( 'CTC_FW_CSS_DIR', 		CTC_FW_DIR . '/' . CTC_CSS_DIR );	// framework stylesheets directory	define( 'CTC_FW_JS_DIR', 		CTC_FW_DIR . '/' . CTC_JS_DIR );	// framework JavaScript directory	define( 'CTC_FW_IMG_DIR', 		CTC_FW_DIR . '/' . CTC_IMG_DIR );	// framework images directory	}/******************************************** * INCLUDES ********************************************//** * Include Files */add_action( 'after_setup_theme', 'ctc_fw_include_files', 1 ); // very earlyfunction ctc_fw_include_files() {	// Functions	$includes = array(			// Frontend or Admin		'always' => array(					// Functions			CTC_FW_INC_DIR . '/localization.php',			CTC_FW_INC_DIR . '/dependencies.php',			CTC_FW_INC_DIR . '/support.php',			CTC_FW_INC_DIR . '/options.php',			CTC_FW_INC_DIR . '/customize.php',			CTC_FW_INC_DIR . '/color-schemes.php',			CTC_FW_INC_DIR . '/fonts.php',			CTC_FW_INC_DIR . '/media.php',			CTC_FW_INC_DIR . '/head.php',			CTC_FW_INC_DIR . '/menus.php',				CTC_FW_INC_DIR . '/templates.php',			CTC_FW_INC_DIR . '/shortcodes.php',			CTC_FW_INC_DIR . '/widgets.php',			CTC_FW_INC_DIR . '/posts.php',			CTC_FW_INC_DIR . '/pages.php',			CTC_FW_INC_DIR . '/sermons.php',			CTC_FW_INC_DIR . '/gallery.php',			CTC_FW_INC_DIR . '/helpers.php',			CTC_FW_INC_DIR . '/maps.php',			CTC_FW_INC_DIR . '/deprecated.php',						// Classes			CTC_FW_CLASS_DIR . '/customize-controls.php',			CTC_FW_CLASS_DIR . '/walker-nav-menu-description.php',			CTC_FW_CLASS_DIR . '/widget.php',						// Libraries			CTC_FW_LIB_DIR . '/ct-options/ct-options.php',					),			// Admin Only		'admin' => array(					// Functions			CTC_FW_ADMIN_DIR . '/activation.php',			CTC_FW_ADMIN_DIR . '/update.php',			CTC_FW_ADMIN_DIR . '/admin-css.php',			CTC_FW_ADMIN_DIR . '/admin-js.php',			CTC_FW_ADMIN_DIR . '/admin-menu.php',			CTC_FW_ADMIN_DIR . '/meta-boxes.php',						// Libraries			CTC_FW_LIB_DIR . '/ct-meta-box/ct-meta-box.php',		),				// Frontend Only		'frontend' => array (					// Functions			CTC_FW_INC_DIR . '/download.php',			CTC_FW_INC_DIR . '/redirection.php',		),	);	// Include Files	$includes = apply_filters( 'ctc_fw_includes', $includes ); // make filterable	ctc_load_includes( $includes );	}/** * Include Loader Function * * Used by framework above and function.php for theme-specific includes. * If include exists in child theme, it will be used. Otherwise, parent theme file is used. */function ctc_load_includes( $includes ) {			// Loop conditions	foreach ( $includes as $condition => $files ) {			// Check condition		$do_includes = false;		switch( $condition ) {						// Admin Only			case 'admin':							if ( is_admin() ) {					$do_includes = true;				}								break;							// Frontend Only			case 'frontend':							if ( ! is_admin() ) {					$do_includes = true;				}								break;							// Admin or Frontend (always)			default:							$do_includes = true;								break;								}			// Loop files if condition met		if ( $do_includes ) {					foreach( $files as $file ) {					locate_template( $file, true ); // include from child theme first, then parent theme			}					}			}}