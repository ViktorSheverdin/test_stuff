<?php

error_reporting(E_ALL);
//httP_response_code(500);

$servername = "localhost";
$username = "adminuser";
$password = "P@ssw0rd";
$database = "testing";
echo 'test.';


echo <<<HTML
<html>
<body style='font-family: Calibri, "Segoe UI", Arial, sans-serif;'>
HTML;



try {
	echo 'inside try';
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo ("Connected successfully");
    echo("Text");
    echo($_SERVER['REMOTE_ADDR']);
  // Get row data
    
    //foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
      //  if (array_key_exists($key, $_SERVER) === true){
        //    foreach (explode(',', $_SERVER[$key]) as $ip){
          //      $ip = trim($ip); // just to be safe
//
  //              if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
    //                echo($ip);
      //          }
        //    }
      //  }
   // }

    $serverOneIP = "172.31.20.29";
    $serverTwoIP = "172.31.21.76";
    $serverOneIsMaster = 0;
    $serverTwoIsMaster = 0;
    $result = $conn->query('SHOW SLAVE STATUS;');
    $colcount = $result->columnCount();
    if($colcount>1){
         $serverOneIsMaster = 1;
         $serverTwoIsMaster = 0;
    }
    echo "<div>Colcount $colcount</div>";

    echo "Server 1: $serverOneIP";
    echo "<br>";
    echo "Server 2: $serverTwoIP";
    echo "<br>";    
    echo "Server 1 is master? $serverOneIsMaster";
    echo "<br>";    
    echo "Server 2 is master? $serverTwoIsMaster";
    echo "<br>";
    echo "<br>";



    echo($_SERVER['REMOTE_ADDR']);
    echo "Show Status on Server 1";
    echo "<br>";
    echo "Server 1: 172.35.00.00";
    echo "<br>";
    echo "Server 2: 172.31.20.29";
    echo "<br>";
    echo "Show Status on Server 1";
    echo "<br>";
    



    echo "SHOW SLAVE STATUS;";
    //echo($_SERVER['REMOTE_ADDR']);
    $result = $conn->query('SHOW SLAVE STATUS;');
    $colcount = $result->columnCount();
     echo ("<table style='border: solid 1px black;'><tr>");
    for ($i = 0; $i < $colcount; $i++){
        $meta = $result->getColumnMeta($i)["name"];
        echo('<th>' . $meta . '</th>');
    }
    echo('</tr>');
    $replicationLag = 0;
     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>');
        for ($i = 0; $i < $colcount; $i++){
            if($row['Slave_IO_Running'] == 'Yes' || $row['Slave_SQL_Running'] == 'Yes'){
                if($row['Seconds_Behind_Master'] <=30){
                     $meta = $result->getColumnMeta($i)["name"];
                     echo("<td style='border: solid 1px black;'>" . $row[$meta] . '</td>');
		     //echo($_SERVER['REMOTE_ADDR']);
                }
                else{
                     http_response_code(500);
                     $replicationLag = 1;
                     //echo($_SERVER['REMOTE_ADDR']);
                     //echo("Replication Lag");
                }
            }
            else{
                 http_response_code(500);
                 echo('Replication error');
           }
        }
        echo('</tr>');
    }
    if($replicationLag = 1){
         echo('<br/>');
         //echo("Replication Lag");
    }
    echo ('</table>');

    echo "SHOW MASTER STATUS;";

    echo "\n";
    $result = $conn->query('SHOW MASTER STATUS;');
    $colcount = $result->columnCount();
     echo ("<table style='border: solid 1px black;'><tr>");
    for ($i = 0; $i < $colcount; $i++){
        $meta = $result->getColumnMeta($i)["name"];
        echo('<th>' . $meta . '</th>');
    }
    echo('</tr>');

     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>');
        for ($i = 0; $i < $colcount; $i++){
            $meta = $result->getColumnMeta($i)["name"];
            echo("<td style='border: solid 1px black;'>" . $row[$meta] . '</td>');
        }
        echo('</tr>');
    }

    echo ('</table>');

    echo "SHOW PROCESSLIST;";

     $result = $conn->query('SHOW PROCESSLIST;');
    $colcount = $result->columnCount();
     echo ("<table style='border: solid 1px black;'><tr>");
    for ($i = 0; $i < $colcount; $i++){
        $meta = $result->getColumnMeta($i)["name"];
        echo('<th>' . $meta . '</th>');
    }
    echo('</tr>');

    

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>');
        for ($i = 0; $i < $colcount; $i++){
            $meta = $result->getColumnMeta($i)["name"];
            echo("<td style='border: solid 1px black;'>" . $row[$meta] . '</td>');
        }
        echo('</tr>');
    }

    echo ('</table>');



    echo "SHOW @@read_only";

 $result = $conn->query('SELECT @@READ_ONLY');
    $colcount = $result->columnCount();
     echo ("<table style='border: solid 1px black;'><tr>");
    for ($i = 0; $i < $colcount; $i++){
        $meta = $result->getColumnMeta($i)["name"];
        echo('<th>' . $meta . '</th>');
    }
    echo('</tr>');



    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>');
        for ($i = 0; $i < $colcount; $i++){
            $meta = $result->getColumnMeta($i)["name"];
            echo("<td style='border: solid 1px black;'>" . $row[$meta] . '</td>');
        }
        echo('</tr>');
    }

    echo ('</table>');




}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    http_response_code(500);    
}



try {
    echo 'inside try';
    $conn = new PDO("mysql:host=172.31.21.76;dbname=$database", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully";
echo "<br>";

echo "Server 2";
echo "<br>";
    
echo "<br>";
echo "SHOW SLAVE STATUS;";
 $result = $conn->query('SHOW SLAVE STATUS;');
    $colcount = $result->columnCount();
     echo ("<table style='border: solid 1px black;'><tr>");
    for ($i = 0; $i < $colcount; $i++){
        $meta = $result->getColumnMeta($i)["name"];
        echo('<th>' . $meta . '</th>');
    }
    echo('</tr>');
     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>');
        for ($i = 0; $i < $colcount; $i++){
            $meta = $result->getColumnMeta($i)["name"];
            echo("<td style='border: solid 1px black;'>" . $row[$meta] . '</td>');
        }
        echo('</tr>');
    }

    echo ('</table>');

    echo "SHOW MASTER STATUS;";

    echo "\n";
    $result = $conn->query('SHOW MASTER STATUS;');
    $colcount = $result->columnCount();
     echo ("<table style='border: solid 1px black;'><tr>");
    for ($i = 0; $i < $colcount; $i++){
        $meta = $result->getColumnMeta($i)["name"];
        echo('<th>' . $meta . '</th>');
    }
    echo('</tr>');

     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>');
        for ($i = 0; $i < $colcount; $i++){
            $meta = $result->getColumnMeta($i)["name"];
            echo("<td style='border: solid 1px black;'>" . $row[$meta] . '</td>');
        }
        echo('</tr>');
    }

    echo ('</table>');



 echo "SHOW PROCESSLIST;";

     $result = $conn->query('SHOW PROCESSLIST;');
    $colcount = $result->columnCount();
     echo ("<table style='border: solid 1px black;'><tr>");
    for ($i = 0; $i < $colcount; $i++){
        $meta = $result->getColumnMeta($i)["name"];
        echo('<th>' . $meta . '</th>');
    }
    echo('</tr>');



    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>');
        for ($i = 0; $i < $colcount; $i++){
            $meta = $result->getColumnMeta($i)["name"];
            echo("<td style='border: solid 1px black;'>" . $row[$meta] . '</td>');
        }
        echo('</tr>');
    }

    echo ('</table>');


 echo "SHOW @@read_only";

 $result = $conn->query('SELECT @@READ_ONLY');
    $colcount = $result->columnCount();
     echo ("<table style='border: solid 1px black;'><tr>");
    for ($i = 0; $i < $colcount; $i++){
        $meta = $result->getColumnMeta($i)["name"];
        echo('<th>' . $meta . '</th>');
    }
    echo('</tr>');



    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>');
        for ($i = 0; $i < $colcount; $i++){
            $meta = $result->getColumnMeta($i)["name"];
            echo("<td style='border: solid 1px black;'>" . $row[$meta] . '</td>');
        }
        echo('</tr>');
    }

    echo ('</table>');



}


catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    http_response_code(500);
}









echo <<<HTML
</body>
</html>
HTML;

?>
