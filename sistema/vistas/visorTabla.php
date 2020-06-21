<?php (!defined('APLICACION')) ? exit('No se permite acceso directo al script') : false;?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?=ap_titulo();?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?=vista_css('w3.css');?>" rel="stylesheet" >
</head>
<body>
    <div class="w3-container">
        <?php if (count($registros) > 0): ?>
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr>
                <th><?php echo implode('</th><th>', array_keys(current($registros))); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $row): array_map('htmlentities', $row);?>
			                <tr>
			                <td><?php echo implode('</td><td>', $row); ?></td>
			                </tr>
			                <?php endforeach;?>
            </tbody>
        </table>
        <?php endif;?>
    </div>
</body>
</html>
