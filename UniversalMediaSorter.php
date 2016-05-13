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
        $search = array('YYYY', 'MM', 'DD', 'HH', 'II', 'SS', 'XX');
        $replace = array('(\d{4})', '(\d{2})', '(\d{2})', '(\d{2})', '(\d{2})', '(\d{2})', '(.*)');
        $regex['regex'] = str_replace($search, $replace, $string);

        if (preg_match_all('#YYYY|MM|DD|HH|II|SS|X#i', $string, $matches)) {
            $regex['index'] = $matches[0];
        }

        $this->regex[] = $regex;
    }

    /**
     * Browse input directory and returns files with datetime using previous regex
     * @param string $input directory
     * @return array Files with datetimes
     */
    public function getFiles($input)
    {
        echo $input;
        echo '<pre>' . print_r($this->regex, true) . '</pre>';
        return array();
    }

}
