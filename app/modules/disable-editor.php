<?php
/**
 * Disable editor
 * Disables file editor in Dashboard
 *
 * @since 2.0
 * @package UmbrellaAntivirus
 */

namespace Umbrella;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

define( 'DISALLOW_FILE_EDIT', true );
