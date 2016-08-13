<?php
session_name('basket');
session_start('basket');

if (file_exists("config.txt")) { include "config.txt"; }


//Se establece el limite maximo de ejecucion (solo tiene efecto si no esta en safe-mode:
if (isset($set_time_limit) && $set_time_limit != "" && is_numeric($set_time_limit)) { set_time_limit($set_time_limit); }


if (isset($_GET)) {
if (isset($_GET['screen_width'])) { $screen_width = $_GET['screen_width']; }
if (isset($_GET['table_width_var'])) { $table_width_var = $_GET['table_width_var']; }
if (isset($_GET['javascript_support'])) { $javascript_support = $_GET['javascript_support']; }
if (isset($_GET['change_resolution'])) { $change_resolution = $_GET['change_resolution']; }

if (isset($_GET['category'])) { $category = $_GET['category']; }
if (isset($_GET['subcategory'])) { $subcategory = $_GET['subcategory']; }
if (isset($_GET['search'])) { $search = $_GET['search']; }
if (isset($_GET['allwords'])) { $allwords = $_GET['allwords']; }

if (isset($_GET['ref'])) { $ref = $_GET['ref']; }
if (isset($_GET['act'])) { $act = $_GET['act']; }
if (isset($_GET['quantity'])) { $quantity = $_GET['quantity']; }
if (isset($_GET['quantity_mod'])) { $quantity_mod = $_GET['quantity_mod']; }
}

if (isset($contact_file) && $contact_file != "") {
$this_file = $contact_file;
} else {
$this_file = "contact.php";
}





//Funciones de trace-route espia:
//$spy_start_sec = time();
$spy_start_hour = date("H:i:s");
$spy_start_date = date("d/m/Y");

if(!isset($_SESSION['spy_ip'])) { $_SESSION['spy_ip'] = $_SERVER['REMOTE_ADDR']; }
if(!isset($_SESSION['spy_dns'])) { $_SESSION['spy_dns'] = gethostbyaddr($_SESSION['spy_ip']); }

if (!isset($_SESSION['spy_route'])) {
$_SESSION['spy_route'] = "IP: ".$_SERVER['REMOTE_ADDR']."\n";
$_SESSION['spy_route'] .= "DNS: ".gethostbyaddr($_SERVER['REMOTE_ADDR'])."\n";


if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "") {
$_SESSION['spy_route'] .= "Referer (origin): ".$_SERVER['HTTP_REFERER']."\n";
} else {
$_SESSION['spy_route'] .= "Referer (origin): unknown\n";
}



if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] != "") {
$_SESSION['spy_route'] .= "Language support: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."\n";
} else {
$_SESSION['spy_route'] .= "Language support: unknown\n";
}



}

if (!isset($_SESSION['spy_browser'])) {
//$_SESSION['spy_browser'] = $_SERVER["HTTP_USER_AGENT"];
if (isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"] != "") { $_SESSION['spy_browser'] = $_SERVER["HTTP_USER_AGENT"]; }
else { $_SESSION['spy_browser'] = "undefined"; }
$_SESSION['spy_route'] .= "Browser: ".$_SESSION['spy_browser']."\n";
}

if (!isset($_GET)) { $spy_get_vars = " (sin variables)"; }
else {
$spy_get_vars = "";
}

$spy_get_vars_x = 0;

foreach($_GET as $spy_get_vars_name => $spy_get_vars_value)  {

if($spy_get_vars_x == 0) {
$spy_get_vars .= "?".urlencode($spy_get_vars_name)."=".urlencode($spy_get_vars_value);
} else {
$spy_get_vars .= "&".urlencode($spy_get_vars_name)."=".urlencode($spy_get_vars_value);
}

$spy_get_vars_x++;

}


$_SESSION['spy_route'] .= "\n[". $spy_start_hour . "] " . $spy_start_date;

//$_SESSION['spy_route'] .= " (( ".$this_file. $spy_get_vars ." ))\n";
//$_SESSION['spy_route'] .= " (( ".$this_file. urlencode($spy_get_vars) ." ))\n";
//$_SESSION['spy_route'] .= " (( ".$this_file. urlencode($spy_get_vars) ." ))\n";
$_SESSION['spy_route'] .= " (( ".$this_file. $spy_get_vars ." ))\n";


if (isset($_GET['screen_width']) && $_GET['screen_width'] != "" && isset($_GET['screen_height']) && $_GET['screen_height'] != "") {
//echo "aaaaaaaaaa";
$_SESSION['spy_resolution'] = $_GET['screen_width']."x".$_GET['screen_height'];
$_SESSION['spy_route'] .= "Resolucion: ".$_SESSION['spy_resolution']."\n";
}

if (isset($_SESSION['screen_width']) && $_SESSION['screen_width'] != "" && isset($_SESSION['screen_height']) && $_SESSION['screen_height'] != "") {
if (!isset($_GET['screen_width']) || !isset($_GET['screen_height'])) {
$_SESSION['spy_resolution'] = $_SESSION['screen_width']."x".$_SESSION['screen_height'];
$_SESSION['spy_route'] .= "Resolucion: ".$_SESSION['spy_resolution']."\n";
}
}

if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] != "") {
$_SESSION['spy_javascript_support'] = $_SESSION['javascript_support'];
$_SESSION['spy_route'] .= "JavaScript 1.2: ".$_SESSION['spy_javascript_support']."\n";
}


if (SID) {
$_SESSION['spy_route'] .= "Cookies (SID): disabled (".SID.")\n";
} else {
$_SESSION['spy_route'] .= "Cookies (SID): enabled\n";
}


if (isset($_SESSION['spy_ip']) && $_SESSION['spy_ip'] != $_SERVER['REMOTE_ADDR']) {
$_SESSION['spy_ip'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['spy_route'] .= "\nDetectado cambio de IP. Nueva: ".$_SESSION['spy_ip']."\n";
}

if (isset($_SESSION['spy_dns']) && $_SESSION['spy_dns'] != gethostbyaddr($_SESSION['spy_ip'])) {
$_SESSION['spy_dns'] = gethostbyaddr($_SESSION['spy_ip']);
$_SESSION['spy_route'] .= "\nDetectado cambio de DNS. Nueva: ".$_SESSION['spy_dns']."\n";
}




//Fin de Funciones de trace-route espia:





$category_content = file($category_file);

$items_content = file($items_file);


$_SESSION['last_page_visited'] = $this_file;

$change_resolution_page = "?change_resolution=ok";

$last_page_visited_vars = $_GET;

$last_page_visited_vars_x = 0;

if (isset($last_page_visited_vars) && $last_page_visited_vars != "") {

foreach ($last_page_visited_vars as $last_page_visited_vars_separated => $last_page_visited_vars_separated_result) {


if (trim(urlencode($last_page_visited_vars_separated)) != "change_resolution" && trim(urlencode($last_page_visited_vars_separated)) != "table_width_var" && trim(urlencode($last_page_visited_vars_separated)) != session_name()) {

$change_resolution_page .= "&" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));

if ($last_page_visited_vars_x == 0) {

$_SESSION['last_page_visited'] .= "?" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));

} else {
$_SESSION['last_page_visited'] .= "&" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));

}

$last_page_visited_vars_x++;

}

}

}


if (SID && $_SESSION['last_page_visited'] == $this_file) {
$_SESSION['last_page_visited'] .= "?" . SID;
}
elseif (SID && $_SESSION['last_page_visited'] != $this_file) {
$_SESSION['last_page_visited'] .= "&" . SID;
}



if (!isset($_SESSION['change_resolution_page_session'])) { $_SESSION['change_resolution_page_session'] = $change_resolution_page; }




//Pruebita resoluciones:

if (isset($user_can_alternate_page_width) && $user_can_alternate_page_width == "on" || isset($_GET['screen_width'])) {

if (isset($javascript_autodetect_resolution) && $javascript_autodetect_resolution == "on" && isset($_GET['screen_width']) && $_GET['screen_width'] != "" && isset($_GET['table_width_var']) && $_GET['table_width_var'] == "auto") {

$_SESSION['screen_width'] = $_GET['screen_width'];
if (isset($_GET['screen_height']) && $_GET['screen_height'] != "") { $_SESSION['screen_height'] = $_GET['screen_height']; }
//echo "Resolucion width: ".$_SESSION['screen_width'];

if ($_SESSION['screen_width'] == "undefined") { $_SESSION['screen_is_undefined'] = "enabled"; }

if ($_SESSION['screen_width'] < 640 && $_SESSION['screen_width'] > 0) {
//echo "Menor que 640 y mayor que 0";
$_GET['table_width_var'] = $page_width_less_than_640x480;
}

if ($_SESSION['screen_width'] >= 640 && $_SESSION['screen_width'] < 800) {
//echo "Mayor o igual que 640 y menor que 800";
$_GET['table_width_var'] = $page_width_640x480;
}

if ($_SESSION['screen_width'] >= 800 && $_SESSION['screen_width'] < 1024) {
//echo "Mayor o igual que 800 y menor que 1024";
$_GET['table_width_var'] = $page_width_800x600;
}

if ($_SESSION['screen_width'] >= 1024 && $_SESSION['screen_width'] < 1280) {
//echo "Mayor o igual que 1024 y menor que 1280";
$_GET['table_width_var'] = $page_width_1024x768;
}

if ($_SESSION['screen_width'] == 1280) {
//echo "Igual que 1280";
$_GET['table_width_var'] = $page_width_1280x1024;
}

if ($_SESSION['screen_width'] > 1280) {
//echo "Mayor que 1280";
$_GET['table_width_var'] = $page_width_more_than_1280x1024;
}

}


if (isset($_GET['table_width_var']) && $_GET['table_width_var'] != "") {

if (isset($page_width_less_than_640x480) && $page_width_less_than_640x480 != "" && isset($page_width_640x480) && $page_width_640x480 != "" && isset($page_width_800x600) && $page_width_800x600 != "" && isset($page_width_1024x768) && $page_width_1024x768 != "" && isset($page_width_1280x1024) && $page_width_1280x1024 != "" && isset($page_width_more_than_1280x1024) && $page_width_more_than_1280x1024 != "") {

if ($_GET['table_width_var'] == $page_width_less_than_640x480 || $_GET['table_width_var'] == $page_width_640x480 || $_GET['table_width_var'] == $page_width_800x600 || $_GET['table_width_var'] == $page_width_1024x768 || $_GET['table_width_var'] == $page_width_1280x1024 || $_GET['table_width_var'] == $page_width_more_than_1280x1024) {
//echo  "a";

$logo_width = $table_width_var;
$table_width = $logo_width;

//echo "menllefeeeeeeee";

if (isset($page_width_less_than_640x480) && $_GET['table_width_var'] == $page_width_less_than_640x480) {
$product_table_width = $product_table_width_less_than_640x480; $_SESSION['changed_resolution_product'] = $product_table_width_less_than_640x480; $_SESSION['changed_resolution'] = $page_width_less_than_640x480;
if (isset($logo_file_less_than_640x480) && $logo_file_less_than_640x480 != "" && $logo_file_less_than_640x480 != "auto") { $logo_file = $logo_file_less_than_640x480; $_SESSION['changed_resolution_logo_file'] = $logo_file; }
if (isset($logo_width_less_than_640x480) && $logo_width_less_than_640x480 != "" && $logo_width_less_than_640x480 != "auto") { $logo_width = $logo_width_less_than_640x480; $_SESSION['changed_resolution_logo_width'] = $logo_width; }
if (isset($logo_width_less_than_640x480) && $logo_width_less_than_640x480 == "auto") { unset($logo_width); }
if (isset($logo_height_less_than_640x480) && $logo_height_less_than_640x480 != "" && $logo_height_less_than_640x480 != "auto") { $logo_height = $logo_height_less_than_640x480; $_SESSION['changed_resolution_logo_height'] = $logo_height; }
if (isset($logo_height_less_than_640x480) && $logo_height_less_than_640x480 == "auto") { unset($logo_height); }
}
//Cuidao:
//}

if (isset($page_width_640x480) && $_GET['table_width_var'] == $page_width_640x480) {
$product_table_width = $product_table_width_640x480; $_SESSION['changed_resolution_product'] = $product_table_width_640x480; $_SESSION['changed_resolution'] = $page_width_640x480;
if (isset($logo_file_640x480) && $logo_file_640x480 != "" && $logo_file_640x480 != "auto") { $logo_file = $logo_file_640x480; $_SESSION['changed_resolution_logo_file'] = $logo_file; }
if (isset($logo_width_640x480) && $logo_width_640x480 != "" && $logo_width_640x480 != "auto") { $logo_width = $logo_width_640x480; $_SESSION['changed_resolution_logo_width'] = $logo_width; }
if (isset($logo_width_640x480) && $logo_width_640x480 == "auto") { unset($logo_width); }
if (isset($logo_height_640x480) && $logo_height_640x480 != "" && $logo_height_640x480 != "auto") { $logo_height = $logo_height_640x480; $_SESSION['changed_resolution_logo_height'] = $logo_height; }
if (isset($logo_height_640x480) && $logo_height_640x480 == "auto") { unset($logo_height); }
}

if (isset($page_width_800x600) && $_GET['table_width_var'] == $page_width_800x600) {
$product_table_width = $product_table_width_800x600; $_SESSION['changed_resolution_product'] = $product_table_width_800x600; $_SESSION['changed_resolution'] = $page_width_800x600;
if (isset($logo_file_800x600) && $logo_file_800x600 != "" && $logo_file_800x600 != "auto") { $logo_file = $logo_file_800x600; $_SESSION['changed_resolution_logo_file'] = $logo_file; }
if (isset($logo_width_800x600) && $logo_width_800x600 != "" && $logo_width_800x600 != "auto") { $logo_width = $logo_width_800x600; $_SESSION['changed_resolution_logo_width'] = $logo_width; }
if (isset($logo_width_800x600) && $logo_width_800x600 == "auto") { unset($logo_width); }
if (isset($logo_height_800x600) && $logo_height_800x600 != "" && $logo_height_800x600 != "auto") { $logo_height = $logo_height_800x600; $_SESSION['changed_resolution_logo_height'] = $logo_height; }
if (isset($logo_height_800x600) && $logo_height_800x600 == "auto") { unset($logo_height); }
}

if (isset($page_width_1024x768) && $_GET['table_width_var'] == $page_width_1024x768) {
$product_table_width = $product_table_width_1024x768; $_SESSION['changed_resolution_product'] = $product_table_width_1024x768; $_SESSION['changed_resolution'] = $page_width_1024x768;
if (isset($logo_file_1024x768) && $logo_file_1024x768 != "" && $logo_file_1024x768 != "auto") { $logo_file = $logo_file_1024x768; $_SESSION['changed_resolution_logo_file'] = $logo_file; }
if (isset($logo_width_1024x768) && $logo_width_1024x768 != "" && $logo_width_1024x768 != "auto") { $logo_width = $logo_width_1024x768; $_SESSION['changed_resolution_logo_width'] = $logo_width; }
if (isset($logo_width_1024x768) && $logo_width_1024x768 == "auto") { unset($logo_width); }
if (isset($logo_height_1024x768) && $logo_height_1024x768 != "" && $logo_height_1024x768 != "auto") { $logo_height = $logo_height_1024x768; $_SESSION['changed_resolution_logo_height'] = $logo_height; }
if (isset($logo_height_1024x768) && $logo_height_1024x768 == "auto") { unset($logo_height); }
}

if (isset($page_width_1280x1024) && $_GET['table_width_var'] == $page_width_1280x1024) {
$product_table_width = $product_table_width_1280x1024; $_SESSION['changed_resolution_product'] = $product_table_width_1280x1024; $_SESSION['changed_resolution'] = $page_width_1280x1024;
if (isset($logo_file_1280x1024) && $logo_file_1280x1024 != "" && $logo_file_1280x1024 != "auto") { $logo_file = $logo_file_1280x1024; $_SESSION['changed_resolution_logo_file'] = $logo_file; }
if (isset($logo_width_1280x1024) && $logo_width_1280x1024 != "" && $logo_width_1280x1024 != "auto") { $logo_width = $logo_width_1280x1024; $_SESSION['changed_resolution_logo_width'] = $logo_width; }
if (isset($logo_width_1280x1024) && $logo_width_1280x1024 == "auto") { unset($logo_width); }
if (isset($logo_height_1280x1024) && $logo_height_1280x1024 != "" && $logo_height_1280x1024 != "auto") { $logo_height = $logo_height_1280x1024; $_SESSION['changed_resolution_logo_height'] = $logo_height; }
if (isset($logo_height_1280x1024) && $logo_height_1280x1024 == "auto") { unset($logo_height); }
}

if (isset($page_width_more_than_1280x1024) && $_GET['table_width_var'] == $page_width_more_than_1280x1024) {
$product_table_width = $product_table_width_more_than_1280x1024; $_SESSION['changed_resolution_product'] = $product_table_width_more_than_1280x1024; $_SESSION['changed_resolution'] = $page_width_more_than_1280x1024;
//echo "menllefe";
if (isset($logo_file_more_than_1280x1024) && $logo_file_more_than_1280x1024 != "" && $logo_file_more_than_1280x1024 != "auto") { $logo_file = $logo_file_more_than_1280x1024; $_SESSION['changed_resolution_logo_file'] = $logo_file; }
if (isset($logo_width_more_than_1280x1024) && $logo_width_more_than_1280x1024 != "" && $logo_width_more_than_1280x1024 != "auto") { $logo_width = $logo_width_more_than_1280x1024; $_SESSION['changed_resolution_logo_width'] = $logo_width; }
if (isset($logo_width_more_than_1280x1024) && $logo_width_more_than_1280x1024 == "auto") { unset($logo_width); }
if (isset($logo_height_more_than_1280x1024) && $logo_height_more_than_1280x1024 != "" && $logo_height_more_than_1280x1024 != "auto") { $logo_height = $logo_height_more_than_1280x1024; $_SESSION['changed_resolution_logo_height'] = $logo_height; }
if (isset($logo_height_more_than_1280x1024) && $logo_height_more_than_1280x1024 == "auto") { unset($logo_height); }
}

//Cuidao: 
}


}
}
}


if (isset($_SESSION['changed_resolution']) && $_SESSION['changed_resolution'] != "") {

$logo_file = $_SESSION['changed_resolution_logo_file'];

$logo_width = $_SESSION['changed_resolution_logo_width'];
$logo_height = $_SESSION['changed_resolution_logo_height'];

$table_width = $_SESSION['changed_resolution'];
$product_table_width = $_SESSION['changed_resolution_product'];

}

//Fin pruebita resoluciones.


//Calcular el 25% y el 75% de \$table_width (en caso de no existir, se tomara \$menu_width).
//Se restaran los decimales de uno y se sumaran en el otro. Debe ser un entero, si no producira error:

if (isset($table_width) && is_numeric($table_width)) {

   $td_menu_width = ($table_width / 100) * 25;

   $td_body_width = ($table_width / 100) * 75;
   
} else {
        if (isset($logo_width) && is_numeric($logo_width)) {
           $td_menu_width = ($logo_width / 100) * 25;

           $td_body_width = ($logo_width / 100) * 75;
        }
        else { $td_menu_width = 100; $td_body_width = 500; }
}

if (is_numeric($td_body_width) && is_numeric($td_menu_width)) {

   $dec_td_body_width = explode(".", $td_body_width);
   $dec_td_menu_width = explode(".", $td_menu_width);

   if (isset($dec_td_body_width[1]) && isset($dec_td_menu_width[1])) {

      if ($dec_td_body_width[1] + $dec_td_menu_width[1] == 1000 || $dec_td_body_width[1] + $dec_td_menu_width[1] == 100 || $dec_td_body_width[1] + $dec_td_menu_width[1] == 10) {

         $td_body_width = $dec_td_body_width[0];
         $td_menu_width = $dec_td_menu_width[0] + 1;
         } else {
            if (!isset($errors)) { $errors = ""; }
            $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>LA VARIABLE</b>\$table_width o la variable \$logo_width <b><u>NO SON NUMEROS ENTEROS</u> O CONTIENEN ALGUN ERROR.</b>(\$table_width = <i> ".$table_width." </i>y \$logo_width = <i>".$logo_width."</i>)</font><br>";
         }
   }

//   $suma_tds = $td_body_width + $td_menu_width;
//   echo "x (".$td_body_width.") + y (".$td_menu_width.") = " . $suma_tds;

}

if (isset($doctype)) {
//echo "DOCTYPE SIII ESTA SETEADO";
echo $doctype;
} else {
//echo "DOCTYPE NO ESTA SETEADO";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";
}

?>    

<?php 
if (isset($content_invert) && $content_invert == "on") {
echo "<html dir=\"RTL\" lang=\"".$language_short_web."\">";
} else {
echo "<html lang=\"".$language_short_web."\">";
}
?>
      
      <!-- Programa y Web por Joan Alba Maldonado -->

      <head>
            <title><?php readfile($title_file); ?></title>

            <link rev="made" href="mailto:<?php echo $meta_mademail; ?>">
            <link rel="SHORTCUT ICON" href="favicon.ico">
           
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <meta http-equiv="Content-Style-Type" content="text/css">
            <meta http-equiv="Content-Script-Type" content="text/javascript">
            <meta http-equiv="Content-Language" content="<?php echo $meta_language_short; ?>">

            <meta http-equiv="Reply-To" content="<?php echo $meta_mademail; ?>">

            <meta http-equiv="imagetoolbar" content="no">

            <meta http-equiv="Pragma" content="no-cache">
            <meta http-equiv="Cache-Control" content="no-cache">
            <meta http-equiv="expires" content="0">

            <meta name="VW96.objecttype" content="Document">
            <meta name="resource-type" content="Document">
            <meta name="DC.Type" scheme="DCMIType" content="Text">
            <!-- <meta name="DC.Format.Medium" content="text/html"> -->

            <meta name="DC.Format" content="text/html">

            <meta name="DC.Identifier" content="<?php echo $meta_url; ?>">
            <meta name="URL" content="<?php echo $meta_url; ?>">
            <meta http-equiv="URL" content="<?php echo $meta_url; ?>">

            <meta name="DC.Source" content="<?php echo $meta_title; ?>">

            <meta name="htdig-email" content="<?php echo $meta_mademail; ?>">

            <meta name="subject" content="<?php echo $meta_subject; ?>">
            <meta name="DC.Subject" content="<?php echo $meta_subject; ?>">

            <meta name="generator" content="<?php echo $meta_generator; ?>">

            <meta name="title" content="<?php echo $meta_title; ?>">
            <meta name="DC.title" content="<?php echo $meta_title; ?>">
            <meta http-equiv="title" content="<?php echo $meta_title; ?>">

            <meta name="author" content="<?php echo $meta_author; ?>">
            <meta name="autor" content="<?php echo $meta_author; ?>">
            <meta name="DC.Creator" content="<?php echo $meta_author; ?>">
            <meta name="DC.Publisher" content="<?php echo $meta_author; ?>">

            <meta name="creator" content="<?php echo $meta_author; ?>">
            <meta name="DC.creator" content="<?php echo $meta_author; ?>">

            <meta name="keywords" content="<?php echo $meta_keywords; ?>">
            <meta name="htdig-keywords" content="<?php echo str_replace(",", "", $meta_keywords); ?>">
            <meta http-equiv="keywords" content="<?php echo $meta_keywords; ?>">
            
            <meta name="description" content="<?php echo $meta_description; ?>">
            <meta name="DC.Description" content="<?php echo $meta_description; ?>">
            <meta http-equiv="description" content="<?php echo $meta_description; ?>">

            <meta name="distribution" content="<?php echo $meta_distribution; ?>">
            <meta http-equiv="distribution" content="<?php echo $meta_distribution; ?>">

            <meta name="revisit" content="<?php echo $meta_revisit; ?>">
            <meta name="revisit-after" content="<?php echo $meta_revisit_after; ?>">
            <meta name="robots" content="<?php echo $meta_robots; ?>">
            <meta name="GOOGLEBOT" content="<?php echo $meta_robots; ?>"> 

            <meta name="DC.Language" scheme="RFC1766" content="<?php echo $meta_language_short; ?>">
            <meta name="language" content="<?php echo $meta_language_short; ?>">

            <meta name="copyright" content="&copy; <?php echo date("Y")." ".$meta_title; ?>" lang="<?php echo $meta_language_short; ?>">
            <meta name="DC.Rights" content="(c) <?php echo date("Y")." ".$meta_title; ?>" lang="<?php echo $meta_language_short; ?>">

<!--

<meta name="DC.Date" content="2001-06-16">
<meta name="DC.Relation.isPartOf" content="http://www.drogaslibres.com/">
<meta name="DC.Relation" content="http://www.drogaslibres.com">
<meta name="DC.Coverage" content="Spain">

<meta name="DC.Contributor" content="Graficos por Pepito Grillo">

<meta name="keywords" lang="de" content="Ferien, Griechenland, Sonnenschein">
<meta name="keywords" lang="en-us" content="vacation, Greece, sunshine">
<meta name="keywords" lang="en" content="holiday, Greece, sunshine">
<meta name="keywords" lang="fr" content="vacances, Gr&egrave;ce, soleil">
<meta name="keywords" lang="es" content="vacaciones, Grecia, sol">

        <meta name="price" content="free">
        <meta name="how-much" content="free">
        <meta name="OS-tested" content="Windows 3.0, Windows 3.1, Windows 3.11, Windows NT, Windows 2000, Windows 2003, Windows 95, Windows 98, Windows ME, Linux, Unix, BeOS, OS/2, QNX, Inferno, PalmOS, Windows CE, Windows XP, Novell Netware, Solaris, Irix, MAC OS, FreeBSD, NetBSD, OpenBSD, MenuetOS, MS-DOS, FreeDOS, OpenDOS">
        <meta name="OS-compatible" content="Windows 3.0, Windows 3.1, Windows 3.11, Windows NT, Windows 2000, Windows 2003, Windows 95, Windows 98, Windows ME, Linux, Unix, BeOS, OS/2, QNX, Inferno, PalmOS, Windows CE, Windows XP, Novell Netware, Solaris, Irix, MAC OS, FreeBSD, NetBSD, OpenBSD, MenuetOS, MS-DOS, FreeDOS, OpenDOS">
        <meta name="browser-tested" content="Microsoft Internet Explorer 3.0, Microsoft Internet Explorer 4.0, Microsoft Internet Explorer 5.0, Microsoft Internet Explorer 5.5, Microsoft Internet Explorer 6.0, Netscape Navigator 2.0, Netscape Navigator 3.0, Netscape Navigator 4.0, Netscape Navigator 5.0, Netscape Navigator 6.0, Netscape Navigator 6.1, Opera Software Opera 5.10, Opera Opera Software 5.12, Mozilla 0.9.2, Mozilla 0.9.3, W3C Amaya 5.1, HotJava Browser 3.0, 1X Net Browser v1.0 b62, NCSA Mosaic 3.0, Lynx 2.8.3, WebTV Viewer 2.6 Build 46, WinWAP 3.0 PRO, AtomNetPE 1.23, CELLO, ARACHNE, Pythia, Emissary 2.0, DR-Web SPYder, TradeWave winWeb, Tango, WEBVIEW, HORSE, I-View PRO, UdiWWW, SlipKnot, SPRYNET Internet Explorer, Clue Evaluation Version, IOD4, OffByOne Browser, NavROAD">
        <meta name="browser-compatible" content="Microsoft Internet Explorer 3.0, Microsoft Internet Explorer 4.0, Microsoft Internet Explorer 5.0, Microsoft Internet Explorer 5.5, Microsoft Internet Explorer 6.0, Netscape Navigator 2.0, Netscape Navigator 3.0, Netscape Navigator 4.0, Netscape Navigator 5.0, Netscape Navigator 6.0, Netscape Navigator 6.1, Opera Software Opera 5.10, Opera Opera Software 5.12, Mozilla 0.9.2, Mozilla 0.9.3, W3C Amaya 5.1, HotJava Browser 3.0, 1X Net Browser v1.0 b62, NCSA Mosaic 3.0, Lynx 2.8.3, WebTV Viewer 2.6 Build 46, WinWAP 3.0 PRO, AtomNetPE 1.23, CELLO, ARACHNE, Pythia, Emissary 2.0, DR-Web SPYder, TradeWave winWeb, Tango, WEBVIEW, HORSE, I-View PRO, UdiWWW, SlipKnot, SPRYNET Internet Explorer, Clue Evaluation Version, IOD4, OffByOne Browser, NavROAD">
        <meta name="system-tested" content="WAP, IBM PC and Compatible, Macintosh, WebTV, TEXT ONLY, SPARC, Amiga, PDA, Pocket PC">
        <meta name="system-compatible" content="WAP, IBM PC and Compatible, Macintosh, WebTV, TEXT ONLY, SPARC, Amiga, PDA, Pocket PC">
        <meta http-equiv="price" content="free">
        <meta http-equiv="how-much" content="free">
        <meta http-equiv="OS-tested" content="Windows 3.x, Windows NT, Windows 2000, Windows 9x and Me, Linux, Unix, BeOS, OS2/Warp, Inferno, PalmOS, Windows CE, Windows XP, Novell Netware, Solaris, Irix, MAC OS">
        <meta http-equiv="OS-compatible" content="Windows 3.x, Windows NT, Windows 2000, Windows 9x and Me, Linux, Unix, BeOS, OS2/Warp, Inferno, PalmOS, Windows CE, Windows XP, Novell Netware, Solaris, Irix, MAC OS">
        <meta http-equiv="browser-tested" content="Microsoft Internet Explorer 3.0, Microsoft Internet Explorer 4.0, Microsoft Internet Explorer 5.0, Microsoft Internet Explorer 5.5, Microsoft Internet Explorer 6.0, Netscape Navigator 2.0, Netscape Navigator 3.0, Netscape Navigator 4.0, Netscape Navigator 5.0, Netscape Navigator 6.0, Netscape Navigator 6.1, Opera Software Opera 5.10, Opera Opera Software 5.12, Mozilla 0.9.2, Mozilla 0.9.3, W3C Amaya 5.1, HotJava Browser 3.0, 1X Net Browser v1.0 b62, NCSA Mosaic 3.0, Lynx 2.8.3, WebTV Viewer 2.6 Build 46, WinWAP 3.0 PRO, AtomNetPE 1.23, CELLO, ARACHNE, Pythia, Emissary 2.0, DR-Web SPYder, TradeWave winWeb, Tango, WEBVIEW, HORSE, I-View PRO, UdiWWW, SlipKnot, SPRYNET Internet Explorer, Clue Evaluation Version, IOD4, OffByOne Browser, NavROAD">
        <meta http-equiv="browser-compatible" content="Microsoft Internet Explorer 3.0, Microsoft Internet Explorer 4.0, Microsoft Internet Explorer 5.0, Microsoft Internet Explorer 5.5, Microsoft Internet Explorer 6.0, Netscape Navigator 2.0, Netscape Navigator 3.0, Netscape Navigator 4.0, Netscape Navigator 5.0, Netscape Navigator 6.0, Netscape Navigator 6.1, Opera Software Opera 5.10, Opera Opera Software 5.12, Mozilla 0.9.2, Mozilla 0.9.3, W3C Amaya 5.1, HotJava Browser 3.0, 1X Net Browser v1.0 b62, NCSA Mosaic 3.0, Lynx 2.8.3, WebTV Viewer 2.6 Build 46, WinWAP 3.0 PRO, AtomNetPE 1.23, CELLO, ARACHNE, Pythia, Emissary 2.0, DR-Web SPYder, TradeWave winWeb, Tango, WEBVIEW, HORSE, I-View PRO, UdiWWW, SlipKnot, SPRYNET Internet Explorer, Clue Evaluation Version, IOD4, OffByOne Browser, NavROAD">
        <meta http-equiv="system-tested" content="WAP, IBM PC and Compatible, Macintosh, WebTV, TEXT ONLY, SPARC, Amiga, PDA, Pocket PC">
        <meta http-equiv="system-compatible" content="WAP, IBM PC and Compatible, Macintosh, WebTV, TEXT ONLY, SPARC, Amiga, PDA, Pocket PC">

-->

<?php

//Detectar javascript:

//if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == "enabled") {

//if (isset($_GET['javascript_support']) && $_GET['javascript_support'] == "enabled") {
  //echo "[EN SESSION]<br>";
//  echo "Javascript activado!!!<br>";

//if (isset($_SESSION['screen_width']) && $_SESSION['screen_width'] != "" && isset($_SESSION['screen_height']) && $_SESSION['screen_height'] != "") {
//echo $_SESSION['screen_width'] . " x " . $_SESSION['screen_height'] . "<br>";
//echo "<br>";
//}
//}

//} else {

//  echo "[EN SESSION]<br>";
  //echo "javascript desactivado :(<br>";

//}

//if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == "enabled") {
//echo "[SESSION] Javascript activado!!!<br>";
//} else {
//echo "[SESSION] javascript desactivado :(<br>";
//}

//if (isset($_GET['javascript_support']) && $_GET['javascript_support'] == "enabled") {
//echo "[GET] Javascript activado!!!<br>";
//} else {
//echo "[GET] javascript desactivado :(<br>";
//}

if (isset($javascript_detect) && $javascript_detect == "on" && !isset($_SESSION['javascript_support'])) {

if (isset($_SESSION['js_count'])) {
$_SESSION['js_count']++;
} else {
$_SESSION['js_count'] = 0;
}


if (isset($_GET['javascript_support']) && $_GET['javascript_support'] == "enabled") {

//  echo "[EN GET]<br>";

//  echo "Javascript activado!!!<br>";

//if (isset($_GET['screen_width']) && $_GET['screen_width'] != "" && isset($_GET['screen_height']) && $_GET['screen_height'] != "") {
//echo $_GET['screen_width'] . " x " . $_GET['screen_height'] . "<br>";
//echo "<br>";

if (isset($javascript_autodetect_resolution) && $javascript_autodetect_resolution == "on" && isset($_GET['screen_width']) && $_GET['screen_width'] != "") {
$_SESSION['screen_width'] = $_GET['screen_width'];
if (isset($_GET['screen_height']) && $_GET['screen_height'] != "") { $_SESSION['screen_height'] = $_GET['screen_height']; }
//echo "Resolucion width: ".$_SESSION['screen_width'];
}

$_SESSION['javascript_support'] = "enabled";

} else {

$_SESSION['js_count'] = 0;

if (isset($_SESSION['js_count']) && $_SESSION['js_count'] == 0) {

$_SESSION['js_count']++;

  echo "<script language=\"JavaScript1.2\" type=\"text/javascript\">\n";
  echo "<!--\n";

//if (isset($javascript_autodetect_resolution) && $javascript_autodetect_resolution == "on") {
//          echo "if (navigator.appVersion) {\n";
  //        echo "var screen_width = \"\" + screen.width;\n";
    //      echo "}\n";
  //        }

//echo "if (navigator.appVersion) {\n";

//echo "<a href=\"" . $this_file . urldecode($change_resolution_page) . "&table_width_var=" . $page_width_800x600 . "\" title=\"Cambiar diseño adaptandose a resoluci&oacute;n 800x600\">800x600</a> - ";


 if (SID) {

if (isset($javascript_autodetect_resolution) && $javascript_autodetect_resolution == "on") {
//'table_width_var'
//  echo "  location.href=\"".$this_file."?javascript_support=enabled&screen_width=\" + screen.width + \"&" . session_name() . "=". session_id() ."\";\n";
//  echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&screen_width=\" + screen.width + \"&table_width_var=auto&" . session_name() . "=". session_id() ."\";\n";
  echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&screen_width=\" + screen.width + \"&screen_height=\" + screen.height + \"&table_width_var=auto&" . session_name() . "=". session_id() ."\";\n";
} else {
  echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&" . session_name() . "=". session_id() ."\";\n";
  }

  } else {
if (isset($javascript_autodetect_resolution) && $javascript_autodetect_resolution == "on") {
//echo "  location.href=\"".$this_file."?javascript_support=enabled&screen_width=\" + screen.width;\n";
//echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&screen_width=\" + screen.width + \"&table_width_var=auto\";\n";
echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&screen_width=\" + screen.width + \"&screen_height=\" + screen.height + \"&table_width_var=auto\";\n";
} else {
    echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled\";\n";
    }
    }

//echo "}\n";

  echo "//-->\n";
  echo "</script>\n";

  $_SESSION['js_count']++;

}

}

}

?>

            
            <style type="text/css">

            <!--

            

            body {

            scrollbar-face-color:<?php echo $scrollbar_face_color ?>;
            scrollbar-shadow-color:<?php echo $scrollbar_shadow_color ?>;
            scrollbar-highlight-color:<?php echo $scrollbar_highlight_color ?>;
            scrollbar-3dlight-color:<?php echo $scrollbar_3dlight_color ?>;
            scrollbar-darkshadow-color:<?php echo $scrollbar_darkshadow_color ?>;
            scrollbar-track-color:<?php echo $scrollbar_track_color ?>;
            scrollbar-arrow-color:<?php echo $scrollbar_arrow_color ?>;
            
            margin-top:<?php echo $margin_top ?>;
            margin-left:<?php echo $margin_left ?>;
            margin-right:<?php echo $margin_right ?>;
            margin-bottom:<?php echo $margin_bottom ?>;

            <?php
            
            if (isset($bg_fixed) && $bg_fixed == "on" && isset($general_bg) && $general_bg{0} != "#" && $general_bg != "off") {
            
            echo "background: white url(".$general_bg.");";
            echo "background-attachment: fixed;";
            
            }
            
            ?>
            
            }
            
            <?php
            //La siguiente linea con un asterisco (*) hara que no funcione bien en el browser Clue v4.2:
            if (isset($line_height) && $line_height != "off") {
            ?>          
            * {
            line-height:<?php echo $line_height ?>;
            }
            <?php
            }
            ?>
 
            a { <?php echo $css_link ?> }
            a:link { <?php echo $css_link ?> }
            a:hover { <?php echo $css_link_hover ?> }
            a:active { <?php echo $css_link_active ?> }
            <?php
            if ($css_link_visited != "off") {
            echo "a:visited { ".$css_link_visited." }";
            }
            ?>
            
            a.menu { <?php echo $css_menu_link ?> }
            a.menu:link { <?php echo $css_menu_link ?> }
            a.menu:hover { <?php echo $css_menu_link_hover ?> }
            a.menu:active { <?php echo $css_menu_link_active ?> }
            <?php
            if ($css_menu_link_visited != "off") {
            echo "a.menu:visited { ".$css_menu_link_visited." }";
            }
            ?>

            -->

            </style>

      </head>


<?php



if (!isset($content_invert)) { $content_invert = "off"; }
if ($content_invert != "on" && $content_invert != "off") { $content_invert = "off"; }
if (!isset($bg_fixed)) { $bg_fixed = "off"; }

$general_bg = trim($general_bg);
if (!isset($general_bg) || $general_bg == "off" || $general_bg == "" || empty($general_bg)) {
      if (!isset($content_invert) || $content_invert == "off") {
      ?>
      <body text="<?php echo $general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
      <?php
      }
      if (isset($content_invert) && $content_invert == "on") {
         ?>
         <body text="<?php echo $general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;" dir="rtl"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
         <?php
         }
      } else {
             if ($general_bg{0} == "#") { 
                if (isset($content_invert) && $content_invert == "off") {
                ?>
                <body bgcolor="<?php echo $general_bg; ?>" text="<?php echo $general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                <?php
                }
                if (isset($content_invert) && $content_invert == "on") {
                ?>
                <body bgcolor="<?php echo $general_bg; ?>" text="<?php echo $general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;" dir="rtl"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                <?php
                }
                } else {
                       if (isset($content_invert) && $content_invert == "off") {
                       ?>
                       <body background="<?php echo $general_bg ?>" text="<?php echo $general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                       <?php
                       }
                       if (isset($content_invert) && $content_invert == "on") {
                       ?>
                       <body background="<?php echo $general_bg ?>" text="<?php echo $general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;" dir="rtl"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                       <?php
                       }
                       }
      }
?>

             <?php
             if (isset($errors)) {
             echo "<font color=\"#ff0000\" size=\"3\" face=\"arial\"><b>&iexcl;Han habido errores!</b></font><br>";
             echo $errors."<font color=\"#ff0000\" size=\"3\" face=\"arial\"><b>Fin de errores.</b> (almacenados en errors.log)</font><br><br>";
             $errors_fopen = fopen("errors.log", "a+");
             //$errors_represent = str_replace("<", "&lt;", $errors);
             //$errores_represent = str_replace(">", "&qt;", $errors);
             fwrite($errors_fopen,$errors);
             fclose($errors_fopen);
             }

        
             ?>

             <center>

             <table width="<?php echo $table_width; ?>" border="0" cellspacing="0" cellpadding="0" align="center" valign="middle">

<!-- Prueba resoluciones: acordarse de SID -->

<?php

if (isset($user_can_alternate_page_width) && $user_can_alternate_page_width == "on") {
echo "<tr><td>";
echo "Resoluci&oacute;n: ";

if (SID) {
if (isset($page_width_less_than_640x480)) {
if ($table_width != $page_width_less_than_640x480) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_less_than_640x480 . "&" . SID . "\" title=\"Cambiar diseño adaptandose a la resoluci&oacute;n Menor\">Menor</a> - ";
} else{
echo "<b>Menor</b> - ";
}
}

if (isset($page_width_640x480)) {
if ($table_width != $page_width_640x480) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_640x480 . "&" . SID . "\" title=\"Cambiar diseño adaptandose a resoluci&oacute;n 640x480\">640x480</a> - ";
} else {
echo "<b>640x480</b> - ";
}
}

if (isset($page_width_800x600)) {
if ($table_width != $page_width_800x600) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_800x600 . "&" . SID . "\" title=\"Cambiar diseño adaptandose a resoluci&oacute;n 800x600\">800x600</a> - ";
} else {
echo "<b>800x600</b> - ";
}
}

if (isset($page_width_1024x768)) {
if ($table_width != $page_width_1024x768) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_1024x768 . "&" . SID . "\" title=\"Cambiar diseño adaptandose a resoluci&oacute;n 1024x768\">1024x768</a> - ";
} else {
echo "<b>1024x768</b> - ";
}
}

if (isset($page_width_1280x1024)) {
if ($table_width != $page_width_1280x1024) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_1280x1024 . "&" . SID . "\" title=\"Cambiar diseño adaptandose a resoluci&oacute;n 1280x1024\">1280x1024</a> - ";
} else {
echo "<b>1280x1024</b> - ";
}
}

if (isset($page_width_more_than_1280x1024)) {
if ($table_width != $page_width_more_than_1280x1024) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_more_than_1280x1024 . "&" . SID . "\" title=\"Cambiar diseño adaptandose a la resoluci&oacute;n Mayor\">Mayor</a>";
} else {
echo "<b>Mayor</b>";
}
}

} else {
//if (isset($page_width_less_than_640x480)) { echo "<a href=\"" . urldecode($_SESSION['last_page_visited']) . "&table_width_var=" . $page_width_less_than_640x480 . "\">Menor</a> - "; }
//if (isset($page_width_640x480)) { echo "<a href=\"" . urldecode($change_resolution_page) . "&table_width_var=" . $page_width_640x480 . "\">640x480</a> - "; }
//if (isset($page_width_800x600)) { echo "<a href=\"" . urldecode($change_resolution_page) . "&table_width_var=" . $page_width_800x600 . "\">800x600</a> - "; }
//if (isset($page_width_1024x768)) { echo "<a href=\"" . urldecode($change_resolution_page) . "&table_width_var=" . $page_width_1024x768 . "\">1024x768</a> - "; }
//if (isset($page_width_1280x1024)) { echo "<a href=\"" . urldecode($change_resolution_page) . "&table_width_var=" . $page_width_1280x1024 . "\">1280x1024</a> - "; }
//if (isset($page_width_more_than_1280x1024)) { echo "<a href=\"" . urldecode($change_resolution_page) . "&table_width_var=" . $page_width_more_than_1280x1024 . "\">Mayor</a>"; }

if (isset($page_width_less_than_640x480)) {
if ($table_width != $page_width_less_than_640x480) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_less_than_640x480 . "\" title=\"Cambiar diseño adaptandose a la resoluci&oacute;n Menor\">Menor</a> - ";
} else{
echo "<b>Menor</b> - ";
}
}

if (isset($page_width_640x480)) {
if ($table_width != $page_width_640x480) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_640x480 . "\" title=\"Cambiar diseño adaptandose a resoluci&oacute;n 640x480\">640x480</a> - ";
} else {
echo "<b>640x480</b> - ";
}
}

if (isset($page_width_800x600)) {
if ($table_width != $page_width_800x600) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_800x600 . "\" title=\"Cambiar diseño adaptandose a resoluci&oacute;n 800x600\">800x600</a> - ";
} else {
echo "<b>800x600</b> - ";
}
}

if (isset($page_width_1024x768)) {
if ($table_width != $page_width_1024x768) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_1024x768 . "\" title=\"Cambiar diseño adaptandose a resoluci&oacute;n 1024x768\">1024x768</a> - ";
} else {
echo "<b>1024x768</b> - ";
}
}

if (isset($page_width_1280x1024)) {
if ($table_width != $page_width_1280x1024) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_1280x1024 . "\" title=\"Cambiar diseño adaptandose a resoluci&oacute;n 1280x1024\">1280x1024</a> - ";
} else {
echo "<b>1280x1024</b> - ";
}
}

if (isset($page_width_more_than_1280x1024)) {
if ($table_width != $page_width_more_than_1280x1024) {
echo "<a href=\"" . $this_file . $change_resolution_page . "&table_width_var=" . $page_width_more_than_1280x1024 . "\" title=\"Cambiar diseño adaptandose a la resoluci&oacute;n Mayor\">Mayor</a>";
} else {
echo "<b>Mayor</b>";
}
}

}

echo "</td></tr>";

}
?>

<!-- Fin prueba resoluciones. -->


             <tr><td align="center" valign="middle"><!-- Logotipo general: --><center><img src="<?php if (isset($logo_file) && $logo_file != "" && file_exists($logo_file)) { echo $logo_file; } else { echo "img/logo/logo.jpg"; }?>"<?php if (isset($logo_width) && $logo_width != "" && is_numeric($logo_width) && $logo_width != 0) { echo " width=\"".$logo_width."\""; } else { echo " width=\"600\""; } if (isset($logo_height) && $logo_height != "" && is_numeric($logo_height) && $logo_height != 0) { echo " height=\"".$logo_height."\""; } else { echo "height=\"1000\""; } ?> border="0" align="center" alt="<?php readfile($title_file); ?>" title="<?php readfile($title_file); ?>" hspace="0" vspace="0"></center><!-- Tabla general: --></td></tr>
             <tr><td align="center" valign="middle">


<?php
$table_bg = trim($table_bg);
if (!isset($table_bg) || $table_bg == "off" || $table_bg == "" || empty($table_bg)) {
             echo "<table width=\"".$table_width."\" border=\"".$table_border."\" cellspacing=\"".$table_cellspacing."\" cellpadding=\"".$table_cellpadding."\" bordercolordark=\"".$table_border_color_dark."\" bordercolorlight=\"".$table_border_color_light."\" bordercolor=\"".$table_border_color."\" style=\"border: ".$table_border_css."px solid ".$table_border_color."\">";
      } else {
             if ($table_bg{0} == "#") { 
             echo "<table width=\"".$table_width."\" border=\"".$table_border."\" cellspacing=\"".$table_cellspacing."\" cellpadding=\"".$table_cellpadding."\" bgcolor=\"".$table_bg."\" bordercolordark=\"".$table_border_color_dark."\" bordercolorlight=\"".$table_border_color_light."\" bordercolor=\"".$table_border_color."\" style=\"border: ".$table_border_css."px solid ".$table_border_color."\">";
                } else {
             echo "<table width=\"".$table_width."\" border=\"".$table_border."\" cellspacing=\"".$table_cellspacing."\" cellpadding=\"".$table_cellpadding."\" background=\"".$table_bg."\" bordercolordark=\"".$table_border_color_dark."\" bordercolorlight=\"".$table_border_color_light."\" bordercolor=\"".$table_border_color."\" style=\"border: ".$table_border_css."px solid ".$table_border_color."\">";
                       }
      }
?>

                    <tr>



                    <!-- Menu: -->
<?php
$menu_bg = trim($menu_bg);
if (!isset($menu_bg) || $menu_bg == "off" || $menu_bg == "" || empty($menu_bg)) {
//             echo "<td width=\"25%\" align=\"center\" valign=\"top\">";
             //echo "sadfasdfdsaf";
             echo "<td width=\"" .$td_menu_width. "\" align=\"center\" valign=\"top\">";
      } else {
             if ($menu_bg{0} == "#") { 
             echo "<td width=\"".$td_menu_width."\" align=\"center\" valign=\"top\" bgcolor=\"".$menu_bg."\">";
                } else {
             echo "<td width=\"".$td_menu_width."\" align=\"center\" valign=\"top\" background=\"".$menu_bg."\">";
                       }
      }

                         //readfile(str_replace("<br />", "<br>",$menu_file)); fclose($menu);
                         //readfile($menu_file); fclose($menu);
                         
//                         echo "<br>";



//comienza el menu de buskeda:

if (isset($menu_search_form) && $menu_search_form == "on") {


?>

<form method="get" action="products.php">
<table cellspacing="0" cellpadding="0" border="0" align="center"><tr><td>

<center>
<table cellspacing="0" cellpadding="0" border="0" align="center">
<tr><td align="center">
<?php
echo "<center>";

?>
<font color="<?php echo $font_color_little_title?>" size="<?php echo $font_size_little_title?>">
<?php

readfile($title_file);

echo "</font>";
echo "</center>";


?>
</td></tr>
</table>
</center>

<br>

</td>
</tr>


<tr><td>
<center>
<table cellspacing="0" cellpadding="2" border="0">

<tr>
<td align="center">
<input type="hidden" name="category" value="all">

<input type="text" name="search"<?php if (isset($search) && $search != "") { echo " value=\"".stripslashes(htmlspecialchars($search))."\""; } ?> size="10" title="Texto a buscar">

</td>
</tr>
<tr>
<td align="center">
<center><input type="submit" value="Buscar" title="Buscar texto"></center>

<?php
if (SID) {
?>
<input type="hidden" name="<?php echo session_name(); ?>" value="<?php echo session_id(); ?>">
<?php
}
?>
</td>
</tr>

</table>
</center>

</td></tr>
</table>

</form>


<?php
//finaliza menu de buskeda.

} else {
echo "<center>";
?>
<font color="<?php echo $font_color_little_title?>" size="<?php echo $font_size_little_title?>">
<?php
readfile($title_file);
echo "</font>";
echo "</center>";
}

echo "<br>";

                         
                         if (isset($this_file) && isset($index_file) && $this_file != $index_file) {
//                         echo "<a href=\"".$index_file."\" title=\"Inicio\" onMouseOver=\"window.status='Inicio'; return true;\">Inicio</a>";
                         if (SID) {  
                         echo "<a href=\"".$index_file."?".SID."\" title=\"Inicio\" class=\"menu\">Inicio</a>";
                         } else {
                         echo "<a href=\"".$index_file."\" title=\"Inicio\" class=\"menu\">Inicio</a>";
                         }
                         echo "<br><br><br>";
                         } elseif ($this_file == $index_file || $this_file == "index.php") {
                         echo "<b>= Inicio =</b>";
                         echo "<br><br><br>";
                         }


                         if (file_exists($menu_file)) {
                         include $menu_file;
                         }
                        
                         
//                         echo "<br><br>";

                         //Este codigo servira para crear los links en el menu y tambien para crear un menu con las subcategorias en products.htm
//Falta: calcular si el archivo no existe y crearlo.
//Nota: si la opcion esta activada, dar la posibildiad de listar todos los productos. 
//Creara enlaces a: $products_file?category=[categoria|all]


//$products_file = "products.php";

//$category_file = "category.txt";
//$category_file_open = fopen($category_file, "a+");
//fclose($category_file_open);

//$category_content = file($category_file);

if (isset($menu_view_basket) && $menu_view_basket == "on") {

if (SID) {

if (isset($basket_file)) {
echo "[ <a href=\"".$basket_file."?".SID."\" title=\"Cesta de Compra\" accesskey=\"e\" class=\"menu\">Mi c<u>e</u>sta</a> ]<br><br>";
} else {
echo "[ <a href=\"basket.php?".SID."\" title=\"Cesta de Compra\" accesskey=\"e\" class=\"menu\">Mi c<u>e</u>sta</a> ]<br><br>";
}

} else {
if (isset($basket_file)) {
echo "[ <a href=\"".$basket_file."\" title=\"Cesta de Compra\" accesskey=\"e\" class=\"menu\">Mi c<u>e</u>sta</a> ]<br><br>";
} else {
echo "[ <a href=\"basket.php\" title=\"Cesta de Compra\" accesskey=\"e\" class=\"menu\">Mi c<u>e</u>sta</a> ]<br><br>";
}
}

}


if (isset($process_page) && $process_page == "on" && isset($process_file)) {

//if ($this_file == $process_file) {
if ($this_file == $process_file && isset($_GET['process']) && $_GET['process'] == "ok") {

echo "= <b>Pedido</b> =<br><br>";

} else {

//if (!isset($contact_file) || $contact_file == "") { $contact_file == "contact.php"; }
if (SID) {
echo "<a href=\"".$process_file."?process=ok&".SID."\" title=\"Realizar Pedido\" class=\"menu\" accesskey=\"p\"><b><u>P</u>edido</b></a><br><br>";
} else {
echo "<a href=\"".$process_file."?process=ok\" title=\"Realizar Pedido\" class=\"menu\" accesskey=\"p\"><b><u>P</u>edido</b></a><br><br>";
}
}
}




//echo "<br>";

if ($menu_list_all_option == "on" && $products_file != "" && isset($products_file)) {

//echo "<a href=\"".$products_file."?category=all\" title=\"Ver Todos\" class=\"menu\" accesskey=\"v\"><u>V</u>er Todos</a><br><br>";
if (SID) {
echo "<br><a href=\"".$products_file."?category=all&".SID."\" title=\"Ver Todos\" class=\"menu\" accesskey=\"v\"><b><u>V</u>er Todos</b></a><br>";
} else {
echo "<br><a href=\"".$products_file."?category=all\" title=\"Ver Todos\" class=\"menu\" accesskey=\"v\"><b><u>V</u>er Todos</b></a><br>";
}

}

echo "<br>";

foreach($category_content as $category_real_lines) {

  //Separamos por lineas con punto y coma (;) ->
             $category_separated = explode("|", trim($category_real_lines));
 
             foreach ($category_separated as $category_lines) {
                      if ($category_lines != "") {

                      //Separamos por elementos diferenciados con dos puntos (:) ->
                      $category_separated = explode(":", trim($category_lines));
                      
                      $x = 0;
                      
                      foreach ($category_separated as $category_subcategory) {
                      
                              $category_subcategory = trim($category_subcategory);
                                      
                              if ($x == 0 && $category_subcategory != "Categoria") {

                                 //Esta es la parte que contiene la Categoria:

//                                 echo "<a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\" class=\"menu\" >".$category_subcategory."</a><br>";

//                                 if (isset($supply_category) && $category_subcategory == $supply_category) {
                                 
  //                               echo "<a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\" class=\"menu\"><b>".$category_subcategory."</b></a><br>";
                                 
    //                             } else {
      //                           echo "<a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\" class=\"menu\">".$category_subcategory."</a><br>";
        //                         }
                                         if (isset($supply_category)) { $supply_category = trim($supply_category); }
       
                                         if (isset($supply_category) && $category_subcategory == $supply_category) {
                                 
                                 if (SID) {
                                 echo "<a href=\"".$products_file."?category=".urlencode($category_subcategory)."&" . SID . "\" title=\"".$category_subcategory."\" class=\"menu\"><b>".$category_subcategory."</b></a><b>:</b><br>";
                                 echo "[ <a href=\"".$products_file."?category=".urlencode($supply_category)."&".SID."\" title=\"Ver ofertas\">Ver ofertas</a> ]<br>";
                                 }
                                 else {
                                 echo "<a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\" class=\"menu\"><b>".$category_subcategory."</b></a><b>:</b><br>";                                 
                                 echo "[ <a href=\"".$products_file."?category=".urlencode($supply_category)."\" title=\"Ver ofertas\">Ver ofertas</a> ]<br>";
                                 }
                                 
                                 } else {
                                 if (SID) {
                                 echo "<a href=\"".$products_file."?category=" . urlencode($category_subcategory) . "&" . SID . "\" title=\"".$category_subcategory."\" class=\"menu\">".$category_subcategory."</a>";
                                 if ($menu_show_subcategories == "on") {
                                 if (!isset($category_separated[1]) || trim($category_separated[1]) != "") {
                                 echo "<b>:</b>";
                                 }
                                 } 
                                 echo "<br>";
                                 } else {
                                 echo "<a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\" class=\"menu\">".$category_subcategory."</a>";
                                 if ($menu_show_subcategories == "on") {
                                 if (!isset($category_separated[1]) || trim($category_separated[1]) != "") {
                                 echo "<b>:</b>";
                                 }
                                 } 
                                 echo "<br>";
                                 }
                                 }



                                 }
                              if ($x == 1 && $category_subcategory != "Subcategoria1, Subcategoria2, Subcategoria3, etc") {
                                 //Esta es la parte que contiene la Subcategoria:
                                 //Util en products.php para que se ordenen los productos por subcategorias.
                      
                                 //Separamos por elementos diferenciados por coma (,) ->
                                 $subcategory_separated = explode(",", trim($category_subcategory));
                                 
                                 foreach ($subcategory_separated as $subcategory_real) {

                                         $subcategory_real = trim($subcategory_real);

                                         if (isset($supply_category)) { $supply_category = trim($supply_category); }
                                         
                                         if ($menu_show_subcategories == "on") {
                                         
                                         if (trim($category_separated[0]) != trim($supply_category) && trim($subcategory_real) != "") {
                                         if (SID) {
                                         echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."&subcategory=".urlencode($subcategory_real)."&".SID."\" title=\"".$subcategory_real." (".$category_separated[0].")\" class=\"menu\">".$subcategory_real."</a><br>";
                                         } else {
                                         echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."&subcategory=".urlencode($subcategory_real)."\" title=\"".$subcategory_real." (".$category_separated[0].")\" class=\"menu\">".$subcategory_real."</a><br>";                                        
                                         }
                                         }
                                         
                                         }
                                         
                                 }
                                 
                                 echo "<br>";
                                 
                                 }
                             
                              $x++;
                            
                              }
                              
                       }     
                      }

//                              if ($product_ref && $product_img_path && $product_name && $product_category && $product_subcategory && $product_price && $product_description ) {
}

if (isset($contact_email) && $contact_email != "off" && isset($contact_file)) {

if ($this_file == $contact_file) {

if (isset($contact_page) && $contact_page == "on") {
echo "= <b>Contacto</b> =<br><br>";
}

} else {

if (isset($contact_page) && $contact_page == "on") {

//if (!isset($contact_file) || $contact_file == "") { $contact_file == "contact.php"; }
if (SID) {
echo "<br><a href=\"".$contact_file."?".SID."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><b><u>C</u>ontacto</b></a><br><br>";
} else {
echo "<br><a href=\"".$contact_file."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><b><u>C</u>ontacto</b></a><br><br>";
}

} else {
echo "<br><a href=\"mailto:".$contact_email."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><b><u>C</u>ontacto</b></a><br><br>";
}
}
}


//echo "<br>";

                                      ?></td>
                    <!-- Cuerpo: -->

<?php
$body_bg = trim($body_bg);
if (!isset($body_bg) || $body_bg == "off" || $body_bg == "" || empty($body_bg)) {
             echo "<td width=\"".$td_body_width."\" align=\"center\" valign=\"top\">";
      } else {
             if ($body_bg{0} == "#") { 
             echo "<td width=\"".$td_body_width."\" align=\"center\" valign=\"top\" bgcolor=\"$body_bg\">";
                } else {
             echo "<td width=\"".$td_body_width."\" align=\"center\" valign=\"top\" background=\"$body_bg\">";
                       }
      }
                         //readfile(str_replace("<br />", "<br>",$body_file)); fclose($body);
                         //readfile($body_file); fclose($body);
                         ?>
                         <table width="<?php echo $td_body_width - $table_margin; ?>" border="0" align="center" valign="top" cellspacing="<?php echo $table_cellspacing; ?>" cellpadding="<?php echo $table_cellpadding; ?>">
                         <tr><td align="left" width="<?php echo $td_body_width - $table_margin; ?>">
                         <?php
//                         include $body_file;
                         ?>
                         </td></tr>
                         </table>
                         <?php
                         ?></td>
                    </tr>
             </table>             


</td></tr></table>

 </center>

      </body>

</html>
