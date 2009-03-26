<?php

$req_id = $_REQUEST['id'];

$cache_id = md5($req_id);

$dir = "/var/www/tmp/book_experimental/cache/$cache_id";
exec("mkdir $dir");

foreach ($_REQUEST as $key => $value) {
    $fh = fopen("$dir/".$key, "w");
    fwrite($fh, $value);
}

$out = shell_exec("/var/www/tmp/book_experimental/makebook $dir");

print($out);

?>
