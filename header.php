<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<?php

include_once("config.php");

// do image cleanup
include_once("clean-up.php");

if(!$ptitle)   $ptitle = $site_name;
if(!$selected) $selected = "HOME";

//local func
function createhtmlname($name) {
  // remove extension first
  $replace_values = array(" ", "'", "\"", "\\", "/", "?", "|", "@", "#", "~", "!", "£", "$", "%", "^", "&", "*", "(", ")", "[", "]", "{", "}", "+", "=", "-");
  $name = str_replace($replace_values, "_", $name);
  $name = str_replace(",", "", $name);
  return strtolower($name);
}

?>

<html>
<head>
<title><?php echo $ptitle; ?> - <?php echo $site_url; ?></title>
    <META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <META NAME="keywords" CONTENT="<?php echo $pkeys; ?>">
    <META NAME="description" CONTENT="<?php echo $pdesc; ?>">
	<meta name="distribution" content="global">
    <link rel="stylesheet" href="<?php echo "http://".$site_url."/"; ?>styles.css" type="text/css">
</head>

<body style="margin-top:5px;margin-bottom:0px;margin-right:0px;margin-left:0px;" bgcolor="#FFFFFF">
<table width="760" cellpadding="0" cellspacing="0" bgcolor="#47567A" align="center">
<tr>
  <td valign="top" width="10" style="background-image:url('<?php echo "http://".$site_url."/"; ?>images/top-bg-main.jpg'); background-repeat: repeat-x;"><img src="<?php echo "http://".$site_url."/"; ?>images/top-left-main.jpg" width="10" height="10"></td>
  <td valign="top" style="background-image:url('<?php echo "http://".$site_url."/"; ?>images/top-bg-main.jpg'); background-repeat: repeat-x;">
    <a href="index.html"><img src="<?php echo "http://".$site_url."/"; ?>images/main-logo.jpg" width="340" height="79" border="0" alt="<?php echo $site_name; ?> - Free Image Hosting"></a>
  </td>
  <td valign="top" align="right" style="background-image:url('<?php echo "http://".$site_url."/"; ?>images/top-bg-main.jpg'); background-repeat: repeat-x;"><img src="<?php echo "http://".$site_url."/"; ?>images/top-right-main.jpg" width="10" height="10"></td>
</tr>

<tr>
  <td valign="top" colspan="3">
    <table width="749" cellpadding="0" cellspacing="0" align="center">
	  <tr>
        <td valign="top"><img src="<?php echo "http://".$site_url."/"; ?>images/sub-top.jpg" width="749" height="6"></td>
	  </tr>
	  <tr>
	    <td valign="top" bgcolor="#356AA0" align="left" style="background-image:url('<?php echo "http://".$site_url."/"; ?>images/dashed-line.jpg'); background-repeat: repeat-x; background-position: bottom;"><br>
		  <table cellpadding="0" cellspacing="0">
		    <tr>
			<td width="13" style="background-image:url('<?php echo "http://".$site_url."/"; ?>images/dashed-line.jpg'); background-repeat: repeat-x; background-position: bottom;">&nbsp;</td>
			<?php
			function outputtab($name, $url, $state = "off") {
			  global $site_url;
			  return '<td><table cellpadding="0" cellspacing="0"><tr>
			<td><img src="http://'.$site_url.'/images/tab-left-'.$state.'.jpg" width="7" height="40"></td>
			<td style="background-image:url(\'http://'.$site_url.'/images/tab-mid-'.$state.'.jpg\'); background-repeat: repeat-x;" class="headerfont">&nbsp;&nbsp;<a href="http://'.$site_url.'/'.$url.'" class="headera">'.$name.'</a>&nbsp;&nbsp;</td>
			<td><img src="http://'.$site_url.'/images/tab-right-'.$state.'.jpg" width="6" height="40"></td>
			</tr></table></td>';
			}
			if($selected == "HOME") $state = "on"; else $state = "off";
			echo outputtab("upload an image", "index.html", $state);
			if($selected == "FAQ") $state = "on"; else $state = "off";
			echo outputtab("faq", "faq.html", $state);
			if($selected == "RECENT") $state = "on"; else $state = "off";
			echo outputtab("recent uploads", "recent.html", $state);
			if($selected == "TOS") $state = "on"; else $state = "off";
			echo outputtab("terms", "tos.html", $state);
			if($selected == "CONTACT") $state = "on"; else $state = "off";
			echo outputtab("contact us", "contact.html", $state);
			?>
			<td>&nbsp;</td>
			</tr>
		  </table>
		</td>
	  </tr>
	  <tr>
	    <td height="300" valign="top" bgcolor="#FFFFFF">

		  <table cellpadding="3" cellspacing="0" width="100%">
		    <tr>
			  <td>