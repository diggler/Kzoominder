<?php include("header.php");?>

    <div id="content">
        <div class="container">
            
            <div class="half">
                <h3>Login</h3>
                <form action="index.php" method="POST">
                    
                    <input type="text" name="email" placeholder="email"/>
                    <input type="password" name="password" placeholder="Password"/>
                    <input type="submit" name="login"/>
                    
                </form>
                
                <?php if($session->is_logged_in()){
                    echo '<a href="profile.php">View Profile</a>';
                }
                ?>
                
            </div>
            
            <div class="half2">
                <h3>Sign-up</h3>
                <form action="addUser.php" method="POST">
  			<input type="text" name="first_name" placeholder="First Name" required><br>
  			<input type="text" name="last_name" placeholder="Last Name" required><br>
  			<input type="email" name="email" placeholder="Email" required><br>
  			<input type="password" name="password" placeholder="Password" required><br>
  			<input type="tel" name="phone" placeholder="Telephone Number"><br>
  			<!--<input list="phoneProvider" name="phoneProvider" placeholder="Phone Service Provider">
				<datalist id="phoneProvider">
  					<option value="Sprint">
  					<option value="T-Mobile">
  					<option value="Verizon">
  					<option value="Metro PCS">
  					<option value="Boost Mobile">
  					<option value="AT&T">
  					<option value="Cricket">
				</datalist><br> -->
                        <select id = "phoneProvider" name="phone_provider">
                                        <option value="1">Sprint</option>
  					<option value="2">T-Mobile</option>
  					<option value="3">Verizon</option>
  					<option value="4">Metro PCS</option>
  					<option value="5">Boost Mobile</option>
  					<option value="6">AT&T</option>
  					<option value="7">Cricket</option>
                                        <option value="8">US Cellular</option>
                        </select>
  			<input type="submit" name="user" value="Sign Up">
		</form>
                
            </div>
            
            
        </div>       
        
    </div><!-- END COntainer -->
       

<?php include("footer.php")?>