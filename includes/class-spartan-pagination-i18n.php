<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/cardboardchris/spartan-pagination
 * @since      1.0.0
 *
 * @package    Spartan_Pagination
 * @subpackage Spartan_Pagination/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Spartan_Pagination
 * @subpackage Spartan_Pagination/includes
 * @author     Chris Metivier <chris.metivier@gmail.com>
 */
class Spartan_Pagination_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'spartan-pagination',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
