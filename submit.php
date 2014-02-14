<?php
include 'credentials.php';

$link = mysql_connect('localhost', $credentials['db_user'], $credentials['db_pass']); 
if (!$link) { 
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($credentials['db_name']);

$comment = $_POST[comment];
$comment = str_replace("'", "&#39;", $comment);
$comment = str_replace("<", "&#60;", $comment);
$comment = str_replace(">", "&#62;", $comment);
$comment = substr($comment, 0, 300);
$plate = $_POST[plate];
$plate = strtolower($plate);
$plate = preg_replace('/[^a-z0-9]+/i', '', $plate);
$plate = str_replace(" ", "", $plate);
$plate = substr($plate, 0, 7);
$numdate = date(YmdHis);
$date = date(F . " " . j . ", " . Y);
$validcomment = true;
$validplate = true;
if (isset($_COOKIE[carcomments])) {
	printf("You can only submit one comment every five minutes" . "<br/>");
	$title = "Error";
} else {
	if (empty($comment) || $comment === "Comment") {
		printf("Please submit a valid comment." . "<br/>");
		$validcomment = false;
		$title = "Error(s)";
	}
	if (empty($plate) || $plate === "plate") {
		printf("Please submit a valid license plate" . "<br/>");
		$validplate = false;
		$title = "Error(s)";
	}
	if ($validcomment === true && $validplate === true) {
		mysql_query("INSERT INTO comments (`plate`, `comment`, `numdate`, `date`) VALUES ('$plate', '$comment', '$numdate', '$date')");
		$message = "Plate: " . $plate . "\r\n" . "Comment: " . $comment;
		mail("jrkolsby@mac.com", "Someone Submitted To CarComments!", $message);
		setcookie("carcomments", "true", time()+300);
		print "<meta http-equiv='REFRESH' content='0;url=http://www.jmkl.co/carcomments/'>";
	}
}

?>
<!DOCTYPE html>
<head>
<title>Submitting...</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<style type="text/css">
body {
	background: #61B1E5;
}
* {
	font-family: 'Open Sans', sans-serif;
	text-align: center;
	color: #fff;
}
</style>
</head>