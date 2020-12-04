<?php
defined('OC_ACCESS') or die('Access closed');
parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) == 'settings' or die('Access closed');
unlink('../xml/orders.xml');
array_map('unlink', glob('../xml/this/*'));
echo "<script>window.location.replace('index.php?settings');</script>";
