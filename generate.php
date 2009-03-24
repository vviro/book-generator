<?php

$req_id = $_REQUEST['id'];

$cache_id = md5($req_id);

$dir = "/var/www/tmp/book/cache/$cache_id";
exec("mkdir $dir");

$head = $_REQUEST['head'];
$page = $_REQUEST['page'];
$foot = $_REQUEST['foot'];
$num_boards = $_REQUEST['num_boards'];

if ($num_boards > 1000) $num_boards = 1;

$x = $_REQUEST['x'];
$y = $_REQUEST['y'];

$head = str_replace('<BR>',"\n",$head);
$page = str_replace('<BR>',"\n",$page);
$foot = str_replace('<BR>',"\n",$foot);

$head = str_replace('<br>',"\n",$head);
$page = str_replace('<br>',"\n",$page);
$foot = str_replace('<br>',"\n",$foot);

$fh = fopen("$dir/header.tex", 'w');
fwrite($fh, $head);
$fp = fopen("$dir/page.tex", 'w');
fwrite($fp, $page);
$ff = fopen("$dir/footer.tex", 'w');
fwrite($ff, $foot);

$fx = fopen("$dir/sizex",'w');
fwrite($fx, $x);
$fy = fopen("$dir/sizey",'w');
fwrite($fy, $y);

$fn = fopen("$dir/num_boards",'w');
fwrite($fn, $num_boards);


$out = shell_exec("/var/www/tmp/book/makebook $dir");

print($out);

?>
