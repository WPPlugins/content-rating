<?php
/**
 * ICRA 2000 Module for the WordPress Content Rating Plugin
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

final class Miqro_icra2 extends MiqroRatingSystem {

    const NAME = 'ICRAv02';
    const SYSTEM_URL = 'http://www.icra.org/ratingsv02.html';
    const DESCRIPTION = 'An obsolete version of the ICRA specification.';
    const FILENAME = '';

    /**
     * Initializes all member variables of the parent class.
     */
    public function __construct() {
        $this->structure['n'] = array(
            'name' => 'Nudity and Sexual Material',
            'values' => array(
                'a' => array(
                    'name' => 'Erections or female genitals in detail',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Male genitals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'c' => array(
                    'name' => 'Female genitals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'd' => array(
                    'name' => 'Female breasts',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'e' => array(
                    'name' => 'Bare buttocks',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'f' => array(
                    'name' => 'Explicit sexual acts',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'g' => array(
                    'name' => 'Obscured or implied sexual acts',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'h' => array(
                    'name' => 'Visible sexual touching',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'i' => array(
                    'name' => 'Passionate kissing',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'r' => array(
                    'name' => 'Artistic Context Modifier',
                    'exclusive' => FALSE,
                    'description' => 'This material appears in an artistic context and is suitable for young children.'
                ),
                's' => array(
                    'name' => 'Educational Context Modifier',
                    'exclusive' => FALSE,
                    'description' => 'This material appears in an educational context and is suitable for young children.'
                ),
                't' => array(
                    'name' => 'Medical Context Modifier',
                    'exclusive' => FALSE,
                    'description' => 'This material appears in a medical context and is suitable for young children.'
                ),
                'z' => array(
                    'name' => 'None of the above',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['v'] = array(
            'name' => 'Violence',
            'values' => array(
                'a' => array(
                    'name' => 'Sexual violence / rape',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Blood and gore, human beings',
                    'exclusive' => FALSE,
                    'description' => 'The portrayal of blood splashing, pools of blood on the ground, objects or persons smeared or stained with blood.'
                ),
                'c' => array(
                    'name' => 'Blood and gore, animals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'd' => array(
                    'name' => 'Blood and gore, fantasy characters (including animation)',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'e' => array(
                    'name' => 'Killing of human beings',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'f' => array(
                    'name' => 'Killing of animals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'g' => array(
                    'name' => 'Killing of fantasy characters (including animation)',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'h' => array(
                    'name' => 'Deliberate injury to human beings',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'i' => array(
                    'name' => 'Deliberate injury to animals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'j' => array(
                    'name' => 'Deliberate injury to fantasy characters (including animation)',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'k' => array(
                    'name' => 'Deliberate damage to objects',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'r' => array(
                    'name' => 'Artistic Context Modifier',
                    'exclusive' => FALSE,
                    'description' => 'This material appears in an artistic context and is suitable for young children.'
                ),
                's' => array(
                    'name' => 'Educational Context Modifier',
                    'exclusive' => FALSE,
                    'description' => 'This material appears in an educational context and is suitable for young children.'
                ),
                't' => array(
                    'name' => 'Medical Context Modifier',
                    'exclusive' => FALSE,
                    'description' => 'This material appears in a medical context and is suitable for young children.'
                ),
                'u' => array(
                    'name' => 'Sports Context Modifier',
                    'exclusive' => FALSE,
                    'description' => 'Material that satisfy the criteria under '
                        .'violence, but appears only in a sports context, '
                        .'e.g. a site dedicated to boxing but does not contain '
                        .'other depictions of violence.'
                ),
                'z' => array(
                    'name' => 'None of the above',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['l'] = array(
            'name' => 'Language',
            'values' => array(
                'a' => array(
                    'name' => 'Explicit sexual language',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Crude words or profanity',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'c' => array(
                    'name' => 'Mild expletives',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'z' => array(
                    'name' => 'None of the above',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['o'] = array(
            'name' => 'Other Topics',
            'values' => array(
                'a' => array(
                    'name' => 'Promotion of tobacco use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Promotion of alcohol use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'c' => array(
                    'name' => 'Promotion of drug use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'd' => array(
                    'name' => 'Gambling',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'e' => array(
                    'name' => 'Promotion of weapon use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'f' => array(
                    'name' => 'Promotion of discrimination or harm against people',
                    'exclusive' => FALSE,
                    'description' => 'Promotion of discrimination or harm against '
                        .'any group or person by virtue of membership in a group or '
                        .'based on gender, sexual orientation or ethnic, religious '
                        .'or national identity. Discrimination in this context is '
                        .'defined as treating differently. This is a broad category '
                        .'including but not limited to, advocating ethnic supremacy, '
                        .'gender discrimination etc. The option allows you to mark '
                        .'expressions to which parents may choose not to expose '
                        .'their children.'
                ),
                'g' => array(
                    'name' => 'Material that might be perceived as setting a bad example for young children',
                    'exclusive' => FALSE,
                    'description' => 'This is a range of criteria often found in '
                        .'rating of film and may include a number of actions which '
                        .'depending on the context, could make it a concern for '
                        .'parents of young children. For example: picking locks, '
                        .'theft, urinating in public, bomb making, fraud, vandalism '
                        .'or violations of local customs / laws.'
                ),
                'h' => array(
                    'name' => 'Material that might disturb young children',
                    'exclusive' => FALSE,
                    'description' => 'This is a range of criteria often found in '
                        .'rating of film and may include a number of actions which '
                        .'depending on the context, could make it a concern for '
                        .'parents of young children. For example: material intended '
                        .'to invoke fear, horror, suicide, threats, humiliation, '
                        .'psychological terror, death, suffering, pain, punishment, '
                        .'bullying, abandonment, dramatic accidents, [confusing '
                        .'elements of] irony or parody.'
                ),
                'z' => array(
                    'name' => 'None of the above',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['c'] = array(
            'name' => 'Chat',
            'values' => array(
                'a' => array(
                    'name' => 'Unmoderated chat',
                    'exclusive' => FALSE,
                    'description' => 'If the site offers chat, this box should be '
                        .'checked unless the pages, branches or directory '
                        .'containing chat is labelled separately. Labelling '
                        .'branches or pages containing chat separately may be a '
                        .'good idea so children are not barred from otherwise '
                        .'useful material.'
                ),
                'b' => array(
                    'name' => 'Moderated chat suitable for children and teens',
                    'exclusive' => FALSE,
                    'description' => 'Note that this category does not say young '
                        .'children and includes teens. Checking this box is a '
                        .'positive statement that all chat that the label describes '
                        .'is both moderated and suitable for children. If some of '
                        .'the chat is unmoderated, do not check this checkbox.'
                ),
                'z' => array(
                    'name' => 'None of the above',
                    'exclusive' => TRUE,
                    'description' => 'This box should be only be checked if the '
                        .'site either does not contain chat rooms, or the page(s) '
                        .'or branch(es) containing chat are marked separately as '
                        .'containing chat.'
                )
            )
        );
    }

    // Properties
    public function name() {
        return self::NAME;
    }

    public function description() {
        return self::DESCRIPTION;
    }

    public function system_url() {
        return self::SYSTEM_URL;
    }

    // Methods

    /**
     * Returns the HTTP header for a specific label.
     *
     * @param object $record A MiqroPostRecord representing the label for the current page.
     * @return string The raw label header for the current page.
     */
    protected function make_http_header(MiqroPostRecord $record) {
        return $this->pics_header($record);
    }

    /**
     * Returns the HTML header for a specific label.
     *
     * @param object $record A MiqroPostRecord representing the label for the current page.
     * @return string The raw label header for the current page.
     */
    protected function make_html_header(MiqroPostRecord $record) {
        return $this->pics_meta_header($record);
    }

    /**
     * Converts raw data into an array of arrays.
     *
     * @param object $label
     * @return array of arrays having a [$key][*] => $value structure
     */
    public function get_data_from_label(MiqroLabel $label) {
        return $this->parse_data($label->data);
    }

    /**
     * Converts an array of arrays into raw data.
     *
     * @param array $data Having a [$key][*] => $value structure
     * @return string The value to be stored in $label->data
     */
    public function get_label_from_data(array $data) {
        $pairs = array();
        foreach($data as $code => $values) {
            if (count($values) > 0 and 'errors' != $code) {
                foreach($values as $value) {
                    $pairs[] = "$code$value 1";
                }
            }
        }
        return implode(' ', $pairs);
    }

    /**
     * Converts raw data into structured data.
     *
     * @param string $data The value retrieved from $label->data
     * @return array of arrays having a [$key][*] => $value structure
     */
    private function parse_data($data) {
        $results = array();

        $data = str_replace(' 1', '', $data);
        $data = explode(' ', $data);

        foreach($data as $pair) {
            $key = substr($pair, 0, 1);
            $value = substr($pair, 1);
            $results[$key][] = $value;
        }

        return $results;
    }

    /**
     * Dynamically generates a new label that is the result of taking the most
     * conservative (most severe) rating from each label.
     *
     * @param array $records An array of MiqroPostRecord objects that were generated by this type of MiqroRatingSystem.
     * @return object
     */
    protected function combine_ratings(array $records) {
        // Parse key, value pairs for all labels and take the max value of each key.
        $label = new MiqroLabel();
        $label->comments = 'Label dynamically generated.';
        $results = array();
        $data = array();
        $timestamp = 0;
        foreach($records as $record) {
            foreach($this->parse_data($record->label->data) as $code => $values) {
                foreach($values as $value) {
                    if (empty($results[$code])) {
                        $results[$code][] = $value;
                    } elseif (!in_array($value, $results[$code]) and !$this->structure[$code]['values'][$value]['exclusive']) {
                        if (1 == count($results[$code])) {
                            $existing = $results[$code][0];
                            if ($this->structure[$code]['values'][$existing]['exclusive']) {
                                $results[$code] = array();
                            }
                        }
                        $results[$code][] = $value;
                    }
                }
            }
            if ($record->timestamp > $timestamp) {
                $timestamp = $record->timestamp;
            }
        }
        $label->data = $this->get_label_from_data($results);
        $record = new MiqroPostRecord($label, $timestamp);
        return $record;
    }
}
?>