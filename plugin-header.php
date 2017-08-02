<?php
/**
 * Plugin Name: Content Rating
 *
 * Description: Rate and label your posts to enable parental control.
 *
 * Plugin URI: http://www.miqrogroove.com/pro/software/
 * Author URI: http://www.miqrogroove.com/
 *
 * @author: Robert Chapin (miqrogroove)
 * @version: 1.1.02
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

if (version_compare(phpversion(), '5.1', '<')) exit('This version of the Content Rating plugin requires PHP version 5.1 or higher.');
require(dirname(__FILE__).'/content-rating.php');
$GLOBALS['miqrorate'] = new MiqroRating(plugin_basename(__FILE__));
?>
