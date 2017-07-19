<?php
/**
 * third API Detect
 */
class ThirdDetect
{
    public $ip = '';
    public $bold = '';
    public $lblue = '';
    public $cln = '';

    function __construct($ip, $bold, $lblue, $cln)
    {
        $this->ip = $ip;
        $this->bold = $bold;
        $this->lblue = $lblue;
        $this->cln = $cln;
    }

    public function detect()
    {
        $third_infos = array(
            array('W H O I S   L O O K U P', 'http://api.hackertarget.com/whois/?q='),
            array('G E O  I P  L O O K  U P', 'http://api.hackertarget.com/geoip/?q='),
            array('D N S   L O O K U P', 'http://api.hackertarget.com/dnslookup/?q='),
            array('S U B N E T   C A L C U L A T I O N', 'http://api.hackertarget.com/subnetcalc/?q='),
            array('N M A P   P O R T   S C A N', 'http://api.hackertarget.com/nmap/?q=')
        );

        foreach ($third_infos as $third_info) {
            echo "\n\n$this->bold".$this->lblue.$third_info['0']."\n";
            echo"=========================";
            echo"\n\n$this->cln";
            $url= $third_info['1']. $this->ip;
            $result = file_get_contents($url);
            echo $result ;
            echo "\n\n$this->cln";
        }
    }
}
