<html>
<head>
	<style>
	body {
		padding: 0;
		margin: 0;
		background:url("bck.jpg") no-repeat center center fixed;
		 background-size: cover;
	}
	#header {
		padding: 20px 20px 10px;
		background-color: rgba(255, 255, 255,0.25); /*rgb(225, 91, 80);*/
		text-align: center;
		color: #ffffff;
	}
	h1 {
		margin: 16px 0 8px;
	}
	.green  { color:#00FF00; }
	.red  { color:#FF3300; } 
	#wrapper {
		margin: 10px;

	}
	a { 
		color:#0066ff; 
	}

	#nitclogo {
		padding: 10px;
		margin-right: 600px;
		background-color: #FEFEFE;
		text-align: center;
		border: 1px solid #ccc;
		min-width: 320px;
		float: right;
	}
	#nitclogo img {
		width: 320px;
	}
	#results {

		margin: 0 8px;
		padding: 10px;
		text-align: center;
		height: 425px;
		color: #D0D0D0;
	}
	input[type=text], input[type=password] {
		width: 256px;
		height: 30px;
	}
	input {
		margin: 3px;
	}
	form {
		margin: 0;
	}
	#footer {
		padding: 20px 20px 10px;
		text-align: center;
		color: 009900;
		font-size: 15.5px;
	}
	</style>
</head>
<body>

	<div id="header">
			<h1>No dues - just a click away</h1>
		</div>
	<div id="results">
		<h2><u>Status</u></h2>
		<h3>
<?php
require_once('config.php');
$mysqli= new mysqli($host,$db_user,$db_password,$db_name);
	
/* check connection */
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$roll = $_REQUEST["rollno"];
if (!$roll || !preg_match("/[bBmMpP][0-9]{6}[A-Za-z]{2}/", $roll))
	{
		$res1 = "Invalid Roll Number!";
		$res2 ="";
	}
else{	
if (isset($_REQUEST["apply"])) {
	$query = "INSERT IGNORE INTO students (roll_no) VALUES ('$roll')";
	$mysqli->query($query);
	$query = "UPDATE `students` SET hostel_due=null WHERE roll_no='$roll' AND hostel_due=0";
	$mysqli->query($query);
	$query = "UPDATE `students` SET library_due=null WHERE roll_no='$roll' AND library_due=0";
	$mysqli->query($query);
	$res1 = "<div class=\"green\">Successfully applied!</div>";
	$res2 ="";
} else if (isset($_REQUEST["status"])) {

	$query="SELECT * FROM students WHERE roll_no='$roll'";
	if ($result = $mysqli->query($query))
	{
		/* fetch associative array */
		if ($row = $result->fetch_assoc()) {
			if ($row["hostel_due"] === null)
				$res1 = "Hostel dues are yet to be approved.\n";
			else if ($row["hostel_due"] == 1)
				$res1 = "<div class=\"green\">You have NO hostel dues.</div>\n";
			else
				$res1 = "<div class=\"red\">Your hostel no-dues request was REJECTED.</div>\n";
			/*echo "<br/>\n";*/
			if ($row["library_due"] === null)
				$res2 = "Library dues are yet to be approved.\n";
			else if ($row["library_due"] == 1)
				$res2 = "<div class=\"green\">You have NO library dues.</div>\n";
			else
				$res2 = "<div class=\"red\">Your library no-dues request was REJECTED.</div>\n";
		}

		/* free result set */
		$result->free();
	}
}
}
echo "<p>";
echo $res1;
echo "</p>";
echo "<p>";
echo "\n";
echo $res2;
echo "</p>";
?>
</h3>
<p><a href="index.php"> Go Back </a>
	</div>
		<div id="footer">
		Save Our Earth..Save Paper, Save Trees, Save Money
	</div>
</body>
</html>