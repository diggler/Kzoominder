<?
$types = array("1" => "Trash", "2" => "Recycling", "3" => "Bulk pick-up", "12" => "Trash and recycling");
$days = array("0" => "every day", "1" => "Sunday", "2" => "Monday", "3" => "Tuesday", "4" => "Wednesday", "5" => "Thursday",
"6" => "Friday", "7" => "Saturday", "8" => "Private");
$frequencies = array("1" => "every", "2" => "first", "3" => "second", "4" => "third", "5" => "fourth");
 
 function connect() {
global $con;
if ($con) return;
$host="localhost";
$username="kzoomind_kzoo";
$password="kzoohack104";
$db_name="kzoomind_kzoominder";
$con = mysql_connect("$host", "$username", "$password")
or die("cannot connect");
mysql_select_db("$db_name")
or die("cannot select DB");

// Check connection

if (!$con)
echo "Failed to connect to MySQL: " . mysql_connect_error();
}

function lookup_address($address, $city, $state) {
// Return matching locations/information for an address
global $con;
connect();
$results = mysql_query("select * from `city_data` where `street` like '%$address%'", $con)
or $err = "Unable to connect to database";
if ($err) return $err;
// Initialize array for results
$res = "";
$count = mysql_num_rows($results);
if ($count == 0) return "No results";
// Initialize and populate array of matching locations
$res = "";
$count = 0;
while($item = mysql_fetch_assoc($results)) {
foreach($item as $k => $v) {
$res[$count][$k] = $v;
}
$count++;
}
return $res;

}
function city_data_detail($id) {
// Return detail for an id
global $con;
connect();
$results = mysql_query("select * from `city_data` where `id` = '$id'", $con)
or $err = "Unable to connect to database";
if ($err) return $err;
// Initialize array for results
$res = "";
$count = mysql_num_rows($results);
if ($count == 0) return "No results";
// Initialize and populate array of location
$res = "";
$count = 0;
$item = mysql_fetch_assoc($results);
foreach($item as $k => $v) {
$res[$count][$k] = $v;
}
return $res;
 }
function next_alert($alerts_id = "", $city_data_id = "") {
// Finds next matching day for an alert or a city_data_id
// Will use alert_id first if specified
global $con, $days;
connect();
if ($alerts_id != "") {
$results = mysql_query("select city_data.frequency, city_data.day from city_data, alerts where alerts.id = '$alerts_id' and alerts.city_data_id = city_data.id", $con)
or $err = "Unable to connect to database";
}
elseif ($city_data_id != "") {
$results = mysql_query("select frequency, day from city_data where id = '$city_data_id'", $con)
or $err = "Unable to connect to database";
}
else return "No id specified";
$count = mysql_num_rows($results);
if ($count == 0) return "No matching alert";
$item = mysql_fetch_assoc($results);
if ($item['frequency'] == 1) {
// Weekly alerts
$day_text = $days[$item['day']];
$time = strtotime($day_text, (time() + 86400));
return $time;
}
if ($item['frequency'] == 2) {
// 2 through 5 is for X Mon/Tue/Wed/etc. of the month
$day_text = "first " . $days[$item['day']];
}
if ($item['frequency'] == 3	) {
$day_text = "second " . $days[$item['day']];
}
if ($item['frequency'] == 4) {
$day_text = "third " . $days[$item['day']];
}
if ($item['frequency'] == 5) {
$day_text = "fourth " . $days[$item['day']];
}
$time = strtotime($day_text, (time() + 86400));
return $time;
}
?>