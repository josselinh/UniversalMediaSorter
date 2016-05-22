<?php

/**
 * Pretty print
 * @param mixed $value
 * @param string $name
 */
function pr($value = array(), $name = 'default')
{
    echo '<table border="1">'
    . '<thead><tr><th>' . $name . '</th></tr></thead>'
    . '<tbody><tr><td><pre>' . print_r($value, true) . '</pre></td></tr></body>'
    . '</table>';
}

/* Get post datas */
$inputDirectory = (empty($_POST['data']['input']['directory']) ? null : $_POST['data']['input']['directory']);
$inputFormats = (empty($_POST['data']['input']['formats']) ? null : $_POST['data']['input']['formats']);
$outputDirectory = (empty($_POST['data']['output']['directory']) ? null : $_POST['data']['output']['directory']);
$outputFormats = (empty($_POST['data']['output']['formats']) ? null : $_POST['data']['output']['formats']);
$outputOptions = (empty($_POST['data']['output']['options']) ? null : $_POST['data']['output']['options']);

/* Requires */
require_once 'UniversalMediaSorter.php';

/* Universal Media Sorter */
$universalMediaSorter = new UniversalMediaSorter\UniversalMediaSorter();

try {
    $files = $universalMediaSorter->findFiles($inputDirectory, $inputFormats)->getFiles();
} catch (Exception $e) {
    exit($e->getMessage());
}

$datetime_titles = array();

if (!empty($files) && !empty($files[0]['datetime'])) {
    $datetime_titles = array_keys($files[0]['datetime']);
    $datetime_titles = array_map(function($s) {
        return ucwords(str_replace('_', ' ', $s));
    }, $datetime_titles);
}

function minNotNull(Array $values)
{
    return min(array_diff(array_map('intval', $values), array(0)));
}
