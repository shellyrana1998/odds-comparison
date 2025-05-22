<?php
/**
 * Plugin Name: Odds Comparison
 * Description: Compare live odds from various bookmakers with Filters.
 * Version: 1.0
 * Author: Shelly Rana
 */

// Exit if accessed directly to prevent unauthorized access
if ( ! defined( 'ABSPATH' ) ) exit;

// Load the required class files from the plugin's includes directory
require_once plugin_dir_path( __FILE__ ) . 'includes/class-odds-fetcher.php';     // Handles fetching odds data
require_once plugin_dir_path( __FILE__ ) . 'includes/class-odds-converter.php';   // (Optional) Handles odds format conversions
require_once plugin_dir_path( __FILE__ ) . 'includes/class-odds-admin.php';       // Handles admin-related functionality

/**
 * Register the custom Gutenberg block and its associated scripts.
 */
function odds_comparison_register_block() {
    // Register the JavaScript file for the block editor
    wp_register_script(
        'odds-comparison-block', // Handle for the script
        plugins_url( 'blocks/odds-comparison-block/edit.js', __FILE__ ), // Path to the block's JS file
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ), // Dependencies required by the block
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/odds-comparison-block/edit.js' ), // Versioning via file modification time
        true // Load script in the footer
    );

    // Optional: Register block-specific styles if needed (commented for now)
    // wp_register_style( 'odds-comparison-style', plugins_url( 'style.css', __FILE__ ), array(), '1.0' );

    // Register the block with a render callback for dynamic output
    register_block_type( 'odds-comparison/api-data-block', array(
        'editor_script'   => 'odds-comparison-block',   // Script to use in the block editor
        'render_callback' => 'odds_comparison_render_block', // PHP function to render block output
    ) );
}
// Hook into 'init' to register the block during WordPress initialization
add_action( 'init', 'odds_comparison_register_block' );

/**
 * Callback function to render the block content on the front-end.
 * This is where the odds table template is included and returned as HTML.
 */
function odds_comparison_render_block( $attributes ) {
    ob_start(); // Start output buffering
    include plugin_dir_path( __FILE__ ) . 'templates/odds-table.php'; // Include the odds table markup
    return ob_get_clean(); // Return the buffered content
}
?>
