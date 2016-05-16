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

        /* Open directory */
        $handleInputDirectory = opendir($inputDirectory);

        if ($handleInputDirectory) {
            while (false !== ($entry = readdir($handleInputDirectory))) {
                if (!in_array($entry, array('.', '..'))) {
                    if (is_dir($inputDirectory . '/' . $entry)) {
                        $this->findFiles($inputDirectory . '/' . $entry, $inputFormats);
                    }

                    if (is_file($inputDirectory . '/' . $entry)) {
                        $this->analyse($inputDirectory . '/' . $entry, $inputFormats);
                    }
                }
            }
        } else {
            throw new Exception('Input directory is not a valid directory');
        }

        return $this;
    }

    /**
     * Analyse a file
     * @param string $inputFile
     * @param array $inputFormats
     */
    private function analyse($inputFile = null, $inputFormats = array())
    {
        foreach ($inputFormats as $inputFormat) {
            $inputFileMatches = array();
            $regex = str_replace(array('%year%', '%month%', '%day%', '%hour%', '%minute%', '%second%', '%anything%'), array('(\d{4})', '(\d{2})', '(\d{2})', '(\d{2})', '(\d{2})', '(\d{2})', '(.*)'), $inputFormat);

            if (preg_match('#' . $regex . '#i', $inputFile, $inputFileMatches)) {
                $inputFormatMatches = array();
                $inputFileFormatValues = array(
                    'year' => null,
                    'month' => null,
                    'day' => null,
                    'hour' => 0,
                    'minute' => 0,
                    'second' => 0);

                if (preg_match_all('#' . implode('|', $this->formatKeys) . '#i', $inputFormat, $inputFormatMatches)) {
                    foreach ($inputFormatMatches[0] as $index => $format) {
                        $value = $inputFileMatches[$index + 1];

                        if ('%year%' === $format) {
                            if (1970 < $value && date('Y') >= $value) {
                                $inputFileFormatValues['year'] = $value;
                            } else {
                                continue 2;
                            }
                        }

                        if ('%month%' === $format) {
                            if (1 <= $value && 12 >= $value) {
                                $inputFileFormatValues['month'] = $value;
                            } else {
                                continue 2;
                            }
                        }

                        if ('%day%' === $format) {
                            if (1 <= $value && 31 >= $value) {
                                $inputFileFormatValues['day'] = $value;
                            } else {
                                continue 2;
                            }
                        }

                        if ('%hour%' === $format) {
                            if (0 <= $value && 23 >= $value) {
                                $inputFileFormatValues['hour'] = $value;
                            } else {
                                continue 2;
                            }
                        }

                        if ('%minute%' === $format) {
                            if (0 <= $value && 59 >= $value) {
                                $inputFileFormatValues['minute'] = $value;
                            } else {
                                continue 2;
                            }
                        }

                        if ('%second%' === $format) {
                            if (0 <= $value && 59 >= $value) {
                                $inputFileFormatValues['second'] = $value;
                            } else {
                                continue 2;
                            }
                        }
                    }
                }

                $file = array(
                    'filename' => $inputFile,
                    'datetime_format' => null,
                    'datetime_modified' => date('Y-m-d H:i:s', filemtime($inputFile)),
                    'datetime_exif' => null);

                if (!empty($inputFileFormatValues['year']) && !empty($inputFileFormatValues['month']) && !empty($inputFileFormatValues['day'])) {
                    $file['datetime_format'] = date('Y-m-d H:i:s', mktime($inputFileFormatValues['hour'], $inputFileFormatValues['minute'], $inputFileFormatValues['second'], $inputFileFormatValues['month'], $inputFileFormatValues['day'], $inputFileFormatValues['year']));
                }

                $this->files[] = $file;
            }
        }
    }

    /**
     * Return found files
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

}
