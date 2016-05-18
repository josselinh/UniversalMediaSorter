<?php require_once './inc/step-3.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Universal Media Sorter - Step #2</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <table border="1">
            <thead>
                <tr>
                    <th>Old filename</th>
                    <th>New filename</th>
                    <th>Report</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?php echo $report['filename']['old']; ?></td>
                        <td><?php echo $report['filename']['new']; ?></td>
                        <td><?php echo $report['report']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>
