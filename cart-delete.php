<?php session_start(); ?>
<?php require 'header.php'; ?>
<link href="styles/cart-delete.css" rel="stylesheet">
<?php
unset($_SESSION['movie'][$_GET['id']]);

require 'cart-show.php';
?>
<?php require 'menu.php'; ?>