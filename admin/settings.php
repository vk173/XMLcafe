<?php defined('OC_ACCESS') or die('Access closed');?>
<!DOCTYPE html>
<html class="font_family_google_fira" lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/admin.css">
  <link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,500,700,400italic,500italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
  <title>Admin panel | XMLcafe</title>
</head>
<?php
$data = simplexml_load_file('../xml/settings.xml');
?>
<body>
  <header id="header">
<div id="adminMenu">
  <a href="?menu">Menu</a>
  <a href="?orders">Orders</a>
  <a href="?settings">Settings</a>
  <a href="?p=exit">Exit</a>
</div>
<div id="logo"><img src="../img/<?=$data->logo?>" alt="logo"></div>
</header>
  <main id="main">
    <form id="root" name="root" action="index.php?save_settings" method="post" enctype="multipart/form-data">
          <div class="Settings">
            <div class="nameSettings">
              <input name="name" type="text" placeholder="Name" value="<?=$data->name?>">
              <input name="logo" type="hidden" value="<?=$data->logo?>">
              <input id="imgLogo" name="imgLogo" class="hidden" type="file">
              <label for="imgLogo"></label>
            </div>
              <ul>
                    <li>
                      <input name="time" type="text" placeholder="Opening hours" value="<?=$data->time?>">
                      <input name="tel" type="text" placeholder="Telephone" value="<?=$data->tel?>">
                      <input name="email" type="text" placeholder="Mail" value="<?=$data->email?>">
                      <input name="address" type="text" placeholder="Address" value="<?=$data->address?>">
                    </li>
                    <li>
                      <textarea name="description" placeholder="Description"><?=$data->description?></textarea>
                    </li>
              </ul>
              <div class="nameSettings">
                <p>Map</p>
              </div>
              <ul>
              <li>
                <textarea name="map" placeholder="HTML-code"><?=$data->map?></textarea>
              </li>
              </ul>
              <div class="nameSettings">
                <p>Interior</p>
              </div>
              <ul>
                <li class="imgSlider">
                  <?php $slider = simplexml_load_file('../xml/slider.xml');?>
                    <?php if ($slider->name): ?>
                  <?php foreach ($slider as $name): ?>
                    <img src="../img/slider/<?=$name?>" alt="">
                  <?php endforeach;?>
                <?php endif;?>
                <?php if (!$slider->name): ?>
                    <p>Upload photos of the interior...</p>
                <?php endif;?>
                <input id="imgSlider" type="file" name="images[]" multiple>
                <label for="imgSlider">Upload</label>
              </li>
              </ul>
            <button type="submit">Save</button>
        </div>
  </form>
</main>
<form id="delete" name="delete" action="index.php?delete" method="post" onSubmit='return confirm("Delete all orders OK");'>
        <button class="delete" type="submit">Delete all orders</button>
</form>
<script>
function addName() {
  var arrayDataName = document.querySelectorAll('[type="file"]');
  console.log(arrayDataName);
  for (var i = 0; i < arrayDataName.length; i++) {
    arrayDataName[i].addEventListener('change', function (evt){
    let targetNameMenu = evt.target;
    let nameId = targetNameMenu.id;
    let nameFor = '[for="' + nameId + '"]';
    if (nameId == 'imgSlider') {
    var imgSliderI = targetNameMenu.files;
    var AllImgSlider = [];
    for (var i = 0; i < imgSliderI.length; i++) {
      AllImgSlider += imgSliderI[i].name + ' ';
    }
    document.querySelector(nameFor).innerHTML = AllImgSlider;
    }
    if (nameId == 'imgLogo') {
    document.querySelector(nameFor).innerHTML = targetNameMenu.files[0].name;
    document.querySelector(nameFor).setAttribute('style', 'opacity: 1' );
    document.querySelector('#logo').innerHTML = '';
    }
  });
  }
}
addName();
</script>
</body>
</html>
