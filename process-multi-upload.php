<?php
include_once("config.php");
include_once("function-library.php");
?>

<?php
function log_data($data) {
	$ourFileName = "logs/".date("Y-m-d").".txt";
	$ourFileHandle = fopen($ourFileName, 'a') or die("can't open file");
	fwrite($ourFileHandle, date("d/m/Y H:i:s").": ".$data."\n");
	fclose($ourFileHandle);
}

log_data("Started import of ".$_FILES['Filedata']['name']);
$userip = $_SERVER['REMOTE_ADDR']; 
log_data("User IP is ".$userip);

  // validation bits
  $filesize    = $_FILES['Filedata']['size'];
  $tmpfile     = $_FILES['Filedata']['tmp_name'];
  $filename    = $_FILES['Filedata']['name'];
  $contenttype = $_FILES['Filedata']['type'];
  $extension   = pathinfo($_FILES['Filedata']['name']);
  $extension   = strtolower($extension[extension]);
  

	$valid_ext_types = array('jpeg', 'jpg', 'gif', 'png');
	if(!in_array($extension, $valid_ext_types)) {
	  $error .= "File type does not appear to be a supported image (".$extension."). Please try another format.<br>";
	}
  
  if(strlen($error) == 0) {

    $uploaddir        = 'storage/originals/';
    $newfilename      = randomfilename() . "." . $extension;
	
    $uploadfile = $uploaddir . $newfilename;
	
    if (!move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile)) {
	  $error .= "Could not move file into storage, please try again later.";
	  log_data("ERROR: ".$error);
	}
	else {
	  // add to db
	  $userip = $_SERVER['REMOTE_ADDR']; 
	  list($originalwidth, $originalheight, $type, $attr) = getimagesize($uploadfile);
	  
	  $tracker = randomfilename();
	  
	  $insert_image    = "INSERT INTO images (dateadded, mimetype, originalfilename, filename, filesize, description, originalip, originalwidth, originalheight, lastaccessed, tracker, mutracker) VALUES (NOW(), '".preparedata($contenttype)."', '".preparedata($filename)."', '".preparedata($newfilename)."', '".preparedata($filesize)."', '', '".preparedata($userip)."', '".$originalwidth."', '".$originalheight."', NOW(), '".preparedata($tracker)."', '".preparedata($mutracker)."')";
	  $do_insert_image = @mysql_query($insert_image);
	  $item_id = mysql_insert_id();
	  if($do_insert_image) {
		log_data("SUCCESS: Image successfully uploaded. Ref: ".$item_id);
	  }
	  else log_data("ERROR: SQL INSERT FAILED - ".$insert_image);
	}

  }
  else log_data("ERROR: ".$error);
  
  log_data("Finished import process for ".$_FILES['Filedata']['name']."\n\r");

?>