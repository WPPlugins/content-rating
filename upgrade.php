<?php
/**
 * WordPress Content Rating Plugin Upgrader
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

if (!function_exists('current_user_can')) {
    header('HTTP/1.0 403 Forbidden');
    exit("Not allowed to run this file directly.");
}
if (!current_user_can('activate_plugins')) return;  // caller is unable to check perms, so don't die here.

global $wpdb;

$this->settings_init();
$this->init();
if ($this->settings['schema_ver'] < 2) {
    // Abandon the hash-as-id strategy.
    $fixme = array();
    $hashme = array();
    foreach($this->settings['static_labels'] as $key => $label) {
        if (0 == (int)$key) {
            $fixme[$key] = $label;
        } else {
            $hashme[$key] = $label;
        }
    }
    // Used separate loops for clarity.
    foreach($fixme as $key => $label) {
        unset($this->settings['static_labels'][$key]);
    }
    foreach($hashme as $key => $label) {
        $label->save(); // Hash all labels.
    }
}
$this->settings['schema_ver'] = self::SCHEMA_VER;
update_option(self::OPTION, $this->settings);
$this->init_menus();
?>
