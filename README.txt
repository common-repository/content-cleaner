=== Content Cleaner ===
Contributors: colin3440
Donate link: http://colinul.in/
Tags: sanitize, clean, non-printable characters, UTF-8, unicode
Requires at least: 4.2
Tested up to: 4.7.2
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically removes non-printable characters, including the ETX character, from content, title, and Advanced Custom fields.

== Description ==

The Content Cleaner plugin is an all-in-one tool for automatically removing non-printable characters from content and 
title fields. After building Wordpress sites for many years, one problem that consistently plagues my clients (especially 
the less tech-savvy ones) is non-printable characters in their content or in their titles. This plugin works by running 
a regular expression find and replace to clean up post content, post titles, and even Advanced Custom Fields. It's 
extremely lightweight and works without any setup required.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/content-cleaner` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= Will Content Cleaner delete things I don't want it to delete? =

For most people, Content Cleaner won't appear to make any difference and won't remove anything from your content.

= What is the regex you're running on the content? =

All content and titles are run through a preg_replace function using this regular expression: '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u'

== Changelog ==

= 1.0 =
* Added ACF compatibility.