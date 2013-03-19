<?php
require_once 'headerFunctions.php';
setcookie("auth", "", time() - 3600);
redirect('index.php');
?>
