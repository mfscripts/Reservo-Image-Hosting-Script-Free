<?php

// script to handle deletions of old images
// only images which have not been accessed since $days_to_keep_images
// days will be removed.

include_once("config.php");

$ago = date('Y-m-d H:i:s', strtotime("-".$days_to_keep_images." days"));
$get_images = mysql_query("SELECT id, filename FROM images WHERE lastaccessed < '".$ago."' AND status != 'removed'");
while($row = mysql_fetch_array($get_images)) {
  $fullpath = "storage/originals/".$row['filename'];
  unlink($fullpath);
  $update = mysql_query("UPDATE images SET status = 'removed', filename = 'removed.jpg' WHERE id = ".$row['id']." LIMIT 1");
}

?>