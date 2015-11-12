<?php

error_reporting(0);

// db bits here
include_once("db_connect.php");

// site details
$site_name  = "Your Site Name";           // site name/title
$site_url   = "yourdomain.com";    // site url. Lowercase. Excluding the www. Remove any ending forward slash '/'. i.e. 'mysitename.com'.
$site_admin = "info@yourdomain.com";      // email address used for the contact page

// other bits
$max_upload_size         = "2097152";     // maximum image filesize permitted
$max_upload_display_size = "2mb";         // displays on the homepage
$days_to_keep_images     = 60;            // after how many days of inactivity images should be removed
$permit_hotlinking       = TRUE;          // whether or not to allow images to be directly linked from external sites

$watermark        = "images/watermark.png";  // path to watermark image - must be a PNG - Leave blank for no watermark
$watermark_alpha  = 50;  // measured from 1 to 100 this is the transparency of the watermark image
$watermark_pos    = "bottom-right";  // watermark position. Options are top-left, top-right, bottom-left, bottom-right, center

$show_delete_code = TRUE;  // if TRUE, the user is given a unique url to delete the image. This is shown on the completition of upload page. (index.html)

$show_pass_option = TRUE;  // if TRUE, the user is given the option to specify a password on an image

$default_upload_view = "MULTIPLE";  // should be set to 'SINGLE' or 'MULTIPLE' to set either the single or Flash multiple uploader tool, as the default homepage view

ini_set("memory_limit", "100M");

?>