<form method="post" >
    Domain/IP: 
    <input type="text" name="domain" /> 
    <input type="submit" value="Scan" />
</form>
<br />
 
<?php
if(!empty($_POST['domain'])) {    
    //list of port numbers to scan
    $ports = array(21, 22, 23, 25, 53, 80, 110, 1433, 3306);

    /* 
    | Port numbers: 
    | -----------------------
    | Port 21   = FTP       |
    | Port 22   = SSH       |
    | Port 23   = Telnet    |
    | Port 25   = SMTP      |
    | Port 53   = Domain    |
    | Port 80   = HTTP      |
    | Port 110  = POP3      |
    | Port 1433 = ms-sql-s  |
    | Port 3306 = MySQL     |
    | -----------------------
    */ 

    
    $results = array();
    foreach($ports as $port) {
        if($pf = @fsockopen($_POST['domain'], $port, $err, $err_string, 1)) {
            $results[$port] = true;
            fclose($pf);
        } else {
            $results[$port] = false;
        }
    }
 
    foreach($results as $port=>$val)    {
        $prot = getservbyport($port,"tcp");
                echo "Port $port ($prot): ";
        if($val) {
            echo "<span style=\"color:green\">OK</span><br/>";
        }
        else {
            echo "<span style=\"color:red\">Inaccessible</span><br/>";
        }
    }
}
?>
