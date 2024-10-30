<?php
/*
Plugin Name: Content Cleaner
Description: Remove unwanted characters and junk (like ETX) from your content that doesn't conform to UTF-8.
Version: 1.0
Author: Colin Ulin
Author URI: http://colinul.in/
License: GPL
Copyright: Colin Ulin
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main ContentCleaner Class.
 *
 * @class ContentCleaner
 * @version	1.0
 */
class ContentCleaner {

	/**
	 * The single instance of the class.
	 *
	 * @var ContentCleaner
	 * @since 1.0
	 */
	protected static $_instance = null;

	/**
	 * Main ContentCleaner Instance.
	 *
	 * Ensures only one instance of Content Cleaner is loaded or can be loaded.
	 *
	 * @since 1.0
	 * @static
	 * @see ContentCleaner()
	 * @return ContentCleaner - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * ContentCleaner Constructor.
	 */
	public function __construct() {
		$this->_init_hooks();
	}

	/**
	 * Hook into actions and filters.
	 * @since 1.0
	 */
	private function _init_hooks() {
		add_filter( 'the_content', array($this, '_sanitize_content'), 20 );
		add_filter( 'the_title', array($this, '_sanitize_content'), 20 );

		if ( is_admin() ) {
			add_filter( 'richedit_pre', array($this, '_sanitize_content'), 20 );
			add_filter( 'wp_insert_post_data', array($this, '_sanitize_post'), 99, 2 );

			// advanced custom fields hooks
			if ( !has_filter( 'acf/load_value' ) && !has_filter( 'acf/update_value' ) && !has_filter( 'acf/prepare_field' ) ) {
				add_filter( 'acf/load_value', array($this, '_sanitize_content'), 10, 3 );
				add_filter( 'acf/update_value', array($this, '_sanitize_content'), 10, 3 );
				add_filter( 'acf/prepare_field', array($this, '_sanitize_acf_post'), 10, 1 );
			}
		}
	}

	/**
	 * Sanitize content
	 * @return Sanitized value
	 */
	public function _sanitize_content($value) {
		$value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
		return $value;
	}

	/**
	 * Sanitize content and title of post before it's saved
	 * @return Post with sanitized content and title
	 */
	public function _sanitize_post($post) {
		if ( $post ) {
			$post['post_content'] = $this->_sanitize_content($post['post_content']);
			$post['post_title']   = $this->_sanitize_content($post['post_title']);
			return $post;
		}
	}

	/**
	 * Sanitize content before it's loaded into ACF field
	 * @return Post with sanitized value
	 */
	public function _sanitize_acf_post($post) {
		if ( $post ) {
			$post['value'] = $this->_sanitize_content($post['value']);
			return $post;
		}
	}
}

/**
 * Main instance of ContentCleaner.
 *
 * Returns the main instance of ContentCleaner to prevent the need to use globals.
 *
 * @since  2.1
 * @return ContentCleaner
 */
function ContentCleaner() {
	return ContentCleaner::instance();
}

// Global for backwards compatibility.
$GLOBALS['contentcleaner'] = ContentCleaner();




