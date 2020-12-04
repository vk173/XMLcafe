<?php defined('OC_ACCESS') or die('Access closed');?>
<!DOCTYPE html>
<html class="font_family_google_fira" lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/admin.css">
  <link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,500,700,400italic,500italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
  <title>Admin panel | XMLcafe</title>
</head>
<?php
$dataSettings = simplexml_load_file('../xml/settings.xml');
?>
<body>
  <header id="header">
<div id="adminMenu">
  <a href="?menu">Menu</a>
  <a href="?orders">Orders</a>
  <a href="?settings">Settings</a>
  <a href="?p=exit">Exit</a>
</div>
<div id="logo"><img src="../img/<?=$dataSettings->logo?>" alt="Logo"></div>
</header>
  <main id="main">
    <?php
    $z = microtime(true);
    $data = simplexml_load_file('../xml/menu.xml');
    if(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) !== 'save_menu')
    $data->asXML('../xml/backup_menu.xml');
    ?>
    <form id="root" name="root" action="index.php?save_menu" method="post" enctype="multipart/form-data">
      <?php $a=0;?>
      <?php foreach ($data as $menu):?>
        <?php foreach ($menu as $name_menu): $a++?>
          <div id="<?=$a?>" class="Menu">

            <div class="nameMenu">
              <input name="nameMenu_<?=$a?>" type="text" placeholder="Menu name" value="<?=$name_menu->nameMenu?>">
              <input id="imgMenu<?=$a?>" name="imgMenu<?=$a?>" class="hidden" type="file">
              <label for="imgMenu<?=$a?>"></label>
              <button type="button" onclick="document.getElementById('<?=$a?>').innerHTML = '';">Delete menu</button>
            </div>
            <ul id="list<?=$a?>">
              <?php $i=0; ?>
              <?php foreach ($name_menu as $el_menu):?>
                <?php foreach ($el_menu as $elMenu): $i++?>
                  <?php if ($elMenu->name):?>
                    <li draggable="true">
                      <input name="index_<?=$a?><?=$i?>" type="hidden" value="">
                      <input name="nameMenu_<?=$a?><?=$i?>" type="hidden" value="<?=$name_menu->nameMenu?>">
                      <label for="img_<?=$a?><?=$i?>" style="background:url(../img/menu/<?=$elMenu->img?>);background-size:cover;"></label>
                      <input name="name_<?=$a?><?=$i?>" type="text" placeholder="Name" value="<?=$elMenu->name?>">
                      <input id="weight_<?=$a?><?=$i?>" name="weight_<?=$a?><?=$i?>" type="text" placeholder="oz." value="<?=$elMenu->weight?>">
                      <label for="weight_<?=$a?><?=$i?>" data-fon="E"></label>
                      <input id="price_<?=$a?><?=$i?>" name="price_<?=$a?><?=$i?>" type="text" placeholder="Price" value="<?=$elMenu->price?>">
                      <label for="price_<?=$a?><?=$i?>" data-fon="$"></label>
                      <input name="img_<?=$a?><?=$i?>" type="hidden" value="<?=$elMenu->img?>">
                      <input id="img_<?=$a?><?=$i?>" name="images[]" type="file">
                      <textarea name="description_<?=$a?><?=$i?>" placeholder="Description"><?=$elMenu->description?></textarea>
                    </li>
                  <?php endif;?>
                <?php endforeach;?>
              <?php endforeach;?>
              </ul>
              <div id="new<?=$a?>">
              </div>
              <script type="text/javascript">
              let indexEl<?=$a?> = 0;
              </script>
            <button type="button" onclick="indexEl<?=$a?>++; var createEl=document.createElement('div');createEl.innerHTML = '<input class=\'hidden\' name=\'new_nameMenu_' + <?=$a?> + indexEl<?=$a?> + '\' type=\'text\' value=\'<?=$name_menu->nameMenu?>\'required><input name=\'new_name_' + <?=$a?> + indexEl<?=$a?> + '\' type=\'text\' placeholder= \'Name\' value=\'\'><input name=\'new_weight_' + <?=$a?> + indexEl<?=$a?> + '\' type=\'text\' placeholder= \'oz.\' value=\'\'><input name=\'new_price_' + <?=$a?> + indexEl<?=$a?> + '\' type=\'text\' placeholder= \'Price\' value=\'\'><input name=\'new_img_' + <?=$a?> + indexEl<?=$a?> + '\' type=\'hidden\' placeholder= \'img\' value=\'not.png\'><textarea name=\'new_description_' + <?=$a?> + indexEl<?=$a?> + '\' placeholder= \'Description\'></textarea>';document.getElementById('new<?=$a?>').appendChild(createEl);">+ Add</button>
            <button type="submit">Save</button>
        </div>
      <?php endforeach;?>
    <?php endforeach;
    echo round(microtime(true) - $z, 4);?>

  </form>
</main>
<script src="js/admin.js"></script>
</body>
</html>
