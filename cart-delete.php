<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php
unset($_SESSION['movie'][$_GET['id']]);

require 'cart-show.php';
?>
