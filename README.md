#UniversalMediaSorter

UniversalMediaSorter is a simple way to sort your media as jpg, mp4.

If you need dng, avi, ... just add them.

##Preparation
###Input formats
Prepare the analyse schema with the following keys : %year%, %month%, %day%, %hour%, %minute%, %second% and %anything%.
```php
$inputFormats = array(
    '%year%/%month%/%day%/IMG_%year%%month%%day%_%hour%%minute%%second%.jpg',
    'IMG_%year%%month%%day%_%hour%%minute%%second%.jpg',
    'VID_%year%%month%%day%_%hour%%minute%%second%.mp4',
    '%year%%month%%day%_%hour%%minute%%second%.jpg',
    'GO%anything%.jpg'
);
```
###Output formats
This is the output file format with the following keys : %year%, %month%, %day%, %hour%, %minute% and %second%.
```php
$outputFormats = array(
    'jpg' => '%year%/%month%/%day%/IMG_%year%%month%%day%_%hour%%minute%%second%.jpg',
    'mp4' => '%year%/%month%/%day%/VID_%year%%month%%day%_%hour%%minute%%second%.mp4'
);
```

##Utilisation
###Step 1 (find files)
```php
require_once 'UniversalMediaSorter.php';
$universalMediaSorter = new UniversalMediaSorter\UniversalMediaSorter();
$files = $universalMediaSorter->findFiles($inputDirectory, $inputFormats)->getFiles();
```
$inputDirectory is the directory to analyse.

$inputFormats is the same as previous.

$files contains found files.
```php
$files = array ( 
  0 => array ( 
    'filename' => '/home/josselin/Projects/UniversalMediaSorter/Unsorted/IMG_20160405_223545.jpg', 
    'datetime' => array ( 
      'format' => 1459888545, 
      'exif_datetime_original' => 1459888551, 
      'exif_file_datetime' => 1463602693, 
      'modified' => 1463602693, ), ), 
  1 => array ( 
    'filename' => '/home/josselin/Projects/UniversalMediaSorter/Unsorted/20160416_144349.jpg', 
    'datetime' => array ( 
      'format' => 1460810629, 
      'exif_datetime_original' => 1460810630, 
      'exif_file_datetime' => 1462190779, 
      'modified' => 1462190779, ), ),
      ...
```
###Step 2 (sorting)
```php
require_once 'UniversalMediaSorter.php';
$universalMediaSorter = new UniversalMediaSorter\UniversalMediaSorter();
$reports = $universalMediaSorter->setFiles($inputFiles)->sort($outputDirectory, $outputFormats);
```
$inputFiles contains files and chosen datetime.
```php
$inputFiles = array ( 
  0 => array ( 
    'filename' => '/home/josselin/Projects/UniversalMediaSorter/Unsorted/IMG_20160405_223545.jpg', 
    'datetime' => '1459888545', ), 
  1 => array ( 
    'filename' => '/home/josselin/Projects/UniversalMediaSorter/Unsorted/20160416_144349.jpg', 
    'datetime' => '1460810629', ), 
    ...
```
$outputDirectory contains the target directory.
$outputFormats is the same as previous.
$reports contains the old name, new name and the result for each file.
