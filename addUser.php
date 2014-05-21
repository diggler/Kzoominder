<?php

require_once("includes/initialize.php");


if( (isset($_POST['email'])) && (isset($_POST['password'])) && (isset($_POST['first_name'])) && (isset($_POST['last_name'])) ){
        $user = new User();
	$user->email = $_POST['email'];
	$user->password = $_POST['password'];
	$user->first_name = $_POST['first_name'];
	$user->last_name = $_POST['last_name'];
	$user->phone = $_POST['phone'];
	$user->phone_provider = $_POST['phone_provider'];
	$user->date_created = date('Y-m-d G:i:s');
	$user->create();
        redirect_to("index.php");
    }else{
        redirect_to("index.php");
    }
?>