<?php

namespace UniversalMediaSorter;

/**
 * Description of UniversalMediaSorter
 *
 * @author josselin
 */
class UniversalMediaSorter
{

    /**
     * @var array 
     */
    private $files = array();

    /**
     * @var array 
     */
    private $formatKeys = array('%year%', '%month%', '%day%', '%hour%', '%minute%', '%second%', '%anything%');

    /**
     * Find files according to format
     * @param string $inputDirectory
     * @param array $inputFormats
     * @return \UniversalMediaSorter\UniversalMediaSorter
     */
    public function findFiles($inputDirectory = null, $inputFormats = array())
    {
        /* Check $inputDirectory */
        /* Empty */
        if (empty($inputDirectory)) {
            throw new Exception('Input directory value is empty');
        }
        
        /* Is a directory */
        if (!is_dir($inputDirectory)) {
            throw new Exception('Input directory is not a valid directory');
        }
        
        /* Check $inputFormats */
        /* Empty */
        if (empty($inputFormats)) {
            throw new Exception('Input format value is empty');
        }

        return $this;
    }

    /**
     * Return found files
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Contains regex to find files
     * @var array
     */
    private $oldregex = array();

    /**
     * Convert a string to a regex and save positions
     * @example DD-MM-YYYY_HH-MM-SS_X.jpg => (\d{2})-(\d{2})-(\d{4})_(\d{2})-(\d{2})-(\d{2})_(.*).jpg
     * @param string $string
     */
    public function oldsetRegexByString($string)
    {
        $matches = array();
        $search = array('%year%', '%month%', '%day%', '%hour%', '%minute%', '%second%', '%anything%');
        $replace = array('(\d{4})', '(\d{2})', '(\d{2})', '(\d{2})', '(\d{2})', '(\d{2})', '(.*)');
        $regex['regex'] = str_replace($search, $replace, $string);

        if (preg_match_all('#' . implode('|', $search) . '#i', $string, $matches)) {
            $regex['index'] = array_flip($matches[0]);
        }

        $this->regex[] = $regex;

        pr($regex);
        die;
    }

    /**
     * Browse input directory and returns files with datetime using previous regex
     * @param string $input directory
     * @return array Files with datetimes
     */
    public function oldgetFiles($input = null, &$filesDatetimes = array())
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
                            $fileDatetimes = $this->fileMatchesRegex($input . DS . $entry);

                            if (false !== $fileDatetimes) {
                                $filesDatetimes[] = $fileDatetimes;
                            }
                        }
                    }
                }

                return $filesDatetimes;
            } else {
                throw new Exception('"' . $input . '" is not a valid directory');
            }
        } else {
            throw new Exception('"' . $input . '" is not a directory');
        }
    }

    private function oldfileMatchesRegex($file = null)
    {
        foreach ($this->regex as $regex) {
            $matches = array();

            if (preg_match('#' . $regex['regex'] . '#i', $file, $matches)) {
                $formatMatches = array();

                foreach ($regex['index'] as $format => $position) {
                    $formatMatches[$format] = $matches[$position + 1];
                }

                $fileDatetimes = array(
                    'file' => $file,
                    'datetime' => null
                );

                return $fileDatetimes;
            }
        }

        return false;
    }

}
