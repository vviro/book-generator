<?php

$req_id = $_REQUEST['id'];

$cache_id = md5($req_id);

$dir = "/var/www/tmp/book_experimental/cache/$cache_id";
exec("mkdir $dir");

$js = $_REQUEST['@javascript'];
unset($_REQUEST['@javascript']);
$js = str_replace("@","",$js);
$fj = fopen("$dir/javascript", "w");
fwrite($fj, $js."\n");

foreach ($_REQUEST as $key => $template) {
    if ($key[0] != "@") continue;
    $key = trim($key, "@");
    $templ_vars_ = array();
    preg_match_all( '|\$[a-zA-Z_]+|U', $template, $templ_vars_, PREG_PATTERN_ORDER );
    $templ_vars = $templ_vars_[0];
    sort( $templ_vars, SORT_STRING );
    $var_list = "";
    foreach($templ_vars as $var_name) {
        $var_list .= $var_name . ", ";
    }
    $var_list = trim($var_list, ", ");
    
    $fun  = "function ".$key."(".$var_list.") {\n";
    $fun .= "  $key = readFile('@".$key."');\n";
    foreach($templ_vars as $var_name) {
        $fun .= "  $key = $key.replace('$var_name', $var_name)\n";      
    }
    $fun .= "  runCommand('bash','-c', 'echo \" + ".$key." + \" >> book.tex');\n";
    $fun .= "}\n\n";

    fwrite($fj, $fun);
    $fh = fopen("$dir/".$key, "w");
    fwrite($fh, $template);
}

$out = shell_exec("/var/www/tmp/book_experimental/makebook $dir");

print($out);

?>
