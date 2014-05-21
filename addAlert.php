<?php require_once("includes/initialize.php"); ?>
<?php
    if( (isset($_GET['method'])) && (isset($_GET['id'])) ){
        $alert = new Alerts();
	$alert->user_id = $session->user_id;
	$alert->city_data_id = $_GET['id'];
	$alert->method = $_GET['method'];
	$alert->active = 1;
	$alert->create();
        redirect_to("profile.php");
    }else{
        redirect_to("profile.php");
    }
?>