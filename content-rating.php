<?php
/**
 * WordPress Content Rating Plugin
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

/**
 * Encapsulates all logic for this plugin to avoid namespace issues.
 */
final class MiqroRating {

    const OPTION = 'miqrorate_settings';
    const META_KEY = 'miqro_rating';
    const PAGE_NAME_LABELS = 'content-rating';
    const PAGE_URL_LABELS = 'edit.php?page=content-rating';
    const PAGE_URL_SYSTEMS = 'edit.php?page=content-rating&amp;action=systems';
    const PAGE_URL_EDIT = 'edit.php?page=content-rating&amp;action=edit';
    const PAGE_URL_VIEW = 'edit.php?page=content-rating&amp;action=view';
    const PAGE_URL_VIEW_RAW = 'edit.php?page=content-rating&action=view';
    const PAGE_URL_APPLY = 'edit.php?page=content-rating&amp;action=apply';
    const PAGE_URL_DELETE = 'edit.php?page=content-rating&amp;action=delete';
    const PAGE_URL_DEFAULT = 'edit.php?page=content-rating&amp;action=default';
    const PAGE_URL_RATE = 'edit.php?page=content-rating&amp;action=rate';
    const PAGE_URL_POST_LIST = 'edit.php?page=content-rating&amp;action=list';
    const PERM_ERROR = 'Unexpected permissions fault in the Content Rating Plugin.';
    const POSTS_PER_PAGE = 20;
    const SCHEMA_VER = 2; // To be modified in case of any major format changes.
    const WP_VER_MIN = '2.7'; // (inclusive)

    /**
     * @var string The plugin basename for this plugin.
     */
    private $plugin = '';

    /**
     * @var array|bool Array of settings stored in the Options API, or FALSE.
     */
    private $settings = FALSE;

    /**
     * @var array of available Rating System ID strings.
     */
    private $system_ids = array
    (
        'icra_powder',
        'icra3_rdf',
        'icra3_pics',
        'icra2',
        'rsaci',
        'rta',
        'safesurf'
    );

    /**
     * @var array of Rating System objects.
     *
     * Holds instances of all active modules, except when in the Settings screen
     * where all modules need to be displayed regardless of status.
     */
    private $systems = array();

    /**
     * @var mixed Variables used to pass data from one hook to another.
     */
    private $onloadtemp1;
    private $onloadtemp2;
    private $onloadtemp3;

    /**
     * Initializes member variables and hooks up more init routines.
     *
     * @param string $basename The machine name of this plugin.
     */
    public function __construct($basename) {
        $this->plugin = $basename;
        $this->settings = get_option(self::OPTION);
        if ($this->assert_versions()) {
            add_action('init', array($this, 'init'));
            add_action('admin_menu', array($this, 'init_menus'));
        }
    }

    /**
     * Performs all one-time setup tasks needed before normal operation.
     */
    public function install() {
        if (!current_user_can('activate_plugins')) wp_die(self::PERM_ERROR);

        if (FALSE === $this->settings) {
            $this->settings_init();
            add_option(self::OPTION, $this->settings, '', 'yes');
            $this->init(); // Important!  First initialization.
        } elseif (self::SCHEMA_VER != $this->settings['schema_ver']) {
            $this->upgrade();
        } else { // previously installed and ready to go
            $this->init();
        }
    }

    /**
     * Initialize settings one at a time for expandability.
     */
    private function settings_init() {
        $defaults = array(
            'active_systems' => array(),
            'default_labels' => array(),
            'hash_table' => array(),
            'static_labels' => array(),
            'schema_ver' => self::SCHEMA_VER,
            'output_type' => 'http'
        );
        foreach($defaults as $key => $value) {
            if (!isset($this->settings[$key])) $this->settings[$key] = $value;
        }
    }

    /**
     * Initialize all user-mode features.
     */
    public function init() {
        // Load the abstraction layer
        require(dirname(__FILE__).'/abstract-system.php');
        // Load the $systems array
        $this->load_modules();
        // Set up label headers.
        if (in_array($this->settings['output_type'], array('http','both'))) {
            // See wp-includes/template-loader.php and keep priority > 10 to avoid canonical redirects.
            add_action('template_redirect', array($this, 'do_headers'), 11, 0);
        }
        if (in_array($this->settings['output_type'], array('html','both'))) {
            // See wp-includes/general-template.php and keep priority < 1 to make IE happy.
            add_action('wp_head', array($this, 'do_meta_headers'), 0, 0);
        }
    }

    /**
     * Initialize the admin-only features.
     */
    public function init_menus() {
        // Don't even think about creating pages for unprivileged users.
        if (!current_user_can('publish_posts')) return;
        // Adds the "Content Rating" link under the Posts heading, and hooks page=tag-groups
        $hookname = add_posts_page('Content Rating', 'Content Rating', 'publish_posts', self::PAGE_NAME_LABELS, array($this, 'admin_php'));
        // Provides a headers hook for the "Content Rating" page before output begins.
	 	add_action('load-'.$hookname, array($this, 'admin_php_onload'));
        // Adds the "Settings" link to the Plugins page.
        add_filter("plugin_action_links_$this->plugin", array($this, 'plugins_settings_link'));
        // Adds "Label" links to the Posts lists.  See wp-admin/includes/template.php and wp-admin/upload.php
        if (!empty($this->settings['active_systems'])) {
	        add_filter('media_row_actions', array($this, 'post_rating_links'), 10, 2);
	        add_filter('page_row_actions', array($this, 'post_rating_links'), 10, 2);
	        add_filter('post_row_actions', array($this, 'post_rating_links'), 10, 2);
		}
    }

    /**
     * Retrieves the list of activated modules and instantiates them.
     */
    private function load_modules($all = FALSE) {
        $list = $all ? $this->system_ids : $this->settings['active_systems'];
        $result = array(); // Used to maintain the $list sort order.
        foreach($list as $id) {
            try {
                $result[$id] = isset($this->systems[$id]) ? $this->systems[$id] : MiqroRatingSystem::factory($id);
            } catch (Exception $e) {
                // ignore it
            }
        }
        $this->systems =& $result;
    }

    /**
     * Checks all system requirements and fixes any problems.
     */
    private function assert_versions() {
        $all_good = FALSE;
        if (!$this->is_this_plugin_active()) {
            if (version_compare(get_bloginfo('version'), self::WP_VER_MIN, '<')) {
                exit('This version of the Content Rating plugin requires WordPress version '.self::WP_VER_MIN.' or higher.');
            } else {
                register_activation_hook($this->plugin, array($this, 'install'));
            }
        } elseif (FALSE === $this->settings) {
            // Guests hitting asynchronously during install, or a failed install.  Returns false.
        } elseif (self::SCHEMA_VER != $this->settings['schema_ver']) {
            add_action('admin_init', array($this, 'upgrade'));
        } elseif (!isset($this->settings['output_type'])) {
            $this->settings_init();
            update_option(self::OPTION, $this->settings);
            $all_good = TRUE;
        } else {
            $all_good = TRUE;
        }
        return $all_good;
    }

    /**
     * Performs schema upgrades, then asserts current schema.
     */
    public function upgrade() {
        require(dirname(__FILE__).'/upgrade.php');
    }

    /**
     * Checks if this plugin has been activated yet.
     *
     * Based on wp-admin/includes/plugin.php::is_plugin_active()
     * @return bool
     */
    private function is_this_plugin_active() {
        return in_array($this->plugin, get_option('active_plugins'));
    }

    /**
     * Adds the Settings link on the Plugins page.
     *
     * @param array $actions List of links.
     * @return array of strings with the Settings link added.
     */
    public function plugins_settings_link(array $actions) {
        if (!current_user_can('activate_plugins')) wp_die(self::PERM_ERROR);

		array_unshift($actions, '<a href="' . self::PAGE_URL_SYSTEMS . '">' . __('Settings') . '</a>');

        return $actions;
    }

    /**
     * Adds the "Label" links to the list of posts in edit.php
     *
     * @param array $actions The list of links.
     * @param object $post
     * @return array
     */
    public function post_rating_links(array $actions, $post) {
        $actions['content-rating'] = '<a href="' . self::PAGE_URL_RATE . '&amp;id='.$post->ID.'" title="' . esc_attr(__('Rate this post with content labels')) . '">' . __('Label') . '</a>';
        return $actions;
    }

    /**
     * Organizes and transmits all HTTP headers for content labels.
     */
    public function do_headers() {
        if (headers_sent() or empty($this->systems)) return;

        $records = $this->collect_records();
        $headers = array();

        foreach($this->systems as $sid => $system) {

            // Hand off the dirty work to this labelling module.
            if (!empty($records[$sid])) {
                if ($header = $system->get_http_header($records[$sid])) {
                    $headers[] = $header;
                }
            }

        }

        // Handle PICS protocol
        $active_services = array();
        foreach($this->systems as $system) {
            $active_services[] = $system->system_url();
        }
        $headers = $system->combine_pics_headers($headers, $active_services);

        // Transmit headers
        foreach($headers as $header) {
            header($header, FALSE);
        }
    }

    /**
     * Organizes and transmits all HTML headers for content labels.
     */
    public function do_meta_headers() {
        if (empty($this->systems)) return;

        $records = $this->collect_records();
        $headers = array();

        foreach($this->systems as $sid => $system) {
            // Hand off the dirty work to this labelling module.
            if (!empty($records[$sid])) {
                if ($header = $system->get_html_header($records[$sid])) {
                    $headers[] = $header;
                }
            }
        }

        // Handle PICS protocol
        $headers = $system->combine_html_headers($headers);

        // Transmit headers
        foreach($headers as $header) {
            echo $header, "\n";
        }
    }

    /**
     * Organizes content records for the current page.
     *
     * @since 1.1.0
     * @return array of arrays of MiqroPostRecord objects, indexed first by the system id.
     */
    private function collect_records() {
        $records = array();

        while(have_posts()) {
            the_post();

            // Load post label records from the meta cache.
            $pid = get_the_ID();
            $metas = get_post_meta($pid, self::META_KEY, TRUE);

            // Fall back to parent post's labels on attachment pages.
            if (!is_array($metas)) {
                if (is_attachment()) {
                    $pid = $GLOBALS['post']->post_parent;
                    $metas = get_post_meta($pid, self::META_KEY, TRUE);
                    if (!is_array($metas)) continue;
                } else {
                    continue;
                }
            }

            // Construct label record objects and key them by module.
            foreach($this->parse_metas($pid, $metas) as $sid => $record) {
                $records[$sid][] = $record;
            }
        }

        foreach($this->systems as $sid => $system) {
            if (empty($records[$sid])) {
                // Fall back on default labels
                $lid = $this->default_label_for($sid);
                if (isset($this->settings['static_labels'][$lid])) {
                    $label = $this->settings['static_labels'][$lid];
                    $records[$sid][] = new MiqroPostRecord($label, time(), get_the_ID());
                }
            }
        }

        return $records;
    }

    /**
     * @param int $pid The post ID that the metas came from.
     * @param array @metas
     * @return array of MiqroPostRating objects indexed by $sid
     */
    private function parse_metas($pid, array $metas) {
        $records = array();
        foreach($metas as $meta) {
            $lid = substr($meta['label'], 1, -1); // format is @12345@
            if (isset($this->settings['static_labels'][$lid])) {
                $label = $this->settings['static_labels'][$lid];
                $records[$label->system] = new MiqroPostRecord($label, $meta['timestamp'], $pid);
            }
        }
        return $records;
    }

    /**
     * Saves a new or updated label object.  See apply_label() for labelling.
     *
     * Static (user-generated) labels are saved with sequential ID numbers.
     * Dynamic labels are saved with a data hash for the sake of indexing.
     *
     * @param object $label
     * @param string $type 'dynamic' or 'static'
     */
    public function save_label(MiqroLabel $label, $type) {
        // Check if dynamic label already exists
        $hash = md5($label->system.$label->data);
        if ('dynamic' == $type) {
            if (isset($this->settings['hash_table'][$hash])) {
                $label->id = $this->settings['hash_table'][$hash];
                return; // id value returned by reference in $label.
            } else {
                $label->id = NULL;
            }
        } elseif (is_null($label->id)) {
            if (!current_user_can('publish_posts')) wp_die(self::PERM_ERROR);
        } else {
            // The settings array has been updated already because labels are a reference type.
            // Try not to orphan hash objects.
            foreach($this->settings['hash_table'] as $key => $id) {
                if ($id == $label->id and $key != $hash) {
                    unset($this->settings['hash_table'][$key]);
                }
            }
        }

        // Set ID number and hash value.
        if (is_null($label->id)) {
            $labels =& $this->settings['static_labels'];
            if (empty($labels)) {
                $labels[1] = $label;
            } else {
                $labels[] = $label;
            }
            end($labels);
            $label->id = key($labels);
        }
        $this->settings['hash_table'][$hash] = $label->id;

        // Save it
        $this->flush_label_file($label->system);
        update_option(self::OPTION, $this->settings);
    }

    /**
     * Exports all labels for the specified rating module.
     *
     * @param string $sid The rating system ID.
     */
    private function flush_label_file($sid) {
        $labels = array();
        foreach($this->settings['static_labels'] as $label) {
            if ($label->system == $sid) $labels[] = $label;
        }
        try {
            $this->systems[$sid]->flush_label_file($labels);
        } catch (Exception $e) {
            wp_die('The '.$this->systems[$sid]->name().' rating system failed to
                save your label to disk. Please check the file permissions in
                your WordPress root directory.');
        }
    }

    /**
     * Finds the default label ID for the specified rating system.
     *
     * @param string $sid The rating system ID.
     * @return int|string The label ID, or null for no default.
     */
    private function default_label_for($sid) {
        if (isset($this->settings['default_labels'][$sid])) {
            return $this->settings['default_labels'][$sid];
        } else {
            return NULL;
        }
    }

    /**
     * Sets the specified label as the site-wide default for its module.
     *
     * @param object $label
     */
    private function set_default(MiqroLabel $label) {
        $this->settings['default_labels'][$label->system] = $label->id;
        update_option(self::OPTION, $this->settings);
    }

    /**
     * Removes the default status for the specified label.
     *
     * @param object $label
     */
    private function unset_default(MiqroLabel $label) {
        if (isset($this->settings['default_labels'][$label->system])) {
            if ($this->settings['default_labels'][$label->system] === $label->id) {
                unset($this->settings['default_labels'][$label->system]);
                update_option(self::OPTION, $this->settings);
            }
        }
    }

    /**
     * Relates the specified post to the specified label.
     *
     * Label IDs are saved in a '@1234@' format to aid postmeta table scanning.
     *
     * @param int $pid The post ID
     * @param object $label
     */
    private function apply_label($pid, MiqroLabel $label) {
        $pid = (int) $pid;
        $metas = get_post_meta($pid, self::META_KEY, TRUE);

        if (isset($metas[$label->system])) {
            if ($metas[$label->system]['label'] == "@$label->id@") {
                // Label already applied
                return;
            }
        }

        $metas[$label->system]['label'] = "@$label->id@";
        $metas[$label->system]['timestamp'] = time();
        update_post_meta($pid, self::META_KEY, $metas);
    }

    /**
     * Deletes the specified label record from the specified post.
     *
     * @param int $pid The post ID
     * @param object $label
     */
    private function unapply_label($pid, MiqroLabel $label) {
        $pid = (int) $pid;
        $metas = get_post_meta($pid, self::META_KEY, TRUE);

        if (isset($metas[$label->system])) {
            if ($metas[$label->system]['label'] == "@$label->id@") {
                unset($metas[$label->system]);
                if (empty($metas)) {
                    delete_post_meta($pid, self::META_KEY);
                } else {
                    update_post_meta($pid, self::META_KEY, $metas);
                }
            }
        }
    }

    /**
     * Deletes the specified label given only its system ID.
     *
     * @param int $pid The post ID
     * @param string $sid The system ID
     */
    private function unapply_rating($pid, $sid) {
        $pid = (int) $pid;
        $metas = get_post_meta($pid, self::META_KEY, TRUE);

        if (isset($metas[$sid])) {
            unset($metas[$sid]);
            if (empty($metas)) {
                delete_post_meta($pid, self::META_KEY);
            } else {
                update_post_meta($pid, self::META_KEY, $metas);
            }
        }
    }

    /**
     * Retrieves the number of posts related to the specified label.
     *
     * @param object $label
     * @return int
     */
    private function count_label(MiqroLabel $label) {
        global $wpdb;

        $id = $wpdb->_real_escape($label->id);
        return $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key='".self::META_KEY."' AND meta_value LIKE '%@$id@%'");
    }

    /**
     * Deletes the specified label and all of its relationships.
     *
     * @param object $label
     */
    private function delete_label(MiqroLabel $label) {
        global $wpdb;

        if ($label->id == $this->default_label_for($label->system)) {
            $this->unset_default($label);
        }
        $id = $wpdb->_real_escape($label->id);
        $posts = $wpdb->get_col("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='".self::META_KEY."' AND meta_value LIKE '%@$id@%'");
        foreach($posts as $pid) {
            $this->unapply_label($pid, $label);
        }
        $hash = md5($label->system.$label->data);
        unset($this->settings['hash_table'][$hash]);
        unset($this->settings['static_labels'][$label->id]);
        $this->flush_label_file($label->system);
        update_option(self::OPTION, $this->settings);
    }

    /**
     * Handles all actions for the Content Rating page.
     */
    public function admin_php_onload() {
        if (!current_user_can('publish_posts')) wp_die(self::PERM_ERROR, array('response' => 403));

		if ( empty( $_POST['action'] ) ) {
			if ( empty( $_GET['action'] ) )
				$action = '';
			else
				$action = $_GET['action'];
		} else {
			$action = $_POST['action'];
		}

        if ( isset( $_GET['action'] ) && isset($_GET['delete']) && ( 'delete' == $_GET['action'] || 'delete' == $_GET['action2'] ) )
        	$action = 'bulk-delete';

        switch($action) {

        case 'systems':

            if (!current_user_can('manage_options')) wp_die(self::PERM_ERROR, array('response' => 403));

            if (isset($_POST['submit'])) {
                $checked = isset($_POST['checked']) ? $_POST['checked'] : array();
                if (is_array($checked)) {
                    $this->settings['active_systems'] = array();
                    $input = stripslashes_deep($checked);
                    foreach($this->system_ids as $id) {
                        $id = stripslashes($id);
                        if (in_array($id, $input)) {
                            $this->settings['active_systems'][] = $id;
                        }
                    }
                    if (isset($_POST['format']) and is_string($_POST['format'])) {
                        if (in_array($_POST['format'], array('http','both','html'))) {
                            $this->settings['output_type'] = $_POST['format'];
                        }
                    }
                    update_option(self::OPTION, $this->settings);
                }
            }

            break;
        case 'edit':
            $lid = isset($_GET['id']) ? (int)$_GET['id'] : NULL;
            $sid = '';
            if (isset($_GET['system'])) {
                if (is_string($_GET['system'])) {
                    $sid = stripslashes($_GET['system']);
                }
            }

            if (isset($this->settings['static_labels'][$lid])) {
                $label = $this->settings['static_labels'][$lid];
                $sid = $label->system;
            } else {
                $lid = NULL;
                $label = new MiqroLabel();
                $label->system = $sid;
            }

            if (!isset($this->systems[$sid])) wp_die('The specified rating system is not enabled.', array('response' => 404));

            $system = $this->systems[$sid];

            if (isset($_POST['submit'])) {

                // Convert all inputs to an intermediate logical structure defined by the module.
                $data = $system->get_data_from_post();
                $errors = $data['errors'];

                // Convert the intermediate structure into raw label data,
                // which can then be saved or passed back for more editing.
                $label->data = $system->get_label_from_data($data);
                if (empty($_POST['name'])) {
                    array_unshift($errors, 'Nothing was entered for the label name.');
                } else {
                    $label->name = stripslashes($_POST['name']);
                }
                if (isset($_POST['comments'])) $label->comments = stripslashes($_POST['comments']);
                if (0 == count($errors)) {
                    $label->save();
                    if (is_null($lid)) {
                        wp_safe_redirect( self::PAGE_URL_VIEW_RAW.'&id='.$label->id.'&message=1' );
                    } else {
                        wp_safe_redirect( self::PAGE_URL_VIEW_RAW.'&id='.$label->id.'&message=2' );
                    }
                    exit;
                }
            } else {
                $errors = array();
            }

            $this->onloadtemp1 = $label;
            $this->onloadtemp2 = $errors;
            $this->onloadtemp3 = $system->name();

            break;
        case 'view':
            $lid = isset($_GET['id']) ? (int)$_GET['id'] : NULL;

            if (isset($this->settings['static_labels'][$lid])) {
                $label = $this->settings['static_labels'][$lid];
            } else {
                wp_die('The specified label was not be found.', array('response' => 404));
            }

            if (!isset($this->systems[$label->system])) wp_die('The specified rating system is not enabled.', array('response' => 404));

            $this->onloadtemp1 = $label;

            break;
        case 'apply':
            $lid = isset($_GET['id']) ? (int)$_GET['id'] : NULL;

            if (isset($this->settings['static_labels'][$lid])) {
                $label = $this->settings['static_labels'][$lid];
            } else {
                wp_die('The specified label was not be found.', array('response' => 404));
            }

            if (!isset($this->systems[$label->system])) wp_die('The specified rating system is not enabled.', array('response' => 404));

            $message = '';
            if (isset($_POST['pid'])) {
                $pid = (int) $_POST['pid'];
                $post = get_post($pid);
                if (is_null($post)) wp_die('The specified post was not found.', array('response' => 400));

                if (isset($_POST['submit'])) {
                    $this->apply_label($pid, $label);
                    $message = 'Label applied successfully to '.get_the_title( $pid );
                } elseif (isset($_POST['remove'])) {
                    $this->unapply_label($pid, $label);
                    $message = 'Label removed from '.get_the_title( $pid );
                }
            }

            $this->onloadtemp1 = $label;
            $this->onloadtemp2 = $message;

            break;
        case 'delete':
            $lid = isset($_GET['id']) ? (int)$_GET['id'] : NULL;

            if (isset($this->settings['static_labels'][$lid])) {
                $label = $this->settings['static_labels'][$lid];
            } else {
                wp_die('The specified label was not be found.', array('response' => 404));
            }

            if (!isset($this->systems[$label->system])) wp_die('The specified rating system is not enabled.', array('response' => 404));

            if (isset($_POST['submit'])) {
                $this->delete_label($label);
                wp_safe_redirect( self::PAGE_URL_LABELS.'&message=2' );
            }

            $this->onloadtemp1 = $label;

            break;
        case 'default':
            $lid = isset($_GET['id']) ? (int)$_GET['id'] : NULL;

            if (isset($this->settings['static_labels'][$lid])) {
                $label = $this->settings['static_labels'][$lid];
            } else {
                wp_die('The specified label was not be found.', array('response' => 404));
            }

            if (!isset($this->systems[$label->system])) wp_die('The specified rating system is not enabled.', array('response' => 404));

            if (isset($_POST['submit'])) {
                $this->set_default($label);
                wp_safe_redirect( self::PAGE_URL_VIEW_RAW.'&id='.$label->id.'&message=2' );
            } elseif (isset($_POST['remove'])) {
                $this->unset_default($label);
                wp_safe_redirect( self::PAGE_URL_VIEW_RAW.'&id='.$label->id.'&message=2' );
            }

            $this->onloadtemp1 = $label;
            break;
        case 'rate':
            $records = array();
            $pid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if (isset($_POST['submit'])) {
                $post = get_post($pid);
                if (is_null($post)) wp_die('The specified post was not found.', array('response' => 404));

                foreach($this->systems as $sid => $system) {
                    if (isset($_POST[$sid])) {
                        $lid = (int)$_POST[$sid];
                        if (0 === $lid) {
                            $this->unapply_rating($pid, $sid);
                        } elseif (isset($this->settings['static_labels'][$lid])) {
                            $this->apply_label($pid, $this->settings['static_labels'][$lid]);
                        }
                    }
                }
            }

            $records = array();
            $metas = get_post_meta($pid, self::META_KEY, TRUE);

            if (is_array($metas)) {
                $records = $this->parse_metas($pid, $metas);
            }

            $this->onloadtemp1 = $pid;
            $this->onloadtemp2 = $records;

            break;
        case 'list':
            $lid = isset($_GET['id']) ? (int)$_GET['id'] : NULL;
            $page = isset($_GET['pagenum']) ? (int)$_GET['pagenum'] : 1;
            if ($page < 1) $page = 1;

            if (isset($this->settings['static_labels'][$lid])) {
                $label = $this->settings['static_labels'][$lid];
            } else {
                wp_die('The specified label was not be found.', array('response' => 404));
            }

            if (!isset($this->systems[$label->system])) wp_die('The specified rating system is not enabled.', array('response' => 404));

            $count = $this->count_label($label);

            if (0 == $count) wp_die('The specified label is not applied to any posts yet.', array('response' => 404));

            $max_page = ceil($count / self::POSTS_PER_PAGE);

            if ($page > $max_page) wp_die('Page not found.', array('response' => 404));

            $this->onloadtemp1 = $label;
            $this->onloadtemp2 = $max_page;
            $this->onloadtemp3 = $page;

            break;
        }

    } // end function admin_php_onload()

    /**
     * Generates the Content Rating page.
     */
    public function admin_php() {
        global $title;

        if (!current_user_can('publish_posts')) wp_die(self::PERM_ERROR, array('response' => 403));

		if ( empty( $_POST['action'] ) ) {
			if ( empty( $_GET['action'] ) )
				$action = '';
			else
				$action = $_GET['action'];
		} else {
			$action = $_POST['action'];
		}

if ( isset( $_GET['action'] ) && isset($_GET['delete']) && ( 'delete' == $_GET['action'] || 'delete' == $_GET['action2'] ) )
	$action = 'bulk-delete';

switch($action) {

case 'systems':
	$title = __('Content Rating Systems');

	$this->admin_edit_systems_php();

    break;
case 'edit':
	$title = $this->onloadtemp3 . __(' Label Editing');

	$this->admin_edit_label_php($this->onloadtemp1, $this->onloadtemp2);

    break;
case 'view':
    $title = __('View Label');

	$this->admin_view_label_php($this->onloadtemp1);

    break;
case 'apply':
    $title = __('Apply Label');

	$this->admin_apply_label_php($this->onloadtemp1, $this->onloadtemp2);

    break;
case 'delete':
	$title = __('Delete Label');

	$this->admin_delete_label_php($this->onloadtemp1);

    break;
case 'default':
	$title = __('Manage Default Label');

	$this->admin_default_label_php($this->onloadtemp1);

    break;
case 'rate':
	$title = __('Post Rating');

	$this->admin_rate_post_php($this->onloadtemp1, $this->onloadtemp2);

    break;
case 'list':
	$title = __('List Posts');

	$this->admin_list_posts_php($this->onloadtemp1, $this->onloadtemp2, $this->onloadtemp3);

    break;
default:

$count = 0;

$messages[1] = __('Label added.');
$messages[2] = __('Label deleted.');
$messages[3] = __('Label updated.');
$messages[4] = __('Label not added.');
$messages[5] = __('Label not updated.');
?>

<div class="wrap nosubsub">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<div class="breadcrumb">
<?php
echo '<a href="./">';
_e('Dashboard');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_LABELS . '">';
_e('Content Rating');
echo "</a>\n";
?>
</div>
<br />

<?php
if ( isset($_GET['message']) && ( $msg = (int) $_GET['message'] ) ) : ?>
<div id="message" class="updated fade"><p><?php echo $messages[$msg]; ?></p></div>
<?php $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
endif; ?>

<p>To get started, first visit the settings page to <a href="<?php echo self::PAGE_URL_SYSTEMS; ?>">Enable Rating Systems</a>, then add some labels below.</p>
<br />

<?php
foreach($this->systems as $sid => $system) {
    echo '<h3>'.$system->name().'</h3>';
?>

<table class="widefat">
	<thead>
	<tr>
		<th scope="col">Label Name</th>
		<th scope="col">Comments</th>
	</tr>
	</thead>
	<tbody>

<?php
	foreach( $this->settings['static_labels'] as $id => $label ) {
        if ($label->system == $sid) {
            $count++;
?>

	<tr>
		<td class="row-title"><a href="<?php echo self::PAGE_URL_VIEW."&amp;id=$label->id" ?>"><?php echo esc_html($label->name); ?></a></td>
		<td><?php echo esc_html($label->comments); ?></td>
	</tr>

<?php
        }
	} //end foreach;
    echo '<tr><td><a href="'.self::PAGE_URL_EDIT.'&amp;system='.esc_attr(rawurlencode($sid)).'">Add a new label</a></td><td></td></tr>';
?>
	</tbody>
</table>
<?php
} //end foreach;

if ($count > 0) {
?>
<br />
<form method="get" action="<?php echo self::PAGE_URL_RATE; ?>">
<input type="hidden" name="page" value="<?php echo self::PAGE_NAME_LABELS; ?>">
<input type="hidden" name="action" value="rate">
<label>Query a Post ID:<input type="text" size="32" name='id'></label>
<input type="submit" class="button-secondary" value="Go" />
</form>
<?php } ?>

<br /><br />
<p>Content Rating plugin Copyright &copy; 2011 by <a href="http://www.miqrogroove.com/">Robert Chapin</a>.</p>

</div><!-- wrap -->
<?php
            break;
        } // switch
    } // end function admin_php()

    /**
     * Generates the Enable/Disable Modules page.
     */
    private function admin_edit_systems_php() {
        global $title;

        $this->load_modules(TRUE);

        if (isset($_POST['submit'])) {
            $messages = __('Content rating systems updated.');
        } else {
            $messages = '';
        }
?>

<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<div class="breadcrumb">
<?php
echo '<a href="./">';
_e('Dashboard');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_LABELS . '">';
_e('Content Rating');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_SYSTEMS . '">';
_e('Enable/Disable Systems');
echo "</a>\n";
?>
</div>
<br />

<?php if (0 != strlen($messages)) { ?>
<div id="message" class="updated fade"><p><?php echo $messages; ?></p></div>
<?php } ?>

<p>Please select which labeling systems you would like to use for rating content.</p>
<p>Disabling a system does not delete anything.  However, disabled systems will not output any labels.</p>
<p>To view or edit any labels, the system for those labels must be enabled.</p>
<p><br />
<form method="post" action="<?php echo self::PAGE_URL_SYSTEMS; ?>">
<table class="widefat">
	<thead>
	<tr>
		<th scope="col" class="check-column"><input type="checkbox" name="check-all" /></th>
		<th scope="col">Module Name</th>
		<th scope="col">Description</th>
	</tr>
	</thead>
	<tbody>

<?php
	foreach ( $this->systems as $id => $system ) {
		$active = in_array($id, $this->settings['active_systems']);
		$style = $active ? ' style="background-color: #e7f7d3"' : '';
?>

	<tr<?php echo $style ?>>
		<th scope="row" class="check-column"><input type="checkbox" name="checked[]" value="<?php echo esc_attr($id) ?>" <?php if ( $active ) echo 'checked="checked"' ?> /></th>
		<td><?php echo $system->name(); ?></td>
		<td><?php echo $system->description(); ?></td>
	</tr>

<?php
	} //end foreach;
?>
	</tbody>
</table>
<p>Please select which type of label output to use.</p>
<table>
    <thead></thead>
    <tbody>
        <tr>
            <td><input type="radio" name="format" value="http" <?php if ( 'http' == $this->settings['output_type'] ) echo 'checked="checked"' ?> /></td>
            <td>HTTP Only (Not compatible with WP Super Cache)</td>
        </tr>
        <tr>
            <td><input type="radio" name="format" value="both" <?php if ( 'both' == $this->settings['output_type'] ) echo 'checked="checked"' ?> /></td>
            <td>HTTP and HTML</td>
        </tr>
        <tr>
            <td><input type="radio" name="format" value="html" <?php if ( 'html' == $this->settings['output_type'] ) echo 'checked="checked"' ?> /></td>
            <td>HTML Only</td>
        </tr>
    </tbody>
</table>
<br /><br /><input type="submit" name="submit" class="button-secondary" value="Save Module Choices" />
</p>
</form>
</div><!-- wrap -->

<?php

    } // end function admin_edit_systems_php()

    /**
     * Generates the Add Label and Edit Label pages.
     *
     * @param object $label
     * @param array @errors Strings explaining user input mistakes.
     */
    private function admin_edit_label_php(MiqroLabel $label, array $errors) {
        global $title;

        if (isset($_POST['submit'])) {
            if (0 == count($errors)) {
                $messages = __('Label saved.');
            } else {
                $messages = __('Invalid label. Please try again!');
                foreach($errors as $error) {
                    $messages .= "\n<br />$error";
                }
            }
        } else {
            $messages = '';
        }

?>

<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<div class="breadcrumb">
<?php
echo '<a href="./">';
_e('Dashboard');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_LABELS . '">';
_e('Content Rating');
echo "</a> &raquo\n";
if (!is_null($label->id)) {
    echo '<a href="' . self::PAGE_URL_VIEW . '&amp;id='.$label->id.'">';
    _e('View Label');
    echo "</a> &raquo\n";
    echo '<a href="' . self::PAGE_URL_EDIT . '&amp;id='.$label->id.'">';
    _e('Edit Label');
} else {
    echo '<a href="' . self::PAGE_URL_EDIT . '&amp;system='.esc_attr(rawurlencode($label->system)).'">';
    _e('Add Label');
}
echo "</a>\n";
?>
</div>
<br /><br />

<?php if (0 != strlen($messages)) { ?>
<div id="message" class="updated fade"><p><?php echo $messages; ?></p></div>
<?php } ?>

<?php $this->label_form($label); ?>

</div><!-- wrap -->

<?php
    } // end function admin_edit_label_php()

    /**
     * Generates the form used on the Add Label and Edit Label pages.
     *
     * @param object $label
     */
    private function label_form(MiqroLabel $label) {
        $name = esc_attr($label->name);
        $comments = esc_html($label->comments);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : $label->id;
        $sid = esc_attr(rawurlencode($label->system));
        $system = $this->systems[$label->system];

        if (!is_null($id)) {
            echo "<form method='post' action='".self::PAGE_URL_EDIT."&amp;id=$id'>\n";
        } else {
            echo "<form method='post' action='".self::PAGE_URL_EDIT."&amp;system=$sid'>\n";
        }
        echo "<label><strong>Name for this label</strong>: <input type='text' name='name' value='$name' size='40' /></label><br /><br />\n";
        echo "<label><strong>Comments</strong>: (These are published with the label)<br /><textarea name='comments' rows='3' cols='80'>\n";
        echo $comments."</textarea></label>\n";
        echo $system->get_label_form($label);
        echo '<br /><br /><input type="submit" name="submit" class="button-secondary" value="Save This Label" />';
        echo '<br /><br /></form>';
    }

    /**
     * Generates the View Label page.
     *
     * @param object $label
     */
    private function admin_view_label_php(MiqroLabel $label) {
        global $title;

        $system = $this->systems[$label->system];
        $count = $this->count_label($label);

$messages[1] = __('Label added.');
$messages[2] = __('Label updated.');

?>

<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<div class="breadcrumb">
<?php
echo '<a href="./">';
_e('Dashboard');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_LABELS . '">';
_e('Content Rating');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_VIEW . '&amp;id='.$label->id.'">';
_e('View Label');
echo "</a>\n";
?>
</div>
<br />

<?php
if ( isset($_GET['message']) && ( $msg = (int) $_GET['message'] ) ) : ?>
<div id="message" class="updated fade"><p><?php echo $messages[$msg]; ?></p></div>
<?php $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
endif; ?>

<h3>Description</h3>

<table class="widefat">
 <thead><tr>
  <th scope="col">Field</th>
  <th scope="col">Value</th>
 </tr></thead>
 <tbody>
  <tr><td>Name</td><td><?php echo esc_html($label->name); ?></td></tr>
  <tr><td>Type</td><td><?php echo esc_html($system->name()); ?></td></tr>
  <tr><td>Count</td><td><?php
    if ($count > 0) {
        echo "<a href='", self::PAGE_URL_POST_LIST, "&amp;id=$label->id&amp;pagenum=1'>$count</a>";
    } else {
        echo '0';
    }
   ?></td></tr>
  <tr><td>Default</td><td><?php
    if ($label->id === $this->default_label_for($label->system)) {
        echo 'TRUE - This label is added automatically to all unlabeled pages.';
    } else {
        echo 'FALSE - This label does not get added to unlabeled pages.';
    }
   ?></td></tr>
  <tr><td>Comments</td><td><?php echo esc_html($label->comments); ?></td></tr>
 </tbody>
</table>

<h3>Label</h3>
<?php
        echo $system->get_label_view($label);
?>
<h3>Raw Header</h3>
<?php
$record = new MiqroPostRecord($label, time());
if (in_array($this->settings['output_type'], array('http','both'))) {
    echo '<p>', htmlspecialchars($system->get_http_header(array($record))), '</p>';
}
if (in_array($this->settings['output_type'], array('html','both'))) {
    echo '<p>', htmlspecialchars($system->get_html_header(array($record))), '</p>';
}
?>

<a href="<?php echo self::PAGE_URL_EDIT."&amp;id=$label->id" ?>">Edit this label</a> |
<a href="<?php echo self::PAGE_URL_APPLY."&amp;id=$label->id" ?>">Apply this label to a post</a> |
<a href="<?php echo self::PAGE_URL_DEFAULT."&amp;id=$label->id" ?>">Default label for <?php echo $system->name(); ?></a> |
<a href="<?php echo self::PAGE_URL_DELETE."&amp;id=$label->id" ?>">Delete permanently</a>
<br /><br />

</div><!-- wrap -->

<?php
    } // end function admin_view_label_php()

    /**
     * Generates the Apply Label page.
     *
     * @param object $label
     * @param string $messages Success message generated by the onload handler.
     */
	private function admin_apply_label_php(MiqroLabel $label, $messages) {
        global $title;

?>

<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<div class="breadcrumb">
<?php
echo '<a href="./">';
_e('Dashboard');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_LABELS . '">';
_e('Content Rating');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_VIEW . '&amp;id='.$label->id.'">';
_e('View Label');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_APPLY . '&amp;id='.$label->id.'">';
_e('Apply Label');
echo "</a>\n";
?>
</div>
<br /><br />

<?php if (0 != strlen($messages)) { ?>
<div id="message" class="updated fade"><p><?php echo $messages; ?></p></div>
<?php } ?>

<h3><?php echo esc_html($label->name); ?></h3>
<form method="post" action="<?php echo self::PAGE_URL_APPLY . '&amp;id='.$label->id; ?>">
<label>Enter the post ID number:<input type="text" name="pid" size="10" /></label>
<br /><br />
<input type="submit" name="submit" class="button-secondary" value="Apply Label to Post" />
<input type="submit" name="remove" class="button-secondary" value="Remove Label From Post" />
</form>

</div><!-- wrap -->

<?php

    } // end function admin_apply_label_php()

    /**
     * Generates the Delete Label page.
     *
     * @param object $label
     */
   	private function admin_delete_label_php($label) {
        global $title;

?>

<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<div class="breadcrumb">
<?php
echo '<a href="./">';
_e('Dashboard');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_LABELS . '">';
_e('Content Rating');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_VIEW . '&amp;id='.$label->id.'">';
_e('View Label');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_DELETE . '&amp;id='.$label->id.'">';
_e('Delete Label');
echo "</a>\n";
?>
</div>
<br /><br />

<h3><?php echo esc_html($label->name); ?></h3>
<form method="post" action="<?php echo self::PAGE_URL_DELETE . '&amp;id='.$label->id; ?>">
<?php if (($count = $this->count_label($label)) > 20) echo "<strong>WARNING</strong>: This operation will be extremely database-intensive with $count posts."; ?>
<br /><br /><input type="submit" name="submit" class="button-secondary" value="Confirm Delete" />
</form>

</div><!-- wrap -->

<?php

    } // end function admin_delete_label_php()

    /**
     * Generates the Manage Default Label page.
     *
     * @param object $label
     */
	private function admin_default_label_php($label) {
        global $title;

?>

<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<div class="breadcrumb">
<?php
echo '<a href="./">';
_e('Dashboard');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_LABELS . '">';
_e('Content Rating');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_VIEW . '&amp;id='.$label->id.'">';
_e('View Label');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_DEFAULT . '&amp;id='.$label->id.'">';
_e('Manage Defaults');
echo "</a>\n";
?>
</div>
<br /><br />

<h3><?php echo esc_html($label->name); ?></h3>
<form method="post" action="<?php echo self::PAGE_URL_DEFAULT . '&amp;id='.$label->id; ?>">
The default label for your site should reflect the youngest appropriate audience.
On dynamic pages where at least one post has a label, the default label will be ignored.
In other words, the default label is always overridden and never combined with other labels.
<br /><br />
<?php if($this->default_label_for($label->system) !== $label->id) { ?>
<input type="submit" name="submit" class="button-secondary" value="Confirm Default Label" />
<?php } else { ?>
<input type="submit" name="remove" class="button-secondary" value="Remove Default Setting" />
<?php } ?>
</form>

</div><!-- wrap -->

<?php

    } // end function admin_default_label_php()

    /**
     * Generates the Post Rating page.
     */
	private function admin_rate_post_php($pid, $records) {
        global $title;

        if (isset($_POST['submit'])) {
            $messages = __('Ratings updated.');
        } else {
            $messages = '';
        }

?>
<div class="wrap nosubsub">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<div class="breadcrumb">
<?php
echo '<a href="./">';
_e('Dashboard');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_LABELS . '">';
_e('Content Rating');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_RATE . '&amp;id='.$pid.'">';
_e('Post Rating');
echo "</a>\n";
?>
</div>
<br />

<?php if (0 != strlen($messages)) { ?>
<div id="message" class="updated fade"><p><?php echo $messages; ?></p></div>
<?php } ?>

<h3><?php echo get_the_title( $pid ); ?></h3>

<form method="post" action="<?php echo self::PAGE_URL_RATE . '&amp;id='.$pid; ?>">
<?php
foreach($this->systems as $sid => $system) {
    echo '<h4>'.$system->name().'</h4>';
?>

<table class="widefat">
	<thead>
	<tr>
		<th scope="col">Label Name</th>
		<th scope="col">Comments</th>
	</tr>
	</thead>
	<tbody>

<?php
    $found = FALSE;
	foreach( $this->settings['static_labels'] as $id => $label ) {
        if ($label->system == $sid) {
            if (isset($records[$sid])) {
                $match = $id === $records[$sid]->label->id;
                $checked = $match ? 'checked="checked"' : '';
                $found |= $match;
            } else {
                $checked = '';
            }
?>

	<tr>
        <td class="row-title">
            <label>
            <input type="radio" name="<?php echo $sid; ?>" value="<?php echo $id; ?>" <?php echo $checked; ?> />
            <?php echo esc_html($label->name); ?>
            </label>
        </td>
		<td><?php echo esc_html($label->comments); ?></td>
	</tr>

<?php
        }
	} //end foreach;
    $checked = (!$found) ? 'checked="checked"' : '';
?>
	<tr>
        <td>
            <label>
            <input type="radio" name="<?php echo $sid; ?>" value="0" <?php echo $checked; ?> />
    		<?php echo __('None') ?>
    		</label>
        </td>
		<td></td>
	</tr>

	</tbody>
</table>
<?php
} //end foreach;
?>
<br />
<input type="submit" name="submit" class="button-secondary" value="Save Ratings" />
</form>

</div><!-- wrap -->

<?php
    } // end function admin_rate_post_php()


    /**
     * Generates the List Posts page.
     */
	private function admin_list_posts_php($label, $max_page, $page) {
        global $title, $wpdb;

?>
<div class="wrap nosubsub">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<div class="breadcrumb">
<?php
echo '<a href="./">';
_e('Dashboard');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_LABELS . '">';
_e('Content Rating');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_VIEW . '&amp;id='.$label->id.'">';
_e('View Label');
echo "</a> &raquo\n";
echo '<a href="' . self::PAGE_URL_POST_LIST . '&amp;id='.$label->id.'&amp;pagenum='.$page.'">';
_e('List Posts');
echo "</a>\n";
?>
</div>
<br />

<h3><?php echo esc_html($label->name); ?></h3>

<?php
$page_links = paginate_links( array(
	'base' => add_query_arg( 'pagenum', '%#%' ),
	'format' => '',
	'prev_text' => __('&laquo;'),
	'next_text' => __('&raquo;'),
	'total' => $max_page,
	'current' => $page
));

if ( $page_links )
	echo "<div class='tablenav-pages'>$page_links</div>";

?>

<div>

<?php

$id = $wpdb->_real_escape($label->id);
$start = self::POSTS_PER_PAGE * ($page - 1);
$results = $wpdb->get_col("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='".self::META_KEY."' AND meta_value LIKE '%@$id@%' LIMIT $start, ".self::POSTS_PER_PAGE);

if (empty($results)) exit('Unexpected empty result set.');

$posts = new WP_Query();
$posts->query(array('post__in' => $results, 'posts_per_page' => -1));

foreach ($posts->posts as $post) {
    echo get_the_title($post->ID);
    echo " | <a href='", get_permalink($post), "'>View</a>";
    echo " | <a href='", self::PAGE_URL_RATE, "&amp;id=$post->ID'>Label</a><br />";
}

?>

</div>

<?php

if ( $page_links )
	echo "<div class='tablenav-pages'>$page_links</div>";

    } // end function admin_list_posts_php()
}

/**
 * All labels are stored as serialized versions of this class.
 */
final class MiqroLabel {

    /**
     * @var int|string The label ID number
     */
    public $id = NULL;

    /**
     * @var string The name given by the user.
     */
    public $name = '';

    /**
     * @var string The rating module ID
     */
    public $system = '';

    /**
     * @var string The raw ratings in whatever format is needed by the module.
     */
    public $data = '';

    /**
     * @var string The label comments given by the user.
     */
    public $comments = '';

    /**
     * Aliases save_label().
     *
     * This method is public because some modules can't directly output labels,
     * so their dynamic data have to be maintained in the database.
     *
     * @param string $type 'static' or 'dynamic'
     */
    public function save($type = 'static') {
        global $miqrorate;

        $miqrorate->save_label($this, $type);
    }
}

/**
 * These objects represent the label meta records, as well as a label reference.
 *
 * See also parse_metas()
 */
final class MiqroPostRecord {

    /**
     * @var int The post ID
     */
    public $pid = 0;

    /**
     * @var int Time when the label was applied to this post.
     */
    public $timestamp = 0;

    /**
     * @var object The MiqroLabel corresponding to the ID in the postmeta record.
     */
    public $label;

    /**
     * Initializes all member variables.
     *
     * @param object $label
     * @param int $timestamp
     * @param int $pid
     */
    public function __construct(MiqroLabel $label, $timestamp, $pid = 0) {
        $this->pid = $pid;
        $this->timestamp = $timestamp;
        $this->label = $label;
    }
}

?>
