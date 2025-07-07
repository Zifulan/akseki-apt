<?php 
$feed_link = implode(',',get_post_custom_values("aptn_link"));
header($feed_link); 
?>