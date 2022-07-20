
<?php
$fp = fopen('/tmp/requests.txt', 'a');
$time = $_SERVER['REQUEST_TIME'];
fwrite($fp, $time + "\n");
echo "$time.<br>";
foreach (getallheaders() as $name => $value) {
    $cur_hd = "$name: $value\n";
    fwrite($fp, $cur_hd);
    echo "$cur_hd.<br>";
}
fwrite($fp, "***\n");
fclose($fp);
?>
