<?php
defined('OC_ACCESS') or die('Access closed');
parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) == 'settings' or die('Access closed');
$array = $_POST;
if ($_FILES['imgLogo']['name']) {
$extLogo = substr(strrchr($_FILES['imgLogo']['name'], "."), 1);
if($extLogo == 'svg' or $extLogo == 'png') move_uploaded_file($_FILES['imgLogo']['tmp_name'], '../img/logo.' . $extLogo);
$_POST[logo] = 'logo.' . $extLogo;
}
file_put_contents('../xml/settings.xml', '<root><logo>' . $_POST[logo] . '</logo><name>' . $_POST[name] . '</name>' . '<description>' . $_POST[description] . '</description>' .
'<time>' . $_POST[time] . '</time>' . '<address>' . $_POST[address] . '</address>' . '<tel>' . $_POST[tel] . '</tel>' . '<email>' . $_POST[email] . '</email>' . '<map>' . htmlspecialchars($_POST[map]) . '</map></root>');

$uploadDir = "../img/slider/";
for ($i = 0; $i < count($_FILES['images']['name']); $i++) {

 $ext = substr(strrchr($_FILES['images']['name'][$i], "."), 1);
 $types = array('jpg', 'png', 'jpeg');

if(in_array($ext, $types)){
 $fPath = $i+1 . ".$ext";
 $result = move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploadDir . $fPath);
 $fPathXml .= '<name>' . $fPath . '</name>';
 }
}
if($_FILES['images']['name'][0] != false) file_put_contents('../xml/slider.xml', '<root>' . $fPathXml . '</root>');

echo "<script>window.location.replace('index.php?settings');</script>";
