<?php
require_once '../../vendor/autoload.php';
require_once '../service/Firestore.php';
require_once '../service/DevTools.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
		<link rel="stylesheet" href="../../assets/css/main.css">
        <title><?php echo "KOMUNIKATOR: ".$_COOKIE['url']; ?></title>
    </head>
    <body>
        <p>PUBLIC:</p>
        <?php include "../view/".$_COOKIE['url']; ?>
    </body>
</html>
