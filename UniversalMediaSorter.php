<?php

namespace UniversalMediaSorter;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Description of UniversalMediaSorter
 *
 * @author josselin
 */
class UniversalMediaSorter
{

    /**
     * Contains regex to find files
     * @var array
     */
    private $regex = array();

    /**
     * Convert a string to a regex and save positions
     * @example DD-MM-YYYY_HH-MM-SS_X.jpg => (\d{2})-(\d{2})-(\d{4})_(\d{2})-(\d{2})-(\d{2})_(.*).jpg
     * @param string $string
     */
    public function setRegexByString($string)
    {
        $matches = array();
        $search = array('YYYY', 'MM', 'DD', 'HH', 'II', 'SS', 'X');
        $replace = array('(\d{4})', '(\d{2})', '(\d{2})', '(\d{2})', '(\d{2})', '(\d{2})', '(.*)');
        $regex['regex'] = str_replace($search, $replace, $string);

        if (preg_match_all('#YYYY|MM|DD|HH|II|SS|X#i', $string, $matches)) {
            $regex['index'] = $matches[0];
        }

        $this->regex[] = $regex;

        //echo '<pre>'.print_r($regex, true).'</pre>';
    }

    /**
     * Browse input directory and returns files with datetime using previous regex
     * @param string $input directory
     * @return array Files with datetimes
     */
    public function getFiles($input = null)
    {
        if (is_dir($input)) {
            $handleDirectory = opendir($input);

            if ($handleDirectory) {
                while (false !== ($entry = readdir($handleDirectory))) {
                    if (!in_array($entry, array('.', '..'))) {
                        if (is_dir($input . DS . $entry)) {
                            $this->getFiles($input . DS . $entry);
                        }

                        if (is_file($input . DS . $entry)) {
                            $this->fileMatchesRegex($input . DS . $entry);
                        }
                    }
                }
            } else {
                throw new Exception('"' . $input . '" is not a valid directory');
            }
        } else {
            throw new Exception('"' . $input . '" is not a directory');
        }
    }

    private function fileMatchesRegex($file = null)
    {
        echo '<h3>' . $file . '</h3>';

        foreach ($this->regex as $regex) {
            $matches = array();

            if (preg_match('#' . $regex['regex'] . '#i', $file, $matches)) {
                echo '<pre>' . print_r($matches, true) . '</pre>';
                echo '<pre>' . print_r($regex['index'], true) . '</pre>';
                echo '<hr />';

                break;
            }
        }
    }

}
