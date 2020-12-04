<?php
defined('OC_ACCESS') or die('Access closed');
$array = $_POST;
file_put_contents($_POST[fileName], '<status>' . $_POST[status] . '</status>');
echo "<script>window.location.replace('index.php?orders');</script>";
