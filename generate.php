<?php

$req_id = $_REQUEST['id'];

$cache_id = md5($req_id);

$dir = "/var/www/tmp/book_experimental/cache/$cache_id";
exec("mkdir $dir");

$js = $_REQUEST['@javascript'];
$js = stripslashes($js);
$js = str_replace("@","",$js);
$js = "var $ = '';\n". $js . "\n";
$js .= "runCommand('bash','-c', \"echo '\" + $ + \"' > book.tex\");\n";

$fj = fopen("$dir/javascript", "w");
fwrite($fj, $js);

unset($_REQUEST['@javascript']);
foreach ($_REQUEST as $key => $template) {
    $template = stripslashes($template);

    if ($key[0] != "@") continue;
    $key = trim($key, "@");
    $templ_vars_ = array();
    preg_match_all( '|\$[a-zA-Z_]+|', $template, $templ_vars_, PREG_PATTERN_ORDER );
    $templ_vars = $templ_vars_[0];
    sort( $templ_vars, SORT_STRING );
    $var_list = "";
    foreach($templ_vars as $var_name) {
        $var_list .= $var_name . ", ";
    }
    $var_list = trim($var_list, ", ");
    
    $fun  = "function ".$key."(".$var_list.") {\n";
    $fun .= "  val_$key = readFile('@".$key."');\n";
    foreach($templ_vars as $var_name) {
        $fun .= "  val_$key = val_$key.replace('$var_name', $var_name);\n";      
    }
//    $fun .= "  runCommand('bash','-c', 'echo \" + val_$key + \" >> book.tex');\n";
    $fun .= "  return val_$key+\"\\n\";\n";
    $fun .= "}\n\n";

    fwrite($fj, $fun);
    $fh = fopen("$dir/@".$key, "w");
    fwrite($fh, $template);
}

$out = shell_exec("/var/www/tmp/book_experimental/makebook $dir");

print($out);

?>
