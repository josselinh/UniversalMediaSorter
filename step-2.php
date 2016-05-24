<?php require_once './inc/step-2.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Universal Media Sorter - Step #2</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="default.css">
    </head>

    <body>        
        <?php if (!empty($files)) : ?>
            <form method="post" action="step-3.php">
                <div class="section">
                    <table>
                        <thead>
                            <tr>
                                <th>Filename</th>
                                <?php foreach ($datetime_titles as $datetime_title): ?>
                                    <th><?php echo $datetime_title; ?></th>
                                <?php endforeach; ?>
                                <!--th>Other</th-->
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($files as $i => $file): ?>
                                <tr>
                                    <td>
                                        <?php echo sprintf('<input type="hidden" name="data[input][%d][filename]" value="%s"/>%s', $i, $file['filename'], basename($file['filename'])); ?>
                                    </td>

                                    <?php
                                    $min = minNotNull($file['datetime']);

                                    foreach ($file['datetime'] as $datetime) {
                                        echo '<td>';

                                        if (!empty($datetime)) {
                                            echo sprintf('<label><input type="radio" name="data[input][%d][datetime]" value="%s" %s/>%s</label>', $i, $datetime, ($min === $datetime ? 'checked' : ''), date('Y-m-d H:i:s', $datetime));
                                        }

                                        echo '</td>';
                                    }
                                    ?>

                                    <!--td>
                                    <?php echo sprintf('<input type="radio" name="data[input][%d][datetime]" value="other"/><input type="text" name="data[input][%d][other]"/>', $i, $i); ?>
                                    </td-->
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <input type="hidden" name="data[output][directory]" value="<?php echo $outputDirectory; ?>"/>
                <?php foreach ($outputFormats as $ext => $outputFormat): ?>
                    <input type="hidden" name="data[output][formats][<?php echo $ext; ?>]" value="<?php echo $outputFormat; ?>"/>
                <?php endforeach; ?>
                <?php foreach ($outputOptions as $key => $outputOption): ?>
                    <input type="hidden" name="data[output][options][<?php echo $key; ?>]" value="<?php echo $outputOption; ?>"/>
                <?php endforeach; ?>

                <div class="section">
                    <button type="submit" name="submit" value="sort">Sort</button>
                </div>
            </form>
        <?php else: ?>
            <div>
                No file found
            </div>
        <?php endif; ?>
    </body>
</html>
