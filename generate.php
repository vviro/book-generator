<?php

$req_id = $_REQUEST['id'];

$cache_id = md5($req_id);

$dir = "/var/www/tmp/book_public/cache/$cache_id";
exec("mkdir $dir");

// forming and storing the main js code block from javascript set in EditArea
$js = $_REQUEST['@javascript'];
$js = stripslashes($js);
$js = str_replace("@","",$js);
$js = "var $ = '';\n". $js . "\n";
$js .= "runCommand('bash','-c', \"echo '\" + $ + \"' > book.tex\");\n";

$fj = fopen("$dir/javascript", "w");
fwrite($fj, $js);

// for each template, generate a function js function that will load it, 
// fill with values and give the result back.
foreach ($_REQUEST as $key => $template) {
    $template = stripslashes($template);

	// working only with request parameters that came from EditArea and is not the js code
    if ($key[0] != "@" || $key == "@javascript") continue;
    $key = trim($key, "@");
    $templ_vars_ = array();
    
    // identifying all variables in the template body
    preg_match_all( '|\$[a-zA-Z_]+|', $template, $templ_vars_, PREG_PATTERN_ORDER );
    $templ_vars = $templ_vars_[0];
    $templ_vars = array_unique($templ_vars);
    
    // sorting variables alphabetically for use in the definition of correspoding js function
    sort( $templ_vars, SORT_STRING );
    $var_list = "";
    foreach($templ_vars as $var_name) {
        $var_list .= $var_name . ", ";
    }
    $var_list = trim($var_list, ", ");
    
    // generating js-functions that fill templates with js values 
    $fun  = "function ".$key."(".$var_list.") {\n";
    $fun .= "  val_$key = readFile('@".$key."');\n";
    foreach($templ_vars as $var_name) {
        $fun .= "  val_$key = val_$key.replace('$var_name', $var_name);\n";      
    }
    $fun .= "  return val_$key+\"\\n\";\n";
    $fun .= "}\n\n";
	
	// writing generated javascript to disk 
    fwrite($fj, $fun);
    
    // writing templates to disk. they will be read by js in Rhino-engine
    $fh = fopen("$dir/@".$key, "w");
    fwrite($fh, $template);
}

$out = shell_exec("/var/www/tmp/book_public/makebook $dir");

print($out);

?>
