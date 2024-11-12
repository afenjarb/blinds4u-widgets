<?php
/*
Plugin Name: Custom Title Widget
Description: An Elementor widget for creating customizable titles with background lines.
Version: 1.0
Author: Innotent LTD
*/

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Register Customizable Title Widget
function ct_register_customizable_title_widget() {
    // Check if Elementor is active
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning is-dismissible"><p>Custom Title Widget requires Elementor to be active.</p></div>';
        });
        return;
    }
    
    require_once(plugin_dir_path(__FILE__) . 'widgets/customizable-title-widget.php');

    // Register the widget with Elementor
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Customizable_Title_Widget());
}
add_action('elementor/widgets/widgets_registered', 'ct_register_customizable_title_widget');

// Register Categories Grid Widget
function register_categories_grid_widget() {
    require_once(plugin_dir_path(__FILE__) . 'widgets/categories-grid-widget.php');
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Categories_Grid_Widget());
}
add_action('elementor/widgets/widgets_registered', 'register_categories_grid_widget');

function enqueue_categories_grid_assets() {
    wp_enqueue_style('categories-grid-style', plugins_url('assets/categories-grid-widget-style.css', __FILE__));
    wp_enqueue_script('categories-grid-script', plugins_url('assets/categories-grid-widget-script.js', __FILE__), ['jquery'], '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_categories_grid_assets');

// Enqueue the styles and scripts
function ct_enqueue_custom_title_widget_assets() {
    wp_enqueue_style('custom-title-widget-style', plugins_url('assets/customizable-title-widget-style.css', __FILE__));
    wp_enqueue_style('categories-grid-style', plugins_url('assets/categories-grid-widget-style.css', __FILE__));
    wp_enqueue_script('categories-grid-script', plugins_url('assets/categories-grid-widget-script.js', __FILE__), ['jquery', 'elementor-frontend'], '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'ct_enqueue_custom_title_widget_assets');
