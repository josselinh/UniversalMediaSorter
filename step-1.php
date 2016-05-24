<?php require_once './inc/step-1.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Universal Media Sorter - Step #1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="default.css">
    </head>

    <body>
        <form method="post" action="step-2.php">
            <div class="section">
                <span class="title">Input</span>

                <div class="content">
                    <div>
                        <label>Directory to analyse :
                            <input type="text" name="data[input][directory]" placeholder="Directory to analyse" value="/home/josselin/Projects/UniversalMediaSorter/Unsorted"/>
                        </label>
                    </div>

                    <div>
                        Formats :
                        <?php foreach ($inputFormats as $inputFormat): ?>
                            <div>
                                <label>
                                    <input type="checkbox" name="data[input][formats][]" value="<?php echo $inputFormat; ?>" checked/>
                                    <?php echo $inputFormat; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="section">
                <span class="title">Output</span>

                <div class="content">
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

                    <div>
                        Existing file :
                        <div>
                            <label>
                                <input type="radio" name="data[output][options][existing]" value="rename" checked/>
                                Rename
                            </label>
                            <label>
                                <input type="radio" name="data[output][options][existing]" value="overwrite"/>
                                Overwrite
                            </label>
                            <label>
                                <input type="radio" name="data[output][options][existing]" value="ignore"/>
                                Ignore
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <button type="submit" name="data[submit]" value="analyse">Analyse</button>
            </div>
        </form>
    </body>
</html>
