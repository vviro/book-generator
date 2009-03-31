<?php

$req_id = $_REQUEST['id'];

$cache_id = md5($req_id);

$date = date("Y-m-d_H-i-s");

$dir = "/var/www/tmp/book_public/cache/$cache_id";
exec("mkdir $dir");
$dir = "$dir/store";
exec("mkdir $dir");
$dir = "$dir/$date";
exec("mkdir $dir");

foreach ($_REQUEST as $key => $template) {
    $template = stripslashes($template);

	// working only with request parameters that came from EditArea and is not the js code
    if ($key[0] != "@" ) continue;
    // writing templates to disk. they will be read by js in Rhino-engine
    $fh = fopen("$dir/$key", "w");
    fwrite($fh, $template);
}

$o = array();
$o['ver'] = $date;
echo json_encode($o);
?>
