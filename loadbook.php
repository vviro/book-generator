<?php

$req_id = $_REQUEST['id'];

$cache_id = md5($req_id);

$dir = "/var/www/tmp/book_experimental/cache/$cache_id";
exec("mkdir $dir");

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
$o['book'] = $b;

$json = json_encode($o);
echo $json;

?>
