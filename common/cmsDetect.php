<?php
/**
 * detect CMS
 */
 class CmsDetect
 {
     public $cmssc = '';
     public $cmsurl = '';

     function __construct($cmsurl)
     {
         $this->cmssc = file_get_contents($cmsurl);
         $this->cmsurl = $cmsurl;
     }

     public function detect()
     {
         $cms = '';
         $detect_array = array(
             'WordPress'=>'/wp-content/',
             'DedeCMS'=>'DedeCMS',
             'Joomla'=>'Joomla',
             'Magento'=>'/skin/frontend/'
         );
         foreach ($detect_array as $cms_name => $cms_flag) {
             if (strpos($this->cmssc, $cms_flag) !== false) {
                 $cms =$cms_name;
                 return "\e[92m".$cms;
             }
         }

        if ($cms === '') {
            $cms = $this->otherDetect();
        }

         return $cms ? $cms : "\e[91mCould Not Detect";
     }

     public function otherDetect()
     {
         $drpurl= $this->cmsurl."/misc/drupal.js";
         $drpsc = file_get_contents($drpurl);
         if (strpos($drpsc, 'Drupal') !== false) {
             return "\e[92mDrupal";
         }
     }
 }
