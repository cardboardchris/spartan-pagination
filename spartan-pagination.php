<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/cardboardchris/spartan-pagination
 * @since             1.1.4
 * @package           Spartan_Pagination
 *
 * @wordpress-plugin
 * Plugin Name:       Spartan Pagination
 * Plugin URI:        https://github.com/cardboardchris/spartan-pagination/courses/wordpress/portal/resources/wordpress/spartan-pagination/
 * Description:       This plugin adds pagination to pages with a range of options for navigation and page counting.
 * Version:           1.1.3
 * Author:            Chris Metivier
 * Author URI:        https://online.uncg.edu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       spartan-pagination
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// define this plugin's base path
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-spartan-pagination-activator.php
 */
function activate_spartan_pagination() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spartan-pagination-activator.php';
	Spartan_Pagination_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-spartan-pagination-deactivator.php
 */
function deactivate_spartan_pagination() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spartan-pagination-deactivator.php';
	Spartan_Pagination_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_spartan_pagination' );
register_deactivation_hook( __FILE__, 'deactivate_spartan_pagination' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-spartan-pagination.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_spartan_pagination() {

	$plugin = new Spartan_Pagination();
	$plugin->run();

}
run_spartan_pagination();
