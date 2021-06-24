=== Plugin Name ===
Tags: pagination, navigation, breadcrumbs
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin appends pagination text and navigation to the bottom of all pages in a WordPress site.

== Description ==

This plugin allows for customization of pagination navigation at the bottom of pages.
Pagination can include text describing the location of each page, similar to a breadcrumb trail.
It can also include a list of page-number buttons or back and next buttons.

== Installation ==

1. Upload `spartan-pagination folder` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Place `<?php do_action('spartan_pagination'); ?>` in your templates where you want pagination to appear.
   It will usually go right after `<?php the_content(); ?>`.

== Frequently Asked Questions ==

= Is it possible to make the pagination for my course do such-and-such =

Probably, but it will take a long time.

== Screenshots ==

1. This screen shot description corresponds to assets/screenshot-1.png. It's only here for the sake of having a screenshot.

== Changelog ==

= 1.2.1 =
* Added - option now appears on each page to exclude that page from pagination

= 1.2.0 =
* Added - option to specify delimiter string between levels in location text
* Added - Preview of pagination output
* Removed - separate options for continuous numbering for location text and sibling buttons. Now both are controlled by one setting.

= 1.1.4 =
* Added - continuous numbering option for sibling links
* Added - deletes settings from database on uninstall
* Added - screen reader text for disabled buttons and icon buttons
* Changed - descriptive text for some options
* Removed - image as links for back/next buttons (now only icons)

= 1.1.3 =
* Added - optional list of pages to use title only as location text

= 1.1.2 =
* Reorganized code for location text generation
* Added - separate options for display of page numbers in locaion text at each depth level

= 1.1.1 =
* Added - page x of y numbering for current page

= 1.1.0 =
* Added - numbered sibling buttons are optional at each navigation level
* Added - optionally hide the current page's number when using numbered sibling buttons
* Added - use text or an image for back/next buttons

= 1.0.0 =
* This is the initial release.