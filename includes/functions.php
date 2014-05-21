<?
date_default_timezone_set("America/Detroit");
$types = array("1" => "Trash", "2" => "Recycling", "3" => "Bulk pick-up", "12" => "Trash and recycling");
$days = array("0" => "every day", "1" => "Sunday", "2" => "Monday", "3" => "Tuesday", "4" => "Wednesday", "5" => "Thursday",
"6" => "Friday", "7" => "Saturday", "8" => "Private");
$frequencies = array("1" => "every", "2" => "first", "3" => "second", "4" => "third", "5" => "fourth");
$provider_emails = array(1 => "txt.att.net",
2 => "messaging.sprintpcs.com",
3 => "tmomail.net",
4 => "vtext.com",
5 => "vmobl.com",
6 => "myboostmobile.com",
7 => "sms.mycricket.com",
8 => "mymetropcs.com",
9 => "email.uscc.net"); 

function sendmsg_amzn($to_name, $to_email, $from_name, $from_email, $subject, $msg, $ctype=0, $htmlmsg="") {
require_once "Mail.php";
// Send Email
$host = "email-smtp.us-east-1.amazonaws.com";
$username = "AKIAJ64LE2VRAKVNK4WA";
$password = "ArGgmIIsZyTpOI5fhC6yRjqirLkiOdklhzdSujfSqUjO";
if ($ctype) $contenttype = 'multipart/alternative; charset=iso-8859-1; boundary="----=_NextPart_000_00E9_01CAC2C6.4D70C630";';
else $contenttype = 'text/plain';
$subject=strip($subject, 0);
$to_email = str_replace("!", "@", $to_email);
$to = "\"$to_name\" <$to_email>";
$from = "\"$from_name\" <$from_email>";
$to = str_replace("\\'", "'", $to);
$from = str_replace("\\'", "'", $from);
$subject = str_replace("\\'", "'", $subject);
$msg = str_replace("\\'", "'", $msg);
if ($ctype)
$msg = '------=_NextPart_000_00E9_01CAC2C6.4D70C630
Content-Type: text/plain; charset="us-ascii"
Content-Transfer-Encoding: quoted-printable
'. $msg .'
------=_NextPart_000_00E9_01CAC2C6.4D70C630
Content-Type: text/html

<body>
' . $htmlmsg . '
</body>';
$headers = array ('From' => $from,
'Reply-To' => $from,
   'To' => $to,
'MIME-Version' => "1.0",
'Content-Transfer-Encoding' => '8bit',
'Content-Type' => $contenttype,
   'Subject' => $subject);
$smtp = Mail::factory('smtp',
   array ('host' => $host,
     'auth' => true,
     'username' => $username,
     'password' => $password));
#echo print_r($headers);
# echo "<br>$msg";
$mail = $smtp->send($to, $headers, $msg);
if (PEAR::isError($mail)) 
return $mail->getMessage();
else return 1;
}

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

function strip($string, $type=1)
{
$string = preg_replace("'<style[^>]*>.*</style>'siU",'',$string);
if ($type == 0) $string = strip_tags($string);
else $string = stripslashes(strip_tags($string,'<br>'));
return $string;
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
$curdate = mktime(0, 0, 0, date("m"), 1, 2013);
$firstofthemonth = mktime(0, 0, 0, date("m"), 1);
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
$time = strtotime($day_text, $firstofthemonth);
if ($curdate >= $time) {
$month = date("m", $firstofthemonth);
$year = date("Y", $firstofthemonth);
$month++;
if ($month > 12) {
$month = 1;
$year++;
}
$firstofthemonth = mktime(0,0,0, $month, 1, $year);
$time = strtotime($day_text, $firstofthemonth);
}
return $time;
}
?>