<?php
/**
 * ICRA 2008 Module for the WordPress Content Rating Plugin
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

final class Miqro_icra_powder extends MiqroRatingSystem {

    const NAME = 'ICRA 2008';
    const SYSTEM_URL = 'http://hot.miqrogroove.com/blogs/icra2008.rdf#';
    const DESCRIPTION = 'Experimental vocabulary, abandoned September 2010.';
    const FILENAME = 'miqrolabels.xml';

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
                ),
                'Cart' => array(
                    'name' => 'Nudity appears in an artistic context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Clit' => array(
                    'name' => 'Nudity appears in an artistic literature context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cedu' => array(
                    'name' => 'Nudity appears in an educational context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cmed' => array(
                    'name' => 'Nudity appears in a medical context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cnws' => array(
                    'name' => 'Nudity appears in a news context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Crel' => array(
                    'name' => 'Nudity appears in a religious context',
                    'exclusive' => FALSE,
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
                    'name' => 'Bondage/SM',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'g' => array(
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
                ),
                'Cart' => array(
                    'name' => 'Sexual material appears in an artistic context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Clit' => array(
                    'name' => 'Sexual material appears in an artistic literature context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cedu' => array(
                    'name' => 'Sexual material appears in an educational context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cmed' => array(
                    'name' => 'Sexual material appears in a medical context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cnws' => array(
                    'name' => 'Sexual material appears in a news context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Crel' => array(
                    'name' => 'Sexual material appears in a religious context',
                    'exclusive' => FALSE,
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
                    'description' => 'What is portrayed is a rape, whether it is play-acting or not, and should be labelled as such.'
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
                    'name' => 'Torture of human beings',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'i' => array(
                    'name' => 'Killing of human beings',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'j' => array(
                    'name' => 'Death of human beings',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'k' => array(
                    'name' => 'Torture or killing of animals',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'l' => array(
                    'name' => 'Torture or killing of fantasy characters (including animation)',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'z' => array(
                    'name' => 'No Violence',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                'Cart' => array(
                    'name' => 'Violence appears in an artistic context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Clit' => array(
                    'name' => 'Violence appears in an artistic literature context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cedu' => array(
                    'name' => 'Violence appears in an educational context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cmed' => array(
                    'name' => 'Violence appears in a medical context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cspt' => array(
                    'name' => 'Violence appears in a sports context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cnws' => array(
                    'name' => 'Violence appears in a news context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Crel' => array(
                    'name' => 'Violence appears in a religious context',
                    'exclusive' => FALSE,
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
                ),
                'Cart' => array(
                    'name' => 'Potentially offensive language appears in an artistic context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Clit' => array(
                    'name' => 'Potentially offensive language appears in an artistic literature context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cedu' => array(
                    'name' => 'Potentially offensive language appears in an educational context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cmed' => array(
                    'name' => 'Potentially offensive language appears in a medical context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cspt' => array(
                    'name' => 'Potentially offensive language appears in a sports context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cnws' => array(
                    'name' => 'Potentially offensive language appears in a news context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Crel' => array(
                    'name' => 'Potentially offensive language appears in a religious context',
                    'exclusive' => FALSE,
                    'description' => ''
                )
            )
        );
        $this->structure['h'] = array(
            'name' => 'Potentially Harmful Activities',
            'values' => array(
                'a' => array(
                    'name' => 'Depiction of tobacco or its use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'b' => array(
                    'name' => 'Depiction of alcohol or its use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'c' => array(
                    'name' => 'Depiction of recreational drugs or their use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'd' => array(
                    'name' => 'Depiction of weapons or their use',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'e' => array(
                    'name' => 'Gambling',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'z' => array(
                    'name' => 'No potentially harmful activities',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                'Cart' => array(
                    'name' => 'Potentially harmful activities appear in an artistic context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Clit' => array(
                    'name' => 'Potentially harmful activities appear in an artistic literature context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cedu' => array(
                    'name' => 'Potentially harmful activities appear in an educational context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cmed' => array(
                    'name' => 'Potentially harmful activities appear in a medical context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cspt' => array(
                    'name' => 'Potentially harmful activities appear in a sports context',
                    'exclusive' => FALSE,
                    'description' => 'If a website offers gambling on sporting '
                        .'activities, that does not mean that it is gambling in a '
                        .'sports context, it\'s just gambling.'
                ),
                'Cnws' => array(
                    'name' => 'Potentially harmful activities appear in a news context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Crel' => array(
                    'name' => 'Potentially harmful activities appear in a religious context',
                    'exclusive' => FALSE,
                    'description' => ''
                )
            )
        );
        $this->structure['d'] = array(
            'name' => 'Potentially Disturbing Material',
            'values' => array(
                'a' => array(
                    'name' => 'Sets a bad example for young children',
                    'exclusive' => FALSE,
                    'description' => 'Content that teaches or encourages children to perform
                        harmful acts or imitate dangerous behaviour.'
                ),
                'b' => array(
                    'name' => 'Fear, intimidation, horror, or psychological terror',
                    'exclusive' => FALSE,
                    'description' => 'Content that creates feelings of fear, intimidation, horror, or psychological terror'
                ),
                'c' => array(
                    'name' => 'Discrimination or harm',
                    'exclusive' => FALSE,
                    'description' => 'Incitement or depiction of discrimination or harm against any individual or group based on gender, sexual orientation, ethnic, religious or national identity.'
                ),
                'd' => array(
                    'name' => 'Other potentially disturbing material',
                    'exclusive' => FALSE,
                    'description' => 'Content that is not covered by any of the other descriptors in the vocabulary but that may refer to facts, ideas and issues in a way that assumes an adult audience.'
                ),
                'z' => array(
                    'name' => 'No potentially harmful activities',
                    'exclusive' => TRUE,
                    'description' => ''
                ),
                'Cart' => array(
                    'name' => 'Potentially disturbing material appears in an artistic context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Clit' => array(
                    'name' => 'Potentially disturbing material appears in an artistic literature context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cedu' => array(
                    'name' => 'Potentially disturbing material appears in an educational context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cmed' => array(
                    'name' => 'Potentially disturbing material appears in a medical context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cspt' => array(
                    'name' => 'Potentially disturbing material appears in a sports context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Cnws' => array(
                    'name' => 'Potentially disturbing material appears in a news context',
                    'exclusive' => FALSE,
                    'description' => ''
                ),
                'Crel' => array(
                    'name' => 'Potentially disturbing material appears in a religious context',
                    'exclusive' => FALSE,
                    'description' => ''
                )
            )
        );
        $this->structure['u'] = array(
            'name' => 'User Generated Content',
            'values' => array(
                'a' => array(
                    'name' => 'User-generated content (moderated)',
                    'exclusive' => FALSE,
                    'description' => '"Moderated" means that user-supplied '
                        .'content is reviewed before it is posted to the web and '
                        .'that the content is thefore in line with the site label.'
                ),
                'b' => array(
                    'name' => 'User-generated content (unmoderated)',
                    'exclusive' => FALSE,
                    'description' => 'If the site includes a chatroom, message '
                        .'board, forum, is an online classified-ads site, or '
                        .'provides any other method by which users can directly '
                        .'post content, you should check one or other of the '
                        .'descriptors in this section.'
                ),
                'c' => array(
                    'name' => 'Content that facilitates contact between users',
                    'exclusive' => FALSE,
                    'description' => 'If the content includes any method for the '
                        .'user to contact others, through clickable email addresses '
                        .'or links to instant messaging, etc., this should be '
                        .'declared in the label.'
                ),
                'z' => array(
                    'name' => 'No user-generated content',
                    'exclusive' => TRUE,
                    'description' => 'Please remember that it is possible to '
                        .'label sections or pages of your website separately.'
                )
            )
        );
        $this->structure['p'] = array(
            'name' => 'Promotion and Data Protection',
            'values' => array(
                'a' => array(
                    'name' => 'Contains advertising',
                    'exclusive' => FALSE,
                    'description' => 'Some countries have quite specific laws '
                        .'pertaining to advertising to children. This descriptor '
                        .'allows you to declare that the advertising present meets '
                        .'such country-specific regulations.'
                ),
                'b' => array(
                    'name' => 'Contains advertising suitable for children in ...',
                    'exclusive' => FALSE,
                    'description' => 'This option is not yet supported by the Content Rating plugin.'
                ),
                'c' => array(
                    'name' => 'Collects personal data',
                    'exclusive' => FALSE,
                    'description' => 'e.g. e-mail addresses, etc.'
                ),
                'z' => array(
                    'name' => 'No advertising or personal data collection',
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
    public function flush_label_file(array $labels) {
        $path = ABSPATH.self::FILENAME;
        if(!is_writable(ABSPATH)) throw new Exception('Unable to save label file.1');
        if(empty($labels)) {
            unlink($path);
            return;
        }

        $date = gmstrftime('%Y-%m-%dT%T');

        $output = '<?xml version="1.0" encoding="'.get_bloginfo('charset').'"?>
<powder xmlns="http://www.w3.org/2007/05/powder#"
  xmlns:foaf="http://xmlns.com/foaf/0.1/"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:icra="http://hot.miqrogroove.com/blogs/icra2008.rdf#">

  <attribution>
    <issuedby src="'.trailingslashit(get_option('home')).'" />
    <issued>'.$date.'</issued>
    <abouthosts>'.$_SERVER['HTTP_HOST'].'</abouthosts>
  </attribution>';
        $output .= "\n\n";

        foreach($labels as $label) {
            $labeltext = array();
            $output .= '  <descriptorset xml:id="label_'.$label->id.'">';
            $output .= "\n";
            if (!empty($label->comments)) {
                $output .= "    <comment>".htmlspecialchars($label->comments)."</comment>\n";
            }
            $output .= $label->data;
            $data = $this->get_data_from_label($label);
            foreach($data as $group => $values) {
                foreach($values as $value) {
                    $labeltext[] = htmlspecialchars($this->structure[$group]['values'][$value]['name']);
                }
            }
            $output .= "\n    <displaytext>\n      ".implode(";\n      ", $labeltext)."\n    </displaytext>";
            $output .= "\n  </descriptorset>\n\n";
        }

        $output .= '</powder>';

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
        return 'Link: <'.$path.'#label_'.$record->label->id.'>; rel="describedby" type="application/powder+xml"; title="ICRA labels";';
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
        return "<link rel='describedby' href='$path#label_".$record->label->id."' type='application/powder+xml' title='ICRA labels' />";
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

        preg_match_all("@</icra:(\\w{2,6})>@", $data, $matches);

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
            $label->system = 'icra3_powder';
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