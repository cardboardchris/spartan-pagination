<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/cardboardchris/spartan-pagination
 * @since      1.0.0
 *
 * @package    Spartan_Pagination
 * @subpackage Spartan_Pagination/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Spartan_Pagination
 * @subpackage Spartan_Pagination/includes
 * @author     Chris Metivier <chris.metivier@gmail.com>
 */
class Spartan_Pagination_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        delete_option('spartan-pagination');
	}

}
