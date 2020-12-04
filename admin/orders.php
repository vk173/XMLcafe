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
<modal>
  <div class="overlay js-overlay-modal"></div>
  <div class="modal" data-modal="order">
    <svg class="modal__cross js-modal-close" xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg>
    <h2>New order</h2>
    <span class="message">
    </span>
    <form method="post" action="?orders">
        <input type="hidden" name="key" value="yes">
        <input type="submit" value="Refresh" name="">
    </form>
  </div>
</modal>

  <main id="main">

    <?php
    $z = microtime(true);
    $data = simplexml_load_file('../xml/orders.xml');?>

    <div id="orderRoot">
      <?php
      $a=0;
      if ($_POST[full] == 'on') {
        $quantity = 0;
      } else {
        $quantity = count($data) - 50;
      }
      ?>
        <?php foreach ($data as $order): $a++; if ($quantity > $a) continue;?>
          <div id="<?=$order->number?>" class="Order">
            <div class="dateOrder">
            <span>Order № <?=$order->number?></span>
            <span><?=$order->date?></span>
            </div>
            <div class="contacts">
              <div class="name">
                <span name="name"><?=$order->name?></span>
                <?php if($order->comment == '') $order->comment = ':)'?>
                <span name="comment"><?=$order->comment?></span>
              </div>
              <div class="address">
                <?=openssl_decrypt($order->address, 'CAMELLIA-128-ECB', 'OCXMLcafe')?>
              </div>
              <div class="tel">
                <?=openssl_decrypt($order->tel, 'CAMELLIA-128-ECB', 'OCXMLcafe')?>
              </div>
            </div>
            <ul id="list<?=$order->number?>">

              <?php foreach ($order as $dataList):?>
                <?php foreach ($dataList->p as $list):?>
                    <li class="food">
                      <?=$list?>
                    </li>
                <?php endforeach;?>
              <?php endforeach;?>
              </ul>
              <div class="weight"><?=$order->dataList->weight?></div>
              <div class="total"><?=$order->dataList->total?></div>
              <?php
              $optionReplace = array('.', ':');
              $dateOrder = str_replace($optionReplace,'', $order->date);
              $fileName = '../xml/this/' . $dateOrder . 'order' . $order->number . '.xml';
              if(file_exists($fileName)) {
                $status = simplexml_load_file($fileName);
              } else {
                $status = 0;
              }
              ?>
                <?php if($status !== 0):?>
                  <?php if($status[0] == 'Awaiting verification'):?>
                      <form class="status" action="index.php?status" method="post">
                      <select name="status" onchange= this.form.submit()>
                        <option selected value="<?=$status[0]?>"><?=$status[0]?></option>
                        <option value="Cooking">Cooking</option>
                        <option value="Sent by courier">Sent by courier</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                      </select>
                      <input type="hidden" name="fileName" value="<?=$fileName?>">
                      </form>
                  <?php endif;?>
                  <?php if($status[0] == 'Cooking'):?>
                      <form class="status" action="index.php?status" method="post">
                      <select name="status" onchange= this.form.submit()>
                        <option selected value="<?=$status[0]?>"><?=$status[0]?></option>
                        <option value="Sent by courier">Sent by courier</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                      </select>
                      <input type="hidden" name="fileName" value="<?=$fileName?>">
                      </form>
                  <?php endif;?>
                  <?php if($status[0] == 'Sent by courier'):?>
                      <form class="status" action="index.php?status" method="post">
                      <select name="status" onchange= this.form.submit()>
                        <option selected value="<?=$status[0]?>"><?=$status[0]?></option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                      </select>
                      <input type="hidden" name="fileName" value="<?=$fileName?>">
                      </form>
                  <?php endif;?>
                  <?php if($status[0] == 'Delivered'):?>
                      <form class="status" action="index.php?status" method="post">
                      <select name="status" onchange= this.form.submit()>
                        <option selected value="<?=$status[0]?>"><?=$status[0]?></option>
                        <option value="Cancelled">Cancelled</option>
                      </select>
                      <input type="hidden" name="fileName" value="<?=$fileName?>">
                      </form>
                  <?php endif;?>
                  <?php if($status[0] == 'Cancelled'):?>
                      <form class="status" action="index.php?status" method="post">
                      <select name="status" onchange= this.form.submit()>
                        <option selected value="<?=$status[0]?>"><?=$status[0]?></option>
                      </select>
                      <input type="hidden" name="fileName" value="<?=$fileName?>">
                      </form>
                  <?php endif;?>
                <?php endif;?>
        </div>
    <?php endforeach;?>
        <?php echo round(microtime(true) - $z, 4);?>
  </div>
</main>
<form action="" method="post">
<?php if (!$_POST[full] && $quantity > 0): ?>
  <button type="submit" name="full" value="on">All orders</button>
<?php endif; ?>
</form>
<script src="js/orders.js"></script>
</body>
</html>
