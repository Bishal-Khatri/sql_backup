<?php

$con = mysqli_connect('localhost', 'root', '', 'ims');


$tables = array();

$result = mysqli_query($con,"SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}
$return = '';

foreach ($tables as $table) {
    $result = mysqli_query($con, "SELECT * FROM ".$table);
    $num_fields = mysqli_num_fields($result);

    $return .= 'DROP TABLE '.$table.';';

    $row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE '.$table));
    $return .= "\n\n".$row2[1].";\n\n";

    for ($i=0; $i < $num_fields; $i++) {
        while ($row = mysqli_fetch_row($result)) {
            $return .= 'INSERT INTO '.$table.'VALUES(';
            for ($j=0; $j < $num_fields; $j++) {
                $row[$j] = addslashes($row[$j]);
                if (isset($row[$j])) {
                    $return .= '"'.$row[$j].'"';} else { $return .= '""';}
                if($j<$num_fields-1){ $return .= ','; }
            }
            $return .= ");\n";
        }
    }
    $return .= "\n\n\n";

}


$handle = fopen('backup.sql', 'w+');
fwrite($handle, $return);
fclose($handle);
echo "success";


?>



<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'rootpassword';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass,'3311');

if(! $conn ) {
    die('Could not connect: ' . mysqli_error());
}

$table_name = "employee";
$backup_file  = "/employee.sql";
$sql = "SELECT * INTO OUTFILE '$backup_file' FROM '$table_name'";

mysql_select_db('test_db');
$retval = mysql_query( $sql, $conn );

if(! $retval ) {
    die('Could not take data backup: ' . mysql_error());
}

echo "Backedup  data successfully\n";

mysql_close($conn);
?>


