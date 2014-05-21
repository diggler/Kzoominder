<?php include("header.php");?>

    <div id="content">
        <div class="container search">
            
            <?php if(Search::get_search_term() == ''){
                echo '<h2>Please enter a street name above.</h2>';
            }else{?>
            
            <h2>Pick Up Results For: <br><?php echo Search::get_search_term() ?></h2>
            
            <?php $pickups = CityData::find_by_keyword(Search::get_search_term()); ?>
            
            <div class="results">
                <div class="result heading">
                    <span class="street">Street Name</span>
                    <span class="type">Pickup Type</span>
                    <span class="weekday">Weekday</span>
                </div>
            <?php
                foreach($pickups as $key => $val) {
                    echo '<div class="result">';
                        echo '<span class="street">'.$pickups[$key]->street.'</span>';
                        if($pickups[$key]->type == 1){
                            echo '<span class="type">Trash Only</span>';
                        }else if($pickups[$key]->type == 2){
                            echo '<span class="type">Recycling Only</span>';
                        }else if($pickups[$key]->type == 3){
                            echo '<span class="type">Bulk Trash Pickup</span>';
                        }else if($pickups[$key]->type == 12){
                            echo '<span class="type">Trash & Recycling</span>';
                        }else{
                            echo '<span class="type">There is no pickup here.</span>';
                        }
                        
                        echo '<span class="weekday">';
                        if($pickups[$key]->frequency == 1){
                            echo "Every";
                        }else if($pickups[$key]->frequency == 2){
                            echo "First";
                        }else if($pickups[$key]->frequency == 3){
                            echo "Second";
                        }else if($pickups[$key]->frequency == 4){
                            echo "Third";
                        }else if($pickups[$key]->frequency == 5){
                            echo "Fourth";
                        }else{
                            echo "";
                        }
                        
                        echo " ";
                        
                        if($pickups[$key]->day == 2){
                            echo 'Monday';
                        }else if($pickups[$key]->day == 3){
                            echo 'Tuesday';
                        }else if($pickups[$key]->day == 4){
                            echo 'Wednesday';
                        }else if($pickups[$key]->day == 5){
                            echo 'Thursday';
                        }else if($pickups[$key]->day == 6){
                            echo 'Friday';
                        }else if($pickups[$key]->day == 7){
                            echo 'Saturday';
                        }else if($pickups[$key]->day == 1){
                            echo 'Sunday';
                        }else if($pickups[$key]->day == 0){
                            echo 'Every Day';
                        }else{
                            echo 'Private.';
                        }
                        echo '</span>';
                        
                        if($session->is_logged_in()){
                            echo '<span>Add Alert: ';
                            echo '<a href="addAlert.php?method=1&id='.$pickups[$key]->id.'">Email</a>';
                            echo ' <a href="addAlert.php?method=2&id='.$pickups[$key]->id.'">Text</a>';
                            echo '</span>';
                        }
                        
                    echo '</div>';
                }
                }
            ?>
            
            </div>
        </div>      <!-- END CONTAINER --> 
        
    </div><!-- END CONTENT -->
       

<?php include("footer.php"); ?>