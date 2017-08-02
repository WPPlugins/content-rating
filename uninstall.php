<?php
/**
 * WordPress Content Rating Plugin Uninstaller
 *
 * @copyright Copyright © 2010 - 2011 by Robert Chapin
 * @license GPL
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if (!defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	exit('403 Forbidden');
}

if (WP_UNINSTALL_PLUGIN != plugin_basename(dirname(__FILE__).'/plugin-header.php')
    or !current_user_can('activate_plugins')) wp_die('Unexpected permissions fault at the Content Rating uninstaller.');

global $wpdb;

delete_option('miqrorate_settings');
require(dirname(__FILE__).'/abstract-system.php');
$system_ids = array
(
    'icra_powder',
    'icra3_rdf',
    'icra3_pics',
    'icra2',
    'rsaci',
    'rta',
    'safesurf'
);
foreach($system_ids as $id) {
    try {
        $system = MiqroRatingSystem::factory($id);
        $system->uninstall();
    } catch (Exception $e) {
        // ignore it
    }
}
$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key='miqro_rating'");
?>