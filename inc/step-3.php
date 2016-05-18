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
$inputFiles = (empty($_POST['data']['input']) ? null : $_POST['data']['input']);
$outputDirectory = (empty($_POST['data']['output']['directory']) ? null : $_POST['data']['output']['directory']);
$outputFormats = (empty($_POST['data']['output']['formats']) ? null : $_POST['data']['output']['formats']);

/* Requires */
require_once 'UniversalMediaSorter.php';

/* Universal Media Sorter */
$universalMediaSorter = new UniversalMediaSorter\UniversalMediaSorter();

$reports = $universalMediaSorter->setFiles($inputFiles)->sort($outputDirectory, $outputFormats);
