<?php require_once("includes/initialize.php"); ?>
<?php
    if(isset($_GET['id'])){
       $alert = Alerts::find_by_id($_GET['id']);
	$alert->delete();
        redirect_to("/profile.php");
    }else{
        redirect_to("/profile.php");
    }
?>