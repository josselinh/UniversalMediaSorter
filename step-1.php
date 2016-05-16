<?php
$inputFormats = array(
    '%year%/%month%/%day%/IMG_%year%%month%%day%_%hour%%minute%%second%.jpg',
    'IMG_%year%%month%%day%_%hour%%minute%%second%.jpg',
    'VID_%year%%month%%day%_%hour%%minute%%second%.mp4',
    'GO%anything%.jpg'
);

$outputFormats = array(
    'jpg' => '%year%/%month%/%day%/IMG_%year%%month%%day%_%hour%%minute%%seconde%.jpg',
    'mp4' => '%year%/%month%/%day%/VID_%year%%month%%day%_%hour%%minute%%seconde%.mp4'
);
?>

<form method="post" action="step-2.php">
    <div>
        <span>Input</span>

        <div>
            <div>
                <label>Directory to analyse :
                    <input type="text" name="data[input][directory]" placeholder="Directory to analyse" value="/home/josselin/Projects/UniversalMediaSorter/Unsorted"/>
                </label>
            </div>

            <div>
                <fieldset>
                    <legend>Formats</legend>

                    <?php foreach ($inputFormats as $inputFormat): ?>
                        <div>
                            <label>
                                <input type="checkbox" name="data[input][formats][]" value="<?php echo $inputFormat; ?>" checked/>
                                <?php echo $inputFormat; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </div>
        </div>
    </div>

    <div>
        <span>Output</span>

        <div>
            <div>
                <label>Destination directory :
                    <input type="text" name="data[output][directory]" placeholder="Output directory" value="/home/josselin/Projects/UniversalMediaSorter/Sorted"/>
                </label>
            </div>

            <?php foreach ($outputFormats as $ext => $outputFormat): ?>
                <div>
                    <label>Format <?php echo strtoupper($ext); ?> :
                        <input type="text" name="data[output][formats][<?php echo $ext; ?>]" value="<?php echo $outputFormat; ?>"/>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <button type="submit" name="submit" value="analyse">Analyse</button>
</form>