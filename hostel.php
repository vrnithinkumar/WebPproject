<?php
require_once('config.php');
session_start();

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
		background:url("hstl.jpg") no-repeat center center fixed;
		 background-size: cover;
	}
	#nav a { color:white; }
	.reds a { color:green; }
	.green a { color:red; } /* Globally */
	#nav a:visited 
		{ 
			text-decoration: none; color:white; 
		}
	#nav a:hover 
		{ 
			text-decoration: none; color:#0B0B61; 
		}
		.reds,.green{
			font-weight:bold;
		}
	#header {
		padding: 20px 20px 10px;
		background-color: rgba(237, 132, 116,.85); /*rgb(225, 91, 80);*/
		text-align: center;
		color: #ffffff;
	}
	h1 {
		margin: 16px 0 8px;
	}
	#wrapper {
		margin: 10px;
	}
	#main {
		padding: 20px;
		font-size: 15.5px;
		margin-left: 300px;
		background-color: #FEFEFE;
		min-width: 320px;
		background: rgba(255, 255, 255,0.5);
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
	input {
		margin: 3px;
	}
	.error{
		color: red;
	}
	</style>
</head>
<?php if ((isset($_SESSION["user"]))&&($_SESSION["user"]=='h')) : ?>
<body>

	<div id="header">
		<h1>Hostel No-dues</h1>
	</div>
	<div id="wrapper">
		<div id="nav">
			<ul>
				<li><a href="hostel.php">Pending validation</a></li>
				<li><a href="hostel.php?history=1">Validation History</a></li>
				<li><a href="logout.php">Log out</a></li>
			</ul>
		</div>
		<div id="main">
<?php
	if (!isset($_GET["history"])) {
?>
			<h2>List of students pending validation</h2>
			<table >
				<tr>
					<th><strong>Roll Number</strong></th>
					<th><strong>Action</strong></th>
				</tr>
<?php
	
	$query="SELECT roll_no FROM students WHERE hostel_due is NULL";
	if ($result = $mysqli->query($query))
	{
		/* fetch associative array */
		while ($row = $result->fetch_assoc()) {
			echo "<tr>".
					"<td>$row[roll_no]</td>".
					"<td><div class=\"reds\"><a href='admin_action.php?roll=$row[roll_no]&type=h&action=1'>Approve</a></div> <div class=\"green\"><a href='admin_action.php?roll=$row[roll_no]&type=h&action=0'>Reject</a></div></td>".
				"</tr>";
		}

		/* free result set */
		$result->free();
	}
?>
			</table>
<?php
	} else {
?>
			<h2>Validation History</h2>
			<table>
				<tr>
					<th>Roll Number</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
<?php
	
	$query="SELECT roll_no, hostel_due FROM students WHERE hostel_due is not NULL";
	if ($result = $mysqli->query($query))
	{
		/* fetch associative array */
		while ($row = $result->fetch_assoc()) {
			echo "<tr>".
					"<td>$row[roll_no]</td>";
			if ($row["hostel_due"] == '1') 
				echo "<td>Approved</td><td><a href='admin_action.php?roll=$row[roll_no]&type=h&action=0'>Reject</a></td>";
			else
				echo "<td>Rejected</td><td><a href='admin_action.php?roll=$row[roll_no]&type=h&action=1'>Approve</a></td>";
			echo "</tr>";
		}

		/* free result set */
		$result->free();
	}
?>
			</table>
<?php
	}
?>
		</div>
	</div>
	 
        <?php else : ?>
            <h1>
                <span class="error">Error 403 Forbidden <br>You are not authorized to access this page.</span> <br>Please <a href="index.php">login</a>.
            </h1>
        <?php endif; ?>
        
</body>
</html>