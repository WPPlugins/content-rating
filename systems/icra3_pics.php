<?php
/**
 * ICRA 2005 Legacy Module for the WordPress Content Rating Plugin
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

final class Miqro_icra3_pics extends MiqroRatingSystem {

    const NAME = 'ICRAv03 Legacy';
    const SYSTEM_URL = 'http://www.icra.org/pics/vocabularyv03/';
    const DESCRIPTION = 'The system used by default in Internet Explorer version 8.';
    const FILENAME = '';

    /**
     * Initializes all member variables of the parent class.
     */
    public function __construct() {
        $this->structure['n'] = array(
            'name' => 'Nudity',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No bare buttocks, breasts or genitals in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Bare buttocks and/or bare breasts in '
                        .'artistic, medical, educational, sports or news context. '
                        .'No genitals in any context.'
                ),
                '2' => array(
                    'name' => 'Some',
                    'exclusive' => TRUE,
                    'description' => 'Bare buttocks and/or bare breasts in any '
                        .'context, genitals only in artistic, medical, educational, '
                        .'sports or news context.'
                ),
                '3' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Nudity of any kind in any context, although '
                        .'this does not imply sexual content which is described '
                        .'separately.'
                )
            )
        );
        $this->structure['s'] = array(
            'name' => 'Sexual Material',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No passionate kissing, obscured or implied '
                        .'sexual acts, visible sexual touching, explicit sexual '
                        .'language, erections, explicit sexual acts or erotica in '
                        .'any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Obscured or implied sexual acts and visible '
                        .'sexual touching in an artistic, medical, educational, '
                        .'sports or news context. Passionate kissing in any '
                        .'context. No explicit sexual content in any context.'
                ),
                '2' => array(
                    'name' => 'Some',
                    'exclusive' => TRUE,
                    'description' => 'Obscured or implied sexual acts, visible '
                        .'sexual touching, and passionate kissing in any context. '
                        .'Explicit sexual context or erotica in artistic, medical, '
                        .'educational, sports or news context only.'
                ),
                '3' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Sexual material of any kind, in any '
                        .'context, although this does not include sexual violence, '
                        .'which is described separately.'
                )
            )
        );
        $this->structure['v'] = array(
            'name' => 'Violence',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No assault/rape; no injury, torture, '
                        .'killing or blood and dismemberment of humans, animals or '
                        .'fantasy characters (including animation) in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Injury, torture, killing or blood and '
                        .'dismemberment of fantasy characters only in artistic, '
                        .'medical, educational, sports or news context. None of '
                        .'aforementioned of humans or animals in any context. '
                        .'No assault/rape.'
                ),
                '2' => array(
                    'name' => 'Some',
                    'exclusive' => TRUE,
                    'description' => 'Injury, torture, killing or blood and '
                        .'dismemberment of fantasy characters in any context. '
                        .'That of humans or animals in artistic, medical, '
                        .'educational, sports or news context only. '
                        .'No assault/rape.'
                ),
                '3' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Violence of any kind in any context, including assault/rape.'
                )
            )
        );
        $this->structure['l'] = array(
            'name' => 'Language',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No abusive or vulgar terms, no profanity or swearing, no mild expletives in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'No abusive or vulgar terms in any context. '
                        .'Profanity, swearing, or mild expletives only in artistic, '
                        .'medical, educational, sports or news context.'
                ),
                '2' => array(
                    'name' => 'Some',
                    'exclusive' => TRUE,
                    'description' => 'Abusive or vulgar terms only in artistic, '
                        .'medical, educational, sports or news context.  Crude '
                        .'words, profanity or mild expletives in any context.'
                ),
                '3' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Abusive or vulgar terms, profanity, '
                        .'swearing, or mild expletives in any context, although '
                        .'this does not include sexual language, which is described '
                        .'separately.'
                )
            )
        );
        $this->structure['oa'] = array(
            'name' => 'Depiction of tobacco use',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No depiction of tobacco use in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of tobacco use only in artistic, medical, educational, sports or news context.'
                ),
                '2' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of tobacco use in any context.'
                )
            )
        );
        $this->structure['ob'] = array(
            'name' => 'Depiction of alcohol use',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No depiction of alcohol use in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of alcohol use only in artistic, medical, educational, sports or news context.'
                ),
                '2' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of alcohol use in any context.'
                )
            )
        );
        $this->structure['oc'] = array(
            'name' => 'Depiction of drug use',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No depiction of drug use in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of drug use only in artistic, medical, educational, sports or news context.'
                ),
                '2' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of drug use in any context.'
                )
            )
        );
        $this->structure['od'] = array(
            'name' => 'Depiction of weapon use',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No depiction of weapon use in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of weapon use only in artistic, medical, educational, sports or news context.'
                ),
                '2' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of weapon use in any context.'
                )
            )
        );
        $this->structure['oe'] = array(
            'name' => 'Depiction of gambling',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No depiction of gambling in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of gambling only in artistic, medical, educational, or news context.'
                ),
                '2' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Depiction of gambling in any context.'
                )
            )
        );
        $this->structure['of'] = array(
            'name' => 'Content that sets a bad example for young children',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No content that sets a bad example for '
                        .'young children, teaching or encouraging children to '
                        .'perform harmful acts or imitate dangerous behaviour in '
                        .'any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Content that sets a bad example for young '
                        .'children, teaching or encouraging children to perform '
                        .'harmful acts or imitate dangerous behaviour, in artistic, '
                        .'medical, educational, sports or news context only.'
                ),
                '2' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Content that sets a bad example for young '
                        .'children, teaching or encouraging children to perform '
                        .'harmful acts or imitate dangerous behaviour, in any '
                        .'context.'
                )
            )
        );
        $this->structure['og'] = array(
            'name' => 'Content that creates fear, intimidation, etc.',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No content that creates fear, intimidation, etc. in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Content that creates feelings of fear, '
                        .'intimidation, etc. only in artistic, medical, '
                        .'educational, sports or news context.'
                ),
                '2' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Content that creates feelings of fear, intimidation, etc. in any context.'
                )
            )
        );
        $this->structure['oh'] = array(
            'name' => 'Incitement/depiction of discrimination or harm',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No incitement/depiction of discrimination or harm in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Incitement/depiction of discrimination or '
                        .'harm in artistic, medical, educational, sports or news '
                        .'context only.'
                ),
                '2' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Incitement/depiction of discrimination or harm in any context.'
                )
            )
        );
        $this->structure['c'] = array(
            'name' => 'User-generated content',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No user-generated content such as chat rooms and message boards in any context.'
                ),
                '1' => array(
                    'name' => 'Limited',
                    'exclusive' => TRUE,
                    'description' => 'Moderated user-generated content such as chat rooms and message boards in any context.'
                ),
                '2' => array(
                    'name' => 'Some',
                    'exclusive' => TRUE,
                    'description' => 'Moderated user-generated content in any '
                        .'context. Unmoderated user-generated content only in '
                        .'artistic, medical, educational, sports or news context.'
                ),
                '3' => array(
                    'name' => 'Unrestricted',
                    'exclusive' => TRUE,
                    'description' => 'Unmoderated user-generated content such as chat rooms and message boards in any context.'
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
        $data = array();
        foreach($this->parse_data($label->data) as $code => $value) {
            $data[$code][] = $value;
        }
        return $data;
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
                $pairs[] = "$code {$values[0]}";
            }
        }
        return implode(' ', $pairs);
    }

    /**
     * Converts raw data into an array of $code => $value pairs.
     *
     * @param string $data The value retrieved from $label->data
     * @return array
     */
    private function parse_data($data) {
        $results = array();

        // Use regexp to avoid confusion between 'c' and 'oc' keys.
        preg_match_all("@[a-z]{1,2} \\d@", $data, $matches);

        foreach($matches[0] as $pair) {
            $key = substr($pair, 0, -2);
            $value = substr($pair, -1);
            $results[$key] = $value;
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
            foreach($this->parse_data($record->label->data) as $code => $value) {
                if (!isset($results[$code])) {
                    $results[$code] = $value;
                } elseif ($results[$code] < $value) {
                    $results[$code] = $value;
                }
            }
            if ($record->timestamp > $timestamp) {
                $timestamp = $record->timestamp;
            }
        }
        foreach($results as $code => $value) {
            $data[] = "$code $value";
        }
        $label->data = implode(' ', $data);
        $record = new MiqroPostRecord($label, $timestamp);
        return $record;
    }
}
?>