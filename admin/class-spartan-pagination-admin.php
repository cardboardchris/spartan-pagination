<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/cardboardchris/spartan-pagination
 * @since      1.0.0
 *
 * @package    Spartan_Pagination
 * @subpackage Spartan_Pagination/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Spartan_Pagination
 * @subpackage Spartan_Pagination/admin
 * @author     Chris Metivier <chris.metivier@gmail.com>
 */
class Spartan_Pagination_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Spartan_Pagination_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Spartan_Pagination_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/spartan-pagination-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Spartan_Pagination_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Spartan_Pagination_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/spartan-pagination-admin.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'ajax_object', array('ajax_url' => get_admin_url() . '/admin-ajax.php', 'nonce' => wp_create_nonce($this->plugin_name . '-nonce')));
        global $post;
        if (is_object($post)) {
            wp_localize_script($this->plugin_name, 'spartan_pagination_page_id', $post->ID);
        }
    }
    ////////////////////////////////////////////////////////////////////////////////

    /**
     * Whether the user is using the block editor (Gutenberg).
     *
     * @return bool
     *
     * @since 1.2.1
     */
    public static function is_block_editor()
    {
        $current_screen = get_current_screen();
        return method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor();
    }

    /**
     * Adds the meta box to the post or page edit screen.
     *
     * @param string $page the name of the current page.
     * @param string $context the current context.
     * @return void
     *
     * @since 1.2.1
     */
    public function do_meta_boxes($page, $context)
    {
        if (!self::is_block_editor() && 'advanced' === $context) {
            add_meta_box('spartan-pagination', 'Spartan Pagination', array($this, 'meta_box'), $page, 'side');
        }
    }

    /**
     * Checks whether a page is currently excluded from pagination
     *
     * @param   int     $page_id    the id of the page to test
     * @return  bool                true if the page is excluded
     *
     * @since 1.2.1
     */
    private function is_excluded($page_id)
    {
        $pagination_options = get_option($this->plugin_name);
        $currently_excluded_string = $pagination_options['excluded_pages'];
        $currently_excluded_array = explode(',',$currently_excluded_string);

        return in_array($page_id,$currently_excluded_array);
    }

    /**
     * Add the ajax function for use by spartan-pagination-admin.js
     *
     * @return void
     *
     * @since 1.2.1
     */
    public function spartan_pagination_get_option()
    {
        check_ajax_referer($this->plugin_name . '-nonce');
        global $wpdb; // this is how you get access to the database
        $page_id = $_POST['pageId'];
        $operation = $_POST['operation'];
        $pagination_options = get_option($this->plugin_name);
        $currently_excluded_string = $pagination_options['excluded_pages'];
        if (!is_null($currently_excluded_string)) {
            $currently_excluded_array = explode(',', $currently_excluded_string);
        } else {
            $currently_excluded_array = array();
        }
        if ($operation == 'add') { // if adding the current page
            if (!empty($currently_excluded_array)) {
                if (!in_array($page_id,$currently_excluded_array)) {
                    $currently_excluded_array[] = $page_id;
                }
            } else {
                $currently_excluded_array[] = $page_id;
            }
        } else { // if removing the current page
            if (in_array($page_id,$currently_excluded_array)) {
                $key = array_search($page_id,$currently_excluded_array);
                unset($currently_excluded_array[$key]);
            }
        }

        if (count($currently_excluded_array) > 1) {
            $new_excluded_string = implode(',', $currently_excluded_array);
        } else {
            $new_excluded_string = $currently_excluded_array[0];
        }

        $pagination_options['excluded_pages'] = $new_excluded_string;

        $response = json_encode($pagination_options);

        update_option( $this->plugin_name, $pagination_options);

        echo $response;
        wp_die();
    }

    /**
     * Outputs the exclude option to editor meta box.
     *
     * @return void
     *
     * @since 1.2.1
     */
    public function meta_box()
    {
        $post = get_post(null);
        echo '<p>';
        wp_nonce_field('cws_plt_' . $post->ID, '_cws_plt_nonce', false, true);
        echo '</p>';
        ?>
        <p><label for="spartan-pagination-exclude"><input type="checkbox" name="spartan_pagination_exclude" id="spartan-pagination-exclude" value="_blank" <?php echo ($this->is_excluded($post->ID)) ? 'checked="checked"' : ''; ?>> exclude this page from pagination</label></p>
<!--        <p>currently excluded: <span class="currently-excluded">--><?php //echo (!(is_null(get_option($this->plugin_name)['excluded_pages']))) ? get_option($this->plugin_name)['excluded_pages'] : 'none'; ?><!--</span></p>-->

        <?php do_action('spartan_pagination_meta_box_bottom'); ?>

        <?php
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu()
    {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         */
        add_options_page('Spartan Pagination', 'Spartan Pagination', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @param $links
     *
     * @return array
     * @since    1.0.0
     *
     */

    public function add_action_links($links)
    {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page()
    {
        include_once('partials/spartan-pagination-admin-display.php');
    }

    /**
     * Save plugin options from settings page to the database.
     *
     * @since    1.0.0
     */

    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }

    /**
     * Validate inputs from settings page.
     *
     * @param $input
     *
     * @return array
     * @since    1.0.0
     *
     */
    public function validate($input)
    {
        // All checkboxes inputs
        $valid = array();

        // checkboxes
        $valid['back_next_buttons'] = (isset($input['back_next_buttons']) && !empty($input['back_next_buttons'])) ? 1 : 0;
        $valid['back_next_titles'] = (isset($input['back_next_titles']) && !empty($input['back_next_titles'])) ? 1 : 0;
        $valid['back_button_content'] = (isset($input['back_button_content']) && !empty($input['back_button_content'])) ? sanitize_text_field($input['back_button_content']) : null;
        $valid['back_button_icon_span'] = (isset($input['back_button_icon_span']) && !empty($input['back_button_icon_span'])) ? 1 : 0;
        $valid['back_button_icon_default'] = (isset($input['back_button_icon_default']) && !empty($input['back_button_icon_default'])) ? 1 : 0;
        $valid['back_button_icon_path'] = (isset($input['back_button_icon_path']) && !empty($input['back_button_icon_path'])) ? sanitize_text_field($input['back_button_icon_path']) : null;
        $valid['next_button_content'] = (isset($input['next_button_content']) && !empty($input['next_button_content'])) ? sanitize_text_field($input['next_button_content']) : null;
        $valid['next_button_icon_span'] = (isset($input['next_button_icon_span']) && !empty($input['next_button_icon_span'])) ? 1 : 0;
        $valid['next_button_icon_default'] = (isset($input['next_button_icon_default']) && !empty($input['next_button_icon_default'])) ? 1 : 0;
        $valid['next_button_icon_path'] = (isset($input['next_button_icon_path']) && !empty($input['next_button_icon_path'])) ? sanitize_text_field($input['next_button_icon_path']) : null;;
        $valid['first_level_number_buttons'] = (isset($input['first_level_number_buttons']) && !empty($input['first_level_number_buttons'])) ? 1 : 0;
        $valid['second_level_number_buttons'] = (isset($input['second_level_number_buttons']) && !empty($input['second_level_number_buttons'])) ? 1 : 0;
        $valid['second_level_continuous'] = (isset($input['second_level_continuous']) && !empty($input['second_level_continuous'])) ? 1 : 0;
        $valid['third_level_number_buttons'] = (isset($input['third_level_number_buttons']) && !empty($input['third_level_number_buttons'])) ? 1 : 0;
        $valid['third_level_continuous'] = (isset($input['third_level_continuous']) && !empty($input['third_level_continuous'])) ? 1 : 0;

        $valid['first_level_name'] = (isset($input['first_level_name']) && !empty($input['first_level_name'])) ? sanitize_text_field($input['first_level_name']) : null;
        $valid['show_first_level_in_location'] = (isset($input['show_first_level_in_location']) && !empty($input['show_first_level_in_location'])) ? 1 : 0;
        $valid['second_level_name'] = (isset($input['second_level_name']) && !empty($input['second_level_name'])) ? sanitize_text_field($input['second_level_name']) : null;
        $valid['third_level_name'] = (isset($input['third_level_name']) && !empty($input['third_level_name'])) ? sanitize_text_field($input['third_level_name']) : null;
        $valid['show_second_level_in_location'] = (isset($input['show_second_level_in_location']) && !empty($input['show_second_level_in_location'])) ? 1 : 0;
        $valid['show_third_level_in_location'] = (isset($input['show_third_level_in_location']) && !empty($input['show_third_level_in_location'])) ? 1 : 0;
        $valid['first_level_number_display'] = (isset($input['first_level_number_display']) && !empty($input['first_level_number_display'])) ? sanitize_text_field($input['first_level_number_display']) : null;
        $valid['second_level_number_display'] = (isset($input['second_level_number_display']) && !empty($input['second_level_number_display'])) ? sanitize_text_field($input['second_level_number_display']) : null;
        $valid['third_level_number_display'] = (isset($input['third_level_number_display']) && !empty($input['third_level_number_display'])) ? sanitize_text_field($input['third_level_number_display']) : null;
        $valid['level_delimiter'] = (isset($input['level_delimiter']) && !empty($input['level_delimiter'])) ? $input['level_delimiter'] : null;
        $valid['title_only_pages'] = (isset($input['title_only_pages']) && !empty($input['title_only_pages'])) ? sanitize_text_field($input['title_only_pages']) : null;

        $valid['links_to_excluded'] = (isset($input['links_to_excluded']) && !empty($input['links_to_excluded'])) ? 1 : 0;
        $valid['excluded_pages'] = (isset($input['excluded_pages']) && !empty($input['excluded_pages'])) ? sanitize_text_field($input['excluded_pages']) : null;
        $valid['paginate_excluded'] = (isset($input['paginate_excluded']) && !empty($input['paginate_excluded'])) ? sanitize_text_field($input['paginate_excluded']) : null;

        return $valid;
    }

}
