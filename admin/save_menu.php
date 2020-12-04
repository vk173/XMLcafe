<?php
defined('OC_ACCESS') or die('Access closed');
parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) == 'menu' or die('Access closed');
$array = $_POST;
$dataW = [];
for ($i=0; $i < 1000 ; $i++) {
  $data = [];
  $index = 0;
  $name = 0;
  $description = 0;
  $weight = 0;
  $price = 0;
  $img = 0;
  $new_name = 0;
  $new_description = 0;
  $new_weight = 0;
  $new_price = 0;
  $new_img = 0;
  foreach ($array as $key => $value) {
    if ($key === 'new_nameMenu_'.$i) $new_nameMenu = $value;
    if ($key === 'new_name_'.$i) $new_name = $value;
    if ($key === 'new_description_'.$i) $new_description = $value;
    if ($key === 'new_weight_'.$i) $new_weight = $value;
    if ($key === 'new_price_'.$i) $new_price = $value;
    if ($key === 'new_img_'.$i) $new_img = $value;
    if ($key === 'nameMenu_'.$i) $nameMenu = $value;
    if ($key === 'index_'.$i) $index = $value;
    if ($key === 'name_'.$i) $name = $value;
    if ($key === 'description_'.$i) $description = $value;
    if ($key === 'weight_'.$i) $weight = $value;
    if ($key === 'price_'.$i) $price = $value;
    if ($key === 'img_'.$i) $img = $value;
  }

  if ($name) {
    $data = ['nameMenu' => $nameMenu, 'data' => ['index' => $index, 'name' => $name, 'description' => $description, 'weight' => $weight, 'price' => $price, 'img' => $img]];
    $dataW[] = ['menu' => $data] ;
  }

  if ($new_name) {
    $data = ['nameMenu' => $new_nameMenu, 'data' => ['index' => "0.$i", 'name' => $new_name, 'description' => $new_description, 'weight' => $new_weight, 'price' => $new_price, 'img' => $new_img]];
    $dataW[] = ['menu' => $data] ;
  }
}

foreach ($dataW as $arr1) {
  foreach ($arr1 as $arr2) {
    foreach ($arr2 as $key => $value) {
      if ($key === 'data') $data = $value;
      if ($key === 'nameMenu') $nameMenu = $value;
    }

    if ($nameMenu == $array[nameMenu_1]) $datMenu1[] = $data;
    if ($nameMenu == $array[nameMenu_2]) $datMenu2[] = $data;
    if ($nameMenu == $array[nameMenu_3]) $datMenu3[] = $data;
    if ($nameMenu == $array[nameMenu_4]) $datMenu4[] = $data;
    if ($nameMenu == $array[nameMenu_5]) $datMenu5[] = $data;
    if ($nameMenu == $array[nameMenu_6]) $datMenu6[] = $data;
    if ($nameMenu == $array[nameMenu_7]) $datMenu7[] = $data;
    if ($nameMenu == $array[nameMenu_8]) $datMenu8[] = $data;
    if ($nameMenu == $array[nameMenu_9]) $datMenu9[] = $data;

  }
}

for ($i=1; $i < 10 ; $i++) {
  $sort = array();
  if (is_array(${'datMenu' . $i})) {
    foreach (${'datMenu' . $i} as $key => $row) {
      $sort[$key]  = $row['index'];
    }
    array_multisort($sort, SORT_ASC, ${'datMenu' . $i});
  } else { continue; }
}


$dataArr1 = ['menu' => ['nameMenu'  => $array[nameMenu_1], 'data' => $datMenu1]];
$dataArr2 = ['menu' => ['nameMenu'  => $array[nameMenu_2], 'data' => $datMenu2]];
$dataArr3 = ['menu' => ['nameMenu'  => $array[nameMenu_3], 'data' => $datMenu3]];
$dataArr4 = ['menu' => ['nameMenu'  => $array[nameMenu_4], 'data' => $datMenu4]];
$dataArr5 = ['menu' => ['nameMenu'  => $array[nameMenu_5], 'data' => $datMenu5]];
$dataArr6 = ['menu' => ['nameMenu'  => $array[nameMenu_6], 'data' => $datMenu6]];
$dataArr7 = ['menu' => ['nameMenu'  => $array[nameMenu_7], 'data' => $datMenu7]];
$dataArr8 = ['menu' => ['nameMenu'  => $array[nameMenu_8], 'data' => $datMenu8]];
$dataArr9 = ['menu' => ['nameMenu'  => $array[nameMenu_9], 'data' => $datMenu9]];
$arrayData = [$dataArr1, $dataArr2, $dataArr3, $dataArr4, $dataArr5, $dataArr6, $dataArr7, $dataArr8, $dataArr9];


function to_xml(SimpleXMLElement $object, array $data)
{
  foreach ($data as $key => $value) {
    if (is_array($value)) {
      if (is_int($key)) {
        $key = item;
      }
      $new_object = $object->addChild($key);
      to_xml($new_object, $value);
    } else {

      if ($key == (int) $key) {
        $key = "$key";
      }
      $object->addChild($key, $value);
    }
  }
}
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>'.'<root/>');
to_xml($xml, $arrayData);
print $xml->asXML('../xml/menu.xml');


$uploadDir = "../img/menu/";
for ($i = 0; $i < count($_FILES['images']['name']); $i++) {

 $ext = substr(strrchr($_FILES['images']['name'][$i], "."), 1);
 $types = array('jpg', 'png', 'jpeg');

if(in_array($ext, $types)){
 $fName = $_FILES['images']['name'][$i];
 $result = move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploadDir . $fName);
 }
}

for ($i = 1; $i < 10; $i++) {

 $ext = substr(strrchr($_FILES['imgMenu' . $i]['name'], "."), 1);

if($ext == 'svg') {
 $fName = 'menu' . $i . '.svg';
 $result = move_uploaded_file($_FILES['imgMenu' . $i]['tmp_name'], '../img/' . $fName);
 }
}


echo "<script>window.location.replace('index.php?menu');</script>";
?>
