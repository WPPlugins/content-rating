<?php
/**
 * ICRA 2005 Standard Module for the WordPress Content Rating Plugin
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

final class Miqro_icra3_rdf extends MiqroRatingSystem {

    const NAME = 'ICRAv03 Standard';
    const SYSTEM_URL = 'http://www.icra.org/rdfs/vocabularyv03#';
    const DESCRIPTION = 'The final specification issued by ICRA in 2005.';
    const FILENAME = 'miqrolabels.rdf';

    /**
     * Initializes all member variables of the parent class.
     */
    public function __construct() {
        $this->structure['n'] = array(
            'name' => 'Nudity',
            'values' => array(
                'a' => array(
                    'name' => 'Exposed breasts',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Bare buttocks',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'c' => array(
                    'name' => 'Visible genitals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'z' => array(
                    'name' => 'No Nudity',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['s'] = array(
            'name' => 'Sexual Material',
            'values' => array(
                'a' => array(
                    'name' => 'Passionate kissing',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Obscured or implied sexual acts',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'c' => array(
                    'name' => 'Visible sexual touching',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'd' => array(
                    'name' => 'Explicit sexual language',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'e' => array(
                    'name' => 'Erections/explicit sexual acts',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'f' => array(
                    'name' => 'Erotica',
                    'exclusive' => FALSE,
                    'description' => 'Material that is sex-related but does not '
                        .'show sexual activity. Examples include sexually '
                        .'provocative clothing, provocative sex poses and sex toys.'
                ),
                'z' => array(
                    'name' => 'No Sexual Material',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['v'] = array(
            'name' => 'Violence',
            'values' => array(
                'a' => array(
                    'name' => 'Assault/rape',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Injury to human beings',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'c' => array(
                    'name' => 'Injury to animals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'd' => array(
                    'name' => 'Injury to fantasy characters (including animation)',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'e' => array(
                    'name' => 'Blood and dismemberment, human beings',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'f' => array(
                    'name' => 'Blood and dismemberment, animals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'g' => array(
                    'name' => 'Blood and dismemberment, fantasy characters (including animation)',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'h' => array(
                    'name' => 'Torture or killing of human beings',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'i' => array(
                    'name' => 'Torture or killing of animals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'j' => array(
                    'name' => 'Torture or killing of fantasy characters (including animation)',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'z' => array(
                    'name' => 'No Violence',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['l'] = array(
            'name' => 'Language',
            'values' => array(
                'a' => array(
                    'name' => 'Abusive or vulgar terms',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Profanity or swearing',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'c' => array(
                    'name' => 'Mild expletives',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'z' => array(
                    'name' => 'No potentially offensive language',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['o'] = array(
            'name' => 'Potentially Harmful Activities',
            'values' => array(
                'a' => array(
                    'name' => 'Depiction of tobacco use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Depiction of alcohol use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'c' => array(
                    'name' => 'Depiction of drug use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'd' => array(
                    'name' => 'Depiction of the use of weapons',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'e' => array(
                    'name' => 'Gambling',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'f' => array(
                    'name' => 'Sets a bad example for young children',
                    'exclusive' => FALSE,
                    'description' => 'Content that teaches or encourages children to perform '
                        .'harmful acts or imitate dangerous behaviour.'
                ),
                'g' => array(
                    'name' => 'Fear, intimidation, horror, or psychological terror',
                    'exclusive' => FALSE,
                    'description' => 'Content that creates feelings of fear, intimidation, horror, or psychological terror'
                ),
                'h' => array(
                    'name' => 'Discrimination or harm',
                    'exclusive' => FALSE,
                    'description' => 'Incitement or depiction of discrimination or harm against any individual or group based on gender, sexual orientation, ethnic, religious or national identity.'
                ),
                'z' => array(
                    'name' => 'No potentially harmful activities',
                    'exclusive' => TRUE,
                    'description' => ''
                )
            )
        );
        $this->structure['c'] = array(
            'name' => 'User Generated Content',
            'values' => array(
                'a' => array(
                    'name' => 'User-generated content (moderated)',
                    'exclusive' => FALSE,
                    'description' => '"Moderated" means that you review user-supplied content before it is posted to the web.'
                ),
                'b' => array(
                    'name' => 'User-generated content (unmoderated)',
                    'exclusive' => FALSE,
                    'description' => 'If you operate a chatroom, host a message '
                        .'board or any other method by which users can directly '
                        .'post content to your site, you should check one or other '
                        .'of the two descriptors in this section.'
                ),
                'z' => array(
                    'name' => 'No user-generated content',
                    'exclusive' => TRUE,
                    'description' => 'Please remember that it is possible to
                        label sections or pages of your website separately.'
                )
            )
        );
        $this->structure['x'] = array(
            'name' => 'Context',
            'optional' => 'true',
            'values' => array(
                'a' => array(
                    'name' => 'Artistic context',
                    'exclusive' => FALSE,
                    'description' => 'This material appears in an artistic context'
                ),
                'b' => array(
                    'name' => 'Educational context',
                    'exclusive' => FALSE,
                    'description' => 'This material appears in an educational context'
                ),
                'c' => array(
                    'name' => 'Medical context',
                    'exclusive' => FALSE,
                    'description' => 'This material appears in a medical context'
                ),
                'd' => array(
                    'name' => 'Sports context',
                    'exclusive' => FALSE,
                    'description' => 'This context qualifier is provided with '
                        .'contact sports in mind, such as boxing. It is not '
                        .'intended, for example, to cover violent online or video '
                        .'games.'
                ),
                'e' => array(
                    'name' => 'News context',
                    'exclusive' => FALSE,
                    'description' => 'This context qualifier is provided to '
                        .'describe material that reports real life events that in '
                        .'other contexts may be considered harmful by parents.'
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
    public function flush_label_file(array $labels) {
        $path = ABSPATH.self::FILENAME;
        if(!is_writable(ABSPATH)) throw new Exception('Unable to save label file.1');
        if(empty($labels)) {
            unlink($path);
            return;
        }

        $date = gmstrftime('%Y-%m-%d');

        $output = '<?xml version="1.0"?>
<rdf:RDF
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
  xmlns:label="http://www.w3.org/2004/12/q/contentlabel#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:icra="http://www.icra.org/rdfs/vocabularyv03#">

  <rdf:Description rdf:about="">
    <dc:creator rdf:resource="http://www.icra.org" />
    <dcterms:issued>'.$date.'</dcterms:issued>
    <label:authorityFor>http://www.icra.org/rdfs/vocabularyv03#</label:authorityFor>
  </rdf:Description>';
        $output .= "\n\n";

        foreach($labels as $label) {
            $labeltext = array();
            $output .= '  <label:ContentLabel rdf:ID="label_'.$label->id.'">';
            if (!empty($label->comments)) {
                $output .= "\n    <rdfs:comment>".htmlspecialchars($label->comments)."</rdfs:comment>";
            }
            $data = $this->get_data_from_label($label);
            foreach($data as $group => $values) {
                foreach($values as $value) {
                    $labeltext[] = htmlspecialchars($this->structure[$group]['values'][$value]['name']);
                }
            }
            $output .= "\n    <rdfs:label>".implode(', ', $labeltext)."</rdfs:label>\n";
            $output .= $label->data;
            $output .= "\n  </label:ContentLabel>\n\n";
        }

        $output .= '</rdf:RDF>';

        if (!file_put_contents($path, $output, LOCK_EX)) throw new Exception('Unable to save label file.2');
    }

    /**
     * Returns the HTTP header for a specific label.
     *
     * @param object $record A MiqroPostRecord representing the label for the current page.
     * @return string The raw label header for the current page.
     */
    protected function make_http_header(MiqroPostRecord $record) {
        // Using get_option() rather than get_bloginfo() to avoid URL translation.
        $path = trailingslashit(get_option('home')).self::FILENAME;
        return 'Link: <'.$path.'#label_'.$record->label->id.'>; rel="meta" type="application/rdf+xml"; title="ICRA labels";';
    }

    /**
     * Returns the HTML header for a specific label.
     *
     * @param object $record A MiqroPostRecord representing the label for the current page.
     * @return string The raw label header for the current page.
     */
    protected function make_html_header(MiqroPostRecord $record) {
        // Using get_option() rather than get_bloginfo() to avoid URL translation.
        $path = trailingslashit(get_option('home')).self::FILENAME;
        return "<link rel='meta' href='$path#label_".$record->label->id."' type='application/rdf+xml' title='ICRA labels' />";
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
                    $pairs[] = "<icra:$code$value>1</icra:$code$value>";
                }
            }
        }
        return implode("\n", $pairs);
    }

    /**
     * Converts raw data into structured data.
     *
     * @param string $data The value retrieved from $label->data
     * @return array of arrays having a [$key][*] => $value structure
     */
    private function parse_data($data) {
        $results = array();
        $results['x'] = array();

        preg_match_all("@</icra:(\\w{2})>@", $data, $matches);

        foreach($matches[1] as $pair) {
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
        $label_ids = array();
        $timestamp = 0;
        foreach($records as $record) {
            $label_ids[] = $record->label->id;
            if ($record->timestamp > $timestamp) {
                $timestamp = $record->timestamp;
            }
        }
        $label_ids = array_unique($label_ids);

        if (1 == count($label_ids)) {
            $label = $records[0]->label;
        } else {
            // Parse key, value pairs for all labels and take the max value of each key.
            $labels = array();
            $names = array();
            foreach($label_ids as $id) {
                foreach($records as $record) {
                    if ($record->label->id == $id) {
                        $labels[] = $record->label;
                        $names[] = $record->label->name;
                        break;
                    }
                }
            }

            $label = new MiqroLabel();
            $label->name = implode(' + ', $names);
            $label->system = 'icra3_rdf';
            $label->comments = 'Label dynamically generated.';
            $results = array();
            $data = array();

            foreach($labels as $labelin) {
                foreach($this->parse_data($labelin->data) as $code => $values) {
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
            }

            // Make consistent data hashes by sorting the array.
            $data = array();
            foreach($this->structure as $key => $group) {
                if (isset($results[$key])) {
                    foreach($group['values'] as $value => $details) {
                        if (in_array($value, $results[$key])) {
                            $data[$key][] = $value;
                        }
                    }
                } else {
                    $data[$key] = array();
                }
            }

            $label->data = $this->get_label_from_data($data);
            $label->save('dynamic');
        }
        $record = new MiqroPostRecord($label, $timestamp);
        return $record;
    }

    protected function do_uninstall() {
        @unlink(ABSPATH.self::FILENAME);
    }
}
?>