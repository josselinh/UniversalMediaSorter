<?php require_once './inc/step-2.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Universal Media Sorter - Step #2</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <form method="post" action="step-3.php">
            <table border="1">
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Format</th>
                        <th>Exif Datetime Original</th>
                        <th>Exif File Datetime</th>
                        <th>Modified Date</th>
                        <!--th>Other</th-->
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($files as $i => $file): ?>
                        <tr>
                            <td>
                                <?php echo sprintf('<input type="hidden" name="data[input][%d][filename]" value="%s"/>%s', $i, $file['filename'], basename($file['filename'])); ?>
                            </td>

                            <td>
                                <?php echo (!empty($file['datetime']['format']) ? sprintf('<label><input type="radio" name="data[input][%d][datetime]" value="%s" checked/>%s</label>', $i, $file['datetime']['format'], date('Y-m-d H:i:s', $file['datetime']['format'])) : null); ?>
                            </td>

                            <td>
                                <?php echo (!empty($file['datetime']['exif_datetime_original']) ? sprintf('<label><input type="radio" name="data[input][%d][datetime]" value="%s"/>%s</label>', $i, $file['datetime']['exif_datetime_original'], date('Y-m-d H:i:s', $file['datetime']['exif_datetime_original'])) : null); ?>
                            </td>

                            <td>
                                <?php echo (!empty($file['datetime']['exif_file_datetime']) ? sprintf('<label><input type="radio" name="data[input][%d][datetime]" value="%s"/>%s</label>', $i, $file['datetime']['exif_file_datetime'], date('Y-m-d H:i:s', $file['datetime']['exif_file_datetime'])) : null); ?>
                            </td>

                            <td>
                                <?php echo (!empty($file['datetime']['modified']) ? sprintf('<label><input type="radio" name="data[input][%d][datetime]" value="%s"/>%s</label>', $i, $file['datetime']['modified'], date('Y-m-d H:i:s', $file['datetime']['modified'])) : null); ?>
                            </td>

                            <!--td>
                            <?php echo sprintf('<input type="radio" name="data[input][%d][datetime]" value="other"/><input type="text" name="data[input][%d][other]"/>', $i, $i); ?>
                            </td-->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <input type="hidden" name="data[output][directory]" value="<?php echo $outputDirectory; ?>"/>
            <?php foreach ($outputFormats as $ext => $outputFormat): ?>
                <input type="hidden" name="data[output][formats][<?php echo $ext; ?>]" value="<?php echo $outputFormat; ?>"/>
            <?php endforeach; ?>

            <div>
                <button type="submit" name="submit" value="sort">Sort</button>
            </div>
        </form>
    </body>
</html>
