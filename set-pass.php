<?php

include_once("config.php");
include_once("function-library.php");

?>
<html>
<head>
<title></title>
    <link rel="stylesheet" href="<?php echo "http://".$site_url."/"; ?>styles.css" type="text/css">
</head>

<body style="margin-top:5px;margin-bottom:0px;margin-right:0px;margin-left:0px;background-color:transparent;">
<?php
  if(strlen($password) > 4) {
    $userip = GetHostByName($REMOTE_ADDR);
	$add_pass = mysql_query("UPDATE images SET password = '".preparedata($password)."' WHERE id = ".$im." AND originalip = '".$userip."' LIMIT 1");
	if($add_pass) echo "<b>Password set!</b>";
	else echo "<b>ERROR: Could not set password, please contact support.</b>";
  }
  else {
	echo "<b>Optional: Specify A Password:</b><br>Restrict access to this image by requesting a password for anyone attempting to view it.<br>";
	echo "<table width='100%' cellpadding='3' cellspacing='0' style='margin-top:6px;'><form method='POST' action='set-pass.php'><tr><td width='65'>Password:</td><td><input name='password' value='' type='password' style='font-size:10px;'>&nbsp;&nbsp;<input name='submit' type='submit' value='set' style='font-size:10px;'></td></tr><input name='im' type='hidden' value='".$im."'></form></table>";
  }
?>

</body>
</html>