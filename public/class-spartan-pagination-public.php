<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/cardboardchris/spartan-pagination
 * @since      1.0.0
 *
 * @package    Spartan_Pagination
 * @subpackage Spartan_Pagination/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Spartan_Pagination
 * @subpackage Spartan_Pagination/public
 * @author     Chris Metivier <chris.metivier@gmail.com>
 */
class Spartan_Pagination_Public
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
     * @param  string  $plugin_name  The name of the plugin.
     * @param  string  $version  The version of this plugin.
     *
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/spartan-pagination-public.css', array(),
            $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/spartan-pagination-public.js',
            array('jquery'), $this->version, false);

    }

    /**
     * Get the depth of a page.
     *
     * @param  object  $post  the post info object for the page
     *
     * @return   number         the depth value
     * @since    1.1.4
     * @access   private
     */
    private function get_page_depth($post)
    {
        $parent_id = $post->post_parent;
        $depth     = 0;
        while ($parent_id > 0) {
            $page      = get_page($parent_id);
            $parent_id = $page->post_parent;
            $depth++;
        }

        return $depth;
    }

    /**
     * Get the siblings of a page.
     *
     * @param  string  $post_id  the id of the page
     *
     * @return   array             an array of page ids
     * @since    1.0.0
     * @access   private
     */
    private function get_sibling_ids($post_id)
    {

        $parent_id = wp_get_post_parent_id($post_id);

        $args            = array(
            'sort_column'  => 'menu_order',
            'hierarchical' => 0,
            'exclude'      => get_option('page_on_front'),
            'parent'       => $parent_id,
            'post_type'    => 'page',
            'post_status'  => 'publish'
        );
        $sibling_objects = get_pages($args);

        $sibling_ids = array();
        foreach ($sibling_objects as $post) {
            $sibling_ids[] = $post->ID;
        }

        //returns array
        return $sibling_ids;
    }

    /**
     * Convert comma-separated lists into arrays.
     *
     * @param  string  $string  the comma-separated list
     *
     * @return   array            the list elements as an array
     * @since   1.1.3
     * @access  private
     */
    private function list_to_array($string)
    {

        if ( ! is_null($string)) {
            $array_dirty = explode(',', $string);
            $array       = array_filter(array_map('trim', $array_dirty));
        } else {
            $array = array();
        }

        return $array;
    }

    /**
     * Create a list of links to a page's siblings.
     *
     * @param  string   $post_id  the id of the page
     * @param  array    $excluded_pages
     * @param  integer  $first_sibling_number
     *
     * @return string string of html for a list with links
     * @since   1.0.0
     * @access  private
     *
     */
    private function list_siblings($post_id, $excluded_pages, $first_sibling_number)
    {

        $sibling_ids = $this->get_sibling_ids($post_id);

        // echo 'first sibling number: '.$first_sibling_number.'<br>';

        // create sibling page links
        $i             = $first_sibling_number;
        $output_string = '';
        foreach ($sibling_ids as $id) {
            // get the titles of the child posts by their IDs
            // skip excluded pages
            if ( ! in_array($id, $excluded_pages)) {
                $output_string .= "\n\t\t".'<li>';
                $output_string .= '<a ';
                if ($id == $post_id) {
                    $output_string .= 'class="active" ';
                }
                $output_string .= 'href="'.get_page_link($id).'">'.$i.'</a>';
                $output_string .= '</li>';
                $i++;
            }
        }

        return $output_string;
    }

    /**
     * Gets the location text for one level of depth (e.g. "lesson 3")
     *
     * @param  array  $levels  array of levels, with settings for each
     * @param  string  $post_id  the id of the page
     * @param  array  $all_page_ids  ids of all pages in the site
     * @param  integer  $level  the depth level of the page
     *
     * @return   string                 string of html for a list with links
     * @since   1.1.2
     * @access  private
     */
    private function get_level_location_text($levels, $post_id, $all_page_ids, $level)
    {

        $output_string = '';

        if ( ! is_null($levels[$level]['name'])) {
            // if a level name is given
            $output_string .= $levels[$level]['name'];
        } else {
            $post_object   = get_post($post_id);
            $output_string .= get_the_title($post_object);
        }

        $page_number_display = $levels[$level]['display'];

        if ($page_number_display == 'hide') {
            // if current page number is set to hide, show only a colon
            $output_string .= ':';
        } elseif ($page_number_display == 'x_of_y') {
            // if current page number is set to x of y, show the page's number and the count of its siblings
            $x             = $this->get_page_number($levels, $post_id, $all_page_ids, $level);
            $y             = count($this->get_sibling_ids($post_id));
            $output_string .= '&nbsp;'.$x.' of '.$y;
        } else {
            // if current page number is set to show, show the number
            $number        = $this->get_page_number($levels, $post_id, $all_page_ids, $level);
            $output_string .= '&nbsp;'.$number;
        }

        return $output_string;
    }

    /**
     * Gets the number of a page among either its siblings or all pages at its depth
     *
     * @param  array  $levels  array of levels, with settings for each
     * @param  integer  $post_id  the id of the page
     * @param  array  $all_page_ids  ids of all pages in the site
     * @param  integer  $current_page_level  the depth level of the current page
     * @param  string  $purpose  do we want a sibling number or a location number
     * @param  boolean  $debug  whether to output debugging info
     *
     * @return integer                      the number of the page in the list of sibling pages
     * @since  1.0.0
     * @access private
     */
    private function get_page_number(
        $levels,
        $post_id,
        $all_page_ids,
        $current_page_level,
        $purpose = 'location',
        $debug = false
    ) {

        if ($debug) {
            echo '<div class="disabled">';
        }

        if (($purpose == 'location') && ( ! $levels[$current_page_level]['continuous_numbering'])) {
            // we want the current page's number among its siblings, and they are not numbered continuously

            // get the post's siblings
            $siblings = $this->get_sibling_ids($post_id);

            if ($debug) {
                echo 'siblings:<br>';
                print_r($siblings);
            }

            // get its number (key + 1) among its siblings
            $number = array_search($post_id, $siblings) + 1;

        } else { // else get the page's number at its depth
            // the page's depth is its level -1
            $depth = $current_page_level - 1;
            // take an array of all page IDs
            foreach ($all_page_ids as $key => $page_id) {
                // remove all pages with a different number of ancestors
                if (count(get_post_ancestors($page_id)) !== $depth) {
                    unset($all_page_ids[$key]);
                }
            }
            // reset the array keys
            $page_ids = array_values($all_page_ids);
            // get its number (key + 1) in the array
            $number = array_search($post_id, $page_ids) + 1;
        }

        if ($debug) {
            echo '<hr></div>';
        }

        return $number;
    }

    /**
     * Appends the html for all pagination elements wherever do_action('spartan_pagination') is called
     *
     * @return string   pagination HTML
     * @since  1.0.0
     * @access public
     */
    public function paginate_pages()
    {
        // get all options
        $defaults = array(
            'back_next_buttons'     => 1,
            'back_button_icon_span' => 1,
            'next_button_icon_span' => 1,
            'links_to_excluded'     => 1,
            'back_button_content'   => '',
            'next_button_content'   => ''
        );

        $default_back_icon_path = 'svg/chevron-left.php';
        $default_next_icon_path = 'svg/chevron-right.php';

        $options = get_option($this->plugin_name, $defaults);

        (array_key_exists('back_next_buttons',
            $options)) ? $back_next_buttons = $options['back_next_buttons'] : $back_next_buttons = 0;
        (array_key_exists('back_next_titles',
            $options)) ? $back_next_titles = $options['back_next_titles'] : $back_next_titles = 0;

        (array_key_exists('back_button_icon_span',
            $options)) ? $back_button_icon_span = $options['back_button_icon_span'] : $back_button_icon_span = 0;
        (array_key_exists('next_button_icon_span',
            $options)) ? $next_button_icon_span = $options['next_button_icon_span'] : $next_button_icon_span = 0;

        (array_key_exists('back_button_icon_default',
            $options)) ? $back_button_icon_default = $options['back_button_icon_default'] : $back_button_icon_default = null;
        (array_key_exists('next_button_icon_default',
            $options)) ? $next_button_icon_default = $options['next_button_icon_default'] : $next_button_icon_default = null;

        (array_key_exists('back_button_icon_path',
            $options)) ? $custom_back_button_icon_path = $options['back_button_icon_path'] : $custom_back_button_icon_path = null;
        (array_key_exists('next_button_icon_path',
            $options)) ? $custom_next_button_icon_path = $options['next_button_icon_path'] : $custom_next_button_icon_path = null;

        (array_key_exists('first_level_number_buttons',
            $options)) ? $first_level_number_buttons = $options['first_level_number_buttons'] : $first_level_number_buttons = 0;

        (array_key_exists('second_level_number_buttons',
            $options)) ? $second_level_number_buttons = $options['second_level_number_buttons'] : $second_level_number_buttons = 0;
        (array_key_exists('second_level_continuous',
            $options)) ? $second_level_continuous = $options['second_level_continuous'] : $second_level_continuous = 0;

        (array_key_exists('third_level_number_buttons',
            $options)) ? $third_level_number_buttons = $options['third_level_number_buttons'] : $third_level_number_buttons = 0;
        (array_key_exists('third_level_continuous',
            $options)) ? $third_level_continuous = $options['third_level_continuous'] : $third_level_continuous = 0;

        (array_key_exists('first_level_name',
            $options)) ? $first_level_name = $options['first_level_name'] : $first_level_name = false;
        (array_key_exists('second_level_name',
            $options)) ? $second_level_name = $options['second_level_name'] : $second_level_name = false;
        (array_key_exists('third_level_name',
            $options)) ? $third_level_name = $options['third_level_name'] : $third_level_name = false;
        (array_key_exists('show_first_level_in_location',
            $options)) ? $show_first_level_in_location = $options['show_first_level_in_location'] : $show_first_level_in_location = 0;
        (array_key_exists('show_second_level_in_location',
            $options)) ? $show_second_level_in_location = $options['show_second_level_in_location'] : $show_second_level_in_location = 0;
        (array_key_exists('show_third_level_in_location',
            $options)) ? $show_third_level_in_location = $options['show_third_level_in_location'] : $show_third_level_in_location = 0;
        (array_key_exists('first_level_number_display',
            $options)) ? $first_level_number_display = $options['first_level_number_display'] : $first_level_number_display = 'show';
        (array_key_exists('second_level_number_display',
            $options)) ? $second_level_number_display = $options['second_level_number_display'] : $second_level_number_display = 'show';
        (array_key_exists('third_level_number_display',
            $options)) ? $third_level_number_display = $options['third_level_number_display'] : $third_level_number_display = 'show';

        (array_key_exists('back_button_content',
            $options)) ? $back_button_content = trim($options['back_button_content']) : $back_button_content = null;
        (array_key_exists('next_button_content',
            $options)) ? $next_button_content = trim($options['next_button_content']) : $next_button_content = null;

        (array_key_exists('level_delimiter',
            $options)) ? $level_delimiter = $options['level_delimiter'] : $level_delimiter = ', ';
        (array_key_exists('title_only_pages',
            $options)) ? $title_only_pages = $options['title_only_pages'] : $title_only_pages = null;

        (array_key_exists('excluded_pages',
            $options)) ? $excluded_pages = $options['excluded_pages'] : $excluded_pages = null;
        (array_key_exists('links_to_excluded',
            $options)) ? $links_to_excluded = $options['links_to_excluded'] : $links_to_excluded = 0;
        (array_key_exists('paginate_excluded',
            $options)) ? $paginate_excluded = $options['paginate_excluded'] : $paginate_excluded = null;

        // get current page id
        global $post;
        $post_id = $post->ID;

        // get all page ids that will be used in pagination
        $pagelist     = get_pages('sort_column=menu_order');
        $all_page_ids = array();
        foreach ($pagelist as $page) {
            $all_page_ids[] += $page->ID;
        }
        unset($pagelist);

        // // handle comma-separated lists
        // convert string of excluded pages from options page text field to an array
        $excluded_pages   = $this->list_to_array($excluded_pages);
        $title_only_pages = $this->list_to_array($title_only_pages);

        // if pages with "page links to" will be excluded from pagination,
        // get these pages and add them to excluded_pages
        if ($links_to_excluded) {
            global $wpdb;
            // use the global database object to search the postmeta table for posts that use "page links to"
            $meta_key = '_links_to';
            $links_to = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s",
                $meta_key), ARRAY_A);
            // if any exist, add them to the array of excluded pages
            if (count($links_to) > 0) {
                foreach ($links_to as $value) {
                    $excluded_pages[] = $value['post_id'];
                }
            }
            unset($links_to);
        }

        // make a copy of all_page_ids array, since it will be used for getting pages' numbers at their depth
        $page_ids = $all_page_ids;
        // if there are any excluded pages, remove them from the array
        if (count($excluded_pages) > 0) {
            foreach ($excluded_pages as $page_id) {
                $excluded_page_key = array_search($page_id, $page_ids);
                if ($excluded_page_key !== false) {
                    unset($page_ids[$excluded_page_key]);
                }
            }
            $page_ids = array_values($page_ids);
        }
        // $page_ids is now only the page IDs of included pages
        // Don't include pagination on excluded pages unless specified.
        if (in_array($post_id, $page_ids) || null !== $paginate_excluded) {

            // get depth of current page (used for location text and sibling buttons)
            $depth          = 0;
            $parent_page_id = wp_get_post_parent_id($post_id);
            while ($parent_page_id > 0) {
                $page           = get_page($parent_page_id);
                $parent_page_id = $page->post_parent;
                $depth++;
            }

            $current_page_level = $depth + 1;

            // create 2D array of level names and whether they are numbered continuously
            $levels = array(
                1 => array(
                    'name'                 => $first_level_name,
                    'continuous_numbering' => 0,
                    'sibling_buttons'      => $first_level_number_buttons,
                    'show_in_location'     => $show_first_level_in_location,
                    'display'              => $first_level_number_display
                ),
                2 => array(
                    'name'                 => $second_level_name,
                    'continuous_numbering' => $second_level_continuous,
                    'sibling_buttons'      => $second_level_number_buttons,
                    'show_in_location'     => $show_second_level_in_location,
                    'display'              => $second_level_number_display
                ),
                3 => array(
                    'name'                 => $third_level_name,
                    'continuous_numbering' => $third_level_continuous,
                    'sibling_buttons'      => $third_level_number_buttons,
                    'show_in_location'     => $show_third_level_in_location,
                    'display'              => $third_level_number_display
                )
            );

            // get location text output
            if ($first_level_name || $second_level_name || $third_level_name) {
                // start with an empty string
                $location_text_output = '';
                // if the current page is not the front page, get the location
                if ( ! in_array($post_id, $title_only_pages)) {
                    // for each depth level run this loop
                    for ($iteration_level = 1; $iteration_level <= $current_page_level; $iteration_level++) {
                        $temp_page_id = $post_id;
                        // get id of current page's ancestor at the given depth level
                        // by iterating the following loop current_level - $iteration_level times
                        $iterations = abs($current_page_level - $iteration_level);
                        for ($i = 0; $i < $iterations; $i++) {
                            $temp_page_id = wp_get_post_parent_id($temp_page_id);
                        }
                        // only do the rest of this if pages of the given depth are included in the location text
                        if ($levels[$iteration_level]['show_in_location']) {
                            $location_text_output .= $this->get_level_location_text($levels, $temp_page_id,
                                $all_page_ids, $iteration_level);
                        }
                        // add a comma and space to the output if this iteration is not the current page
                        if (($iteration_level < $current_page_level) && ($levels[$iteration_level]['show_in_location'])) {
                            $location_text_output .= $level_delimiter;
                        }
                    }
                } else {
                    // if the current page is the front page, use page title as the location text
                    $location_text_output = get_the_title($post);
                }
            } else {
                $location_text_output = null;
            }

            // prepare output string
            $output_string = '<div class="pagination spartan-pagination">';
            if ($first_level_name || $second_level_name || $third_level_name) {
                $output_string .= '<div class="spartan-pagination-location-text">'.$location_text_output.'</div>';
            }

            // open wrapper div for any navigation buttons
            if ($back_next_buttons || $levels[$current_page_level]['sibling_buttons']) {
                $output_string .= '<div class="spartan-pagination-nav-buttons">';
            }

            // create previous page link
            if ($back_next_buttons) {
                // get next and prev page IDs
                $current = array_search($post_id, $page_ids);
                if (array_key_exists($current - 1, $page_ids)) {
                    $prevID = $page_ids[$current - 1];
                } else {
                    $prevID = null;
                }

                // Get previous page title.
                if ($back_next_titles && null !== $prevID) {
                    $prev_title = get_the_title($prevID);
                } else {
                    $prev_title = null;
                }

                if ( ! empty($prevID)) {
                    $output_string .= "\n\t".'<ul class="back-button"><li>';
                    $output_string .= "\n\t".'<a href="'.get_permalink($prevID).'" ';
                    $output_string .= 'title="'.get_the_title($prevID).'">';
                    if ($back_button_icon_span && $back_button_icon_default) {
                        $output_string .= '<span class="pagination-icon pagination-icon-prev" aria-hidden="true">'.file_get_contents(MY_PLUGIN_PATH.$default_back_icon_path).'</span><span class="screen-reader-text">back</span>';
                    } elseif ($back_button_icon_span && ! is_null($custom_back_button_icon_path)) {
                        $output_string .= '<span class="pagination-icon pagination-icon-prev" aria-hidden="true">'.file_get_contents(get_stylesheet_directory().'/'.ltrim($custom_back_button_icon_path,
                                    '/')).'</span><span class="screen-reader-text">back</span>';
                    } elseif ($back_button_icon_span && ($back_button_icon_default !== 0)) {
                        $output_string .= '<span class="pagination-icon pagination-icon-prev" aria-hidden="true">'.file_get_contents(MY_PLUGIN_PATH.$default_back_icon_path).'</span><span class="screen-reader-text">back</span>';
                    } elseif ($back_button_icon_span) {
                        $output_string .= '<span class="pagination-icon pagination-icon-prev" aria-hidden="true"></span><span class="screen-reader-text">back</span>';
                    }
                    $output_string .= $back_button_content;
                    if (null !== $prev_title) {
                        $output_string .= "<span class='pagination-title pagination-title-prev'>$prev_title</span>";
                    }
                    $output_string .= '</a>';
                    $output_string .= "\n\t".'</li></ul>';
                }
            }

            // prepare siblings output
            if ($levels[$current_page_level]['sibling_buttons']) {
                // get array of IDs of sibling pages if the current page has siblings and is not the front page

                // first get the number of the first sibling among the current page's siblings
                // this first sibling number will depend on whether the sibling buttons at the current page's level are numbered continuously
                if ( ! $levels[$current_page_level]['continuous_numbering']) {
                    // if the sibling buttons should not be numbered continuously, then the first sibling is 1
                    $first_sibling_number = 1;
                } else {
                    // if the sibling buttons should be numbered continuously, then get the number of the first sibling among all pages at the current depth
                    $siblings             = $this->get_sibling_ids($post->ID);
                    $level                = $this->get_page_depth(get_post($siblings[0])) + 1;
                    $first_sibling_number = $this->get_page_number($levels, $siblings[0], $all_page_ids, $level,
                        'sibling');
                }

                $output_string .= "\n\t".'<ul class="sibling-buttons">';
                $output_string .= $this->list_siblings($post_id, array_merge($title_only_pages, $excluded_pages),
                    $first_sibling_number);
                $output_string .= "\n\t".'</ul>';
            }

            // create next page link
            if ($back_next_buttons) {
                $current_key = array_search($post_id, $page_ids);
                if (array_key_exists($current_key + 1, $page_ids)) {
                    $nextID = $page_ids[$current_key + 1];
                } else {
                    $nextID = null;
                }

                // Get next page title.
                if ($back_next_titles && null !== $nextID) {
                    $next_title = get_the_title($nextID);
                } else {
                    $next_title = null;
                }

                if ( ! empty($nextID)) {
                    $output_string .= "\n\t".'<ul class="next-button"><li>';
                    $output_string .= "\n\t".'<a href="'.get_permalink($nextID).'"';
                    $output_string .= 'title="'.get_the_title($nextID).'">';
                    $output_string .= $next_button_content;
                    if (null !== $next_title) {
                        $output_string .= "<span class='pagination-title pagination-title-next'>$next_title</span>";
                    }
                    if ($next_button_icon_span && $next_button_icon_default) {
                        $output_string .= '<span class="pagination-icon pagination-icon-next" aria-hidden="true">'.file_get_contents(MY_PLUGIN_PATH.$default_next_icon_path).'</span><span class="screen-reader-text">next</span>';
                    } elseif ($next_button_icon_span && ! is_null($custom_next_button_icon_path)) {
                        $output_string .= '<span class="pagination-icon pagination-icon-next" aria-hidden="true">'.file_get_contents(get_stylesheet_directory().'/'.ltrim($custom_next_button_icon_path,
                                    '/')).'</span><span class="screen-reader-text">next</span>';
                    } elseif ($next_button_icon_span && ($next_button_icon_default !== 0)) {
                        $output_string .= '<span class="pagination-icon pagination-icon-next" aria-hidden="true">'.file_get_contents(MY_PLUGIN_PATH.$default_next_icon_path).'</span><span class="screen-reader-text">next</span>';
                    } elseif ($next_button_icon_span) {
                        $output_string .= '<span class="pagination-icon pagination-icon-next" aria-hidden="true"></span><span class="screen-reader-text">next</span>';
                    }
                    $output_string .= '</a>';
                    $output_string .= "\n\t".'</li></ul>';
                }
            }

            // close wrapper div for any navigation buttons
            if ($back_next_buttons || $levels[$current_page_level]['sibling_buttons']) {
                $output_string .= '</div>'.'<!-- .spartan-pagination-nav-buttons -->';
            }

            $output_string .= "\n".'</div><!-- .spartan-navigation -->';

            echo $output_string;
        }
    }
}
