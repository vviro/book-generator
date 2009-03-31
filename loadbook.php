<?php

$ver = $_REQUEST['ver'];
$req_id = $_REQUEST['id'];
$cache_id = md5($req_id);

$dir = "/var/www/tmp/book_public/cache/$cache_id/store";
exec("mkdir $dir");

exec('ls -t '.$dir, $files);

if (count($files) == 0) return;
else if (!$ver ) $ver = $files[0];

$dir = "$dir/$ver";

$fj = fopen($dir.'/@javascript', 'r');
$js = fread($fj, filesize($dir.'/@javascript'));

$tmpls = array(); //templates

$handler = opendir($dir);
while ($file = readdir($handler)) {
    if ($file[0] == '@') {
        $f = fopen("$dir/$file", 'r');
        $size = filesize("$dir/$file");

        $file = trim($file,'@');
        $tmpl = array();
        $tmpl['name'] = $file;
        if ($size > 0) {
            $tmpl['value'] = fread( $f, $size );
        } else {
            $tmpl['value'] = '';
        }
        $tmpls[] = $tmpl;
    }
}

$o = array(); // output
$b = array(); // book
$b['id'] = $req_id;
$b['javascript'] = $js;
$b['tmpls'] = $tmpls;
$b['versions'] = $files;
$o['book'] = $b;

$json = json_encode($o);
echo $json;

?>
