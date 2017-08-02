<?php
/**
 * Abstract Module for the WordPress Content Rating Plugin
 *
 * @copyright Copyright � 2010 by Robert Chapin
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

abstract class MiqroRatingSystem {

    // Properties

    /**
     * @var array The $structure data type is arbitrary, however it should
     * conform to the [$key]['values'][$key]['name'] format whenever possible.
     */
    protected $structure;

    /**
     * Returns the human name of the concrete module.  Must override.
     *
     * @return string
     */
    abstract public function name();

    /**
     * Returns the long description of the concrete module.  Must override.
     *
     * @return string
     */
    abstract public function description();

    /**
     * Returns the machine name of the concrete module.  Must override.
     *
     * @return string
     */
    abstract public function system_url();


    // Methods

    /**
     * Writes a new label file to disk after save_label().  Optional override.
     *
     * @param array $labels All of the label objects for this module.
     */
    public function flush_label_file(array $labels) {
        return;
    }

    /**
     * Check permissions, then call a concrete method.  No override.
     */
    final public function uninstall() {
        if (!current_user_can('activate_plugins')) wp_die('Unexpected permissions fault in the Content Rating Plugin.');
        $this->do_uninstall();
    }

    /**
     * Do any module-specific tasks to uninstall.  Optional override.
     *
     * The module is responsible for deleting non-volatile data such as label files.
     */
    protected function do_uninstall() {
        return;
    }

    /**
     * Returns the HTTP header for a specific label.  Must override.
     *
     * @since 1.1.0
     * @param object $record A MiqroPostRecord representing the label for the current page.
     * @return string The raw label header for the current page.
     */
    abstract protected function make_http_header(MiqroPostRecord $record);

    /**
     * Returns the HTML header for a specific label.  Must override.
     *
     * @since 1.1.0
     * @param object $record A MiqroPostRecord representing the label for the current page.
     * @return string The raw label header for the current page.
     */
    abstract protected function make_html_header(MiqroPostRecord $record);

    /**
     * Returns the structured data of a label.  Must override.
     *
     * @param object $label
     * @return array of arrays having a [$key][*] => $value structure if possible
     */
    abstract public function get_data_from_label(MiqroLabel $label);

    /**
     * Returns the raw data of a label.  Must override.
     *
     * @param array $data arrays having a [$key][*] => $value structure if possible
     * @return string The raw rating data in whatever format needed by the module.  Same as $label->data.
     */
    abstract public function get_label_from_data(array $data);

    /**
     * Returns a new label representing the most conservative (severe) combination of multiple labels. Must override.
     *
     * @since 1.1.0
     * @param array $records An array of MiqroPostRecord objects that were generated by this MiqroRatingSystem.
     * @return object A single MiqroPostRecord.
     */
    abstract protected function combine_ratings(array $records);

    /**
     * Returns an instance of the concrete module object.  No override.
     *
     * @param string $type The module ID, which must be the same as the filename and the class name suffix.
     * @return object
     */
    final public static function factory($type) {
        $filename = dirname(__FILE__) . '/systems/' . $type . '.php';

        if (file_exists($filename)) {
            if (include_once($filename)) {
                $classname = 'Miqro_' . $type;
                return new $classname;
            }
        }
        throw new Exception('Rating system not found');
    }

    /**
     * Returns the HTTP header for a given set of labels.  No override.
     *
     * @param array $labels An array of MiqroPostRecord objects representing the label(s) of one or more posts on the current page.
     * @return string The raw label header corresponding to a single static label, or a dynamically generated label resulting from the combination of labels.
     */
    final public function get_http_header(array $labels) {
        if (1 == count($labels)) {
            $record = $labels[0];
        } else {
            $record = $this->combine_ratings($labels);
        }

        return $this->make_http_header($record);
    }

    /**
     * Returns the HTML header for a given set of labels.  Must override.
     *
     * @since 1.1.0
     * @param array $labels An array of MiqroPostRecord objects representing the label(s) of one or more posts on the current page.
     * @return string The raw label header corresponding to a single static label, or a dynamically generated label resulting from the combination of labels.
     */
    final public function get_html_header(array $labels) {
        if (1 == count($labels)) {
            $record = $labels[0];
        } else {
            $record = $this->combine_ratings($labels);
        }

        return $this->make_html_header($record);
    }

    /**
     * Filters and validates all label inputs against the system structure.  Optional override.
     *
     * @return array of arrays having a [$key][*] => $value structure, plus 'errors'.
     */
    public function get_data_from_post() {
        $data = array();
        $data['errors'] = array();
        foreach($this->structure as $key => $group) {
            $data[$key] = array();
            if (isset($_POST[$key])) {
                if (is_array($_POST[$key])) {
                    if (0 == count($_POST[$key])) {
                        if (empty($group['optional'])) {
                            $data['errors'][] = 'Nothing was selected for '.$group['name'];
                        }
                    } else {
                        $valid = 0;
                        $exclusive = 0;
                        foreach($_POST[$key] as $value) {
                            if (is_string($value)) {
                                if (isset($group['values'][$value])) {
                                    $valid++;
                                    if ($group['values'][$value]['exclusive']) $exclusive++;
                                }
                            }
                        }
                        switch($valid) {
                        case 0:
                            $data['errors'][] = 'Input not understood for '.$group['name'];
                            break;
                        case 1:
                            if (1 == count($_POST[$key])) {
                                $data[$key] = $_POST[$key];
                            } else {
                                $data['errors'][] = 'Input not understood for '.$group['name'];
                            }
                            break;
                        default:
                            if (0 == $exclusive and count($_POST[$key]) == $valid) {
                                $data[$key] = $_POST[$key];
                            } else {
                                $data['errors'][] = 'The combination of selections was not valid for '.$group['name'];
                            }
                        }
                    }
                } else {
                    $data['errors'][] = 'Input not understood for '.$group['name'];
                }
            } elseif (empty($group['optional'])) {
                $data['errors'][] = 'Nothing was selected for '.$group['name'];
            }
        }
        return $data;
    }

    /**
     * Returns the XHTML of the label editing form inputs.  Optional override.
     *
     * @param object $label The saved values, or the most recent inputs in case of a user error.
     * @return string The label form details, with default values pre-filled.
     */
    public function get_label_form(MiqroLabel $label) {
        $form = '';
        $data = $this->get_data_from_label($label);
        foreach($this->structure as $key => $group) {
            $mixable = 0;
            foreach($group['values'] as $value => $detail) {
                if (!$detail['exclusive']) $mixable++;
            }
            if ($mixable >= 2) {
                $input_type = 'checkbox';
            } else {
                $input_type = 'radio';
            }

            $form .= "<h3>{$group['name']}</h3>\n"
                   . '<table class="widefat">'
           	       . '<thead><tr>';

            if ('checkbox' == $input_type) {
                $form .= '<th scope="col" class="check-column"><input type="checkbox" name="check-all" /></th>';
            } else {
                $form .= '<th scope="col"></th>';
            }

            $form .= '<th scope="col">Rating</th>'
            	   . '<th scope="col">Description</th>'
            	   . '</tr></thead>'
            	   . '<tbody>';

            $current = isset($data[$key]) ? $data[$key] : array();
            foreach($group['values'] as $value => $detail) {
                $checked = (in_array($value, $current)) ? 'checked="checked"' : '';

                $form .= '<tr>'
                       . '<th scope="row" class="check-column"><input type="'.$input_type.'" name="'.$key.'[]" value="'.$value.'" '.$checked.' /></th>'
                       . '<td>'.$detail['name'].'</td>'
                       . '<td>'.$detail['description'].'</td>'
                       . '</tr>';

            }

            $form .= '</tbody></table>';
        }
        return $form;
    }

    /**
     * Returns a human-readable XHTML version of the label.  Optional override.
     *
     * @param object $label
     * @return string The label details.
     */
    public function get_label_view(MiqroLabel $label) {
        $form = '';
        $data = $this->get_data_from_label($label);
        $form .= '<table class="widefat">'
       	       . '<thead><tr>'
               . ' <th scope="col">Category</th>'
        	   . ' <th scope="col">Rating(s)</th>'
        	   . '</tr></thead>'
        	   . '<tbody>';

        foreach($this->structure as $key => $group) {
            $form .= '<tr><td>'.$group['name'].'</td>';
            $values = array();
            foreach($data[$key] as $value) {
                $values[] = $group['values'][$value]['name'];
            }
            $form .= '<td>'.implode("<br />\n", $values).'</td></tr>';
        }

        $form .= '</tbody></table>';

        return $form;
    }

    /**
     * Handles PICS Protocol requests and responses.  No override.
     *
     * @param array $headers All of the headers generated by all modules.
     * @param array $active_services List of machine names of all active modules.
     * @return array The consolidated HTTP header(s)
     */
    final public function combine_pics_headers(array $headers, array $active_services) {
        $pics = array();
        $notpics = array();
        $start = 'PICS-Label: (PICS-1.1 ';
        $end = ')';

        // Separate the PICS and non-PICS headers.
        foreach($headers as $header) {
            if (substr($header, 0, strlen($start)) == $start) {
                $pics[] = substr($header, strlen($start), -strlen($end));
            } else {
                $notpics[] = $header;
            }
        }

        // Check for PICS Protocol requests
        $result = $this->pics_query();
        if ($result) {
            $notpics[] = 'Protocol: {PICS-1.1 {headers PICS-Label}}';
            $labels = array();
            $services = array();

            // Filter PICS labels by the list of requested services.
            foreach($pics as $label) {
                $pos = strpos($label, '"', 1);
                $service = substr($label, 1, $pos - 1);
                $services[] = $service;
                if (in_array($service, $result['services'])) {
                    $labels[] = $label;
                }
            }

            // Throw errors for requests not filled.
            foreach($result['services'] as $service) {
                if (!in_array($service, $services)) {
                    $url = preg_replace('/["\\r\\n\\0\\\\]/', '', $service);
                    if (in_array($service, $active_services)) {
                        $labels[] = '"' . $url . '" l error (not-labeled)';
                    } else {
                        $labels[] = '"' . $url . '" error (service-unavailable)';
                    }
                }
            }

            $pics =& $labels;
            unset($labels, $services);
        }

        // Consolidate all PICS labels into one header and add it to the list of other headers.
        if (count($pics) > 0) {
            $notpics[] = $start . implode(' ', $pics) . $end;
        }

        return $notpics;
    }

    /**
     * Handles PICS meta headers.  No override.
     *
     * @param array $headers All of the headers generated by all modules.
     * @return array The consolidated HTML header(s)
     */
    final public function combine_html_headers(array $headers) {
        $pics = array();
        $notpics = array();
        $start = "<meta http-equiv='PICS-Label' content='(PICS-1.1 ";
        $end = ")' />";

        // Separate the PICS and non-PICS headers.
        foreach($headers as $header) {
            if (substr($header, 0, strlen($start)) == $start) {
                $pics[] = substr($header, strlen($start), -strlen($end));
            } else {
                $notpics[] = $header;
            }
        }

        // Consolidate all PICS labels into one header and add it to the list of other headers.
        if (count($pics) > 0) {
            $notpics[] = $start . implode(' ', $pics) . $end;
        }

        return $notpics;
    }

    /**
     * Creates a single PICS-Label header from a single label record.  No override.
     *
     * This is a common label header format, the specifics of which did not fall
     * within the scope of the plugin class itself.  Modules that do no use the
     * PICS protocol should define a private function to handle the single-
     * record-to-single-header conversion internally.
     *
     * @param object $record
     * @return string
     */
    final protected function pics_header(MiqroPostRecord $record) {
        $options = '';
        $result = $this->pics_query();
        if ($result) {
            $detail = $result['completeness'];
        } else {
            $detail = 'minimal';
        }
        switch($detail) {
        case 'full':
        case 'signed':
            $comment = preg_replace('/["\\r\\n\\0\\\\]/', '', $record->label->comments);
            $options .= 'gen false ';
            if (0 != strlen($comment)) {
                $options .= 'comment "'. $comment .'" ';
            }
        case 'short':
            $options .= 'on "'. gmstrftime('%Y.%m.%dT%H:%M-0000', $record->timestamp) .'" ';
        case 'minimal':
        default:
            $header = 'PICS-Label: (PICS-1.1 "'.$this->system_url().'" l '.$options.'r ('.$record->label->data.'))';
        }
        return $header;
    }

    /**
     * Creates a single PICS-Label header from a single label record.  No override.
     *
     * This is a common label header format, the specifics of which did not fall
     * within the scope of the plugin class itself.  Modules that do no use the
     * PICS protocol should define a private function to handle the single-
     * record-to-single-header conversion internally.
     *
     * @since 1.1.0
     * @param object $record
     * @return string
     */
    final protected function pics_meta_header(MiqroPostRecord $record) {
        return '<meta http-equiv=\'PICS-Label\' content=\'(PICS-1.1 "'.$this->system_url().'" l r ('.$record->label->data.'))\' />';
    }

    /**
     * Parses PICS Protocol headers.
     *
     * @return array|bool Array with 'completeness' param and the list of machine-named 'services' requested.
     */
    private function pics_query() {
        static $result;
        if (isset($result)) return $result;

        if (isset($_SERVER['HTTP_PROTOCOL_REQUEST'])) {
            $request = strtolower(stripslashes($_SERVER['HTTP_PROTOCOL_REQUEST']));
            $start = '{pics-1.1 {params ';
            $middle = 'services "';
            $end = '"}}}';
            $result = array();
            if (substr($request, 0, strlen($start)) == $start) {
                $pos = strpos($request, $middle);
                $pos2 = strpos($request, $end);
                if (FALSE !== $pos and FALSE !== $pos2) {
                    if (FALSE !== strpos($request, 'params short')) {
                        $result['completeness'] = 'short';
                    } elseif (FALSE !== strpos($request, 'params full')) {
                        $result['completeness'] = 'full';
                    } elseif (FALSE !== strpos($request, 'params signed')) {
                        $result['completeness'] = 'signed';
                    } else {
                        $result['completeness'] = 'minimal';
                    }

                    $request = stripslashes($_SERVER['HTTP_PROTOCOL_REQUEST']);
                    $services = substr($request, $pos + strlen($middle), $pos2 - strlen($request));
                    if (FALSE !== strpos($services, '"')) {
                        $result['services'] = explode('" "', $services);
                    } else {
                        $result['services'] = array($services);
                    }
                    if (count($result['services']) < 10) { // sanity check
                        return $result;
                    }
                }
            }
        }
        return FALSE;
    }
}
?>