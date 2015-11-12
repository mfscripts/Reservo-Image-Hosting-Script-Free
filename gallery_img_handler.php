<?php

function previewImage ($imageid, $max_x = NULL) {

  /* Initialise Includes, Constants, Variables */
  include_once("db_connect.php");
  include_once("config.php");
  $imagesDirectory = "storage/originals";
  
  global $site_url;
  
  if($max_x == NULL) $max_x = 5000;  // set to huge image size so that the original size is used.
  
  $targetDirectory = "$imagesDirectory/".$max_x;
  $errorImage = "errorimage.jpg";
  $imageName = $errorImage;
  $sourceImagePath = "$imagesDirectory/$imageName";
  $targetImagePath = "$targetDirectory/$imageName";
  $outputImageQuality = 80;

  /* Attempt to look up article in DB and find original image */
  $result = mysql_query("SELECT * FROM images WHERE id = $imageid");
  if(mysql_numrows($result) == 1) {
    $filename    = mysql_result($result, 0, filename);
    $description = mysql_result($result, 0, description);
	$dateadded   = mysql_result($result, 0, dateadded);
	$totalviews  = mysql_result($result, 0, totalviews);
	$filesize    = mysql_result($result, 0, filesize);
	$status      = mysql_result($result, 0, status);
	$mime_type   = mysql_result($result, 0, mimetype);
	$password    = mysql_result($result, 0, password);
	$originalfilename    = mysql_result($result, 0, originalfilename);
	$temp_ex     = explode(".", $filename);
	$extension   = $temp_ex[1];
    $tempPath    = "$imagesDirectory/$filename";
    if(file_exists($tempPath)) {
      $imageName = $tempName;
      $sourceImagePath = $tempPath;
      $sourceImagePath = "$imagesDirectory/$filename";
      $targetImagePath = "$targetDirectory/$filename";
    }
  }
  /* Check target directory exists and if not create it */
  if(!is_dir($targetDirectory)) mkdir($targetDirectory, 0777);
  
  /* Check if file is already cached, if so just deliver existing image */
  if(!file_exists($targetImagePath)) {

    /* MAIN RESIZING SCRIPT */

    /* Load Dimensions of Original Image */
    $originalImageSize = getimagesize($sourceImagePath);
    $original_x = $originalImageSize[0];
    $original_y = $originalImageSize[1];
    
    if($original_x > $original_y) {
    $max_y = 0;
    $max_x = $max_x;
    }
    else if($original_x < $original_y) {
    $max_y = $max_x;
    $max_x = 0;
    }
    else {
    $max_y = $max_x;
    $max_x = $max_x;
    }

    /* Work out ratios and which way to crop */
    $state = 0;
    if($square == 1) {
      if($max_x == 0) $max_x = $max_y;
      elseif($max_y == 0) $max_y = $max_x;
    }
    if($max_x == 0) $state = 1;
    elseif($max_y == 0) $state = 2;
    if($state == 0) {
      $testratio = $max_x / $max_y;
      $origratio = $original_x / $original_y;
      if($origratio > $testratio) $state = 1;
      elseif($origratio < $testratio) $state = 2;
      else $state = 3;
    }

    /* With ratios sorted, plot co-ordinates */

    if($state == 1) {
      /* make new-y = max-y OR crop sides */

      if($square == 0) {
        if(($original_y > $max_y) || ($enlarge == 1)) $new_y = $max_y;
        else $new_y = $original_y;
        $new_x = round(($original_x / ($original_y / $new_y)), 0);
        $srcx = 0;
        $srcy = 0;
        $srcw = $original_x;
        $srch = $original_y;
      }

      else {
        if(($original_y > $max_y) || ($enlarge == 1)) $new_y = $max_y;
        else $new_y = $original_y;
        $new_x = $new_y;
        $tempratio = ($original_y / $new_y);
        $sectionwidth = $new_y * $tempratio;
        $srcy = 0;
        $srch = $original_y;
        $srcx = floor(($original_x - $sectionwidth) / 2);
        $srcw = floor($sectionwidth);
      }

    }

    elseif($state == 2) {
      /* make new-x = max-x OR crop top & bottom */
      
      if($square == 0) {
        if(($original_x > $max_x) || ($enlarge == 1)) $new_x = $max_x;
        else $new_x = $original_x;
        $new_y = round(($original_y / ($original_x / $new_x)), 0);
        $srcx = 0;
        $srcy = 0;
        $srcw = $original_x;
        $srch = $original_y;
      }

      else {
        if(($original_x > $max_x) || ($enlarge == 1)) $new_x = $max_x;
        else $new_x = $original_x;
        $new_y = $new_x;
        $tempratio = ($original_x / $new_x);
        $sectionheight = $new_x * $tempratio;
        $srcx = 0;
        $srcw = $original_x;
        $srcy = floor(($original_y - $sectionheight) / 2);
        $srch = floor($sectionheight);
      }

    }

    elseif($state == 3) {
      /* original image ratio = new image ratio - use all of image */

      if($square == 0) {
        if(($original_x > $max_x) || ($enlarge == 1)) $new_x = $max_x;
        else $new_x = $original_x;
        $new_y = round(($original_y / ($original_x / $new_x)), 0);
        $srcx = 0;
        $srcy = 0;
        $srcw = $original_x;
        $srch = $original_y;
      }

      else {
        if(($original_x > $max_x) || ($enlarge == 1)) $new_x = $max_x;
        else $new_x = $original_x;
        $new_y = $new_x;
        $srcx = 0;
        $srcy = 0;
        $srcw = $original_x;
        $srch = $original_y;
      }

    }
    
    
    /* Do Conversion */
	if(($extension == "jpeg") || ($extension == "jpg")) $originalImage = ImageCreateFromJPEG($sourceImagePath);
	elseif($extension == "gif") $originalImage = ImageCreateFromGIF($sourceImagePath);
	elseif($extension == "png") $originalImage = ImageCreateFromPNG($sourceImagePath);
	//elseif($extension == "bmp") $originalImage = ImageCreateFromWBMP($sourceImagePath);  // removed since Windows BMP is not supported
    $newImage = ImageCreateTrueColor($new_x, $new_y);
    ImageCopyResampled ($newImage, $originalImage, 0, 0, $srcx, $srcy, $new_x, $new_y, $srcw, $srch);
	
	global $watermark;
	global $watermark_alpha;
	global $watermark_pos;
	if(strlen($watermark) > 0) {
	  $watermark1 = imagecreatefrompng($watermark);
	  $watermark_width = imagesx($watermark1);  
	  $watermark_height = imagesy($watermark1);
	  if($watermark_pos == "top-left") {
	    $dest_x = 0;  
	    $dest_y = 0;
	  }
	  elseif($watermark_pos == "top-right") {
	    $dest_x = $new_x - $watermark_width;  
	    $dest_y = 0;
	  }
	  elseif($watermark_pos == "bottom-left") {
	    $dest_x = 0;  
	    $dest_y = $new_y - $watermark_height;
	  }
	  elseif($watermark_pos == "bottom-right") {
	    $dest_x = $new_x - $watermark_width;  
	    $dest_y = $new_y - $watermark_height;
	  }
	  else {
	    $dest_x = ($new_x/2) - ($watermark_width/2);  
	    $dest_y = ($new_y/2) - ($watermark_height-2);
	  }
	  imagecolortransparent($watermark1, imagecolorat($watermark1, 0, 0));   
	  imagecopymerge($newImage, $watermark1, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_alpha);
	}
    ImageJPEG ($newImage, $targetImagePath, $outputImageQuality);
    ImageDestroy($newImage);
    ImageDestroy($originalImage);
  }
  
  $imageSize = getimagesize($targetImagePath);
  $returnvars = array();
  
  $returnvars['targetImagePath'] = "http://".$site_url."/".$targetImagePath;
  $returnvars['width']       = $imageSize[0];
  $returnvars['height']      = $imageSize[1];
  $returnvars['description'] = $description;
  $returnvars['status']      = $status;
  $dateadded = substr($dateadded, 8, 2)."/".substr($dateadded, 5, 2)."/".substr($dateadded, 0, 4)." ".substr($dateadded, 11, 8);
  $returnvars['dateadded']   = $dateadded;
  $returnvars['totalviews']  = $totalviews;
  $filesize = number_format($filesize/1024, 1);
  if($filesize > 1000) $filesize = number_format($filesize/1024, 1)."mb";
  else $filesize = $filesize."kb";
  $returnvars['filesize']    = $filesize;
  $returnvars['mime_type']   = $mime_type;
  $returnvars['password']    = $password;
  $returnvars['originalfilename']    = $originalfilename;
  
  return $returnvars;

}

?>