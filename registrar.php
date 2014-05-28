<?php
session_start();
require_once('config.php');
$mysqli= new mysqli($host,$db_user,$db_password,$db_name);
	
/* check connection */
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
?>
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
	#wrapper {
		margin: 10px;
	}
		.green  { color:#00FF00; }
	.red  { color:#FF3300; } 
	#main {
	padding: 20px;
		font-size: 15.5px;
		margin-left: 300px;
		color: #ffffff;
		min-width: 320px;
		background: rgba(0, 0, 0,0.5);
	}
	#nav {
		font-size: 17.5px;
		font-weight:bold;
		float: left;
		width: 270px;
		margin: 0;
		padding: 10px;
		background: rgba(51, 51, 51,0.5);
		height: 80px;
		color: #ffffff;
	}
	input[type=text], input[type=password] {
		width: 256px;
		height: 30px;
	}
	input[type=submit] {
	/*background: #0044cc;*/
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    border: none;
    padding: 10px 25px 10px 25px;
    color: #FFF;
    background-image: linear-gradient(to bottom, #0088cc, #0044cc);
	background-repeat: repeat-x;
	padding: 11px 19px;
	font-size: 17.5px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	}
	input {
		margin: 3px;
	}
	</style>
</head>
<body>
	<?php if ((isset($_SESSION["user"]))&&($_SESSION["user"]=='r')) : ?>
	<div id="header">
		<h1>No-dues: Registrar</h1>
	</div>
	<div id="wrapper">
		<div id="nav">
			<ul>
				<li><a href="logout.php">Log out</a></li>
			</ul>
		</div>
		<div id="main">
			<h1>Verify</h1>
			<form method="post">
				<input type='text' name='rollno' placeholder='Roll number' />
				<input type='submit' value='Check Status' />
			</form>
<?php
if (isset($_POST['rollno'])) {
	$roll = $_POST['rollno'];
	$query="SELECT * FROM students WHERE roll_no='$roll'";
	if ($result = $mysqli->query($query))
	{
		/* fetch associative array */
		if ($row = $result->fetch_assoc()) {
			echo "<h3>Status of $roll</h3>";
			if ($row["hostel_due"] === null)
				echo "Hostel no-dues - yet to be approved.\n";
			else if ($row["hostel_due"] == 1)
				echo "<div class=\"green\">Hostel no-dues request was <b>APPROVED</b>.</div>\n";
			else
				echo "<div class=\"red\">Hostel no-dues request was <b>REJECTED</b>.</div>\n";
			echo "<br/>\n";
			if ($row["library_due"] === null)
				echo "Library no-dues - yet to be approved.\n";
			else if ($row["library_due"] == 1)
				echo "<div class=\"green\">Library no-dues request was <b>APPROVED</b>.</div>\n";
			else
				echo "<div class=\"red\">Library no-dues request was <b>REJECTED</b>.</div>\n";
		} else
			echo "No such roll number.";
		/* free result set */
		$result->free();
	}
}
?>
		</div>
	</div>

<?php else : ?>
            <h1>
                <span class="error"><font color="white">Error 403 Forbidden <br>You are not authorized to access this page.</span> <br>Please <a href="index.php">login</font></a>.
            </h1>
        <?php endif; ?>

</body>
</html>