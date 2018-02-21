<?php
$wp_usernames = array();
$url = "http://wordpresssite.com";
$returned_content = "";
$stripped_user = "";
$mystring = "";


function getTitle_wp_user($data) {
     $data = @file_get_contents($data);
     $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
     if ($data === false) {
       return false;
     }
    else {
    
     return $title;
   }
  }




function get_user($in_url){ 
   
   
   for ($x = 1; $x <= 4000; $x++) 
   {
    $url = $in_url . "/?author=".(string)$x;
    //print $url;
    print "\n";
    $returned_content = getTitle_wp_user($url);
    
      //print $returned_content;
    
    $stripped_user = explode("|",$returned_content); 
    if($returned_content != false)
     {
      $mystring = $stripped_user['0']; 
      print $mystring;
      $wp_usernames[] = $mystring;
     
     }
    else
       {
        break 1;
       }
   }
}
get_user($url);
//work with array possibly?

?>
