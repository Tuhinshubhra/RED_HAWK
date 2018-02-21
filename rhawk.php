<?php
error_reporting(0);
require 'functions.php';
require 'var.php';
echo $cln;
system("clear");
redhawk_banner();
if (extension_loaded('curl') || extension_loaded('dom'))
  {
  }
else
  {
    if (!extension_loaded('curl'))
      {
        echo $bold . $red . "\n[!] cURL Module Is Missing! Try 'fix' command OR Install php-curl" . $cln;
      }
    if (!extension_loaded('dom'))
      {
        echo $bold . $red . "\n[!] DOM Module Is Missing! Try 'fix' command OR Install php-xml\n" . $cln;
      }
  }
thephuckinstart:
echo "\n";
userinput("Enter The Website You Want To Scan ");
$ip = trim(fgets(STDIN, 1024));
if ($ip == "help")
  {
    echo "\n\n[+] RED HAWK Help Screen [+] \n\n";
    echo $bold . $lblue . "Commands\n";
    echo "========\n";
    echo $fgreen . "[1] help:$cln View The Help Menu\n";
    echo $bold . $fgreen . "[2] fix:$cln Installs All Required Modules (Suggested If You Are Running The Tool For The First Time)\n";
    echo $bold . $fgreen . "[3] URL:$cln Enter The Domain Name Which You Want To Scan (Format:www.sample.com / sample.com)\n";
    goto thephuckinstart;
  }
elseif ($ip == "fix")
  {
    echo "\n\e[91m\e[1m[+] RED HAWK FiX MENU [+]\n\n$cln";
    echo $bold . $blue . "[+] Checking If cURL module is installed ...\n";
    if (!extension_loaded('curl'))
      {
        echo $bold . $red . "[!] cURL Module Not Installed ! \n";
        echo $yellow . "[*] Installing cURL. (Operation requeires sudo permission so you might be asked for password) \n" . $cln;
        system("sudo apt-get -qq --assume-yes install php-curl");
        echo $bold . $fgreen . "[i] cURL Installed. \n";
      }
    else
      {
        echo $bold . $fgreen . "[i] cURL is already installed, Skipping To Next \n";
      }
    echo $bold . $blue . "[+] Checking If php-XML module is installed ...\n";
    if (!extension_loaded('dom'))
      {
        echo $bold . $red . "[!] php-XML Module Not Installed ! \n";
        echo $yellow . "[*] Installing php-XML. (Operation requeires sudo permission so you might be asked for password) \n" . $cln;
        system("sudo apt-get -qq --assume-yes install php-xml");
        echo $bold . $fgreen . "[i] DOM Installed. \n";
      }
    else
      {
        echo $bold . $fgreen . "[i] php-XML is already installed, You Are All SET ;) \n";
      }
    echo $bold . $fgreen . "[i] Job finished successfully! Please Restart RED HAWK \n";
    exit;
  }
elseif (strpos($ip, '://') !== false)
  {
    echo $bold . $red . "\n[!] (HTTP/HTTPS) Detected In Input! Enter URL Without Http/Https\n" . $CURLOPT_RETURNTRANSFER;
    goto thephuckinstart;
  }
elseif (strpos($ip, '.') == false)
  {
    echo $bold . $red . "\n[!] Invalid URL Format! Enter A Valid URL\n" . $cln;
    goto thephuckinstart;
  }
elseif (strpos($ip, ' ') !== false)
  {
    echo $bold . $red . "\n[!] Invalid URL Format! Enter A Valid URL\n" . $cln;
    goto thephuckinstart;
  }
else
  {
    echo "\n";
    userinput("Enter 1 For HTTP OR Enter 2 For HTTPS");
    echo $cln . $bold . $fgreen;
    $ipsl = trim(fgets(STDIN, 1024));
    if ($ipsl == "2")
      {
        $ipsl = "https://";
      }
    else
      {
        $ipsl = "http://";
      }
scanlist:

    system("clear");
    echo $bold . $blue . "
      +--------------------------------------------------------------+
      +                  List Of Scans Or Actions                    +
      +--------------------------------------------------------------+

            $lblue Scanning Site : " . $fgreen . $ipsl . $ip . $blue . "
      \n\n";
    echo $yellow . " [0]  Basic Recon$white (Site Title, IP Address, CMS, Cloudflare Detection, Robots.txt Scanner)$yellow \n [1]  Whois Lookup \n [2]  Geo-IP Lookup \n [3]  Grab Banners \n [4]  DNS Lookup \n [5]  Subnet Calculator \n [6]  NMAP Port Scan \n [7]  Subdomain Scanner \n [8]  Reverse IP Lookup & CMS Detection \n [9]  SQLi Scanner$white (Finds Links With Parameter And Scans For Error Based SQLi)$yellow \n [10] Bloggers View$white (Information That Bloggers Might Be Interested In)$yellow \n [11] WordPress Scan$white (Only If The Target Site Runs On WP)$yellow \n [12] Crawler \n [13] MX Lookup \n$magenta [A]  Scan For Everything - (The Old Lame Scanner) \n$blue [F]  Fix (Checks For Required Modules and Installs Missing Ones) \n$fgreen [U]  Check For Updates \n$white [B]  Scan Another Website (Back To Site Selection) \n$red [Q]  Quit! \n\n" . $cln;
askscan:
    userinput("Choose Any Scan OR Action From The Above List");
    $scan = trim(fgets(STDIN, 1024));

    if (!in_array($scan, array(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
        '13',
        'F',
        'f',
        'A',
        'B',
        'U',
        'Q',
        'a',
        'b',
        'q',
        'u'
    ), true))
      {
        echo $bold . $red . "\n[!] Invalid Input! Please Enter a Valid Option! \n\n" . $cln;
        goto askscan;
      }
    else
      {
        if ($scan == "15")
          {
            goto thephuckinstart;
          }
        elseif ($scan == 'q' | $scan == 'Q')
          {
            echo "\n\n\t Good Bye - Have a nice day :)\n\n";
            die();
          }
        elseif ($scan == 'b' || $scan == 'B')
          {
            system("clear");
            goto thephuckinstart;
          }
        elseif ($scan == "0")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : BASIC SCAN" . $cln;
            echo "\n\n";
            echo $bold . $lblue . "[iNFO] Site Title: " . $green;
            echo getTitle($reallink);
            echo $cln;
            $wip = gethostbyname($ip);
            echo $lblue . $bold . "\n[iNFO] IP address: " . $green . $wip . "\n" . $cln;
            echo $bold . $lblue . "[iNFO] Web Server: ";
            WEBserver($reallink);
            echo "\n";
            echo $bold . $lblue . "[iNFO] CMS: \e[92m" . CMSdetect($reallink) . $cln;
            echo $lblue . $bold . "\n[iNFO] Cloudflare: ";
            cloudflaredetect($lwwww);
            echo $lblue . $bold . "[iNFO] Robots File:$cln ";
            robotsdottxt($reallink);
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "1")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : WHOIS Lookup" . $cln;
            echo $bold . $lblue . "\n[~] Whois Lookup Result: \n\n" . $cln;
            $urlwhois    = "http://api.hackertarget.com/whois/?q=" . $lwwww;
            $resultwhois = file_get_contents($urlwhois);
            echo $bold . $fgreen . $resultwhois;
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "2")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : GEO-IP Lookup" . $cln;
            echo "\n\n";
            $urlgip    = "http://api.hackertarget.com/geoip/?q=" . $lwwww;
            $resultgip = readcontents($urlgip);
            $geoips    = explode("\n", $resultgip);
            foreach ($geoips as $geoip)
              {
                echo $bold . $lblue . "[GEO-IP]$green $geoip \n";
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "3")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : Banner Grabbing" . $cln;
            echo "\n\n";
            $hdr = get_headers($reallink);
            foreach ($hdr as $shdr)
              {
                echo $bold . $lblue . "\n" . $green . $shdr;
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "4")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : DNS Lookup" . $cln;
            echo "\n\n";
            $urldlup    = "http://api.hackertarget.com/dnslookup/?q=" . $lwwww;
            $resultdlup = readcontents($urldlup);
            $dnslookups = trim($resultdlup, "\n");
            $dnslookups = explode("\n", $dnslookups);
            foreach ($dnslookups as $dnslkup)
              {
                echo $bold . $lblue . "\n[DNS Lookup] " . $green . $dnslkup;
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "5")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : SubNet Calculator" . $cln;
            echo "\n\n";
            $urlscal    = "http://api.hackertarget.com/subnetcalc/?q=" . $lwwww;
            $resultscal = readcontents($urlscal);
            $subnetcalc = trim($resultscal, "\n");
            $subnetcalc = explode("\n", $subnetcalc);
            foreach ($subnetcalc as $sc)
              {
                echo $bold . $lblue . "\n[SubNet Calc] " . $green . $sc;
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "7")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : Subdomain Scanner" . $cln;
            $urlsd      = "http://api.hackertarget.com/hostsearch/?q=" . $lwwww;
            $resultsd   = readcontents($urlsd);
            $subdomains = trim($resultsd, "\n");
            $subdomains = explode("\n", $subdomains);
            unset($subdomains['0']);
            $sdcount = count($subdomains);
            echo "\n" . $blue . $bold . "[i] Total Subdomains Found : " . $green . $sdcount . "\n\n" . $cln;
            foreach ($subdomains as $subdomain)
              {
                echo $bold . $lblue . "[+] Subdomain: $fgreen" . (str_replace(",", "\n\e[36m[-] IP: $fgreen", $subdomain));
                echo "\n\n" . $cln;
              }
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "6")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : Nmap Port Scan" . $cln;
            echo $bold . $lblue . "\n[~] Port Scan Result: \n\n" . $cln;
            $urlnmap    = "http://api.hackertarget.com/nmap/?q=" . $lwwww;
            $resultnmap = readcontents($urlnmap);
            echo $bold . $fgreen . $resultnmap;
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "8")
          {
            $reallink  = $ipsl . $ip;
            $lwwww     = str_replace("www.", "", $ip);
            $detectcms = "yes";
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : Reverse IP Lookup & CMS Detection" . $cln;
            echo "\n";
            $sth = 'http://domains.yougetsignal.com/domains.php';
            $ch  = curl_init($sth);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "remoteAddress=$ip&ket=");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            $resp  = curl_exec($ch);
            $resp  = str_replace("[", "", str_replace("]", "", str_replace("\"\"", "", str_replace(", ,", ",", str_replace("{", "", str_replace("{", "", str_replace("}", "", str_replace(", ", ",", str_replace(", ", ",", str_replace("'", "", str_replace("'", "", str_replace(":", ",", str_replace('"', '', $resp)))))))))))));
            $array = explode(",,", $resp);
            unset($array[0]);

            echo $bold . $lblue . "[i] Total Sites Found On This Server :$cln " . $green . count($array) . "\n\n$cln";
            if (count($array) > 0)
              {
                userinput("Do You Want RED HAWK To Detect CMS Of The Sites? [Y/N]");
                $detectcmsui = trim(fgets(STDIN, 1024));
                if ($detectcmsui == "y" | $detectcmsui == "Y")
                  {
                    $detectcms = "yes";
                  }
                else
                  {
                    $detectcms = "no";
                  }
              }
            foreach ($array as $izox)
              {
                $izox   = str_replace(",", "", $izox);
                $cmsurl = "http://" . $izox;
                echo "\n" . $bold . $lblue . "HOSTNAME : " . $fgreen . $izox . $cln;
                echo "\n" . $bold . $lblue . "IP       : " . $fgreen . gethostbyname($izox) . $cln . "\n";
                if ($detectcms == "yes")
                  {
                    echo $lblue . $bold . "CMS      : " . $green . CMSdetect($cmsurl) . $cln . "\n\n";
                  }
              }
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "9")
          {
            $reallink = $ipsl . $ip;
            $srccd    = file_get_contents($reallink);
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : SQL Vulnerability Scanner" . $cln;
            echo "\n\n";
            $lulzurl = $reallink;
            $html    = file_get_contents($lulzurl);
            $dom     = new DOMDocument;
            @$dom->loadHTML($html);
            $links = $dom->getElementsByTagName('a');
            $vlnk  = 0;
            foreach ($links as $link)
              {
                $lol = $link->getAttribute('href');
                if (strpos($lol, '?') !== false)
                  {
                    echo $lblue . $bold . "\n[ LINK ] " . $fgreen . $lol . "\n" . $cln;
                    echo $blue . $bold . "[ SQLi ] ";
                    $sqllist = file_get_contents('sqlerrors.ini');
                    $sqlist  = explode(',', $sqllist);
                    if (strpos($lol, '://') !== false)
                      {
                        $sqlurl = $lol . "'";
                      }
                    else
                      {
                        $sqlurl = $ipsl . $ip . "/" . $lol . "'";
                      }
                    $sqlsc = file_get_contents($sqlurl);
                    $sqlvn = $bold . $red . "Not Vulnerable";
                    foreach ($sqlist as $sqli)
                      {
                        if (strpos($sqlsc, $sqli) !== false)
                            $sqlvn = $green . $bold . "Vulnerable!";
                      }
                    echo $sqlvn;
                    echo "\n$cln";
                    echo "\n";
                    $vlnk++;
                  }
              }
            echo "\n" . $blue . $bold . "[+] URL(s) With Parameter(s): " . $green . $vlnk;
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "10")
          {
            $reallink = $ipsl . $ip;
            $srccd    = readcontents($reallink);
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln\t" . $lblue . $bold . "[+] BLOGGERS ViEW [+] \n\n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo "\n\n";
            $test_url = $reallink;
            $handle   = curl_init($test_url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            $tu_response        = curl_exec($handle);
            $test_url_http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            echo $lblue . $bold . "[i] HTTP Response Code : " . $fgreen . $test_url_http_code . "\n";
            echo $lblue . "[i] Site Title: " . $fgreen . getTitle($reallink) . "\n";
            echo $lblue . "[i] CMS (Content Management System) : " . $fgreen . CMSdetect($reallink) . "\n";
            echo $lblue . $bold . "[i] Alexa Global Rank : " . $fgreen . bv_get_alexa_rank($lwwww) . "\n";
            bv_moz_info($lwwww);
            extract_social_links($srccd);
            extractLINKS($reallink);
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == "11")
          {
            userinput("Enter The Directory in which WordPress is installed (for example /blog) If it is running on " . $ipsl . $ip . " simply press ENTER");
            $wp_inst_loc = trim(fgets(STDIN, 1024));
            if ($wp_inst_loc == "")
              {
                $reallink = $ipsl . $ip;
              }
            else
              {
                $reallink = $ipsl . $ip . $wp_inst_loc;
              }
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $reallink \n";
            echo $bold . $yellow . "[S] Scan Type : WordPress Scanner." . $cln;
            echo "\n\n";
            echo $bold . $blue . "[+] Checking if the site is built on WordPress: ";
            $srccd = readcontents($reallink);
            if (strpos($srccd, "wp-content") !== false)
              {
                echo $fgreen . "Determined !" . $cln . "\n";
                echo $bold . $yellow . "\n\t Basic Checks \n\t==============\n\n";
                $wp_rm_src = readcontents($reallink . "/readme.html");
                if (strpos($wp_rm_src, "Welcome. WordPress is a very special project to me.") !== false)
                  {
                    echo $fgreen . "[i] Readme File Found, Link: " . $reallink . "/readme.html\n";
                  }
                else
                  {
                    echo $red . "[!] Readme File Not Found!\n";
                  }
                $wp_lic_src = readcontents($reallink . "/license.txt");
                if (strpos($wp_lic_src, "WordPress - Web publishing software") !== false)
                  {
                    echo $fgreen . "[i] License File Found, Link: " . $reallink . "/license.txt\n";
                  }
                else
                  {
                    echo $red . "[!] License File Not Found!\n";
                  }
                $wp_updir_src = readcontents($reallink . "/wp-content/uploads/");
                if (strpos($wp_updir_src, "Index of /wp-content/uploads") !== false)
                  {
                    echo $fgreen . $reallink . "/wp-content/uploads Is Browseable\n";
                  }
                $wp_xmlrpc_src = readcontents($reallink . "/xmlrpc.php");
                if (strpos($wp_xmlrpc_src, "XML-RPC server accepts POST requests only.") !== false)
                  {
                    echo $fgreen . "[i] XML-RPC interface Available Under " . $reallink . "/xmlrpc.php\n";
                  }
                else
                  {
                    echo $red . "[!] Could Not Find XML-RPC interface\n";
                  }
                echo $bold . $blue . "[+] Finding WordPress Version: ";
                $metaver = preg_match('/<meta name="generator" content="WordPress (.*?)\"/ims', $srccd, $matches) ? $matches[1] : null;
                if ($metaver != "")
                  {
                    echo $fgreen . "Found [Using Method 1 of 3]" . "\n";
                    echo $blue . "[i] WordPress Version: " . $fgreen . $metaver . $cln;
                    $wp_version   = str_replace(".", "", $metaver);
                    $wp_c_version = $metaver;
                  }
                else
                  {
                    $feedsrc = readcontents($reallink . "/feed/");
                    $feedver = preg_match('#<generator>http://wordpress.org/\?v=(.*?)</generator>#ims', $feedsrc, $matches) ? $matches[1] : null;
                    if ($feedver != "")
                      {
                        echo $fgreen . "Found [Using Method 2 of 3]" . "\n";
                        echo $blue . "[i] WordPress Version: " . $fgreen . $feedver . $cln;
                        $wp_version   = str_replace(".", "", $feedver);
                        $wp_c_version = $feedver;
                      }
                    else
                      {
                        $lopmlsrc = readcontents($reallink . "/wp-links-opml.php");
                        $lopmlver = preg_match('#generator="wordpress/(.*?)"#ims', $feedsrc, $matches) ? $matches[1] : null;
                        if ($lopmlver != "")
                          {
                            echo $fgreen . "Found [Using Method 3 of 3]" . "\n";
                            echo $blue . "[i] WordPress Version: " . $fgreen . $lopmlver . $cln;
                            $wp_version   = str_replace(".", "", $lopmlver);
                            $wp_c_version = $lopmlver;
                          }
                      }
                  }
                if ($wp_version != "")
                  {
                    echo "\n" . $bold . $blue . "[+] Collecting Version Details From WPVulnDB: ";
                    $vuln_json = readcontents("https://wpvulndb.com/api/v2/wordpresses/" . $wp_version);
                    if (strpos($vuln_json, "The page you were looking for doesn't exist (404)") !== false)
                      {
                        echo $red . "[!] Seems like the version detection messed up preety bad! Please report here: https://github.com/Tuhinshubhra/RED_HAWK/issues/new\n";
                      }
                    else
                      {
                        $vuln_array = json_decode($vuln_json, TRUE);
                        echo $fgreen . "Done\n\n";
                        echo $yellow . "\t WordPress Version Informations\n\t================================\n\n";
                        echo $lblue . "[i] WordPress Version   : " . $fgreen . $wp_c_version . "\n";
                        echo $lblue . "[i] Release Date        : " . $fgreen . $vuln_array[$wp_c_version]["release_date"] . "\n";
                        echo $lblue . "[i] Changelog URL       : " . $fgreen . $vuln_array[$wp_c_version]["changelog_url"] . "\n";
                        echo $lblue . "[i] Vulnerability Count : " . $fgreen . count($vuln_array[$wp_c_version]["vulnerabilities"]) . "\n";
                        if (count($vuln_array[$wp_c_version]["vulnerabilities"]) != "0")
                          {
                            echo $yellow . "\n\t Version Vulnerabilities \n\t=========================\n\n";
                            $ver_vuln_array = $vuln_array[$wp_c_version]['vulnerabilities'];
                            foreach ($ver_vuln_array as $vuln_s)
                              {
                                echo $lblue . "[i] Vulnerability Title : " . $fgreen . $vuln_s["title"] . "\n";
                                echo $lblue . "[i] Vulnerability Type  : " . $fgreen . $vuln_s["vuln_type"] . "\n";
                                echo $lblue . "[i] Fixed In Version    : " . $fgreen . $vuln_s["fixed_in"] . "\n";
                                echo $lblue . "[i] Vulnerability Link  : " . $fgreen . "http://wpvulndb.com/vulnerabilities/" . $vuln_s['id'] . "\n";
                                foreach ($vuln_s['references']["cve"] as $wp_cve)
                                  {
                                    echo $lblue . "[i] Vuln CVE            : " . $fgreen . "http://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-" . $wp_cve . "\n";
                                  }
                                foreach ($vuln_s['references']['exploitdb'] as $wp_edb)
                                  {
                                    echo $lblue . "[i] ExploitDB Link      : " . $fgreen . "http://www.exploit-db.com/exploits/" . $wp_edb . "\n";
                                  }
                                foreach ($vuln_s['references']['metasploit'] as $wp_metas)
                                  {
                                    echo $lblue . "[i] Metasploit Module   : " . $fgreen . "http://www.metasploit.com/modules/" . $wp_metas . "\n";
                                  }
                                foreach ($vuln_s['references']['osvdb'] as $wp_osvdb)
                                  {
                                    echo $lblue . "[i] OSVDB Link          : " . $fgreen . "http://osvdb.org/" . $wp_osvdb . "\n";
                                  }
                                foreach ($vuln_s['references']['secunia'] as $wp_secu)
                                  {
                                    echo $lblue . "[i] Secunia Link        : " . $fgreen . "http://secunia.com/advisories/" . $wp_secu . "\n";
                                  }
                                foreach ($vuln_s['references']["url"] as $vuln_ref)
                                  {
                                    echo $lblue . "[i] Vuln Reference      : " . $fgreen . $vuln_ref . "\n";
                                  }
                                echo "\n\n";
                              }
                          }
                      }
                    $reallink = $ipsl . $ip;
                    echo "\n\n";
                    echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
                    trim(fgets(STDIN, 1024));
                    goto scanlist;
                  }
                else
                  {
                    $reallink = $ipsl . $ip;
                    echo $red . "Failed \n\n[!] RED HAWK could not determine the WordPress version of the target!";
                    echo "\n\n";
                    echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
                    trim(fgets(STDIN, 1024));
                    goto scanlist;
                  }
              }
            else
              {
                $reallink = $ipsl . $ip;
                echo $red . "Failed \n\n[!] Wordpress installation could not be determined, Exiting Scan!";
                echo "\n\n";
                echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
                trim(fgets(STDIN, 1024));
                goto scanlist;
              }
          }
        elseif ($scan == "12")
          {
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : Crawling" . $cln;
            echo "\n\n";
            echo $bold . $blue . "\n[i] Loading Crawler File ....\n" . $cln;
            if (file_exists("crawl/admin.ini"))
              {
                echo $bold . $fgreen . "\n[^_^] Admin Crawler File Found! Scanning For Admin Pannel [-]\n" . $cln;
                $crawllnk = file_get_contents("crawl/admin.ini");
                $crawls   = explode(',', $crawllnk);
                echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                foreach ($crawls as $crawl)
                  {
                    $url    = $ipsl . $ip . "/" . $crawl;
                    $handle = curl_init($url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                    $response = curl_exec($handle);
                    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                    if ($httpCode == 200)
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $fgreen . "Found!" . $cln;
                      }
                    elseif ($httpCode == 404)
                      {
                      }
                    else
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $yellow . "HTTP Response: " . $httpCode . $cln;
                      }
                    curl_close($handle);
                  }
              }
            else
              {
                echo "\n File Not Found, Aborting Crawl ....\n";
              }
            if (file_exists("crawl/backup.ini"))
              {
                echo "\n[-] Backup Crawler File Found! Scanning For Site Backups [-]\n";
                $crawllnk = file_get_contents("crawl/backup.ini");
                $crawls   = explode(',', $crawllnk);
                echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                foreach ($crawls as $crawl)
                  {
                    $url    = $ipsl . $ip . "/" . $crawl;
                    $handle = curl_init($url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                    $response = curl_exec($handle);
                    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                    if ($httpCode == 200)
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $fgreen . "Found!" . $cln;
                      }
                    elseif ($httpCode == 404)
                      {
                      }
                    else
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $yellow . "HTTP Response: " . $httpCode . $cln;
                      }
                    curl_close($handle);
                  }
              }
            else
              {
                echo "\n File Not Found, Aborting Crawl ....\n";
              }
            if (file_exists("crawl/others.ini"))
              {
                echo "\n[-] General Crawler File Found! Crawling The Site [-]\n";
                $crawllnk = file_get_contents("crawl/others.ini");
                $crawls   = explode(',', $crawllnk);
                echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                foreach ($crawls as $crawl)
                  {
                    $url    = $ipsl . $ip . "/" . $crawl;
                    $handle = curl_init($url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                    $response = curl_exec($handle);
                    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                    if ($httpCode == 200)
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $fgreen . "Found!" . $cln;
                      }
                    elseif ($httpCode == 404)
                      {
                      }
                    else
                      {
                        echo $bold . $lblue . "\n\n[U] $url : " . $cln;
                        echo $bold . $yellow . "HTTP Response: " . $httpCode . $cln;
                      }
                    curl_close($handle);
                  }
              }
            else
              {
                echo "\n File Not Found, Aborting Crawl ....\n";
              }
          }
        elseif ($scan == "13")
          {
            $reallink = $ipsl . $ip;
            $lwwww    = str_replace("www.", "", $ip);
            echo "\n$cln" . $lblue . $bold . "[+] Scanning Begins ... \n";
            echo $blue . $bold . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo $bold . $yellow . "[S] Scan Type : MX Lookup" . $cln;
            echo "\n\n";
            echo MXlookup($lwwww);
            echo "\n\n";
            echo $bold . $yellow . "[*] Scanning Complete. Press Enter To Continue OR CTRL + C To Stop\n\n";
            trim(fgets(STDIN, 1024));
            goto scanlist;
          }
        elseif ($scan == 'U' || $scan == 'u')
          {
            echo "\n\n" . $bold . $yellow . "-[ RED HAWK Update Corner]-\n\n" . $cln;
            echo $bold . "[i] Fetching Stuffs .... \n" . $cln;
            $latestversion = readcontents("https://raw.githubusercontent.com/Tuhinshubhra/RED_HAWK/master/version.txt");
            echo $bold . $blue . "[C] Current Version: " . $rhversion . $cln;
            echo "\n" . $bold . $lblue . "[L] Latest Version:  " . $latestversion . $cln;
            if ($latestversion > $rhversion)
              {
                echo $bold . $fgreen . "\n\n[U] Update Available, Please Update Your Version Of RED HAWK \n" . $cln;
                echo $bold . $white . "    Link: https://github.com/Tuhinshubhra/RED_HAWK\n\n" . $cln;
              }

            elseif ($rhversion == $latestversion)
              {
                echo $bold . $fgreen . "\n[i] You are already running the latest version of RED HAWK. \n\n" . $cln;
              }
            else
              {
                echo $bold . $red . "\n[U] Seems You Tampered With The Script !! Please Take The Trouble OF Checking For Update Manually!!! \n\n";
              }
          }
        elseif ($scan == "F" || $scan == "f"){
          echo "\n\e[91m\e[1m[+] RED HAWK FiX MENU [+]\n\n$cln";
          echo $bold . $blue . "[+] Checking If cURL module is installed ...\n";
          if (!extension_loaded('curl'))
            {
              echo $bold . $red . "[!] cURL Module Not Installed ! \n";
              echo $yellow . "[*] Installing cURL. (Operation requeires sudo permission so you might be asked for password) \n" . $cln;
              system("sudo apt-get -qq --assume-yes install php-curl");
              echo $bold . $fgreen . "[i] cURL Installed. \n";
            }
          else
            {
              echo $bold . $fgreen . "[i] cURL is already installed, Skipping To Next \n";
            }
          echo $bold . $blue . "[+] Checking If php-XML module is installed ...\n";
          if (!extension_loaded('dom'))
            {
              echo $bold . $red . "[!] php-XML Module Not Installed ! \n";
              echo $yellow . "[*] Installing php-XML. (Operation requeires sudo permission so you might be asked for password) \n" . $cln;
              system("sudo apt-get -qq --assume-yes install php-xml");
              echo $bold . $fgreen . "[i] DOM Installed. \n";
            }
          else
            {
              echo $bold . $fgreen . "[i] php-XML is already installed, You Are All SET ;) \n";
            }
          echo $bold . $fgreen . "[i] Job finished successfully! Please Restart RED HAWK \n";
          exit;
        }
        elseif ($scan == "A" || $scan == "a")
          {

            echo "\n$cln" . "$lblue" . "[+] Scanning Begins ... \n";
            echo "$blue" . "[i] Scanning Site:\e[92m $ipsl" . "$ip \n";
            echo "\n\n";

            echo "\n$bold" . "$lblue" . "B A S I C   I N F O \n";
            echo "====================\n";
            echo "\n\e[0m";

            $reallink = $ipsl . $ip;
            $srccd    = file_get_contents($reallink);
            $lwwww    = str_replace("www.", "", $ip);

            echo "\n$blue" . "[+] Site Title: ";
            echo "\e[92m";
            echo getTitle($reallink);
            echo "\e[0m";


            $wip = gethostbyname($ip);
            echo "\n$blue" . "[+] IP address: ";
            echo "\e[92m";
            echo $wip . "\n\e[0m";

            echo "$blue" . "[+] Web Server: ";
            WEBserver($reallink);
            echo "\n";

            echo "$blue" . "[+] CMS: \e[92m" . CMSdetect($reallink) . " \e[0m";

            echo "\n$blue" . "[+] Cloudflare: ";
            cloudflaredetect($reallink);

            echo "$blue" . "[+] Robots File:$cln ";
            robotsdottxt($reallink);
            echo "\n\n$cln";
            echo "\n\n$bold" . $lblue . "W H O I S   L O O K U P\n";
            echo "========================";
            echo "\n\n$cln";
            $urlwhois    = "http://api.hackertarget.com/whois/?q=" . $lwwww;
            $resultwhois = file_get_contents($urlwhois);
            echo "\t";
            echo $resultwhois;
            echo "\n\n$cln";

            echo "\n\n$bold" . $lblue . "G E O  I P  L O O K  U P\n";
            echo "=========================";
            echo "\n\n$cln";
            $urlgip    = "http://api.hackertarget.com/geoip/?q=" . $lwwww;
            $resultgip = readcontents($urlgip);
            $geoips    = explode("\n", $resultgip);
            foreach ($geoips as $geoip)
              {
                echo $bold . $green . "[i]$cln $geoip \n";
              }
            echo "\n\n$cln";

            echo "\n\n$bold" . $lblue . "H T T P   H E A D E R S\n";
            echo "=======================";
            echo "\n\n$cln";
            gethttpheader($reallink);
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "D N S   L O O K U P\n";
            echo "===================";
            echo "\n\n$cln";
            $urldlup    = "http://api.hackertarget.com/dnslookup/?q=" . $lwwww;
            $resultdlup = file_get_contents($urldlup);
            echo $resultdlup;
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "S U B N E T   C A L C U L A T I O N\n";
            echo "====================================";
            echo "\n\n$cln";
            $urlscal    = "http://api.hackertarget.com/subnetcalc/?q=" . $lwwww;
            $resultscal = file_get_contents($urlscal);
            echo $resultscal;
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "N M A P   P O R T   S C A N\n";
            echo "============================";
            echo "\n\n$cln";
            $urlnmap    = "http://api.hackertarget.com/nmap/?q=" . $lwwww;
            $resultnmap = file_get_contents($urlnmap);
            echo $resultnmap;
            echo "\n";

            echo "\n\n$bold" . $lblue . "S U B - D O M A I N   F I N D E R\n";
            echo "==================================";
            echo "\n\n";
            $urlsd      = "http://api.hackertarget.com/hostsearch/?q=" . $lwwww;
            $resultsd   = file_get_contents($urlsd);
            $subdomains = trim($resultsd, "\n");
            $subdomains = explode("\n", $subdomains);
            unset($subdomains['0']);
            $sdcount = count($subdomains);
            echo "\n$blue" . "[i] Total Subdomains Found :$cln " . $green . $sdcount . "\n\n$cln";
            foreach ($subdomains as $subdomain)
              {
                echo "[+] Subdomain:$cln $fgreen" . (str_replace(",", "\n\e[0m[-] IP:$cln $fgreen", $subdomain));
                echo "\n\n$cln";
              }
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "R E V E R S E   I P   L O O K U P\n";
            echo "==================================";
            echo "\n\n";
            $sth = 'http://domains.yougetsignal.com/domains.php';
            $ch  = curl_init($sth);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "remoteAddress=$ip&ket=");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            $resp  = curl_exec($ch);
            $resp  = str_replace("[", "", str_replace("]", "", str_replace("\"\"", "", str_replace(", ,", ",", str_replace("{", "", str_replace("{", "", str_replace("}", "", str_replace(", ", ",", str_replace(", ", ",", str_replace("'", "", str_replace("'", "", str_replace(":", ",", str_replace('"', '', $resp)))))))))))));
            $array = explode(",,", $resp);
            unset($array[0]);
            echo "\n$blue" . "[i] Total Sites Found On This Server :$cln " . $green . count($array) . "\n\n$cln";
            foreach ($array as $izox)
              {
                echo "\n$blue" . "[#]$cln " . $fgreen . $izox . $cln;
                echo "\n$blue" . "[-] CMS:$cln $green";
                $cmsurl = "http://" . $izox;
                $cmssc  = file_get_contents($cmsurl);
                if (strpos($cmssc, '/wp-content/') !== false)
                  {
                    $tcms = "WordPress";
                  }
                else
                  {
                    if (strpos($cmssc, 'Joomla') !== false)
                      {
                        $tcms = "Joomla";
                      }
                    else
                      {
                        $drpurl = "http://" . $izox . "/misc/drupal.js";
                        $drpsc  = file_get_contents($drpurl);
                        if (strpos($drpsc, 'Drupal') !== false)
                          {
                            $tcms = "Drupal";
                          }
                        else
                          {
                            if (strpos($cmssc, '/skin/frontend/') !== false)
                              {
                                $tcms = "Magento";
                              }
                            else
                              {
                                $tcms = $red . "Could Not Detect$cln ";
                              }
                          }
                      }
                  }
                echo $tcms . "\n";
              }

            echo "\n\n";
            echo "\n\n$bold" . $lblue . "S Q L   V U L N E R A B I L I T Y   S C A N N E R\n";
            echo "===================================================$cln";
            echo "\n";
            $lulzurl = $ipsl . $ip;
            $html    = file_get_contents($lulzurl);
            $dom     = new DOMDocument;
            @$dom->loadHTML($html);
            $links = $dom->getElementsByTagName('a');
            $vlnk  = 0;
            foreach ($links as $link)
              {
                $lol = $link->getAttribute('href');
                if (strpos($lol, '?') !== false)
                  {
                    echo "\n$blue [#] " . $fgreen . $lol . "\n$cln";
                    echo $blue . " [-] Searching For SQL Errors: ";
                    $sqllist = file_get_contents('sqlerrors.ini');
                    $sqlist  = explode(',', $sqllist);
                    if (strpos($lol, '://') !== false)
                      {
                        $sqlurl = $lol . "'";
                      }
                    else
                      {
                        $sqlurl = $ipsl . $ip . "/" . $lol . "'";
                      }
                    $sqlsc = file_get_contents($sqlurl);
                    $sqlvn = "$red Not Found";
                    foreach ($sqlist as $sqli)
                      {
                        if (strpos($sqlsc, $sqli) !== false)
                            $sqlvn = "$green Found!";
                      }
                    echo $sqlvn;
                    echo "\n$cln";
                    echo "\n";
                    $vlnk++;
                  }
              }
            echo "\n\n$blue [+] URL(s) With Parameter(s):" . $green . $vlnk;
            echo "\n\n";

            echo "\n\n$bold" . $lblue . "C R A W L E R \n";
            echo "=============";
            echo "\n\n";
            echo "\nCrawling Types & Descriptions:$cln";
            echo "\n\n$bold" . "69:$cln This is the lite version of tge crawler, This will show you the files which returns the http code '200'. This is time efficient and less messy.\n";
            echo "\n$bold" . "420:$cln This is a little advance one it will show you all the list of files with their http code other then the badboy 404. This is a little messier but informative \n\n";
csel:
            echo "Select Crawler Type (69/420): ";
            $ctype = trim(fgets(STDIN, 1024));
            if ($ctype == "420")
              {
                echo "\n\t -[ A D V A N C E   C R A W L I N G ]-\n";
                echo "\n\n";
                echo "\n Loading Crawler File ....\n";
                if (file_exists("crawl/admin.ini"))
                  {
                    echo "\n[-] Admin Crawler File Found! Scanning For Admin Pannel [-]\n";
                    $crawllnk = file_get_contents("crawl/admin.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Found!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        else
                          {
                            echo "\n\n[U] $url : ";
                            echo "HTTP Response: " . $httpCode;
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n File Not Found, Aborting Crawl ....\n";
                  }
                if (file_exists("crawl/backup.ini"))
                  {
                    echo "\n[-] Backup Crawler File Found! Scanning For Site Backups [-]\n";
                    $crawllnk = file_get_contents("crawl/backup.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Found!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        else
                          {
                            echo "\n\n[U] $url : ";
                            echo "HTTP Response: " . $httpCode;
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n File Not Found, Aborting Crawl ....\n";
                  }
                if (file_exists("crawl/others.ini"))
                  {
                    echo "\n[-] General Crawler File Found! Crawling The Site [-]\n";
                    $crawllnk = file_get_contents("crawl/others.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Found!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        else
                          {
                            echo "\n\n[U] $url : ";
                            echo "HTTP Response: " . $httpCode;
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n File Not Found, Aborting Crawl ....\n";
                  }
              }
            elseif ($ctype == "69")
              {
                echo "\n\t -[ B A S I C   C R A W L I N G ]-\n";
                echo "\n\n";
                echo "\n Loading Crawler File ....\n";
                if (file_exists("crawl/admin.ini"))
                  {
                    echo "\n[-] Admin Crawler File Found! Scanning For Admin Pannel [-]\n";
                    $crawllnk = file_get_contents("crawl/admin.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Found!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        else
                          {
                            echo ".";
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n File Not Found, Aborting Crawl ....\n";
                  }
                if (file_exists("crawl/backup.ini"))
                  {
                    echo "\n[-] Backup Crawler File Found! Scanning For Site Backups [-]\n";
                    $crawllnk = file_get_contents("crawl/backup.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Found!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n File Not Found, Aborting Crawl ....\n";
                  }
                if (file_exists("crawl/others.ini"))
                  {
                    echo "\n[-] General Crawler File Found! Crawling The Site [-]\n";
                    $crawllnk = file_get_contents("crawl/others.ini");
                    $crawls   = explode(',', $crawllnk);
                    echo "\nURLs Loaded: " . count($crawls) . "\n\n";
                    foreach ($crawls as $crawl)
                      {
                        $url    = $ipsl . $ip . "/" . $crawl;
                        $handle = curl_init($url);
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($handle);
                        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                        if ($httpCode == 200)
                          {
                            echo "\n\n[U] $url : ";
                            echo "Found!";
                          }
                        elseif ($httpCode == 404)
                          {
                          }
                        curl_close($handle);
                      }
                  }
                else
                  {
                    echo "\n File Not Found, Aborting Crawl ....\n";
                  }
              }
            else
              {
                goto csel;
              }
          }
      }
  }
?>
