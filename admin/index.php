<?php

if($_GET["p"]=='exit') {
session_start();
$_SESSION = array();
session_destroy();
header('Location: ../index.html');
}

session_start();
$access = array();
$access = file("pass.php");
$login = trim($access[1]);
$passw = trim($access[2]);
if(!empty($_POST['enter']))
{
 $_SESSION['login'] = $_POST['login'];
 $_SESSION['passw'] = $_POST['passw'];
}
if(empty($_SESSION['login']) or
 $login != $_SESSION['login'] or
 $passw != $_SESSION['passw'] )
{
 ?><!DOCTYPE html>
 <html class="font_family_google_fira" lang="en">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <link rel="stylesheet" href="css/admin.css">
   <link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,500,700,400italic,500italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
   <title>Admin panel | XMLcafe</title>
 </head>
 <body>
<header id="header">
</header>
   <main id="main">
 <div id="login"> <form action="index.php" method="post">
  <input type="text" name="login" placeholder="Username">
  <input type="password" name="passw" placeholder="Password">
 <input type="hidden" name="enter" value="yes">
 <button type="submit">Sign in</button>
<div><?php if(!empty($_POST['enter'])) echo "Wrong Username or Password";?></div></form>
</div>
</main>
 </body>
 </html>
 <?php die; }
?>

<?php
define('OC_ACCESS', true);

if ($_SERVER['QUERY_STRING'] === '') $_SERVER['QUERY_STRING'] = 'orders';
require $_SERVER['QUERY_STRING'] . '.php';
?>
