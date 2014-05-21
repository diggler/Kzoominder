<?php include("header.php");?>

    <div id="content">
        <div class="container profile">
            
            <?php
                $user = User::find_by_id($session->user_id); ?>

           <h3>Welcome <?php echo $user->first_name; ?></h3>     
           <div class="half">
           
           <h4>Profile Info</h4>
           <p>First Name: <?php echo $user->first_name;?></p>
           <p>Last Name: <?php echo $user->last_name;?></p>
           <p>Email: <?php echo $user->email;?></p>
           <p>Phone: <?php echo $user->phone;?></p>
           <p>Service Provider: <?php
                if($user->phone_provider == 1){
                    echo "AT&T";
                }else if($user->phone_provider == 2){
                    echo "Sprint PCS";
                }else if($user->phone_provider == 3){
                    echo "T-Mobile";
                }else if($user->phone_provider == 4){
                    echo "Verizon";
                }else if($user->phone_provider == 5){
                    echo "Virgin Mobile";
                }else if($user->phone_provider == 6){
                    echo "Boost Mobile";
                }else if($user->phone_provider == 7){
                    echo "Cricket";
                }else if($user->phone_provider == 8){
                    echo "Metro PCS";
                }else if($user->phone_provider == 9){
                    echo "US Cellular";
                }else{
                    echo "Not Set";
                }
           
           
           ?></p>
           <br>
           <a href="logout.php">Log out</a>
           </div>
           <div class="half2">
                <h4>Saved Alerts</h4><a href="search.php">Add Alert</a>
                
                <?php $alerts = Alerts::find_by_user($session->user_id);
                
                foreach($alerts as $key => $val) {
                    echo "<p>";
                    $street = CityData::find_by_id($alerts[$key]->city_data_id);
                    echo $street->street;
                    echo " - ";
                    if($alerts[$key]->method == 1 ){
                        echo "Email";
                    }else if ($alerts[$key]->method == 2){
                        echo "Text";
                    }
                    echo " - ";
                    echo '<a href="deleteAlert.php/?id='.$alerts[$key]->id.'">Delete</a>';
                    echo "</p>";
                }
                
                ?>
           </div>
        </div>       
        
    </div><!-- END COntainer -->
       

<?php include("footer.php")?>