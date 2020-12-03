<?php
if (!$_POST[dataList]) die('Access closed');

$arrayPOST = $_POST;
if (file_exists ('xml/orders.xml')) {
$old = file_get_contents('xml/orders.xml', LOCK_EX);
$thisDate = date('d.m.Y H:i:s');
$numOrder = count(simplexml_load_file('xml/orders.xml')) + 1;

if (mb_substr($old,-7,7) == '</root>') {
$old = str_replace('</root>', '', $old);
file_put_contents('xml/orders.xml', $old, LOCK_EX);
file_put_contents('xml/backup_orders.xml', $old, LOCK_EX);
}
} else {
  file_put_contents('xml/orders.xml', '﻿<?xml version="1.0" encoding="UTF-8"?><root>');
  $thisDate = date('d.m.Y H:i:s');
  $numOrder = 1;
}

$text = "<order><date>$thisDate</date><number>$numOrder</number><name>$arrayPOST[name]</name><tel>$arrayPOST[tel]</tel><address>$arrayPOST[address]</address><dataList>$arrayPOST[dataList]</dataList><comment>$arrayPOST[comment]</comment></order></root>";
file_put_contents('xml/orders.xml', $text, FILE_APPEND | LOCK_EX);

$optionReplace = array('.', ':');
$dateOrder = str_replace($optionReplace,'', $thisDate);

$fileOrderNum = 'xml/this/' . $dateOrder . 'order' . $numOrder . '.xml';
file_put_contents($fileOrderNum, '<status>Awaiting verification</status>');
echo "<script>document.cookie = 'num=$numOrder; max-age=3600';
document.cookie = 'date=$dateOrder; max-age=3600';
window.location.replace('status.html');</script>";
?>
