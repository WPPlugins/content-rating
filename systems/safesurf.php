<?php
/**
 * SafeSurf Module for the WordPress Content Rating Plugin
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

final class Miqro_safesurf extends MiqroRatingSystem {

    const NAME = 'SafeSurf';
    const SYSTEM_URL = 'http://www.classify.org/safesurf/';
    const DESCRIPTION = 'An early specification that may be recognized by standards-compliant software.';
    const FILENAME = '';

    /**
     * Initializes all member variables of the parent class.
     */
    public function __construct() {
        $this->structure['SS~~000'] = array(
            'name' => 'Age Range',
            'values' => array(
                '1' => array(
                    'name' => 'All Ages',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '2' => array(
                    'name' => 'Older Children',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '3' => array(
                    'name' => 'Younger Teens',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '4' => array(
                    'name' => 'Older Teens',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '5' => array(
                    'name' => 'Adult Supervision Recommended',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '6' => array(
                    'name' => 'Adults',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '7' => array(
                    'name' => 'Limited to Adults',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '8' => array(
                    'name' => 'Adults Only',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '9' => array(
                    'name' => 'Explicitly for Adults',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['SS~~001'] = array(
            'name' => 'Profanity',
            'values' => array(
                '0' => array(
                    'name' => 'No Profanity.',
                    'exclusive' => TRUE,
                    'description' => 'Appropriate for all audiences.'
                ),
                '1' => array(
                    'name' => 'Subtle Innuendo',
                    'exclusive' => TRUE,
                    'description' => 'Subtly Implied through the use of Slang.'
                ),
                '2' => array(
                    'name' => 'Strong Innuendo',
                    'exclusive' => TRUE,
                    'description' => 'Expressly implied through the use of Slang.'
                ),
                '3' => array(
                    'name' => 'Technical Reference',
                    'exclusive' => TRUE,
                    'description' => 'Dictionary, encyclopedic, news, technical references.'
                ),
                '4' => array(
                    'name' => 'Non-Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => 'Limited non-sexual expletives used in a artistic fashion.'
                ),
                '5' => array(
                    'name' => 'Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => 'Non-sexual expletives used in a artistic fashion.'
                ),
                '6' => array(
                    'name' => 'Graphic',
                    'exclusive' => TRUE,
                    'description' => 'Limited use of expletives and obscene gestures.'
                ),
                '7' => array(
                    'name' => 'Detailed Graphic',
                    'exclusive' => TRUE,
                    'description' => 'Casual use of expletives and obscene gestures.'
                ),
                '8' => array(
                    'name' => 'Explicit Vulgarity',
                    'exclusive' => TRUE,
                    'description' => 'Heavy use of vulgar language and obscene gestures. Unsupervised Chat Rooms.'
                ),
                '9' => array(
                    'name' => 'Explicit and Crude',
                    'exclusive' => TRUE,
                    'description' => 'Saturated with crude sexual references and gestures. Unsupervised Chat Rooms.'
                )
            )
        );
        $this->structure['SS~~002'] = array(
            'name' => 'Heterosexual Themes',
            'values' => array(
                '0' => array(
                    'name' => 'No Heterosexual Themes',
                    'exclusive' => TRUE,
                    'description' => 'Appropriate for all audiences.'
                ),
                '1' => array(
                    'name' => 'Subtle Innuendo',
                    'exclusive' => TRUE,
                    'description' => 'Subtly Implied through the use of metaphor.'
                ),
                '2' => array(
                    'name' => 'Strong Innuendo',
                    'exclusive' => TRUE,
                    'description' => 'Explicitly implied (not described) through the use of metaphor.'
                ),
                '3' => array(
                    'name' => 'Technical Reference',
                    'exclusive' => TRUE,
                    'description' => 'Dictionary, encyclopedic, news, medical references.'
                ),
                '4' => array(
                    'name' => 'Non-Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => 'Limited metaphoric descriptions used in a artistic fashion.'
                ),
                '5' => array(
                    'name' => 'Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => 'Metaphoric descriptions used in a artistic fashion.'
                ),
                '6' => array(
                    'name' => 'Graphic',
                    'exclusive' => TRUE,
                    'description' => 'Descriptions of intimate sexual acts.'
                ),
                '7' => array(
                    'name' => 'Detailed Graphic',
                    'exclusive' => TRUE,
                    'description' => 'Descriptions of intimate details of sexual acts.'
                ),
                '8' => array(
                    'name' => 'Explicit Vulgarity',
                    'exclusive' => TRUE,
                    'description' => 'Explicit Descriptions of intimate details of sexual acts designed to arouse. Inviting interactive sexual participation. Unsupervised Sexual Chat Rooms or Newsgroups.'
                ),
                '9' => array(
                    'name' => 'Explicit and Crude',
                    'exclusive' => TRUE,
                    'description' => 'Profane Graphic Descriptions of intimate details of sexual acts designed to arouse. Inviting interactive sexual participation.  Unsupervised Sexual Chat Rooms or Newsgroups.'
                )
            )
        );
        $this->structure['SS~~003'] = array(
            'name' => 'Homosexual Themes',
            'values' => array(
                '0' => array(
                    'name' => 'No Homosexual Themes',
                    'exclusive' => TRUE,
                    'description' => 'Appropriate for all audiences.'
                ),
                '1' => array(
                    'name' => 'Subtle Innuendo',
                    'exclusive' => TRUE,
                    'description' => 'Subtly Implied through the use of metaphor.'
                ),
                '2' => array(
                    'name' => 'Strong Innuendo',
                    'exclusive' => TRUE,
                    'description' => 'Explicitly implied (not described) through the use of metaphor.'
                ),
                '3' => array(
                    'name' => 'Technical Reference',
                    'exclusive' => TRUE,
                    'description' => 'Dictionary, encyclopedic, news, medical references.'
                ),
                '4' => array(
                    'name' => 'Non-Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => 'Limited metaphoric descriptions used in a artistic fashion.'
                ),
                '5' => array(
                    'name' => 'Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => 'Metaphoric descriptions used in a artistic fashion.'
                ),
                '6' => array(
                    'name' => 'Graphic',
                    'exclusive' => TRUE,
                    'description' => 'Descriptions of intimate sexual acts.'
                ),
                '7' => array(
                    'name' => 'Detailed Graphic',
                    'exclusive' => TRUE,
                    'description' => 'Descriptions of intimate details of sexual acts.'
                ),
                '8' => array(
                    'name' => 'Explicit Vulgarity',
                    'exclusive' => TRUE,
                    'description' => 'Explicit Descriptions of intimate details of sexual acts designed to arouse. Inviting interactive sexual participation. Unsupervised Sexual Chat Rooms or Newsgroups.'
                ),
                '9' => array(
                    'name' => 'Explicit and Crude',
                    'exclusive' => TRUE,
                    'description' => 'Profane Graphic Descriptions of intimate details of sexual acts designed to arouse. Inviting interactive sexual participation.  Unsupervised Sexual Chat Rooms or Newsgroups.'
                )
            )
        );
        $this->structure['SS~~004'] = array(
            'name' => 'Nudity',
            'values' => array(
                '0' => array(
                    'name' => 'No Nudity',
                    'exclusive' => TRUE,
                    'description' => 'Appropriate for all audiences.'
                ),
                '1' => array(
                    'name' => 'Subtle Innuendo',
                    'exclusive' => TRUE,
                    'description' => 'Subtly Implied through the use of composition, lighting, shaping, revealing clothing, etc.'
                ),
                '2' => array(
                    'name' => 'Strong Innuendo',
                    'exclusive' => TRUE,
                    'description' => 'Explicitly implied (not shown) through the use of composition, lighting, shaping or revealing clothing.'
                ),
                '3' => array(
                    'name' => 'Technical Reference',
                    'exclusive' => TRUE,
                    'description' => 'Dictionary, encyclopedic, news, medical references.'
                ),
                '4' => array(
                    'name' => 'Non-Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => 'Classic works of art presented in public museums for family viewing.'
                ),
                '5' => array(
                    'name' => 'Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => 'Artistically presented without full frontal nudity.'
                ),
                '6' => array(
                    'name' => 'Graphic',
                    'exclusive' => TRUE,
                    'description' => 'Artistically presented with frontal nudity.'
                ),
                '7' => array(
                    'name' => 'Detailed Graphic',
                    'exclusive' => TRUE,
                    'description' => 'Erotic frontal nudity.'
                ),
                '8' => array(
                    'name' => 'Explicit Vulgarity',
                    'exclusive' => TRUE,
                    'description' => 'Detailed provocative presentation.'
                ),
                '9' => array(
                    'name' => 'Explicit and Crude',
                    'exclusive' => TRUE,
                    'description' => 'Explicit pornographic presentation.'
                )
            )
        );
        $this->structure['SS~~005'] = array(
            'name' => 'Violence',
            'values' => array(
                '0' => array(
                    'name' => 'No Violence',
                    'exclusive' => TRUE,
                    'description' => 'Appropriate for all audiences.'
                ),
                '1' => array(
                    'name' => 'Subtle Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '2' => array(
                    'name' => 'Strong Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '3' => array(
                    'name' => 'Technical Reference',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '4' => array(
                    'name' => 'Non-Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '5' => array(
                    'name' => 'Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '6' => array(
                    'name' => 'Graphic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '7' => array(
                    'name' => 'Detailed Graphic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '8' => array(
                    'name' => 'Inviting Participation in Graphic Interactive Format',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '9' => array(
                    'name' => 'Encouraging Personal Participation, Weapon Making',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['SS~~007'] = array(
            'name' => 'Intolerance',
            'values' => array(
                '0' => array(
                    'name' => 'No Intolerance',
                    'exclusive' => TRUE,
                    'description' => 'Appropriate for all audiences.'
                ),
                '1' => array(
                    'name' => 'Subtle Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '2' => array(
                    'name' => 'Strong Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '3' => array(
                    'name' => 'Technical Reference',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '4' => array(
                    'name' => 'Non-Graphic-Literary',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '5' => array(
                    'name' => 'Graphic-Literary',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '6' => array(
                    'name' => 'Graphic Discussions',
                    'exclusive' => TRUE,
                    'description' => 'Intolerance of another\'s race, religion, gender or sexual orientation.'
                ),
                '7' => array(
                    'name' => 'Endorsing Hatred',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '8' => array(
                    'name' => 'Endorsing Violent or Hateful Action',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '9' => array(
                    'name' => 'Advocating Violent or Hateful Action',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['SS~~008'] = array(
            'name' => 'Drug Use',
            'values' => array(
                '0' => array(
                    'name' => 'No Drug Use',
                    'exclusive' => TRUE,
                    'description' => 'Appropriate for all audiences.'
                ),
                '1' => array(
                    'name' => 'Subtle Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '2' => array(
                    'name' => 'Strong Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '3' => array(
                    'name' => 'Technical Reference',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '4' => array(
                    'name' => 'Non-Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '5' => array(
                    'name' => 'Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '6' => array(
                    'name' => 'Graphic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '7' => array(
                    'name' => 'Detailed Graphic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '8' => array(
                    'name' => 'Simulated Interactive Participation',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '9' => array(
                    'name' => 'Soliciting Personal Participation',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['SS~~009'] = array(
            'name' => 'Other Adult Themes',
            'values' => array(
                '0' => array(
                    'name' => 'No Other Adult Themes',
                    'exclusive' => TRUE,
                    'description' => 'Appropriate for all audiences.'
                ),
                '1' => array(
                    'name' => 'Subtle Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '2' => array(
                    'name' => 'Strong Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '3' => array(
                    'name' => 'Technical Reference',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '4' => array(
                    'name' => 'Non-Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '5' => array(
                    'name' => 'Graphic-Artistic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '6' => array(
                    'name' => 'Graphic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '7' => array(
                    'name' => 'Detailed Graphic',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '8' => array(
                    'name' => 'Explicit Vulgarity',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '9' => array(
                    'name' => 'Explicit and Crude',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['SS~~00A'] = array(
            'name' => 'Gambling',
            'values' => array(
                '0' => array(
                    'name' => 'No Gambling',
                    'exclusive' => TRUE,
                    'description' => 'Appropriate for all audiences.'
                ),
                '1' => array(
                    'name' => 'Subtle Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '2' => array(
                    'name' => 'Strong Innuendo',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '3' => array(
                    'name' => 'Technical Discussion',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '4' => array(
                    'name' => 'Non-Graphic-Artistic, Advertising',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '5' => array(
                    'name' => 'Graphic-Artistic, Advertising',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '6' => array(
                    'name' => 'Simulated Gambling',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '7' => array(
                    'name' => 'Real Life Gambling without Stakes',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '8' => array(
                    'name' => 'Encouraging Interactive Real Life Participation with Stakes',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                '9' => array(
                    'name' => 'Providing Means with Stakes',
                    'exclusive' => TRUE,
                    'description' => ''
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