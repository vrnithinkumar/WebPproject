<html>
<head>
<link rel="stylesheet" type="text/css" href="css_index.css">
</head>
<body>
	<div id="header">
		<h1>No dues - just a click away</h1>
		<h4>Making it possible for all college administration to manage students subject registration which includes hostel dues, library dues...</h4>
	</div>


       <div class="ribbon-wrapper-green"><div class="ribbon-green">CONTACT</div></div>



		<div id="adminform">
			<h2>Admin Login</h2>
			<form method="post" action="redirect.php">
				<input type="text" name="user" placeholder="Username" />
				<input type="password" name="pass" placeholder="Password" />
				<input type="submit" value="Log in" />
			</form>
		</div>
		<div id="studentsform">
			<h2>Student</h2>
			<form method="post" action="student_form.php">
				<input type="text" name="rollno" placeholder="Roll Number" />
				<input type="submit" name="apply" value="Apply" />
				<input type="submit" name="status" value="Get Status" />
			</form>
		</div>
		<div id="nitclogo">
			<img src="nitc-logo.png" />
		</div>
	</div>
	<div id="footer">
		Save Our Trees...  Save Paper, Save Trees, Save Money
	</div>
</body>
</html>