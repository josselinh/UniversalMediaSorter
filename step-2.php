<?php
/* Requires */
require_once 'UniversalMediaSorter.php';

/* Universal Media Sorter */
$universalMediaSorter = new UniversalMediaSorter\UniversalMediaSorter();

/* Save masks */
if (!empty($_POST['data']['masks'])) {
    foreach ($_POST['data']['masks'] as $mask) {
        $universalMediaSorter->setRegexByString($mask);
    }
}

$files = $universalMediaSorter->getFiles($_POST['data']['directory']['input']);
echo '<pre>' . print_r($files, true) . '</pre>';
