<?php
/**
 * Plugin Name: WPSSO Add Five Stars
 * Plugin Slug: wpsso-add-five-stars
 * Text Domain: wpsso-add-five-stars
 * Domain Path: /languages
 * Plugin URI: https://wpsso.com/extend/plugins/wpsso-add-five-stars/
 * Assets URI: https://surniaulula.github.io/wpsso-add-five-stars/assets/
 * Author: JS Morisset
 * Author URI: https://wpsso.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: Add a 5 star rating and review from the site organization if the Schema markup does not already have an 'aggregateRating' property.
 * Requires PHP: 7.0
 * Requires At Least: 5.0
 * Tested Up To: 5.8.1
 * WC Tested Up To: 5.8.0
 * Version: 1.0.0
 * 
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 * 
 * Copyright 2014-2021 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoAddOn' ) ) {

	require_once dirname( __FILE__ ) . '/lib/abstracts/add-on.php';	// WpssoAddOn class.
}

if ( ! class_exists( 'WpssoAfs' ) ) {

	class WpssoAfs extends WpssoAddOn {

		public $filters;	// WpssoAfsFilters class object.

		protected $p;		// Wpsso class object.

		private static $instance = null;	// WpssoAfs class object.

		public function __construct() {

			parent::__construct( __FILE__, __CLASS__ );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		public function init_textdomain() {

			load_plugin_textdomain( 'wpsso-add-five-stars', false, 'wpsso-add-five-stars/languages/' );
		}

		/**
		 * $is_admin, $doing_ajax, and $doing_cron available since WPSSO Core v8.8.0.
		 */
		public function init_objects( $is_admin = false, $doing_ajax = false, $doing_cron = false ) {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( $this->get_missing_requirements() ) {	// Returns false or an array of missing requirements.

				return;	// Stop here.
			}

			$this->filters = new WpssoAfsFilters( $this->p, $this );
		}
	}

        global $wpssoafs;

	$wpssoafs =& WpssoAfs::get_instance();
}
