<!DOCTYPE html>
<head>
<title>Car Comments</title>
<meta name="description" content="Working Description">
<meta name="robots" content="ALL">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="global.css" rel="stylesheet" type="text/css" />
<style type="text/css" media="only screen and (max-device-width: 1024px)">
body {
min-width: 1024px;
}
</style>
<style type="text/css" media="only screen and (max-device-width: 480px)">
body {
min-width: 480px;
}
</style>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="sto/main.js"></script>
<?php

include 'credentials.php';

$link = mysql_connect('localhost', $credentials['db_user'], $credentials['db_pass']); 
if (!$link) { 
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($credentials['db_name']);

?>
</head>
<body>
<div id="shadow"></div>
<div id="shadowbox-wrapper">
	<form method="post" action="submit.php">
	<div id="close"></div>
	<div class="plate">
	<input name="plate" class="input" value="plate" onFocus="if(this.value==='plate'){this.value=''};" onblur="if(this.value===''){this.value='plate'};">
	</div>
	<div class="comment">
	<textarea name="comment" class="textarea" value="Comment" onFocus="if(this.value==='Comment'){this.value=''};" onblur="if(this.value===''){this.value='Comment'};"></textarea>
	</div>
	<input value="Send" type="submit" id="send">
	</form>
</div>

<button id="submit">Submit</button>

<div id="logo"></div>

<div id="wrapper">

<?php


$usedplates = array(
	'0' => '0'
);
$query = "SELECT * FROM comments ORDER BY numdate DESC"; 
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
	$currentplate = $row[plate];
	if (!in_array($currentplate, $usedplates)) {
		array_push($usedplates, $currentplate);
		print "<div class='post'>";
		print "<div class='plate'>";
		print "<h1>" . $row[plate] . "</h1>";
		print "</div>";
		$commentquery = "SELECT * FROM comments ORDER BY numdate ASC"; 
		$commentresult = mysql_query($commentquery) or die(mysql_error());
		while($row = mysql_fetch_array($commentresult)){
			if ($row[plate] === $currentplate) {
				print "<div class='comment'>";
				print $row[comment];
				print "<div class='date'>";
				print $row[date];
				print "</div>";
				print "</div>";
			};
		}
		print "<div class='add' ref='" . $currentplate . "'></div>";
		print "</div>";
	};
}
?>
</div>
</body>