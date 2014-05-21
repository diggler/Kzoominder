<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up</title>
	</head>
	
	<body>
		<form action="" >
  			<input type="text" name="firstName" placeholder="First Name" required><br>
  			<input type="text" name="lastName" placeholder="Last Name" required><br>
  			<input type="email" name="email" placeholder="Email" required><br>
  			<input type="password" name="password" placeholder="Password" required><br>
  			<input type="tel" name="tel" placeholder="Telephone Number"><br>
  			<input list="phoneProvider" name="phoneProvider" placeholder="Phone Service Provider">
				<datalist id="phoneProvider">
  					<option value="Sprint">
  					<option value="T-Mobile">
  					<option value="Verizon">
  					<option value="Metro PCS">
  					<option value="Boost Mobile">
  					<option value="AT&T">
  					<option value="Cricket">
				</datalist><br>
  			<input type="submit" value="Sign Up">
		</form>
	</body>
</html>