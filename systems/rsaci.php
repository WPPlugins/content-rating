<?php
/**
 * RSACi Module for the WordPress Content Rating Plugin
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

final class Miqro_rsaci extends MiqroRatingSystem {

    const NAME = 'RSACi';
    const SYSTEM_URL = 'http://www.rsac.org/ratingsv01.html';
    const DESCRIPTION = 'The system used by default in Internet Explorer versions 3 through 7.';
    const FILENAME = '';

    /**
     * Initializes all member variables of the parent class.
     */
    public function __construct() {
        $this->structure['v'] = array(
            'name' => 'Violence',
            'values' => array(
                '0' => array(
                    'name' => 'No violence',
                    'exclusive' => TRUE,
                    'description' => 'No aggressive violence; no natural or accidental violence.'
                ),
                '1' => array(
                    'name' => 'Fighting',
                    'exclusive' => TRUE,
                    'description' => 'Creatures injured or killed; damage to realistic objects.'
                ),
                '2' => array(
                    'name' => 'Killing',
                    'exclusive' => TRUE,
                    'description' => 'Humans or creatures injured or killed. Rewards injuring non-threatening creatures.'
                ),
                '3' => array(
                    'name' => 'Killing with blood and gore',
                    'exclusive' => TRUE,
                    'description' => 'Humans injured or killed.'
                ),
                '4' => array(
                    'name' => 'Wanton and gratuitous violence',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['s'] = array(
            'name' => 'Sex',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No sexual activity portrayed. Romance.'
                ),
                '1' => array(
                    'name' => 'Passionate kissing',
                    'exclusive' => TRUE,
                    'description' => 'This includes any kissing during which '
                        .'tongues touch (or mouths are obviously open), and any '
                        .'kissing on, but not limited to, the neck, torso, breasts, '
                        .'buttocks, legs.'
                ),
                '2' => array(
                    'name' => 'Clothed sexual touching',
                    'exclusive' => TRUE,
                    'description' => 'Groping, petting, licking, rubbing.'
                ),
                '3' => array(
                    'name' => 'Non-explicit sexual touching',
                    'exclusive' => TRUE,
                    'description' => 'Groping, petting, licking, and rubbing, '
                        .'that falls short of intercourse (sexual, oral, or '
                        .'otherwise), and that DOES show bare buttocks or female '
                        .'breasts, but DOES NOT show genitalia.'
                ),
                '4' => array(
                    'name' => 'Explicit sexual activity',
                    'exclusive' => TRUE,
                    'description' => 'Masturbation and sexual intercourse of any kind.'
                )
            )
        );
        $this->structure['n'] = array(
            'name' => 'Nudity',
            'values' => array(
                '0' => array(
                    'name' => 'None',
                    'exclusive' => TRUE,
                    'description' => 'No nudity.'
                ),
                '1' => array(
                    'name' => 'Revealing attire',
                    'exclusive' => TRUE,
                    'description' => 'Portrays outlines through tight clothing, '
                        .'or clothing that otherwise emphasizes male or female '
                        .'genitalia, female nipples or breasts (including the '
                        .'display of cleavage that is more than one half of the '
                        .'possible length of such cleavage), or clothing on a male '
                        .'or female which a reasonable person would consider to be '
                        .'sexually suggestive and alluring.'
                ),
                '2' => array(
                    'name' => 'Partial nudity',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '3' => array(
                    'name' => 'Frontal nudity',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '4' => array(
                    'name' => 'Provocative frontal nudity',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['l'] = array(
            'name' => 'Language',
            'values' => array(
                '0' => array(
                    'name' => 'No profanity',
                    'exclusive' => TRUE,
                    'description' => 'Inoffensive slang.'
                ),
                '1' => array(
                    'name' => 'Mild expletives',
                    'exclusive' => TRUE,
                    'description' => 'Hell, damn, ass and horse\'s ass, butthead and buttface'
                ),
                '2' => array(
                    'name' => 'Moderate expletives',
                    'exclusive' => TRUE,
                    'description' => 'Bastard, son-of-a-bitch, bitch, turd, crap.'
                ),
                '3' => array(
                    'name' => 'Obscene gestures',
                    'exclusive' => TRUE,
                    'description' => 'Flipping the bird, mooning, non-verbal '
                        .'indications of sexual insult, etc., indicating any of '
                        .'the above. Any visual or described innuendo, euphemisms, '
                        .'street slang, double-entendre for any of the above.'
                ),
                '4' => array(
                    'name' => 'Explicit or crude language',
                    'exclusive' => TRUE,
                    'description' => 'Fuck, bugger, mother-fucker, cock-sucker, penis-breath, prick, cock, pussy, twat, cunt, etc.'
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
        foreach($this->structure as $code => $group) {
            $pos = strpos($data, $code.' ');
            if (FALSE !== $pos) {
                $value = substr($data, $pos + strlen($code) + 1, 1);
                if (is_numeric($value)) {
                    $results[$code] = $value;
                }
            }
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