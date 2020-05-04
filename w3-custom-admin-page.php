<?php
/*
Plugin Name: W3 custom admin page
Description: Adds a custom admin pages with sample styles and scripts.
Plugin URI: https://github.com/w3programmers/w3-custom-admin-page
Version: 1.0.0
Author: Masud Alam
Author URI: http://w3programmers.com
Text Domain: w3-custom-admin-page
*/

function w3_admin_menu(){
    add_menu_page(
        __( 'Sample Page', 'w3-textdomain' ),
        __( 'Sample Page', 'w3-textdomain' ),
        'manage_options',
        'sample-page',
        'w3_admin_page_contents',
        'dashicons-schedule',
        3
    );
    
}

add_action( 'admin_menu', 'w3_admin_menu' );

function w3_admin_page_contents() {
?>
<h1>
<?php esc_html_e( 'Welcome to w3 custom admin page.', 'w3-plugin-textdomain' ); ?>
</h1>
<?php
}

function w3_admin_submenu() {
    add_submenu_page(
        'sample-page',
        'Sample Submenu Page',
        'Sample Submenu Page',
        'manage_options',
        'sample-submenu-page',
        'w3_admin_submenu_page_contents',
        4
    );
}

add_action( 'admin_menu', 'w3_admin_submenu' );

function w3_admin_submenu_page_contents() {
    echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
        echo '<h2>My Custom Submenu Page</h2>';
    echo '</div>';
}

function w3_register_plugin_scripts() {
    wp_register_style( 'w3-style', plugins_url( 'css/style.css' ) );
    wp_register_script( 'w3-script', plugins_url( 'js/script.js' ) );
}

add_action( 'admin_enqueue_scripts', 'w3_register_plugin_scripts' );

function load_w3_plugin_scripts( $hook ) {
    // Load only on ?page=sample-page
    if( $hook != 'toplevel_page_sample-page' ) {
        return;
}

// Load style & scripts.
wp_enqueue_style( 'w3-style' );
wp_enqueue_script( 'w3-script' );
}

add_action( 'admin_enqueue_scripts', 'load_w3_plugin_scripts' );

/* Create settings section */

add_action( 'admin_init', 'w3_create_settings_section' );

function w3_create_settings_section(){

    /* Register Settings */
register_setting(
        'reading',             // Options group
        'w3_option_name',      // Option name/database
        'w3_settings_sanitize' // sanitize callback function
);

add_settings_section(
    'w3-section-id',                   // Section ID
    'W3 Additional Reading Settings Section',  // Section title
    'w3_settings_new_section_area', // Section callback function
    'reading'                          // Settings page slug
);
 /* Create settings field */
 add_settings_field(
    'w3-settings-checkbox-id',       // Field ID
    'I agree Terms & Conditions', // Field title 
    'w3_settings_field_callback', // Field callback function
    'reading',                    // Settings page slug
    'w3-section-id',               // Section ID
    array( 'label_for' => 'w3-settings-field-id' )
);

}

/* Sanitize Callback Function */
function w3_settings_sanitize( $input ){
    return isset( $input ) ? true : false;
}


/* Setting Section Description */
function w3_settings_new_section_area(){
    echo wpautop( "This aren't the Settings you're looking for. Move along." );
}

/* Settings Field Callback */
function w3_settings_field_callback(){
    ?>
   
        <input id="w3-settings-checkbox-id" type="checkbox" value="1" name="w3_option_name" <?php checked( get_option( 'w3-option-name', true ) ); ?>>
    
    <?php
}