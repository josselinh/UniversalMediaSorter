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

/* Requires */
require_once 'UniversalMediaSorter.php';

/* Universal Media Sorter */
$universalMediaSorter = new UniversalMediaSorter\UniversalMediaSorter();

$files = $universalMediaSorter->findFiles($inputDirectory, $inputFormats)->getFiles();
pr($files);
