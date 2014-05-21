<?php require_once("includes/initialize.php"); ?>
<?php 
    
    // Remember to give your form's submit tag a name="submit" attribute!
    if (isset($_POST['login'])) { // Form has been submitted.
    
      $email= trim($_POST['email']);
      $password = trim($_POST['password']);
      
      // Check database to see if username/password exist.
            $found_user = User::authenticate($email, $password);
            
      if ($found_user) {
        $session->login($found_user);
                    //log_action('Login', "{$found_user->first_name} logged in.");
        redirect_to("profile.php#content");
      } else {
        // username/password combo was not found in the database
        $message = "Username/password combination incorrect.";
      }
      
    } else { // Form has not been submitted.
      $email = "";
      $password = "";
    }
?>
<!DOCTYPE html>

<html>    
<head>

    
    <title>KzooMinder</title>
    <link rel="stylesheet" type="text/css" href="http://kzoominder.com/style.css">
     
</head>
<body>
    
<div class="wrapper"></div>           
    <header>
            <h1>KzooMinder</h1>
            <a href="index.php">
                <img class="logo" src="http://kzoominder.com/images/Logo.png" width="600px" alt="Kzoominder Logo"/>
            </a>
            <h2>Never miss trash pickup again!</h2>
            <img class="tagline" src="http://kzoominder.com/images/tagline.png" />
            <form action="search.php#content" method="POST">
                
                <input type="text" name="street" placeholder="Enter Your Street Name Here"/>
                <input type="submit" name="search" value="Search"/> 
                
            </form>
            
            <img class="or" src="http://kzoominder.com/images/or.png" width="75px"/>

    </header>
    