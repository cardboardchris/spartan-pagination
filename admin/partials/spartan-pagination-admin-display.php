<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/cardboardchris/spartan-pagination
 * @since      1.0.0
 *
 * @package    Spartan_Pagination
 * @subpackage Spartan_Pagination/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <form method="post" name="pagination_options" action="options.php">

    <?php
        //Grab all options

        $defaults = array(
            'back_next_buttons' => 1,
            'links_to_excluded' => 1,
            'back_button_content' => 'back',
            'next_button_content' => 'next',
            'back_button_icon_span' => 1,
            'next_button_icon_span' => 1,
            'back_button_icon_default' => 0,
            'next_button_icon_default' => 0,
            'back_button_icon_path' => '',
            'next_button_icon_path' => '',
            'first_level_number_display' => 'show',
            'second_level_number_display' => 'show',
            'third_level_number_display' => 'show'
        );

        $default_back_icon_path = 'svg/chevron-left.php';
        $default_next_icon_path = 'svg/chevron-right.php';

        $options = get_option($this->plugin_name, $defaults);

        (array_key_exists('back_next_buttons', $options)) ? $back_next_buttons = $options['back_next_buttons'] : $back_next_buttons = null;
        (array_key_exists('back_next_titles', $options)) ? $back_next_titles = $options['back_next_titles'] : $back_next_titles = null;
        (array_key_exists('back_button_content', $options)) ? $back_button_content = $options['back_button_content'] : $back_button_content = null;
        (array_key_exists('next_button_content', $options)) ? $next_button_content = $options['next_button_content'] : $next_button_content = null;
        (array_key_exists('back_button_icon_span', $options)) ? $back_button_icon_span = $options['back_button_icon_span'] : $back_button_icon_span = 0;
        (array_key_exists('next_button_icon_span', $options)) ? $next_button_icon_span = $options['next_button_icon_span'] : $next_button_icon_span = 0;
        (array_key_exists('back_button_icon_default', $options)) ? $back_button_icon_default = $options['back_button_icon_default'] : $back_button_icon_default = 0;
        (array_key_exists('next_button_icon_default', $options)) ? $next_button_icon_default = $options['next_button_icon_default'] : $next_button_icon_default = 0;
        (array_key_exists('back_button_icon_path', $options)) ? $back_button_icon_path = $options['back_button_icon_path'] : $back_button_icon_path = null;
        (array_key_exists('next_button_icon_path', $options)) ? $next_button_icon_path = $options['next_button_icon_path'] : $next_button_icon_path = null;

        (array_key_exists('first_level_number_buttons', $options)) ? $first_level_number_buttons = $options['first_level_number_buttons'] : $first_level_number_buttons = null;
        (array_key_exists('second_level_number_buttons', $options)) ? $second_level_number_buttons = $options['second_level_number_buttons'] : $second_level_number_buttons = null;
        (array_key_exists('second_level_continuous', $options)) ? $second_level_continuous = $options['second_level_continuous'] : $second_level_continuous = null;
        (array_key_exists('second_level_siblings_continuous', $options)) ? $second_level_continuous = $options['second_level_siblings_continuous'] : $second_level_continuous = 0;
        (array_key_exists('third_level_number_buttons', $options)) ? $third_level_number_buttons = $options['third_level_number_buttons'] : $third_level_number_buttons = null;
        (array_key_exists('third_level_continuous', $options)) ? $third_level_continuous = $options['third_level_continuous'] : $third_level_continuous = null;
        (array_key_exists('third_level_siblings_continuous', $options)) ? $third_level_continuous = $options['third_level_siblings_continuous'] : $third_level_continuous = 0;

        (array_key_exists('first_level_name', $options)) ? $first_level_name = $options['first_level_name'] : $first_level_name = null;
        (array_key_exists('first_level_number_display', $options)) ? $first_level_number_display = $options['first_level_number_display'] : $first_level_number_display = null;
        (array_key_exists('show_first_level_in_location', $options)) ? $show_first_level_in_location = $options['show_first_level_in_location'] : $show_first_level_in_location = null;

        (array_key_exists('second_level_name', $options)) ? $second_level_name = $options['second_level_name'] : $second_level_name = null;
        (array_key_exists('show_second_level_in_location', $options)) ? $show_second_level_in_location = $options['show_second_level_in_location'] : $show_second_level_in_location = null;
        (array_key_exists('second_level_number_display', $options)) ? $second_level_number_display = $options['second_level_number_display'] : $second_level_number_display = null;

        (array_key_exists('third_level_name', $options)) ? $third_level_name = $options['third_level_name'] : $third_level_name = null;
        (array_key_exists('show_third_level_in_location', $options)) ? $show_third_level_in_location = $options['show_third_level_in_location'] : $show_third_level_in_location = null;
        (array_key_exists('third_level_number_display', $options)) ? $third_level_number_display = $options['third_level_number_display'] : $third_level_number_display = null;

        (array_key_exists('level_delimiter', $options)) ? $level_delimiter = $options['level_delimiter'] : $level_delimiter = ',';
        (array_key_exists('title_only_pages', $options)) ? $title_only_pages = $options['title_only_pages'] : $title_only_pages = null;

        (array_key_exists('links_to_excluded', $options)) ? $links_to_excluded = $options['links_to_excluded'] : $links_to_excluded = null;
        (array_key_exists('excluded_pages', $options)) ? $excluded_pages = $options['excluded_pages'] : $excluded_pages = null;
        (array_key_exists('paginate_excluded', $options)) ? $paginate_excluded = $options['paginate_excluded'] : $paginate_excluded = null;

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);

        // back and next buttons output for previews

        // back button
        $back_button_output = '';
        if ($back_next_buttons || $back_next_titles || $back_button_content) {
            $back_button_output .= '<a class="back-next-button" href="#">';
        }
        if ($back_next_buttons && $back_button_icon_span && $back_button_icon_default) {
            // $back_button_output .= '<span class="pagination-icon pagination-icon-prev" aria-hidden="true">'.MY_PLUGIN_PATH.$default_back_icon_path.'</span>';
            $back_button_output .= '<span class="pagination-icon pagination-icon-prev" aria-hidden="true">'.file_get_contents(MY_PLUGIN_PATH.$default_back_icon_path).'</span>';
        } elseif ($back_next_buttons && $back_button_icon_path) {
            $back_button_output .= '<span class="pagination-icon pagination-icon-prev" aria-hidden="true">'.file_get_contents(get_stylesheet_directory().'/'.ltrim($back_button_icon_path,'/')).'</span>';
        }
        if ($back_button_content) {
            $back_button_output .= $back_button_content;
        }
        if ($back_button_content && $back_next_titles) {
            $back_button_output .= ': ';
        }
        if ($back_next_titles) {
            $back_button_output .= '<span class="pagination-title pagination-title-prev">Prev Page Title</span>';
        }
        if ($back_next_buttons || $back_next_titles) {
            $back_button_output .= '</a>';
        }

        // next button
        $next_button_output = '';
        if ($back_next_buttons || $back_next_titles || $next_button_content) {
            $next_button_output .= '<a class="back-next-button" href="#">';
        }
        if ($next_button_content) {
            $next_button_output .= $next_button_content;
        }
        if ($next_button_content && $back_next_titles) {
            $next_button_output .= ': ';
        }
        if ($back_next_titles) {
            $next_button_output .= '<span class="pagination-title pagination-title-next">Next Page Title</span>';
        }
        if ($back_next_buttons && $next_button_icon_span && $next_button_icon_default) {
            $next_button_output .= '<span class="pagination-icon pagination-icon-next" aria-hidden="true">'.file_get_contents(MY_PLUGIN_PATH.$default_next_icon_path).'</span>';
        } elseif ($back_next_buttons && $next_button_icon_path) {
            $next_button_output .= '<span class="pagination-icon pagination-icon-next" aria-hidden="true">'.file_get_contents(get_stylesheet_directory().'/'.ltrim($next_button_icon_path,'/')).'</span>';
        }
        if ($back_next_buttons || $back_next_titles) {
            $next_button_output .= '</a>';
        }

        // first level location text
        $first_level_location_output = '';
        if ($show_first_level_in_location) {
            $first_level_location_output .= $first_level_name.' 1';
        }

        // second level location text
        $second_level_location_output = '';
        if ($first_level_name && $second_level_name) {
            $second_level_location_output .= $level_delimiter;
        }
        if ($second_level_name) {
            $second_level_location_output .= $second_level_name;
            if (!$second_level_continuous) {
                $second_level_location_output .= ' 3';
                if ($second_level_number_display == 'x_of_y') {
                    $second_level_location_output .= ' of 3';
                }
            } else {
                $second_level_location_output .= ' 11';
                if ($second_level_number_display == 'x_of_y') {
                    $second_level_location_output .= ' of 11';
                }
            }
        }

    ?>

        <h2>Example</h2>
        <p>Preview will update when changes are saved.</p>
        <p>Preview is of content only, theme styles will not be applied.</p>

            <table class="form-table pagination-preview">
                <tr valign="top">
                    <th>
                        Top-level pages:
                    </th>
                </tr>
                <tr valign="top">
                    <td scope="row" class="alternate" align="center">
                        <?php
                        // location text
                        if ( $first_level_name || $second_level_name || $third_level_name ) {
                            echo '<p class="location-text">';
                            echo $first_level_location_output;
                            echo '</p>';
                        }

                        echo $back_button_output;

                        // sibling buttons
                        if ($first_level_number_buttons) {
                            echo '<a href="#" class="active">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a>';
                        }

                        echo $next_button_output;

                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th>
                        Second-level pages:
                    </th>
                </tr>
                <tr valign="top">
                    <td scope="row" class="alternate" align="center">
                        <?php
                        // location text
                        if ( $first_level_name || $second_level_name || $third_level_name ) {
                            echo '<p class="location-text">';
                            echo $first_level_location_output;
                            echo $second_level_location_output;
                            echo '</p>';
                        }

                        echo $back_button_output;

                        // sibling buttons
                        if ($second_level_number_buttons && !$second_level_continuous) {
                            echo '<a href="#">1</a> <a href="#">2</a> <a href="#" class="active">3</a>';
                        } elseif ($second_level_number_buttons && $second_level_continuous) {
                            echo '<a href="#">9</a> <a href="#">10</a> <a href="#" class="active">11</a>';
                        }

                        echo $next_button_output;
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th>
                        Third-level pages:
                    </th>
                </tr>
                <tr valign="top">
                    <td scope="row" class="alternate" align="center">
                        <?php
                        // location text
                        if ( $first_level_name || $second_level_name || $third_level_name ) {
                            echo '<p class="location-text">';
                            echo $first_level_location_output;
                            echo $second_level_location_output;
                            if ($second_level_name && $third_level_name) {
                                echo $level_delimiter;
                            }
                            if ($third_level_name) {
                                echo $third_level_name;
                                if (!$third_level_continuous) {
                                    echo ' 2';
                                    if ($third_level_number_display == 'x_of_y') {
                                        echo ' of 5';
                                    }
                                } else {
                                    echo ' 7';
                                    if ($third_level_number_display == 'x_of_y') {
                                        echo ' of 10';
                                    }
                                }
                            }
                            echo '</p>';
                        }

                        echo $back_button_output;

                        // sibling buttons
                        if ($third_level_number_buttons && !$third_level_continuous) {
                            echo '<a href="#">1</a> <a href="#" class="active">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">6</a> <a href="#">7</a>';
                        } elseif ($third_level_number_buttons && $third_level_continuous) {
                            echo '<a href="#">6</a> <a href="#" class="active">7</a> <a href="#">8</a> <a href="#">9</a> <a href="#">10</a> <a href="#">11</a> <a href="#">12</a>';
                        }

                        echo $next_button_output;
                        ?>
                    </td>
                </tr>
            </table>

        <h2>Back/Next Navigation</h2>

        <fieldset>

            <table class="form-table">
                <!-- Add bank and next buttons to the pagination -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Back/next buttons</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-back_next_buttons">
                            <strong>Back/next buttons</strong>
                        </label>
                    </th>
                    <td>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-back_next_buttons" name="<?php echo $this->plugin_name; ?>[back_next_buttons]" value="1" <?php checked($back_next_buttons, 1); ?>/>
                        <label for="<?php echo $this->plugin_name; ?>-back_next_buttons">
                            Yes
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Back/next page titles</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-back_next_titles">
                            <strong>Back/next page titles</strong>
                        </label>
                    </th>
                    <td>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-back_next_titles" name="<?php echo $this->plugin_name; ?>[back_next_titles]" value="1" <?php checked($back_next_titles, 1); ?>/>
                        <label for="<?php echo $this->plugin_name; ?>-back_next_titles">
                            Yes
                        </label>
                        <p class="description">
                            Add the titles of the previous and next pages as link text
                        </p>
                    </td>
                </tr>
                <!-- text to use for back button -->
                <tr valign="top" class="alternate">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Back button content</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-back_button_content">
                            <strong>Back button content</strong>
                        </label>
                    </th>
                    <td>
                        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-back_button_content" name="<?php echo $this->plugin_name; ?>[back_button_content]" value="<?php if(!empty($back_button_content)) { echo $back_button_content; } ?>"/>
                        <p class="description">appears on the back button for each page</p>
                    </td>
                    <td>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-back_button_icon_span" name="<?php echo $this->plugin_name; ?>[back_button_icon_span]" value="1" <?php checked($back_button_icon_span, 1); ?>/>
                        <label for="<?php echo $this->plugin_name; ?>-back_button_icon_span">
                            Use an icon
                        </label>
                        <p class="description">add an icon to each back button</p>
                    </td>
                </tr>
                <!-- icon to use for back button -->
                <tr valign="top" class="alternate">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Back button icon</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-back_button_icon_path">
                            <strong>Back button icon</strong>
                        </label>
                    </th>
                    <td>
                        <input type="text" class="regular-text icon-default-input" id="<?php echo $this->plugin_name; ?>-back_button_icon_path" name="<?php echo $this->plugin_name; ?>[back_button_icon_path]" value="<?php if(!empty($back_button_icon_path)) { echo $back_button_icon_path; } ?>"/>
                        <p class="description">path to a custom icon, relative to theme directory</p>
                    </td>
                    <td>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-back_button_icon_default" name="<?php echo $this->plugin_name; ?>[back_button_icon_default]" value="1" <?php checked($back_button_icon_default, 1); ?>/>
                        <label for="<?php echo $this->plugin_name; ?>-back_button_icon_default">
                            Use the default back icon
                        </label>
                        <p class="description">use a left-pointing chevron as the back icon<br>(overrides the custom back button icon path setting)</p>
                    </td>
                </tr>
                <!-- text to use for next button -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Next button content</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-next_button_content">
                            <strong>Next button content</strong>
                        </label>
                    </th>
                    <td>
                        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-next_button_content" name="<?php echo $this->plugin_name; ?>[next_button_content]" value="<?php if(!empty($next_button_content)) { echo $next_button_content; } ?>"/>
                        <p class="description">appears on the next button for each page</p>
                    </td>
                    <td>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-next_button_icon_span" name="<?php echo $this->plugin_name; ?>[next_button_icon_span]" value="1" <?php checked($next_button_icon_span, 1); ?>/>
                        <label for="<?php echo $this->plugin_name; ?>-next_button_icon_span">
                            Use an icon
                        </label>
                        <p class="description">add an icon to each next button</p>
                    </td>
                </tr>
                <!-- icon to use for next button -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Back button icon</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-next_button_icon_path">
                            <strong>Next button icon</strong>
                        </label>
                    </th>
                    <td>
                        <input type="text" class="regular-text icon-default-input" id="<?php echo $this->plugin_name; ?>-next_button_icon_path" name="<?php echo $this->plugin_name; ?>[next_button_icon_path]" value="<?php if(!empty($next_button_icon_path)) { echo $next_button_icon_path; } ?>"/>
                        <p class="description">path to a custom icon, relative to theme directory<br>(activating default icon overrides this setting)</p>
                    </td>
                    <td>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-next_button_icon_default" name="<?php echo $this->plugin_name; ?>[next_button_icon_default]" value="1" <?php checked($next_button_icon_default, 1); ?>/>
                        <label for="<?php echo $this->plugin_name; ?>-next_button_icon_default">
                            Use the default next icon
                        </label>
                        <p class="description">use a right-pointing chevron as the next icon<br>(overrides the custom next button icon path setting)</p>
                    </td>
                </tr>
            </table>

        </fieldset>

        <h2>Sibling Page Navigation</h2>

        <fieldset>

            <table class="form-table">
                <!-- make a list (ul) of pages by number as navigation -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Top-Level Pages</span></legend>
                        <strong>Top-Level Pages</strong>
                    </th>
                    <!-- on top-level pages, show the sibling number buttons -->
                    <td>
                        <legend class="screen-reader-text"><span>Enable</span></legend>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-first_level_number_buttons" name="<?php echo $this->plugin_name; ?>[first_level_number_buttons]" value="1" <?php checked($first_level_number_buttons, 1); ?> />
                        <label for="<?php echo $this->plugin_name; ?>-first_level_number_buttons">
                            <strong>Enable</strong>
                        </label>
                        <p class="description">top-level pages will have numbered sibling buttons</p>
                    </td>
                </tr>
                <!-- on second-level pages, show the sibling number buttons -->
                <tr valign="top" class="alternate">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Second-Level Pages</span></legend>
                        <strong>Second-Level Pages</strong>
                    </th>
                    <td>
                        <legend class="screen-reader-text"><span>Enable</span></legend>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-second_level_number_buttons" name="<?php echo $this->plugin_name; ?>[second_level_number_buttons]" value="1" <?php checked($second_level_number_buttons, 1); ?> />
                        <label for="<?php echo $this->plugin_name; ?>-second_level_number_buttons">
                            <strong>Enable</strong>
                        </label>
                        <p class="description">second-level pages will have numbered sibling buttons</p>
                    </td>
                </tr>
                <!-- on third-level pages, show the sibling number buttons -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Third-Level Pages</span></legend>
                        <strong>Third-Level Pages</strong>
                    </th>
                    <td>
                        <legend class="screen-reader-text"><span>Enable</span></legend>
                        <input type="checkbox" class="enabler" id="<?php echo $this->plugin_name; ?>-third_level_number_buttons" name="<?php echo $this->plugin_name; ?>[third_level_number_buttons]" value="1" <?php checked($third_level_number_buttons, 1); ?> />
                        <label for="<?php echo $this->plugin_name; ?>-third_level_number_buttons">
                            <strong>Enable</strong>
                        </label>
                        <p class="description">third-level pages will have numbered sibling buttons</p>
                    </td>
                </tr>
            </table>

        </fieldset>

        <h2>Location Text</h2>

        <fieldset>

            <table class="form-table">
                <!-- enter name for top-level pages -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Top-level name</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-first_level_name">
                            <strong>Top-level name</strong>
                        </label>
                    </th>
                    <!-- include top-level parent in location text -->
                     <td>
                        <legend class="screen-reader-text"><span>Include top-level in location</span></legend>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_first_level_in_location" name="<?php echo $this->plugin_name; ?>[show_first_level_in_location]" value="1" <?php checked($show_first_level_in_location, 1); ?> />
                        <label for="<?php echo $this->plugin_name; ?>-show_first_level_in_location">
                            <strong>Show</strong>
                        </label>
                        <p class="description">show top level name</p>
                    </td>
                    <td>
                        <input type="text" class="all-options" id="<?php echo $this->plugin_name; ?>-first_level_name" name="<?php echo $this->plugin_name; ?>[first_level_name]" value="<?php if(!empty($first_level_name)) echo $first_level_name; ?>"/>
                        <p class="description">e.g. "unit" or "module"</p>
                    </td>
                </tr>
                <!-- choose how first-level page numbers will display -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Top-level page number</span></legend>
                        <strong>Top-level page number</strong>
                    </th>
                    <!-- show the page number as a number only -->
                    <td>
                        <label>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-first_level_number_display" name="<?php echo $this->plugin_name; ?>[first_level_number_display]" value="show" <?php checked($first_level_number_display, 'show'); ?>/>
                            <span>Number</span>
                            <p class="description">show as number only</p>
                        </label>
                    </td>
                    <!-- show the page number as X of Y -->
                    <td>
                        <label>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-first_level_number_display" name="<?php echo $this->plugin_name; ?>[first_level_number_display]" value="x_of_y" <?php checked($first_level_number_display, 'x_of_y'); ?>/>
                            <span>X of Y</span>
                            <p class="description">show as number X of total siblings Y (e.g. 2 of 5)</p>
                        </label>
                    </td>
                    <!-- don't show the page number -->
                    <td>
                        <label>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-first_level_number_display" name="<?php echo $this->plugin_name; ?>[first_level_number_display]" value="hide" <?php checked($first_level_number_display, 'hide'); ?>/>
                            <span>Hide</span>
                            <p class="description">don't show the page's number</p>
                        </label>
                    </td>
                </tr>
            </table>

            <table class="form-table alternate">
                <!-- enter name for second-level pages (children of top-level pages) -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Second-level name</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-second_level_name">
                            <strong>Second-level name</strong>
                        </label>
                    </th>
                    <!-- include second-level parent in location text -->
                    <td>
                        <legend class="screen-reader-text"><span>Include second-level in location</span></legend>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_second_level_in_location" name="<?php echo $this->plugin_name; ?>[show_second_level_in_location]" value="1" <?php checked($show_second_level_in_location, 1); ?> />
                        <label for="<?php echo $this->plugin_name; ?>-show_second_level_in_location">
                            <strong>Show</strong>
                        </label>
                        <p class="description">show second level name</p>
                    </td>
                    <td>
                        <input type="text" class="all-options" id="<?php echo $this->plugin_name; ?>-second_level_name" name="<?php echo $this->plugin_name; ?>[second_level_name]" value="<?php if(!empty($second_level_name)) echo $second_level_name; ?>"/>
                        <p class="description">e.g. "lesson" or "section"</p>
                    </td>
                </tr>
                <!-- choose how second-level page numbers will display -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Second-level page number</span></legend>
                        <strong>Second-level page number</strong>
                    </th>
                    <td>
                        <label>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-second_level_number_display" name="<?php echo $this->plugin_name; ?>[second_level_number_display]" value="show" <?php checked($second_level_number_display, 'show'); ?>/>
                            <span>Number</span>
                            <p class="description">show as number only</p>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-second_level_number_display" name="<?php echo $this->plugin_name; ?>[second_level_number_display]" value="x_of_y" <?php checked($second_level_number_display, 'x_of_y'); ?>/>
                            <span>X of Y</span>
                            <p class="description">show as number X of total siblings Y (e.g. 2 of 5)</p>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-second_level_number_display" name="<?php echo $this->plugin_name; ?>[second_level_number_display]" value="hide" <?php checked($second_level_number_display, 'hide'); ?>/>
                            <span>Hide</span>
                            <p class="description">don't show the page's number</p>
                        </label>
                    </td>
                </tr>
            </table>

            <table class="form-table">
                <!-- enter name for third-level pages (children of top-level pages) -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Third-level name</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-third_level_name">
                            <strong>Third-level name</strong>
                        </label>
                    </th>
                    <!-- include third-level parent in location text -->
                    <td>
                        <legend class="screen-reader-text"><span>Include third-level in location</span></legend>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_third_level_in_location" name="<?php echo $this->plugin_name; ?>[show_third_level_in_location]" value="1" <?php checked($show_third_level_in_location, 1); ?> />
                        <label for="<?php echo $this->plugin_name; ?>-show_third_level_in_location">
                            <strong>Show</strong>
                        </label>
                        <p class="description">show third-level name</p>
                    </td>
                    <td>
                        <input type="text" class="all-options" id="<?php echo $this->plugin_name; ?>-third_level_name" name="<?php echo $this->plugin_name; ?>[third_level_name]" value="<?php if(!empty($third_level_name)) echo $third_level_name; ?>"/>
                        <p class="description">e.g. "part" or "page"</p>
                    </td>
                </tr>
                <!-- choose how third-level page numbers will display -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Third-level page number</span></legend>
                        <strong>Third-level page number</strong>
                    </th>
                    <td>
                        <label>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-third_level_number_display" name="<?php echo $this->plugin_name; ?>[third_level_number_display]" value="show" <?php checked($third_level_number_display, 'show'); ?>/>
                            <span>Number</span>
                            <p class="description">show as number only</p>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-third_level_number_display" name="<?php echo $this->plugin_name; ?>[third_level_number_display]" value="x_of_y" <?php checked($third_level_number_display, 'x_of_y'); ?>/>
                            <span>X of Y</span>
                            <p class="description">show as number X of total siblings Y (e.g. 2 of 5)</p>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="radio" id="<?php echo $this->plugin_name; ?>-third_level_number_display" name="<?php echo $this->plugin_name; ?>[third_level_number_display]" value="hide" <?php checked($third_level_number_display, 'hide'); ?>/>
                            <span>Hide</span>
                            <p class="description">don't show the page's number</p>
                        </label>
                    </td>
                </tr>
            </table>

            <table class="form-table alternate">
                <!-- enter delimiter character to separate levels in location text -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Level delimiter</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-level_delimiter">
                            <strong>Level delimiter</strong>
                        </label>
                    </th>
                    <td>
                        <input type="text" class="all-options" id="<?php echo $this->plugin_name; ?>-level_delimiter" name="<?php echo $this->plugin_name; ?>[level_delimiter]" value="<?php if(!empty($level_delimiter)) echo $level_delimiter; ?>"/>
                        <p class="description">enter delimiter string to separate levels in location text</p>
                    </td>
                </tr>
            </table>

            <table class="form-table">
                <!-- enter list of page ids to use page title as location text -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Use page title only</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-title_only_pages">
                            <strong>Use page title only</strong>
                        </label>
                    </th>
                    <td>
                        <input type="text" class="all-options" id="<?php echo $this->plugin_name; ?>-title_only_pages" name="<?php echo $this->plugin_name; ?>[title_only_pages]" value="<?php if(!empty($title_only_pages)) echo $title_only_pages; ?>"/>
                        <p class="description">enter pages by their IDs as a comma-separated list to use only their titles as location text and exclude from sibling numbering</p>
                    </td>
                </tr>
            </table>

        </fieldset>

        <h2>Continuous Numbering</h2>

        <fieldset>
            <table class="form-table">
                <tr valign="top">
                    <td>
                        <legend class="screen-reader-text"><span>Second-level siblings continuous numbering</span></legend>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-second_level_continuous" name="<?php echo $this->plugin_name; ?>[second_level_continuous]" value="1" <?php checked($second_level_continuous, 1); ?> />
                        <label for="<?php echo $this->plugin_name; ?>-second_level_continuous">
                            <strong>Second-level continuous numbering</strong>
                        </label>
                        <p class="description">second-level pages will be numbered continuously through the whole site in location text and/or sibling buttons</p>
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <legend class="screen-reader-text"><span>Third-level siblings continuous numbering</span></legend>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-third_level_continuous" name="<?php echo $this->plugin_name; ?>[third_level_continuous]" value="1" <?php checked($third_level_continuous, 1); ?> />
                        <label for="<?php echo $this->plugin_name; ?>-third_level_continuous">
                            <strong>Third-level continuous numbering</strong>
                        </label>
                        <p class="description">third-level pages will be numbered continuously through the whole site in location text and/or sibling buttons</p>
                    </td>
                </tr>
            </table>
        </fieldset>

        <h2>Excluded Pages</h2>

        <fieldset>

            <table class="form-table">
                <!-- exclude pages with "page links to" from navigation -->
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Page Links To</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-links_to_excluded">
                            <strong>Page Links To</strong>
                        </label>
                    </th>
                    <td>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-links_to_excluded" name="<?php echo $this->plugin_name; ?>[links_to_excluded]" value="1" <?php checked($links_to_excluded, 1); ?>/>
                        Exclude
                        <p class="description">exclude pages that use the "Page Links To" plugin to redirect to another page</p>
                    </td>
                </tr>
                <!-- enter list of page ids to exclude from navigation -->
                <tr valign="top" class="alternate">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Other page IDs</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-excluded_pages">
                            <strong>Other page IDs</strong>
                        </label>
                    </th>
                    <td>
                        <input type="text" class="all-options" id="<?php echo $this->plugin_name; ?>-excluded_pages" name="<?php echo $this->plugin_name; ?>[excluded_pages]" value="<?php if(!empty($excluded_pages)) echo $excluded_pages; ?>"/>
                        <p class="description">enter other pages by their IDs as a comma-separated list to exclude from pagination</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <legend class="screen-reader-text"><span>Include pagination controls on excluded pages</span></legend>
                        <label for="<?php echo $this->plugin_name; ?>-paginate_excluded">
                            <strong>Include pagination controls on excluded pages</strong>
                        </label>
                    </th>
                    <td>
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-paginate_excluded" name="<?php echo $this->plugin_name; ?>[paginate_excluded]" value="1" <?php checked($paginate_excluded, 1); ?>/>
                        <label for="<?php echo $this->plugin_name; ?>-paginate_excluded">
                            Include
                        </label>
                        <p class="description">
                            excluded pages will have a next page button pointing to the first page in the menu order
                        </p>
                    </td>
                </tr>
            </table>

        </fieldset>

        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>

    <p>To activate in your theme, place "<strong>&lt;?php do_action('spartan_pagination'); ?&gt;</strong>" in your templates where you want pagination to appear. It will usually go right after "<strong>&lt;?php the_content(); ?&gt;</strong>".</p>

</div>
