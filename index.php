<?php
/**
 * Plugin name: Tribe Admin Attendance View
 * Description: Provides a way to view a summary of attendance across all events, not just on an event-by-event basis.
 * Version:     2016.09.17A
 * Author:      Modern Tribe, Inc.
 * Author URI:  http://m.tri.be/1x
 * Text Domain: tribe-admin-attendance-view
 * License:     GPLv3 or later <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
 *     Tribe Admin Attendance View
 *     Copyright (C) 2016 Modern Tribe, Inc.
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

defined( 'ABSPATH' ) or exit();

add_action( 'tribe_tickets_plugin_loaded', 'tribe_admin_attendance_view' );

/**
 * @return Tribe__Support__Tickets__Admin_Attendance_View
 */
function tribe_admin_attendance_view() {
	static $object;

	if ( ! isset( $object ) ) {
		define( 'TRIBE_ADMIN_ATTENDANCE_VIEW_DIR', __DIR__ );
		define( 'TRIBE_ADMIN_ATTENDANCE_VIEW_SRC', __DIR__ . '/src' );
		define( 'TRIBE_ADMIN_ATTENDANCE_VIEW_URL', plugin_dir_url( __FILE__ ) );

		Tribe__Autoloader::instance()->register_prefix(
			'Tribe__Support__Tickets',
			TRIBE_ADMIN_ATTENDANCE_VIEW_SRC . '/classes'
		);

		$object = new Tribe__Support__Tickets__Admin_Attendance_View;
	}

	return $object;
}