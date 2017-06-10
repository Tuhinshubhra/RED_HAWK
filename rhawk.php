<?php
error_reporting(0);

$blue = "\e[34m";
$lblue = "\e[36m";
$cln = "\e[0m";
$green = "\e[92m";
$fgreen = "\e[32m";
$red = "\e[91m";
$bold = "\e[1m";

echo"\n\e[91m
---------------------------------------------------------------------------

   ██████╗ ███████╗██████╗     ██╗  ██╗ █████╗ ██╗    ██╗██╗  ██╗
   ██╔══██╗██╔════╝██╔══██╗    ██║  ██║██╔══██╗██║    ██║██║ ██╔╝
   ██████╔╝█████╗  ██║  ██║    ███████║███████║██║ █╗ ██║█████╔╝
   ██╔══██╗██╔══╝  ██║  ██║    ██╔══██║██╔══██║██║███╗██║██╔═██╗
   ██║  ██║███████╗██████╔╝    ██║  ██║██║  ██║╚███╔███╔╝██║  ██╗
   ╚═╝  ╚═╝╚══════╝╚═════╝     ╚═╝  ╚═╝╚═╝  ╚═╝ ╚══╝╚══╝ ╚═╝  ╚═╝
$bold
All In One Tool For Info Gathering, SQL Vulnerability Scannig and Crawling
$fgreen
---------------------------------------------------------------------------
             [+] Coded By - R3D#@X0R_2H1N A.K.A Tuhinshubhra
            $lblue [+] Version - 1.0.0
---------------------------------------------------------------------------
\n";
thephuckinstart :
echo "\n\e[0m".$blue."Enter Your Choice (help/fix/domain) : $green";
$ip=trim(fgets(STDIN,1024));
if ($ip == "help"){
echo"\n\n[+] RED HAWK Help Screen [+] \n\n";
echo $bold.$lblue."Commands\n";
echo "========\n";
echo $fgreen."[1] help:$cln View The Help Menu\n";
echo $bold.$fgreen."[2] fix:$cln Installs All Required Modules (Suggested If You Are Running The Tool For The First Time)\n";
echo $bold.$fgreen."[3] URL:$cln Enter The Domain Name Which You Want To Scan (Format:www.sample.com / sample.com)\n";
goto thephuckinstart;
}
elseif ($ip == "fix") {
  echo "\e[91m\e[1m[+] RED HAWK FiX MENU [+]\n$cln";
  echo "\e[32m[+] Installing Required Modules ...\n";
  echo "\e[32m[+] Installing cURL ...\e[0m";
  system ("sudo apt-get -qq --assume-yes install curl");
  echo "\n\e[32m[i]$bold cURL Installed Successfully!\e[0m";
  echo "\n\e[32m[+] Installing php-xml ...\e[0m";
  system ("sudo apt-get -qq --assume-yes install php-xml");
  echo "\n\e[32m[i]$bold php-XML Installed Successfully!\e[0m";
  echo "\n\e[32m[+] Setting Things Up ...\n\e[0m";
  echo "\e[32m[#]$bold JOB FINISHED SUCCESSFULLY! Starting RED HAWK ...\n\e[0m";
  goto thephuckinstart;
}
elseif (strpos($ip,'://') !== false){ echo "Enter URL Without Http/Https\n"; goto thephuckinstart ;}
elseif (strpos($ip,'.') == false ) { echo "Enter A Valid URL\n"; goto thephuckinstart ;}
else
{
  echo "\nDo The Website Have HTTPS Enabled ?\n";
  echo $bold."1. No \n2. Yes";
  echo $cln."\nInput Choice (1/2): ";
  $ipsl = trim(fgets(STDIN,1024));
  if ($ipsl == "2") {
    $ipsl = "https://";
  }
  else {
    $ipsl = "http://";
  }
  echo"\n$cln"."$lblue"."[+] Scanning Begins ... \n";
  echo"$blue"."[i] Scanning Site:\e[92m $ipsl"."$ip \n";
  echo "\n\n";

//----------------------------------------------------------//
//         Basic Scans
//----------------------------------------------------------//

  echo "\n$bold"."$lblue"."B A S I C   I N F O \n";
  echo "====================\n";
  echo"\n\e[0m";

//website ip

  $wip = gethostbyname($ip);
  echo"\n$blue"."[+] IP address: ";
  echo "\e[92m";
  echo $wip ."\n\e[0m";

//detect webserver

  $urlws = $ipsl.$ip;
  $wsheaders = get_headers($urlws, 1);
  echo"$blue"."[+] Web Server: ";
  $ws = $wsheaders['Server'];
  if ($ws == ""){echo "\e[91mCould Not Detect\e[0m";}
  else { echo "\e[92m$ws \e[0m";}
  echo"\n";

//detect CMS

  $cmsurl = $ipsl.$ip;
  $cmssc = file_get_contents($cmsurl);
  if (strpos($cmssc,'/wp-content/') !== false){$tcms="\e[92mWordPress";}else{
    if (strpos($cmssc,'Joomla') !== false){$tcms="\e[92mJoomla";}else{
    $drpurl= $ipsl.$ip."/misc/drupal.js";
    $drpsc = file_get_contents($drpurl);
      if (strpos($drpsc,'Drupal') !== false){$tcms= "\e[92mDrupal";}else{
          if (strpos($cmssc,'/skin/frontend/') !== false){$tcms="\e[92mMagento";}else{
            $tcms="\e[91mCould Not Detect";
  }}}}
  echo "$blue"."[+] CMS: $tcms \e[0m";

//detect cloudflare

  echo"\n$blue"."[+] Cloudflare: ";
  $urlhh= "http://api.hackertarget.com/httpheaders/?q=". $ip;
  $resulthh = file_get_contents ($urlhh);
  if (strpos($resulthh,'cloudflare') !== false){
    echo "\e[91mDetected\n\e[0m";
  }
  else {
    echo "\e[92mNot Detected\n\e[0m";
  }

//detect robots.txt

  echo"$blue"."[+] Robots File: ";
  $rbturl = $ipsl.$ip."/robots.txt";
  $rbthandle = curl_init($rbturl);
  curl_setopt($rbthandle, CURLOPT_RETURNTRANSFER, TRUE);
  $rbtresponse = curl_exec($rbthandle);
  $rbthttpCode = curl_getinfo($rbthandle, CURLINFO_HTTP_CODE);
  if($rbthttpCode == 200) {
    $rbtcontent = file_get_contents($rbturl);
    if ($rbtcontent == ""){
      echo "Found But Empty!";
    }
    else{
      echo $green."Found $cln \n";
      echo $blue ."\n -------------[ contents ]----------------  $cln \n";
      echo $rbtcontent;
      echo "\n-----------[end of contents]-------------";
    }
  }
  else
  {
      echo $red."Could NOT Find robots.txt! $cln \n";
    }

//The scans starts here

    echo "\n\n$cln";
    echo "\n\n$bold".$lblue."W H O I S   L O O K U P\n";
    echo "========================";
    echo"\n\n$cln";
    $urlwhois= "http://api.hackertarget.com/whois/?q=". $ip;
    $resultwhois = file_get_contents ($urlwhois);
    echo"\t";
    echo $resultwhois ;
    echo"\n\n$cln";


    echo"\n\n$bold".$lblue."G E O  I P  L O O K  U P\n";
    echo "=========================";
    echo"\n\n$cln";
    $urlgip= "http://api.hackertarget.com/geoip/?q=". $ip;
    $resultgip = file_get_contents ($urlgip);
    echo $resultgip ;
    echo "\n\n$cln";


    echo "\n\n$bold".$lblue."H T T P   H E A D E R S\n";
    echo "=======================";
    echo"\n\n$cln";
    echo $resulthh ;
    echo "\n\n";


    echo "\n\n$bold".$lblue."D N S   L O O K U P\n";
    echo "===================";
    echo"\n\n$cln";
    $urldlup= "http://api.hackertarget.com/dnslookup/?q=". $ip;
    $resultdlup = file_get_contents ($urldlup);
    echo $resultdlup ;
    echo "\n\n";


    echo "\n\n$bold".$lblue."S U B N E T   C A L C U L A T I O N\n";
    echo "====================================";
    echo"\n\n$cln";
    $urlscal= "http://api.hackertarget.com/subnetcalc/?q=". $ip;
    $resultscal = file_get_contents ($urlscal);
    echo $resultscal ;
    echo "\n\n";


    echo "\n\n$bold".$lblue."N M A P   P O R T   S C A N\n";
    echo "============================";
    echo"\n\n$cln";
    $urlnmap= "http://api.hackertarget.com/nmap/?q=". $ip;
    $resultnmap = file_get_contents ($urlnmap);
    echo $resultnmap ;
    echo "\n";
//----------------------------------------------------------//
//        Subdomains Finder
//---------------------------------------------------------//
  echo "\n\n$bold".$lblue."S U B - D O M A I N   F I N D E R\n";
  echo "==================================";
  echo"\n\n";
  $urlsd= "http://api.hackertarget.com/hostsearch/?q=". $ip;
  $resultsd = file_get_contents ($urlsd);
  $subdomains = explode("\n", $resultsd);
  $sdcount = count($subdomains);
  $sdcount = $sdcount - 1;
  echo "\n$blue"."[i] Total Subdomains Found :$cln ".$green .$sdcount."\n\n$cln";
  foreach ($subdomains as $subdomain) {
    //echo ;
    echo "[+] Subdomain:$cln $fgreen".(str_replace(",","\n\e[0m[-] IP:$cln $fgreen",$subdomain));
    echo "\n\n$cln";
  }
  echo "\n\n";
//----------------------------------------------------------//
//         Reverse IP scan
//----------------------------------------------------------//

  echo "\n\n$bold".$lblue."R E V E R S E   I P   L O O K U P\n";
  echo "==================================";
  echo"\n\n";
  $sth = 'http://domains.yougetsignal.com/domains.php';
  $ch = curl_init($sth);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 ); curl_setopt($ch, CURLOPT_POSTFIELDS, "remoteAddress=$ip&ket=");
  curl_setopt($ch, CURLOPT_HEADER, 0); curl_setopt($ch, CURLOPT_POST, 1);
  $resp = curl_exec($ch); $resp = str_replace("[","", str_replace("]","", str_replace("\"\"","", str_replace(", ,",",", str_replace("{","", str_replace("{","", str_replace("}","", str_replace(", ",",", str_replace(", ",",", str_replace("'","", str_replace("'","", str_replace(":",",", str_replace('"','', $resp ) ) ) ) ) ) ) ) ) ))));
  $array = explode(",,", $resp);
  unset($array[0]);
  echo "\n$blue"."[i] Total Sites Found On This Server :$cln ".$green .count($array)."\n\n$cln";
  foreach($array as $izox) {
  //  echo"\n";
    echo "\n$blue"."[#]$cln ".$fgreen.$izox.$cln;
    echo"\n$blue"."[-] CMS:$cln $green";
    $cmsurl = $ipsl.$izox;
    $cmssc = file_get_contents($cmsurl);
      if (strpos($cmssc,'/wp-content/') !== false){$tcms="WordPress";}else{
        if (strpos($cmssc,'Joomla') !== false){$tcms="Joomla";}else{
          $drpurl= $ipsl.$ip."/misc/drupal.js";
          $drpsc = file_get_contents($drpurl);
          if (strpos($drpsc,'Drupal') !== false){$tcms= "Drupal";}else{
            if (strpos($cmssc,'/skin/frontend/') !== false){$tcms="Magento";}else{
              $tcms=$red."Could Not Detect$cln ";
            }}}}
            echo $tcms ."\n";
          }

//----------------------------------------------------------//
//        SQL
//----------------------------------------------------------//

  echo "\n\n";
  echo "\n\n$bold".$lblue."S Q L   V U L N E R A B I L I T Y   S C A N N E R\n";
  echo "===================================================$cln";
  echo"\n";
  $lulzurl = $ipsl.$ip;
  $html = file_get_contents($lulzurl);
  $dom = new DOMDocument;
  @$dom->loadHTML($html);
  $links = $dom->getElementsByTagName('a');
  $vlnk = 0;
  foreach ($links as $link){
    $lol= $link->getAttribute('href');
    if( strpos( $lol, '?' ) !== false ){
      echo"\n$blue [#] ".$fgreen .$lol ."\n$cln";
      echo$blue." [-] Searching For SQL Errors: ";
      $sqllist = file_get_contents('sqlerrors.ini');
      $sqlist = explode(',', $sqllist);
      if (strpos($lol, '://') !== false){
        $sqlurl = $lol ."'";
      }
      else{
        $sqlurl = $ipsl.$ip."/".$lol."'";
      }
      $sqlsc = file_get_contents($sqlurl);
      $sqlvn = "$red Not Found";
      foreach($sqlist as $sqli){
        if (strpos($sqlsc, $sqli) !== false) $sqlvn ="$green Found!";
      }
      echo $sqlvn;
      echo"\n$cln";
      echo "\n";
      $vlnk++ ;
    }
  }
  echo"\n\n$blue [+] URL(s) With Parameter(s):".$green.$vlnk;
  echo"\n\n";

//----------------------------------------------------------//
//         Crawler
//----------------------------------------------------------//

  echo"\n\n$bold".$lblue."C R A W L E R \n";
  echo "=============";
  echo"\n\n";
  echo "\nCrawling Types & Descriptions:$cln";
  echo "\n\n$bold"."69:$cln This is the lite version of tge crawler, This will show you the files which returns the http code '200'. This is time efficient and less messy.\n";
  echo "\n$bold"."420:$cln This is a little advance one it will show you all the list of files with their http code other then the badboy 404. This is a little messier but informative \n\n";
  csel :
  echo "Select Crawler Type (69/420): ";
  $ctype = trim(fgets(STDIN,1024));
  if ($ctype == "420"){
    echo"\n\t -[ A D V A N C E   C R A W L I N G ]-\n";
    echo"\n\n";
    echo"\n Loading Crawler File ....\n";
    if (file_exists("crawl/admin.ini")){
      echo"\n[-] Admin Crawler File Found! Scanning For Admin Pannel [-]\n";
      $crawllnk = file_get_contents("crawl/admin.ini");
      //$crawls = array($crawllnk);
      $crawls = explode(',', $crawllnk);
      echo"\nURLs Loaded: ".count($crawls) ."\n\n";
      foreach ($crawls as $crawl){
        $url = $ipsl.$ip ."/".$crawl;
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);
        /* Check for 404 (file not found). */ $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
          if($httpCode == 200) {
            echo"\n\n [ • ] $url : ";
            echo "Found!";
          }
          elseif($httpCode == 404) {
          //do nothing
          }
          else{
            echo"\n\n [ • ] $url : ";
            echo "HTTP Response: " .$httpCode;
          }
          curl_close($handle);
        }
      }
      else{
        echo"\n File Not Found, Aborting Crawl ....\n";
      }
      if (file_exists("crawl/backup.ini")){
        echo"\n[-] Backup Crawler File Found! Scanning For Site Backups [-]\n";
        $crawllnk = file_get_contents("crawl/backup.ini");
        //$crawls = array($crawllnk);
        $crawls = explode(',', $crawllnk);
        echo"\nURLs Loaded: ".count($crawls) ."\n\n";
        foreach ($crawls as $crawl){
            $url = $ipsl.$ip ."/".$crawl;
            $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            /* Get the HTML or whatever is linked in $url. */
            $response = curl_exec($handle);
            /* Check for 404 (file not found). */ $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode == 200) {
                echo"\n\n [ • ] $url : ";
                echo "Found!";
              }
              elseif($httpCode == 404) {
                //do nothing
              }
              else{
                echo"\n\n [ • ] $url : ";
                echo "HTTP Response: " .$httpCode;
              }
              curl_close($handle);
            }
          }
          else{
            echo"\n File Not Found, Aborting Crawl ....\n";
          }
          if (file_exists("crawl/others.ini")){
            echo"\n[-] General Crawler File Found! Crawling The Site [-]\n";
            $crawllnk = file_get_contents("crawl/others.ini");
            //$crawls = array($crawllnk);
            $crawls = explode(',', $crawllnk);
            echo"\nURLs Loaded: ".count($crawls) ."\n\n";
            foreach ($crawls as $crawl){
                $url = $ipsl.$ip ."/".$crawl;
                $handle = curl_init($url);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                /* Get the HTML or whatever is linked in $url. */
                $response = curl_exec($handle);
                /* Check for 404 (file not found). */ $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                  if($httpCode == 200) {
                    echo"\n\n [ • ] $url : ";
                    echo "Found!";
                  }
                  elseif($httpCode == 404) {
                    //do nothing
                  }
                  else{
                    echo"\n\n [ • ] $url : ";
                    echo "HTTP Response: " .$httpCode;
                  }
                  curl_close($handle);
                }
              }
              else{
                echo"\n File Not Found, Aborting Crawl ....\n";
              }
            }
            elseif ($ctype == "69"){
              echo"\n\t -[ B A S I C   C R A W L I N G ]-\n";
              echo"\n\n";
              echo"\n Loading Crawler File ....\n";
              if (file_exists("crawl/admin.ini")){
                echo"\n[-] Admin Crawler File Found! Scanning For Admin Pannel [-]\n";
                $crawllnk = file_get_contents("crawl/admin.ini");
                //$crawls = array($crawllnk);
                $crawls = explode(',', $crawllnk);
                echo"\nURLs Loaded: ".count($crawls) ."\n\n";
                foreach ($crawls as $crawl){
                  $url = $ipsl.$ip ."/".$crawl;
                  $handle = curl_init($url);
                  curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                  $response = curl_exec($handle);
                  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                  if($httpCode == 200) {
                    echo"\n\n [ • ] $url : ";
                    echo "Found!";
                  }
                  elseif($httpCode == 404) {
                    //do nothing
                  }
                  else {
                    echo ".";
                  }
                  curl_close($handle);
                }
              }
              else{
                echo"\n File Not Found, Aborting Crawl ....\n";
              }
              if (file_exists("crawl/backup.ini")){
                echo"\n[-] Backup Crawler File Found! Scanning For Site Backups [-]\n";
                $crawllnk = file_get_contents("crawl/backup.ini");
                $crawls = explode(',', $crawllnk);
                echo"\nURLs Loaded: ".count($crawls) ."\n\n";
                foreach ($crawls as $crawl){
                  $url = $ipsl.$ip ."/".$crawl;
                  $handle = curl_init($url);
                  curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                  $response = curl_exec($handle);
                  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                  if($httpCode == 200) {
                    echo"\n\n [ • ] $url : ";
                    echo "Found!";
                  }
                  elseif($httpCode == 404) {
                    //do nothing
                  }
                  curl_close($handle);
              }
            }
            else{
              echo"\n File Not Found, Aborting Crawl ....\n";
            }
            if (file_exists("crawl/others.ini")){
              echo"\n[-] General Crawler File Found! Crawling The Site [-]\n";
              $crawllnk = file_get_contents("crawl/others.ini");
              $crawls = explode(',', $crawllnk);
              echo"\nURLs Loaded: ".count($crawls) ."\n\n";
              foreach ($crawls as $crawl){
                  $url = $ipsl.$ip ."/".$crawl;
                  $handle = curl_init($url);
                  curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                  $response = curl_exec($handle);
                  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                    if($httpCode == 200) {
                      echo"\n\n [ • ] $url : ";
                      echo "Found!";
                    }
                    elseif($httpCode == 404) {
                      //do nothing
                    }
                    curl_close($handle);
                  }
                }
                else{
                  echo"\n File Not Found, Aborting Crawl ....\n";
                }
              }
              else { goto csel ;}
            }
 ?>
