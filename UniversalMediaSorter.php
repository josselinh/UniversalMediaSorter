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
                /* File informations */
                $file = array(
                    'filename' => $inputFile,
                    'datetime' => array(
                        'format' => null,
                        'exif_datetime_original' => null,
                        'exif_file_datetime' => null,
                        'modified' => filemtime($inputFile)));

                /* Intialise default date value */
                $inputFileFormatValues = array(
                    'year' => null,
                    'month' => null,
                    'day' => null,
                    'hour' => null,
                    'minute' => null,
                    'second' => null);

                $inputFormatMatches = array();

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

                /* Only save date if year, month and day are not empties */
                if (!empty($inputFileFormatValues['year']) && !empty($inputFileFormatValues['month']) && !empty($inputFileFormatValues['day'])) {
                    $file['datetime']['format'] = mktime($inputFileFormatValues['hour'], $inputFileFormatValues['minute'], $inputFileFormatValues['second'], $inputFileFormatValues['month'], $inputFileFormatValues['day'], $inputFileFormatValues['year']);
                }

                /* Exif informations */
                $exif = @read_exif_data($inputFile);

                if (false !== $exif) {
                    if (!empty($exif['DateTimeOriginal'])) {
                        $file['datetime']['exif_datetime_original'] = strtotime($exif['DateTimeOriginal']);
                    }

                    if (!empty($exif['FileDateTime'])) {
                        $file['datetime']['exif_file_datetime'] = $exif['FileDateTime'];
                    }
                }

                $this->files[] = $file;

                break;
            }
        }
    }

    /**
     * Sort
     * @param string $outputDirectory
     * @param array $outputFormats
     * @return array
     */
    public function sort($outputDirectory = null, $outputFormats = array())
    {
        /* Check $outputDirectory */
        if (empty($outputDirectory)) {
            throw new Exception('Output directory value is empty');
        }

        /* Check $outputFormats */
        if (empty($outputFormats)) {
            throw new Exception('Output formats value is empty');
        }

        /* Check files */
        if (empty($this->files)) {
            throw new Exception('File value is empty');
        }

        /* Browse files */
        $reports = array();

        foreach ($this->files as $index => $file) {
            $reports[$index] = array('filename' => array('old' => $file['filename'], 'new' => null), 'report' => null);
            $pathinfo = pathinfo($file['filename']);
            $fileExt = $pathinfo['extension'];

            if (!empty($outputFormats[$fileExt])) {
                /* New filename */
                $newFileName = str_replace(array('%year%', '%month%', '%day%', '%hour%', '%minute%', '%second%'), array(date('Y', $file['datetime']), date('m', $file['datetime']), date('d', $file['datetime']), date('H', $file['datetime']), date('i', $file['datetime']), date('s', $file['datetime'])), $outputDirectory . '/' . $outputFormats[$fileExt]);
                $newFilenamePathinfo = pathinfo($newFileName);

                /* Check if the files already exists */
                if (is_file($newFileName)) {
                    $i = 1;

                    while (is_file($newFilenamePathinfo['dirname'] . '/' . $newFilenamePathinfo['filename'] . '_' . $i . $newFilenamePathinfo['extension'])) {
                        $i = $i + 1;
                    }

                    $newFileName = $newFilenamePathinfo['dirname'] . '/' . $newFilenamePathinfo['filename'] . '_' . $i . $newFilenamePathinfo['extension'];
                }

                /* Check if the output directory exists */
                if (!is_dir($newFilenamePathinfo['dirname'])) {
                    if (!mkdir($newFilenamePathinfo['dirname'], 0777, true)) {
                        $reports[$index]['report'] = 'Could not create directory';
                    }
                }

                if (is_dir($newFilenamePathinfo['dirname'])) {
                    if (rename($file['filename'], $newFileName)) {
                        $reports[$index]['filename']['new'] = $newFileName;

                        if (touch($newFileName, $file['datetime'])) {
                            $reports[$index]['report'] = 'Success';
                        } else {
                            $reports[$index]['report'] = 'Moved, but could not change modify date';
                        }
                    } else {
                        $reports[$index]['report'] = 'Could not move file';
                    }
                }
            } else {
                $reports[$index]['report'] = 'Could not find output format';
            }
        }

        return $reports;
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
     * Set files
     * @param array $files
     * @return \UniversalMediaSorter\UniversalMediaSorter
     */
    public function setFiles($files = array())
    {
        $this->files = $files;

        return $this;
    }

}
