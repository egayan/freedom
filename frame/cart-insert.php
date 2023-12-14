<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'db-conect.php'; ?>
<?php
$pdo=new PDO($connect,USER,PASS);
if($_SERVER["REQUEST_METHOD"]=='POST'){
$id=$_POST['id'];
if(!isset($_SESSION['movie'])){
    $_SESSION['movie']=[];
}
$_SESSION['movie'][$id]=[
    'name'=>$_POST['name'],
    'price'=>$_POST['price'],
    'image'=>$_POST['image']
];
}
require 'cart-show.php';
?>