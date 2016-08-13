<?php

//if (!session_is_registered('basket')) {
session_name('basket');
session_start('basket');
//session_start();
//}
//session_name('pepe');
//session_start('pepe');
//session_register('basket_ref');
//$_SESSION['basket_ref'];


if (file_exists("config.txt")) { include "config.txt"; }
//else { require $index_file; }


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

if (isset($products_file) && $products_file != "") {
$this_file = $products_file;
} else {
$this_file = "products.php";
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




$_SESSION['last_page_visited'] = $this_file;

$change_resolution_page = "?change_resolution=ok";

$last_page_visited_vars = $_GET;
//$last_page_visited_vars = $HTTP_GET_VARS;

$last_page_visited_vars_x = 0;

if (isset($last_page_visited_vars) && $last_page_visited_vars != "") {

foreach ($last_page_visited_vars as $last_page_visited_vars_separated => $last_page_visited_vars_separated_result) {


//echo "\"".trim(urlencode($last_page_visited_vars_separated))."\"";

//if (trim(urlencode($last_page_visited_vars_separated)) != "change_resolution" && trim(urlencode($last_page_visited_vars_separated)) != "table_width_var" && trim(urlencode($last_page_visited_vars_separated)) != session_name()) {
if (trim(urlencode($last_page_visited_vars_separated)) != "change_resolution" && trim(urlencode($last_page_visited_vars_separated)) != "table_width_var" && trim(urlencode($last_page_visited_vars_separated)) != session_name() && trim(urlencode($last_page_visited_vars_separated)) != "act" && trim(urlencode($last_page_visited_vars_separated)) != "ref" && trim(urlencode($last_page_visited_vars_separated)) != "quantity") {
//echo "\"".trim(urlencode($last_page_visited_vars_separated))."\"";
$change_resolution_page .= "&" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));

if ($last_page_visited_vars_x == 0) {
//if (trim(urlencode($last_page_visited_vars_separated)) != "change_resolution" && trim(urlencode($last_page_visited_vars_separated)) != "table_width_var" && trim(urlencode($last_page_visited_vars_separated)) != session_name()) {
$_SESSION['last_page_visited'] .= "?" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));

//$change_resolution_page = "?" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));

//echo $last_page_visited_vars_x[0];
} else {
$_SESSION['last_page_visited'] .= "&" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));

//$change_resolution_page = "&" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));

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


//echo $_SESSION['last_page_visited'];



if (!isset($products_file) || $products_file == "") { $products_file = $this_file; }

//if (isset($search)) { $search = urlencode($search); }

if (isset($category) && $category == "") { $category = "all"; }

if (isset($category) && $category != "" && $category != "all" && isset($subcategory) && $subcategory == "") { unset($subcategory); }

if (isset($category)) { $category = urldecode($category); }

if (isset($search) && !isset($category)) { $category = "all"; }

//if (isset($search)) { $search = urldecode($search); }

//PRUEBITA
$category_empty = 1;

if (isset($supply_category)) { $supply_category = trim($supply_category); }

//Comprobar la existencia de las variables en config.txt:
if (!isset($background) && !isset($bgcolor)) { $bgcolor = "#aaaadd"; $background = "off"; } 
if (!isset($font_color)) { $font_color = "#333333"; }
if (!isset($font_color_title)) { $font_color_title = "#aa0000"; }
if (!isset($font_size)) { $font_size = "4"; }
if (!isset($font_size_title)) { $font_color = "2"; }

$category_content = file($category_file);

$items_content = file($items_file);


//Conversor de monedas:
if (file_exists($money_file)) {
include $money_file;
}

if (isset($product_money) && $product_money != "EUR" && $product_money != "USD") { $product_money = "EUR"; }


if (isset($money_eur_symbol) && file_exists($money_eur_symbol)) {
   if (isset($money_img_width) && isset($money_img_height)) {
      if (is_numeric($money_img_width) && is_numeric($money_img_height)) {
      $money_eur_symbol = "<img src=\"".$money_eur_symbol."\" width=\"".$money_img_width."\" height=\"".$money_img_height."\" alt=\"EUR\" title=\"EUR\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";
      }
      elseif (is_numeric($money_img_width) && !is_numeric($money_img_height)) {
      $money_eur_symbol = "<img src=\"".$money_eur_symbol."\" width=\"".$money_img_width."\" alt=\"EUR\" title=\"EUR\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";      
      }
      elseif (!is_numeric($money_img_width) && is_numeric($money_img_height)) {
      $money_eur_symbol = "<img src=\"".$money_eur_symbol."\" height=\"".$money_img_height."\" alt=\"EUR\" title=\"EUR\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";
      }
      elseif (!is_numeric($money_img_width) && !is_numeric($money_img_height)) {
      $money_eur_symbol = "<img src=\"".$money_eur_symbol."\" alt=\"EUR\" title=\"EUR\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";
      }
   } else {
           $money_eur_symbol = "<img src=\"".$money_eur_symbol."\" alt=\"EUR\" title=\"EUR\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";
          }
}

if (isset($money_usd_symbol) && file_exists($money_usd_symbol)) {
//   $money_usd_symbol = "<img src=\"".$money_usd_symbol."\" alt=\"USD\" title=\"USD\">";
   if (isset($money_img_width) && isset($money_img_height)) {
      if (is_numeric($money_img_width) && is_numeric($money_img_height)) {
      $money_usd_symbol = "<img src=\"".$money_usd_symbol."\" width=\"".$money_img_width."\" height=\"".$money_img_height."\" alt=\"USD\" title=\"USD\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";
      }
      elseif (is_numeric($money_img_width) && !is_numeric($money_img_height)) {
      $money_usd_symbol = "<img src=\"".$money_usd_symbol."\" width=\"".$money_img_width."\" alt=\"USD\" title=\"USD\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";
      }
      elseif (!is_numeric($money_img_width) && is_numeric($money_img_height)) {
      $money_usd_symbol = "<img src=\"".$money_usd_symbol."\" height=\"".$money_img_height."\" alt=\"USD\" title=\"USD\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";
      }
      elseif (!is_numeric($money_img_width) && !is_numeric($money_img_height)) {
      $money_usd_symbol = "<img src=\"".$money_usd_symbol."\" alt=\"USD\" title=\"USD\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";
      }
   } else {
           $money_usd_symbol = "<img src=\"".$money_usd_symbol."\" alt=\"USD\" title=\"USD\" align=\"center\" valign=\"middle\" hspace=\"0\" vspace=\"0\">";
          }
} 
//Fin de conversor de monedas.


//<a href="option1.htm" alt="option.htm" title="option.htm">Option 1</a>




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

$logo_width = $table_width_var;
$table_width = $logo_width;

//if (isset($page_width_less_than_640x480) && $_GET['table_width_var'] == $page_width_less_than_640x480) { $product_table_width = $product_table_width_less_than_640x480; $_SESSION['changed_resolution_product'] = $product_table_width_less_than_640x480; $_SESSION['changed_resolution'] = $page_width_less_than_640x480; }
//if (isset($page_width_640x480) && $_GET['table_width_var'] == $page_width_640x480) { $product_table_width = $product_table_width_640x480; $_SESSION['changed_resolution_product'] = $product_table_width_640x480; $_SESSION['changed_resolution'] = $page_width_640x480; }
//if (isset($page_width_800x600) && $_GET['table_width_var'] == $page_width_800x600) { $product_table_width = $product_table_width_800x600; $_SESSION['changed_resolution_product'] = $product_table_width_800x600; $_SESSION['changed_resolution'] = $page_width_800x600; }
//if (isset($page_width_1024x768) && $_GET['table_width_var'] == $page_width_1024x768) { $product_table_width = $product_table_width_1024x768; $_SESSION['changed_resolution_product'] = $product_table_width_1024x768; $_SESSION['changed_resolution'] = $page_width_1024x768; }
//if (isset($page_width_1280x1024) && $_GET['table_width_var'] == $page_width_1280x1024) { $product_table_width = $product_table_width_1280x1024; $_SESSION['changed_resolution_product'] = $product_table_width_1280x1024; $_SESSION['changed_resolution'] = $page_width_1280x1024; }
//if (isset($page_width_more_than_1280x1024) && $_GET['table_width_var'] == $page_width_more_than_1280x1024) { $product_table_width = $product_table_width_more_than_1280x1024; $_SESSION['changed_resolution_product'] = $product_table_width_more_than_1280x1024; $_SESSION['changed_resolution'] = $page_width_more_than_1280x1024; }

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
            $errors .= "(<font color=\"#ff0000\">ERROR</font>)<font color=\"#aa0000\"> ". date("d/m/Y [H:i:s]") ." </font><b>LA VARIABLE</b><tt> \$table_width o la variable \$logo_width </tt><b><u>NO SON NUMEROS ENTEROS</u> O CONTIENEN ALGUN ERROR.</b><tt>(\$table_width = <i> ".$table_width." </i>y \$logo_width = <i>".$logo_width."</i>)</tt><br>";
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


            <title><?php readfile($title_file);

if ($product_title == "on") {

//if (isset($category)) {
echo " - ";
            
                      $category_end = 0;

foreach($category_content as $category_real_lines) {

                      $category_end++;
                      
  //Separamos por lineas con punto y coma (;) ->
             $category_separated = explode("|", trim($category_real_lines));
 
             foreach ($category_separated as $category_lines) {
                      if ($category_lines != "") {

                      //Separamos por elementos diferenciados con dos puntos (:) ->
                      $category_separated = explode(":", trim($category_lines));

                      $x = 0;
                      $contador = 0;

                      if (trim($category_content[0]) == "Categoria: Subcategoria1, Subcategoria2, Subcategoria3, etc|") {
                         $category_end == $category_end + 1;
                              
                      }
                                                       
                      $category_separated_plain_title = implode($category_separated);

                      foreach ($category_separated as $category_subcategory) {
                      
                              $category_subcategory = trim($category_subcategory);
                              $supply_category = trim($supply_category);

                              if ($x == 0 && $category_subcategory != "Categoria") {
                                 //Esta es la parte que contiene la Categoria:
                                 
                                 if (!isset($category) || $category == "all") {
                                 if (!isset($supply_category) || $supply_category == "off" || $category_subcategory != $supply_category) {
                                 
                                 echo $category_subcategory;
                                 if ($category_separated[1] != "") { echo ": "; }
                                 
                                 }
                                 }
                                 
                                 elseif ($category_subcategory == $category) {
                                 if (!isset($supply_category) || $supply_category == "off" || $category_subcategory != $supply_category) {
                                 //if (sizeof($category_separated) != 0) {
                                 echo $category_subcategory;
                                 if ($category_separated[1] != "") { echo ": "; }
                                 //}               
                                 }
                                 elseif (isset($supply_category) && $supply_category == $category_subcategory) {
                                 //echo "[ ".$category_subcategory." ]";
                                 echo $category_subcategory;
                                 }
                                 }
                                 
                                 }

                              if ($x == 1 && $category_subcategory != "Subcategoria1, Subcategoria2, Subcategoria3, etc") {
                                 //Esta es la parte que contiene la Subcategoria:
                                 //Util en products.php para que se ordenen los productos por subcategorias.
                      
                                 //Separamos por elementos diferenciados por coma (,) ->
                                 $subcategory_separated = explode(",", trim($category_subcategory));
                                 
                                 foreach ($subcategory_separated as $subcategory_real) {

                                 $contador++;                                 

//                                 echo sizeof($subcategory_separated)."@".$contador;
                                 
                                         if (!isset($category) || $category == "all") {
                                 if (!isset($supply_category) || $supply_category == "off" || trim($category_separated[0]) != $supply_category) {
                                         echo trim($subcategory_real);
                                         }
                                         }
                                        elseif ($category == $category_separated[0]) {
                                 if (!isset($supply_category) || $supply_category == "off" || trim($category_separated[0]) != $supply_category) {

                                                                         
                                        if (isset($subcategory) && trim($subcategory) == trim($subcategory_real) ) {
                                        echo "[".trim($subcategory_real)."]";       
                                        } else {
                                        echo trim($subcategory_real); 
                                        }
                                        
                                        
                                        //Vigilar:
                                        $subcategories[$subcategory_real] = trim($subcategory_real);
                                        //Fin vigilar.          
                                        
                                        }           
                                        //echo $category_separated[1];
                                         }

//                                 if (isset($category)) {
                                 if (!isset($category) || $category == "all" || $category == trim($category_separated[0])) {

                                 if ($contador < sizeof($subcategory_separated)) {

                                 if (!isset($supply_category) || $supply_category == "off" || trim($category_separated[0]) != $supply_category) {
                                 echo ", ";
                                 
                                 }
                                 
                                 } else {
                                 
                                 if (!isset($supply_category) || $supply_category == "off" || trim($category_separated[0]) != $supply_category) {
                                 
//                                 if (trim($category_separated[0]) != $supply_category) {

                                 if ($category_separated[1] != "") {
                                 echo ".";
                                 }
  //                               }
                                 
                                 }
                                 
                                 }

//                                 }
}

                                                                         
                                         }
                                
                                 if(isset($category_empty) && $category_empty == 1) {
                                 if (!isset($category) || $category == "all") {
                                 
                                                                 
//                                 echo $category_content[0];
                                 
//                                 echo sizeof($subcategory_separated)."@".$contador;
                                                                  
                                 if ($category_end == sizeof($category_content)) {
                                 echo " #";
                                 }
                                 else {
                                 
                                 if (!isset($supply_category) || $supply_category == "off" || trim($category_separated[0]) != $supply_category) {

                                 if (trim($category_separated[0]) != $supply_category) {
                                 echo " | ";
                                 }
                                 
                                 }
                                 
                                 }

                                 }
                                 }

                                 }

                              $x++;
                            
                              }


                              
                       }     


                      }

//                              if ($product_ref && $product_img_path && $product_name && $product_category && $product_subcategory && $product_price && $product_description ) {

}
//}            
            
}            
            
            ?></title>



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
echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&screen_width=\" + screen.width + \"&screen_height=\" + screen.height + \"&table_width_var=auto\";\n";
//echo "  location.href=\"".$this_file . $_SESSION['change_resolution_page_session'] ."&javascript_support=enabled&screen_width=\" + screen.width + \"&table_width_var=auto\";\n";
} else {
    echo "  location.href=\"".$this_file . $_SESSION['change_resolution_page_session'] ."&javascript_support=enabled\";\n";
    }
    }

//echo "}\n";

  echo "//-->\n";
  echo "</script>\n";

  $_SESSION['js_count']++;

}

}

}




if (isset($javascript_detect) && $javascript_detect == "on" && isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == "enabled") {

if (!isset($product_and_basket_popup_zoom_window_width) || $product_and_basket_popup_zoom_window_width <= 0 || $product_and_basket_popup_zoom_window_width == "") {
$product_and_basket_popup_zoom_window_width = 610;
}

if (!isset($product_and_basket_popup_zoom_window_height) || $product_and_basket_popup_zoom_window_height <= 0 || $product_and_basket_popup_zoom_window_height == "") {
$product_and_basket_popup_zoom_window_height = 450;
}

?>
<script language="JavaScript1.2" type="text/javascript">
<!--

var basket_popup_success = "off";

function zoom_img(image_zoom) {

//img_zoom_target = image_zoom;

<?php
if (SID) {
?>
var load_zoom_window = window.open(image_zoom + '?<?php echo SID; ?>','_blank','scrollbars=yes,menubar=no,height=<?php echo $product_and_basket_popup_zoom_window_height; ?>,width=<?php echo $product_and_basket_popup_zoom_window_width; ?>,resizable=yes,toolbar=no,location=no,status=no');
//var load_zoom_window = window.open(escape(imagen_zoom),'_blank','scrollbars=yes,menubar=no,height=<?php echo $product_and_basket_popup_zoom_window_height; ?>,width=<?php echo $product_and_basket_popup_zoom_window_width; ?>,resizable=yes,toolbar=no,location=no,status=no');
<?php
} else {
?>
var load_zoom_window = window.open(image_zoom,'_blank','scrollbars=yes,menubar=no,height=<?php echo $product_and_basket_popup_zoom_window_height; ?>,width=<?php echo $product_and_basket_popup_zoom_window_width; ?>,resizable=yes,toolbar=no,location=no,status=no');
<?php
}
?>
load_zoom_window.focus();

//return false;

}


function basket_popup(basket_popup_url) {

<?php
if (SID) {
?>
var load_zoom_window = window.open(basket_popup_url + '?<?php echo SID; ?>','basket_popup','<?php if ($basket_javascript_popup_fit_to_screen == "on") { echo "width=' + screen.width + ',height=' + screen.height + ',"; } ?>scrollbars=yes,menubar=yes,resizable=yes,toolbar=yes,location=yes,status=yes<?php if ($basket_javascript_popup_fullscreen == "on") { echo ",fullscreen=1"; } ?>');
<?php
} else {
?>
var load_zoom_window = window.open(basket_popup_url,'basket_popup','<?php if ($basket_javascript_popup_fit_to_screen == "on") { echo "width=' + screen.width + ',height=' + screen.height + ',"; } ?>scrollbars=yes,menubar=yes,resizable=yes,toolbar=yes,location=yes,status=yes<?php if ($basket_javascript_popup_fullscreen == "on") { echo ",fullscreen=1"; } ?>');
<?php
}
?>

//load_zoom_window.focus();

//Cuidadito:
window.focus();

alert("Producto sumado a la cesta");

//basket_popup_success = "on";

//return false;

}

<?php

if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == "enabled" && isset($basket_javascript_popup) && $basket_javascript_popup == "on" && !SID) {
?>

function notify_add_item() {
if(basket_popup_success == "on") {
//alert("Producto sumado a la cesta");
}

//return false;

}

<?php
}

?>


// -->
</script>




<?php
}

?>





            
            <style type="text/css">

            <!--

            

            body {

            <?php //Falta ponerlo todo en echo's, y comprobar si las variables existen y no estan en off: ?>

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
                <body bgcolor="<?php echo $general_bg; ?>" text="<?php echo $products_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                <?php
                }
                if (isset($content_invert) && $content_invert == "on") {
                ?>
                <body bgcolor="<?php echo $general_bg; ?>" text="<?php echo $products_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;" dir="rtl"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                <?php
                }
                } else {
                       if (isset($content_invert) && $content_invert == "off") {
                       ?>
                       <body background="<?php echo $general_bg ?>" text="<?php echo $products_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                       <?php
                       }
                       if (isset($content_invert) && $content_invert == "on") {
                       ?>
                       <body background="<?php echo $general_bg ?>" text="<?php echo $products_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;" dir="rtl"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                       <?php
                       }
                       }
      }
?>

             <?php
             if (isset($errors)) {
             echo "<font color=\"#ff0000\"><b>&iexcl;Han habido errores!</b></font><br>";
             echo $errors."<font color=\"#ff0000\"><b>Fin de errores.</b> (almacenados en errors.log)</font><br><br>";
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

//echo "SI SID";

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

//echo "NO SID";

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
             echo "<td width=\"".$td_menu_width."\" align=\"center\" valign=\"top\" bgcolor=\"$menu_bg\">";
                } else {
             echo "<td width=\"".$td_menu_width."\" align=\"center\" valign=\"top\" background=\"$menu_bg\">";
                       }
      }

                         //readfile(str_replace("<br />", "<br>",$menu_file)); fclose($menu);
                         //readfile($menu_file); fclose($menu);
                         
//                         echo "<br>";


//comienza el menu de buskeda:

if (isset($menu_search_form) && $menu_search_form == "on") {
//echo "<br>";

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

<input type="text" name="search"<?php if (isset($search) && $search != "") { echo " value=\"". stripslashes(htmlspecialchars($search)) . "\""; } ?> size="10" title="Texto a buscar">

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
                         }


                         if (file_exists($menu_file)) {
                         include $menu_file;
                         }

                         
//                         echo "<br><br>";

                         //Este codigo servira para crear los links en el menu y tambien para crear un menu con las subcategorias en products.htm
//Falta: calcular si el archivo no existe y crearlo.
//Nota: si la opcion esta activada, dar la posibildiad de listar todos los productos. 
//Creara enlaces a: $products_file?category=[categoria|all]


//$category_file_open = fopen($category_file, "a+");
//fclose($category_file_open);

$category_content = file($category_file);

if (isset($menu_view_basket) && $menu_view_basket == "on") {

if (SID) {

if (isset($basket_file)) {
//if (isset($basket_file) && isset($_GET['process']) && $_GET['process'] != "ok" || isset($basket_file) && !isset($_GET['process'])) {
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
//if (!isset($contact_file) || $contact_file == "") { $contact_file == "contact.php"; }

//if ($this_file == $process_file) {
if ($this_file == $process_file && isset($_GET['process']) && $_GET['process'] == "ok") {

echo "= <b>Pedido</b> =<br><br>";

} else {

//if (SID) {
//echo "<a href=\"".$process_file."?".SID."\" title=\"Realizar Pedido\" class=\"menu\" accesskey=\"p\"><b><u>P</u>edido</b></a><br><br>";
//} else {
//echo "<a href=\"".$process_file."\" title=\"Realizar Pedido\" class=\"menu\" accesskey=\"p\"><b><u>P</u>edido</b></a><br><br>";
//}
//}
//}

if (SID) {
echo "<a href=\"".$process_file."?process=ok&".SID."\" title=\"Realizar Pedido\" class=\"menu\" accesskey=\"p\"><b><u>P</u>edido</b></a><br><br>";
} else {
echo "<a href=\"".$process_file."?process=ok\" title=\"Realizar Pedido\" class=\"menu\" accesskey=\"p\"><b><u>P</u>edido</b></a><br><br>";
}
}
}




if ($menu_list_all_option == "on" && $products_file != "" && isset($products_file)) {
//echo "<a href=\"".$products_file."?category=all\"> Ver Todos</a><br><br>";
//echo "<a href=\"".$products_file."?category=all\" title=\"Ver Todos\" class=\"menu\">Ver Todos</a><br><br>";

if ($this_file != $products_file || $this_file == $products_file && isset($category) && $category != "all" || $this_file == $products_file && !isset($category) || $this_file == $products_file && isset($category) && isset($search)) {

if (SID) {
echo "<br><a href=\"".$products_file."?category=all&".SID."\" title=\"Ver Todos\" class=\"menu\" accesskey=\"v\"><b><u>V</u>er Todos</b></a><br>";
} else {
echo "<br><a href=\"".$products_file."?category=all\" title=\"Ver Todos\" class=\"menu\" accesskey=\"v\"><b><u>V</u>er Todos</b></a><br>";
}

} else {
echo "<br>= <b>Ver Todos</b> =<br>";
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
//                                 echo "<a href=\"".$products_file."?category=".urlencode($category_subcategory)."\">".$category_subcategory."</a><br>";

                                 if (isset($supply_category)) { $supply_category = trim($supply_category); }



                                 if (isset($supply_category) && $category_subcategory == $supply_category) {
                                 
                                 if (isset($category) && isset($supply_category) && $category == $supply_category) {
                                 echo "<b>".$category_subcategory."</b><b>:</b><br>";
                                 echo "= [ Ver ofertas ] =<br>";

                                 } else {

                                 if (SID) {
                                 echo "<a href=\"".$products_file."?category=".urlencode($category_subcategory)."&" . SID . "\" title=\"".$category_subcategory."\" class=\"menu\"><b>".$category_subcategory."</b></a><b>:</b><br>";
                                 echo "[ <a href=\"".$products_file."?category=".urlencode($supply_category)."&".SID."\" title=\"Ver ofertas\">Ver ofertas</a> ]<br>";
                                 }

                                 else {
                                 echo "<a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\" class=\"menu\"><b>".$category_subcategory."</b></a><b>:</b><br>";                                 
                                 echo "[ <a href=\"".$products_file."?category=".urlencode($supply_category)."\" title=\"Ver ofertas\">Ver ofertas</a> ]<br>";
                                 }

                                 }


                                 
                                 } else {


                                 if (isset($category) && $category == urldecode($category_subcategory) && !isset($subcategory)) {
                                 echo "= <b>".$category_subcategory." </b>=";
//                                 if ($menu_show_subcategories == "on") { echo "<b>:</b>"; } 
                                 echo "<br>";
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
//                                         echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."\">".$subcategory_real."</a><br>";
                                         //echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."\" title=\"".$subcategory_real." (".$category_separated[0].")\" class=\"menu\">".$subcategory_real."</a><br>";
//                                         if (SID) {
  //                                       echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."&".SID."\" title=\"".$subcategory_real." (".$category_separated[0].")\" class=\"menu\">".$subcategory_real."</a><br>";
    //                                     } else {
      //                                   echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."\" title=\"".$subcategory_real." (".$category_separated[0].")\" class=\"menu\">".$subcategory_real."</a><br>";                                        
        //                                 }
        
                                         
//                                         $category_separated[0] = trim($category_separated[0]);
                                         
                                         if (isset($supply_category) && trim($category_separated[0]) != trim($supply_category) && trim($subcategory_real) != "") {

                                         if (isset($category) && $category == $category_separated[0] && isset($subcategory)&& $subcategory == $subcategory_real) {
                                         echo "* <b>".$subcategory_real."</b><br>";
                                         } else {
                                         
                                         if (SID) {
                                         echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."&subcategory=".urlencode($subcategory_real)."&".SID."\" title=\"".$subcategory_real." (".$category_separated[0].")\" class=\"menu\">".$subcategory_real."</a><br>";
                                         } else {
                                         echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."&subcategory=".urlencode($subcategory_real)."\" title=\"".$subcategory_real." (".$category_separated[0].")\" class=\"menu\">".$subcategory_real."</a><br>";                                        
                                         }
                                         
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

//if (isset($contact_email) && $contact_email != "off") { echo "<br><a href=\"mailto:".$contact_email."\" title=\"".$contact_email."\" class=\"menu\">Contacto</a><br><br>"; }
//if (isset($contact_email) && $contact_email != "off") { echo "<br><a href=\"mailto:".$contact_email."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><u>C</u>ontacto</a><br><br>"; }

//if (isset($contact_email) && $contact_email != "off") {
if (isset($contact_email) && $contact_email != "off" && isset($contact_file)) {
if ($contact_page == "on") {
//if (!isset($contact_file) || $contact_file == "") { $contact_file == "contact.php"; }
//echo "<br><a href=\"".$contact_file."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><u>C</u>ontacto</a><br><br>";
if (SID) {
echo "<br><a href=\"".$contact_file."?".SID."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><b><u>C</u>ontacto</b></a><br><br>";
} else {
echo "<br><a href=\"".$contact_file."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><b><u>C</u>ontacto</b></a><br><br>";
}
} else {
echo "<br><a href=\"mailto:".$contact_email."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><b><u>C</u>ontacto</b></a><br><br>";
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


//Fin del menu.


if (isset($category)) { $category == urldecode($category); }








if (isset($category) && $category == "all" || !isset($category)) {
?>

<br>

<form method="get" action="products.php">
<table cellspacing="0" cellpadding="2" border="0">

<tr>
<td>
<input type="hidden" name="category" value="all">

<label for="search" accesskey="u">
<b>B<u>u</u>scar</b>:<br>
<input type="text" name="search"<?php if (isset($search) && $search != "") { echo " value=\"".stripslashes(htmlspecialchars($search))."\""; } ?> size="20" title="Texto a buscar" id="search" accesskey="u">
</label>

</td>
<td valign="bottom">

<br>
<input type="submit" value="Buscar" title="Buscar texto">
</td>
</tr>
<tr>
<td>

<label for="allwords" accesskey="d">
<input type="checkbox" name="allwords"<?php if (isset($allwords) && $allwords == "on") { echo " CHECKED"; } ?> title="Productos que contengan todas las palabras" id="allwords" accesskey="d"> To<u>d</u>as las palabras
</label>

<?php
if (SID) {
?>
<input type="hidden" name="<?php echo session_name(); ?>" value="<?php echo session_id(); ?>">
<?php
}
?>
</td></tr>

</table>
</form>
      
<?php

}



if (isset($allwords) && $allwords == "on" && $search == "") { $allwords = "off"; }

//Condicionar el valor de \$category:

if (isset($category)) {
//echo "Listar todos o solo una categoria<br><br>";

?>
             <table width="<?php echo $td_body_width - $table_margin; ?>" border="0" cellspacing="0" cellpadding="0" align="center" valign="middle">

<?php             
echo "<tr><td>";

if ($category != "all") {

if (isset($supply_category) && $category == $supply_category ) {
echo "<br>* <b>".$category."</b>:<br>";
} else {
echo "<br>* Categoria: <b>".$category."</b><br>";
}

}

















if ($category == "all") {

if (SID) {
echo "<br><a href=\"".$products_file."?".SID."\" title=\"Ver Listado de categorias y subcategorias\">Ver Listado de categorias y subcategorias</a><br><br>";

//if (isset($search)) { echo "<br>"; echo "Busqueda: ".urldecode($search); }
if (isset($search)) {
if ($search == "") {
echo "<br>"; echo "B&uacute;squeda de: <b>(sin especificar)</b>";
if (isset($allwords) && $allwords == "on") { echo " [todas las palabras]"; }
echo "<br><br>";
}
else {
echo "<br>"; echo "B&uacute;squeda de: <b>".nl2br(wordwrap(stripslashes(htmlspecialchars($search)), 35, "<br>", 1))."</b>";
if (isset($allwords) && $allwords == "on") { echo " [todas las palabras]"; }
echo "<br><br>";
}
}

} else {
echo "<br><a href=\"".$products_file."\" title=\"Ver Listado de categorias y subcategorias\">Ver Listado de categorias y subcategorias</a><br><br>";
if (isset($search)) {
if ($search == "") {
echo "<br>"; echo "B&uacute;squeda de: <b>(sin especificar)</b>";
if (isset($allwords) && $allwords == "on") { echo " [todas las palabras]"; }
echo "<br><br>";
}
else {
//$search = "aaaaaaaaaaaaaaaaaabaaaaaaaaaaaaababaabaaaaaaaaaaaaaaaaaaaabaaaaaaaaaaaabaaaaaaaaaaaaaaaaabaaaaaaaaaaaaaaaaa";
//$search_wrap = wordwrap($search, 20, 10);
//$search_wrap = nl2br(wordwrap($search, 38, "<br>", 1));
//echo "<br>"; echo "B&uacute;squeda de: <b>".nl2br(strip_tags(wordwrap($search, 35, "<br>", 1)))."</b>";
echo "<br>"; echo "B&uacute;squeda de: <b>".nl2br(wordwrap(stripslashes(htmlspecialchars($search)), 35, "<br>", 1))."</b>";
if (isset($allwords) && $allwords == "on") { echo " [todas las palabras]"; }
echo "<br><br>";

}
}
}

echo "</td></tr>";

}

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
                                 //Esta es la parte que contiene la Categoria (y se crea un ancla):
                                 if ($category == "all" && !isset($search)) {
//                                 echo "<a name=\"".urlencode($category_subcategory)."\"></a>";
                                 
                                 if (SID) {
                                 
                                 if (isset($supply_category) && $category_subcategory == $supply_category) {
                                 echo "<tr><td><br>* <a href=\"".$products_file."?category=".urlencode($category_subcategory)."&".SID."\" title=\"".$category_subcategory."\"><b>".$category_subcategory."</b></a><br></td></tr>";
                                 } else {
                                 echo "<tr><td><br>* <a href=\"".$products_file."?category=".urlencode($category_subcategory)."&".SID."\" title=\"".$category_subcategory."\">".$category_subcategory."</a><br></td></tr>";
                                 }
                                 
                                 } else {
                                 if (isset($supply_category) && $category_subcategory == $supply_category) {
                                 echo "<tr><td><br>* <a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\"><b>".$category_subcategory."</b></a><b>:</b><br></td></tr>";
                                 } else {
                                 echo "<tr><td><br>* <a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\">".$category_subcategory."</a><b>:</b><br></td></tr>";
                                 }
                                 }
                                 
                                 $category_empty_all = "empty";
//                                 $category_empty_all = 0;

                                 }
                                 }

//                                 $category_empty_all = 0;
                                 
                              if ($x == 1 && $category_subcategory != "Subcategoria1, Subcategoria2, Subcategoria3, etc") {

//                                 if ($category == "all") { $category_empty_all = 1; }

                                 //Esta es la parte que contiene la Subcategoria:
                                 //Util en products.php para que se ordenen los productos por subcategorias.
                      
                                 //Separamos por elementos diferenciados por coma (,) ->
                                 $subcategory_separated = explode(",", trim($category_subcategory));
                                 
                                 foreach ($subcategory_separated as $subcategory_real) {
                                         //echo "Subcategoria: ".$subcategory_real." (categoria:".$category_separated[0].")<br>";
                                 
                                         //Listar productos que coincidan con esta categoria (\$category_separated[0]) y esta subcategoria (\$subcategory_real).
                                 
                                         //Buscar en products.txt los que coincidan con \$category_separated[0] y luego de los resultados, los que coincidan
                                         //con \$subcategory_real:
                                         
                                         $subcategory_count = 0;
                                                                                  
                                         foreach ($items_content as $items_real_lines) {


                                         //Separamos por lineas con punto y coma (;) ->
                                         $items_separated = explode("|", trim($items_real_lines));
 
                                         foreach ($items_separated as $items_lines) {
                                         if ($items_lines != "") {

                                         //Separamos por elementos diferenciados con dos puntos (:) ->
                                         $items_separated = explode(":", trim($items_lines));
                      
                                         $y = 0;
                      
                                         $product_ref = "";
                                         $product_img_path = "";
                                         $product_name = "";
                                         $product_category = "";
                                         $product_subcategory = "";
                                         $product_price = "";
                                         $product_description = "";

                                         $subcategory_real = trim($subcategory_real);
                                         
//                                         $sensor = "vacio";
                                                                                  
                                         if (isset($items_separated[3]) && trim($items_separated[3]) != "Categoria") {
                                         
                                         if (trim($items_separated[3]) == trim($category_separated[0])) {


                                         //Buscar \$subcategory_real aqui:
                                           if (trim($items_separated[4]) == trim($subcategory_real)) {

                                           //Se ha encontrado una subcategoria con productos (se crea un ancla):


                                           if ($subcategory_count == 0) {

//                                              echo "<a name=\"".$category."-".urlencode($subcategory_real)."\"></a>";

//                                              echo "Subcategoria: ".$subcategory_real."<br>";
                                              
                                              $subcategory_count = 1;

                                              }


                                              
                                           if (isset($items_separated[0])) { $product_ref = trim($items_separated[0]); }
                                           if (isset($items_separated[1])) { $product_img_path = trim($items_separated[1]); }
                                          
                                           if (isset($items_separated[2])) {
                                           
                                           if ($items_separated[2]{0} == "*") {
                                           //$product_name = "OFERTA!!! ".trim(str_replace("*", "", $items_separated[2]));
                                           $product_name = trim(str_replace("*", "", $items_separated[2]));
                                           
                                           //echo "<table><tr><td>ofertaaaaaa</td></tr></table>";
                                           
                                           // Mucho ojaldre con esto:
                                           if (isset($product_ref)) {
                                           $_SESSION['product_basket_supply'][$product_ref] = "yes";
                                           }
                                           
                                           $product_supply = "yes";
                                           }
                                           
                                           else {
                                           $product_name = trim($items_separated[2]);
                                           $product_supply = "no";
                                           }
                                           
                                           }
                                          
                                           if (isset($items_separated[3])) {
                                           
                                           $product_category = trim($items_separated[3]);

                                           if (isset($supply_category) && trim($category) == $supply_category && isset($product_supply) && $product_supply == "yes") { $items_separated[3] = $supply_category; }

                                           }

                                           if (isset($items_separated[4])) { $product_subcategory = trim($items_separated[4]); }
                                           if (isset($items_separated[5])) { $product_price = trim($items_separated[5]); }

                                           if (isset($items_separated[6])) {

//                                           $product_description = str_replace("\"", "", $items_separated[6]);
                                           $product_description = str_replace("'", "", $items_separated[6]);


//                                           if (file_exists($product_description[0])) { $product_description[0] = file($product_description); }
                                           
                                           }





                                         if ($category == "all" && isset($search) && $search != "") {

    //                                     $search = urlencode($search);

//                                           $search_separated = explode(" ", urldecode($search));


//                                           $search = eregi_replace("%E1", "&aacute;", urlencode($search));  
  //                                         $search = eregi_replace("%E9", "&eacute;", urlencode($search));  
    //                                       $search = eregi_replace("%ED", "&iacute;", urlencode($search));  
      //                                     $search = eregi_replace("%F3", "&oacute;", urlencode($search));                                             
        //                                   $search = eregi_replace("%FA", "&uacute;", urlencode($search));                                             
                                             

//                                           $search = urldecode($search);
                                             $search = htmlspecialchars(urldecode($search));
                                         
                                           //$search_separated_pre = explode(" ", $search);
                                           //$search_separated[0] = trim($search_separated_pre[0]);
                                           
                                           $search_separated = explode(" ", $search);
//                                           $search_separated[] = urlencode($search_separated[0]);
                                           
                                           //kuidadisimitito:
                                           
                                           //$search_separated[0] = trim($search_separated[0]);
                                           //if (($search_separated) != "") {
                                           //fin kuidadisimitito.
                                           
                                           $search_separated_count = 0;
                                           
                                           foreach ($search_separated as $search_separated_actual) {
                                           
                                           //kuidadote:

                                           if ($search_separated[$search_separated_count] == "") {
                                           unset($search_separated[$search_separated_count]);
                                           }
                                           $search_separated_count++;
                                           
                                                //                                      print_r($search_separated);

                                           //fin kuidadote.                                           
                                                                                      //kuidadisimitito:
                                           //$search_separated_actual = trim($search_separated_actual);

                                           //if ($search_separated_actual == " ") { echo "aaa"; $search_separated_actual = ""; }
                                           
                                           //fin kuidadisimitito.
                                           
                                           if (($search_separated_actual) != "") {
                                           

                                           
                                           //echo "<b>Buscando:".$search_separated_actual."</b><br><br>";

                                         if (substr_count(strtoupper($product_ref), urldecode(strtoupper($search_separated_actual))) > 0) {
                                         
//                                         $product_ref = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_ref);
                                         if (isset($product_ref_x)) {
                                         $product_ref_x = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_ref_x);
                                         } else {
                                         $product_ref_x = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_ref);
                                         }

                                         if (isset($allwords) && $allwords == "on") {
                                         
//                                         if (!isset($product_search_allwords_count[urldecode($search_separated_actual)])) {
                                         if (!isset($product_search_allwords_count[$product_ref][urldecode($search_separated_actual)])) {
                                         $product_search_allwords_count[$product_ref][urldecode($search_separated_actual)] = "on";
                                         }
                                         
                                         } else {
                                         
                                         $product_search[$product_ref] = "ok";
                                         
                                         }

                                         }

//                                         if (substr_count(strtoupper($product_name), strtoupper($search_separated_actual)) > 0) {
                                         if (substr_count(strtoupper($product_name), urldecode(strtoupper($search_separated_actual))) > 0) {
                                           if (isset($product_name_search[$product_ref])) {
//                                           $product_name_search = eregi_replace($search_separated_actual, "<b>".$search_separated_actual."</b>", $product_name_search);
          $product_name_search[$product_ref] = eregi_replace($search_separated_actual, "<b>".$search_separated_actual."</b>", $product_name_search[$product_ref]);
                                           } else {
  //                                                 $product_name_search = eregi_replace($search_separated_actual, "<b>".$search_separated_actual."</b>", $product_name);
                                                     $product_name_search[$product_ref] = eregi_replace($search_separated_actual, "<b>".$search_separated_actual."</b>", $product_name);
                                                   }

                                         if (isset($allwords) && $allwords == "on") {
                                         if (!isset($product_search_allwords_count[$product_ref][urldecode($search_separated_actual)])) {
                                         $product_search_allwords_count[$product_ref][urldecode($search_separated_actual)] = "on";
                                         }
                                         
                                         } else {
                                         
                                         $product_search[$product_ref] = "ok";
                                         
                                         }
                                         }
                                         
                                         if (substr_count(strtoupper($product_category), urldecode(strtoupper($search_separated_actual))) > 0) {
                                         $product_category_x = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_category);


                                         if (isset($allwords) && $allwords == "on") {
                                         if (!isset($product_search_allwords_count[$product_ref][urldecode($search_separated_actual)])) {
//                                         $product_search_allwords_count[urldecode($search_separated_actual)] = "on";
                                         $product_search_allwords_count[$product_ref][urldecode($search_separated_actual)] = "on";
                                         }
                                         
                                         } else {
                                         
                                         $product_search[$product_ref] = "ok";
                                         
                                         }
                                         }

                                         if (substr_count(strtoupper($product_subcategory), urldecode(strtoupper($search_separated_actual))) > 0) {
                                         $product_subcategory_x = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_subcategory);

                                         if (isset($allwords) && $allwords == "on") {
                                         if (!isset($product_search_allwords_count[$product_ref][urldecode($search_separated_actual)])) {
                                         $product_search_allwords_count[$product_ref][urldecode($search_separated_actual)] = "on";
                                         }
                                         
                                         } else {
                                         
                                         $product_search[$product_ref] = "ok";
                                         
                                         }
                                         }


                                         if (!file_exists($product_description)) {
                                         if (substr_count(strtoupper($product_description), urldecode(strtoupper($search_separated_actual))) > 0) {
                                         $product_description = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_description);


                                         if (isset($allwords) && $allwords == "on") {
                                         if (!isset($product_search_allwords_count[$product_ref][urldecode($search_separated_actual)])) {
                                         $product_search_allwords_count[$product_ref][urldecode($search_separated_actual)] = "on";
                                         }
                                         
                                         } else {
                                         
                                         $product_search[$product_ref] = "ok";
                                         
                                         }


                                         }
                                         } else {
                                         
                                         if (!isset($product_description_file)) {
                                         $product_description_file = file($product_description);
                                         }
                                         
                                         foreach ($product_description_file as $product_description_file_line) {

                                         if (!isset($product_description_file_x[$product_description_file_line])) { $product_description_file_x[$product_description_file_line] = $product_description_file_line; }
                                         
                                         if (substr_count(strtoupper($product_description_file_line), urldecode(strtoupper($search_separated_actual))) > 0) {
                                         
                                         //$product_description_file_x[$product_description_file_line] = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_description_file_line);

                                         if (isset($product_description_file_x[$product_description_file_line])) {
                                         $product_description_file_x[$product_description_file_line] = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_description_file_x[$product_description_file_line]);
                                         } else {
                                         $product_description_file_x[$product_description_file_line] = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_description_file_line);
                                           
                                         }
                                         
//                                         else {
  //                                       $product_description_file_x[$product_description_file_line] = eregi_replace(urldecode($search_separated_actual), "<b>".urldecode($search_separated_actual)."</b>", $product_description_file_line);                                         
    //                                     }

//                                         echo $product_description_file_line;
                                         

                                         

                                         if (isset($allwords) && $allwords == "on") {
//                                         if (!isset($product_search_allwords_count[$product_ref])) {
                                         if (!isset($product_search_allwords_count[$product_ref][urldecode($search_separated_actual)])) {
//                                         $product_search_allwords_count[urldecode($search_separated_actual)][$product_ref] = "on";
                                         $product_search_allwords_count[$product_ref][urldecode($search_separated_actual)] = "on";
                                         }
//}                                         
                                         } else {
                                         
                                         $product_search[$product_ref] = "ok";
                                         

                                         
                                         }


                                         }
                                        // unset($product_description_file);
//                                         unset($product_description_file_x);
                                         }
                                         
                                         }

                                         //$product_img_path = "";
                                         }

}

//                                           foreach ($search_separated as $search_separated_actual) {

//                                         $product_search_allwords_count[urldecode($search_separated_actual)] = "on";

//                                           if (($search_separated_actual) != "") {
//                                           echo "aaaaaaaaa";
  //                                         }
  
                                           if (isset($product_search_allwords_count[$product_ref]) && isset($allwords) && $allwords == "on") {
//                                           echo "uuuu";

                                            // print_r($product_search_allwords_count[$product_ref]);

//echo "aaaaaaaaa-sizeof-searchseparated = ".sizeof($search_separated)."<br>";
                                       //    echo "aaaaaaaaa-sizeof-searchallwords = ".sizeof($product_search_allwords_count)."<br>";
//                                             echo "aaa";

                                           if (sizeof($product_search_allwords_count[$product_ref]) == sizeof($search_separated)) {

                                           $product_search[$product_ref] = "ok";  

//                                           echo "aaaaaaaaa-sizeof-searchseparated = ".sizeof($search_separated)."<br>";
  //                                         echo "aaaaaaaaa-sizeof-searchallwords = ".sizeof($product_search_allwords_count)."<br>";
//                                             echo "aaa";

                                             //print_r($product_search_allwords_count[$product_ref]);
                                             unset($product_search_allwords_count[$product_ref]);
                                             //kuidadete:
                                             //unset($product_search_allwords_count);
                                             //kuidadete,


                                           }
                                           }




                                         } elseif (!isset($allwords) || $allwords != "on") {
                                         
                                         $product_search[$product_ref] = "ok";
                                         
                                         }




//                                           if (trim($category) == "Ofertas" && isset($product_supply) && $product_supply == "yes") { $items_separated[3] == "Ofertas"; }

                                           //Calcular si se ha introducido listarlo todo o solo una categoria:
                                           if ($category == "all") {

                                           $category_empty_all = "full";
//                                           $category_empty_all = 1;
                                           
                                           //PRUEBITA
                                           $category_empty = 0;
                                           
//                                                                            $category_empty_all = 1;
                                           
//Cuidadin:
                                           if (isset($search) && isset($product_search[$product_ref]) && $product_search[$product_ref] == "ok" || isset($product_search[$product_ref]) && $product_search[$product_ref] == "ok") {
                                                                              
                                           //echo "* Encontrados: ".$items_separated[2]."<br>";
                                           echo "<tr><td><table border=\"".$product_table_border."\" width=\"".$product_table_width."\" cellspacing=\"".$product_table_cellspacing."\" cellpadding=\"".$product_table_cellpadding."\" bordercolor=\"".$product_table_border_color."\" bordercolordark=\"".$product_table_border_color_dark."\" bordercolorlight=\"".$product_table_border_color_light."\" style=\"border: ".$product_table_border_css."px solid ".$product_table_border_color."\"><tr>";
                                           
                                           if(isset($product_img_path) && $product_img_path == "auto") {

                                           if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {

                                           if (file_exists($product_and_basket_img_zoom_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension)) {
                                           $product_img_zoom_url = $product_and_basket_img_zoom_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension;
                                           }
                                           elseif (file_exists($product_img_auto_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension)) {
                                           $product_img_zoom_url = $product_img_auto_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension;
                                           }
                                           else {
                                           $product_img_zoom_url = strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension;
                                           }

                                           if (!isset($product_img_zoom_url) || $product_img_zoom_url == "") { $product_img_zoom_url = "unknown.jpg"; }

//                                           if (SID) {
  //                                         $product_img_zoom = "<a href=\"javascript:zoom_img('". $product_img_zoom_url . "?" . SID ."');\">";
    //                                       } else {


                                           
                                           $product_img_zoom = "<a href=\"javascript:zoom_img('". $product_img_zoom_url ."');\">";

      //                                     }
                                          
                                           } else {
                                           
                                           if (file_exists($product_and_basket_img_zoom_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension)) {
                                           $product_img_zoom_url = $product_and_basket_img_zoom_path . "" . rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension;
                                           }
                                           elseif (file_exists($product_img_auto_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension)) {
                                           $product_img_zoom_url = $product_img_auto_path . "" . rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension;
                                           }
                                           else {
                                           $product_img_zoom_url = rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension;
                                           }

                                           if (!isset($product_img_zoom_url) || $product_img_zoom_url == "") { $product_img_zoom_url = "unknown.jpg"; }

                                           if (SID) {
                                           $product_img_zoom = "<a href=\"" . $product_img_zoom_url . "?" . SID . "\" target=\"_blank\">";
                                           } else {
                                           $product_img_zoom = "<a href=\"" . $product_img_zoom_url ."\" target=\"_blank\">";
                                           }
                                           
                                           }


                                           if (isset($product_img_width) && isset($product_img_height) && is_numeric($product_img_width) && is_numeric($product_img_height)) {
                                           if ($product_img_width == "auto" && $product_img_height == "auto") {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"" . $product_img_auto_path . "" . rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension ."\" alt=\"".$product_name."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           elseif ($product_img_width == "auto" && $product_img_height != "auto") {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"" . $product_img_auto_path . "" . rawurlencode(strtolower(str_replace("-", "_", $product_ref))) . "" . $product_img_auto_extension ."\" alt=\"".$product_name."\" height=\"".$product_img_height."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           elseif ($product_img_width != "auto" && $product_img_height == "auto") {
                                           echo "<td align=\"center\" width=\"".$product_img_width."\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_auto_path ."".rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension . "\" alt=\"".$product_name."\" width=\"".$product_img_width."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           else {
                                           echo "<td align=\"center\" width=\"".$product_img_width."\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_auto_path."".rawurlencode(strtolower(str_replace("-", "_", $product_ref))) . "" . $product_img_auto_extension ."\" alt=\"".$product_name."\" width=\"".$product_img_width."\" height=\"".$product_img_height."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           }
                                           else {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_auto_path."".rawurlencode(strtolower(str_replace("-", "_", $product_ref))) . "" . $product_img_auto_extension ."\" alt=\"".$product_name."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }

                                           unset($product_img_zoom_url);
                                           unset($product_img_zoom);
                                           
                                           }


                                           if(isset($product_img_path) && $product_img_path != "auto") {

                                           
                                           if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {
                                           
                                           if (file_exists($product_and_basket_img_zoom_path . "" . $product_img_path)) {
                                           $product_img_zoom_url = $product_and_basket_img_zoom_path . "" . $product_img_path;
                                           }

                                           elseif (file_exists($product_img_path)) {
                                           $product_img_zoom_url = $product_img_path;
                                           }
                                           
                                           else {
                                           
                                           $product_img_zoom_url = $product_img_path;
                                                                                                                                
                                           }

                                           if (!isset($product_img_zoom_url) || $product_img_zoom_url == "") { $product_img_zoom_url = "unknown.jpg"; }

//                                           if (SID) {
  //                                         $product_img_zoom = "<a href=\"javascript:zoom_img('". $product_img_zoom_url . "?" . SID ."');\">";
    //                                       } else {
                                           $product_img_zoom = "<a href=\"javascript:zoom_img('". $product_img_zoom_url . "');\">";
      //                                     }
                                          
                                           } else {
                                           
                                           if (file_exists($product_and_basket_img_zoom_path . "" . $product_img_path)) {
                                           $product_img_zoom_url = $product_and_basket_img_zoom_path . "" . trim($product_img_path);
                                           }
                                           elseif (file_exists($product_img_path)) {
                                           $product_img_zoom_url = trim($product_img_path);
                                           }

                                           else {
                                           
                                           $product_img_zoom_url = trim($product_img_path);
                                                                                                                                
                                           }

                                           if (!isset($product_img_zoom_url) || $product_img_zoom_url == "") { $product_img_zoom_url = "unknown.jpg"; }

                                           if (SID) {
                                           $product_img_zoom = "<a href=\"" . $product_img_zoom_url . "?" . SID . "\" target=\"_blank\">";
                                           } else {
                                           $product_img_zoom = "<a href=\"" . $product_img_zoom_url ."\" target=\"_blank\">";
                                           }
                                           
                                           }



                                           if (isset($product_img_width) && isset($product_img_height) && is_numeric($product_img_width) && is_numeric($product_img_height)) {
                                           if ($product_img_width == "auto" && $product_img_height == "auto") {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           elseif ($product_img_width == "auto" && $product_img_height != "auto") {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" height=\"".$product_img_height."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           elseif ($product_img_width != "auto" && $product_img_height == "auto") {
                                           echo "<td align=\"center\" width=\"".$product_img_width."\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" width=\"".$product_img_width."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           else {
                                           echo "<td align=\"center\" width=\"".$product_img_width."\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" width=\"".$product_img_width."\" height=\"".$product_img_height."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           }
                                           else {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }

                                           unset($product_img_zoom_url);
                                           unset($product_img_zoom);

                                           }
                                           
                                           //echo "<td>";
                                           
                                           if (isset($product_img_width) && is_numeric($product_img_width) && $product_img_width != "auto") {
                                              if (isset($product_table_width) && is_numeric($product_table_width)) {
                                           ?>
                                           <td width="<?php echo $product_table_width - $product_img_width; ?>">
                                           <?php 
                                              }
                                           } else {
                                           echo "<td>";
                                           }
                                           
                                           if(isset($supply_category) && isset($product_supply) && $product_supply == "yes") {
                                           
                                           if (SID) {
                                           echo "<b>OFERTA</b> (<a href=\"".$products_file."?category=".$supply_category."&".SID."\" title=\"ver mas ofertas\">ver mas ofertas</a>)<br><br>"; $product_supply = "no";
                                           } else {
                                           echo "<b>OFERTA</b> (<a href=\"".$products_file."?category=".$supply_category."\" title=\"ver mas ofertas\">ver mas ofertas</a>)<br><br>"; $product_supply = "no";
                                           }
                                           
                                           }
                                           
                                           if(isset($product_name_search[$product_ref])) { echo "Nombre: ".$product_name_search[$product_ref]."<br>"; unset($product_name_search[$product_ref]); }
                                           elseif ($product_name) { echo "Nombre: ".$product_name."<br>"; }

                                           if (isset($product_category_x)) {
                                           if (SID) {
                                           echo "Categoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&".SID."\" title=\"".$product_category."\">".$product_category_x."</a><br>";
                                           unset($product_category_x);
                                           } else {
                                           echo "Categoria: <a href=\"".$products_file."?category=".urlencode($product_category)."\" title=\"".$product_category."\">".$product_category_x."</a><br>";
                                           unset($product_category_x);
                                           }                                           
                                           }
                                           elseif($product_category) {
                                           if (SID) {
                                           echo "Categoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&".SID."\" title=\"".$product_category."\">".$product_category."</a><br>";
                                           } else {
                                           echo "Categoria: <a href=\"".$products_file."?category=".urlencode($product_category)."\" title=\"".$product_category."\">".$product_category."</a><br>";
                                           }
                                           }

                                           if (isset($product_subcategory_x)) {
                                           if (SID) {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."&".SID."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory_x."</a><br>";
                                           unset($product_subcategory_x);
                                           } else {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory_x."</a><br>";
                                           unset($product_subcategory_x);
                                           }
                                           }
                                           elseif($product_subcategory) {
                                           if (SID) {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."&".SID."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory."</a><br>";
                                           } else {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory."</a><br>";
                                           }
                                           }
                                           
                                           if (file_exists($product_description)) {
                                           
                                           if (isset($product_description_file_x)) {
//                                           echo "Descripci&oacute;n: ".$product_description_file[0]."<br>";
                                             echo "Descripci&oacute;n: ";
                                             foreach ($product_description_file_x as $product_description_file_x_resalt) {
                                             echo $product_description_file_x_resalt;
//                                             echo nl2br(wordwrap($product_description_file_x_resalt,  10, "<br>", 1));
//                                           echo "Descripci&oacute;n: "; include nl2br(wordwrap($product_description,  4, "-<br>", 1)); echo "<br>";
                                             }
                                             echo "<br>";
//                                         unset($product_description_file_x);
                                           } else {
//                                           echo "Descripci&oacute;n: "; include nl2br(wordwrap($product_description,  4, "-<br>", 1)); echo "<br>";
                                           echo "Descripci&oacute;n: "; include $product_description; echo "<br>";

                                           }
                                           
                                           }
                                           elseif($product_description) { echo "Descripci&oacute;n: ".$product_description."<br>"; }
                                           
//                                           if($product_description) { echo "Descripci&oacute;n: ".$product_description."<br>"; }
                                                                         
//                                           if($product_ref) { echo "Referencia: ".$product_ref."<br>"; }

                                           if(isset($product_ref_x)) { echo "Referencia: ".$product_ref_x."<br>"; unset($product_ref_x); }
                                           elseif(isset($product_ref)) { echo "Referencia: ".$product_ref."<br>"; }

                                           if($product_price) {
                                           


                                           //Seccion Precio con conversion de monedas:
                                           
                                           echo "Precio:<br>";


                                           //Si esta activada la opcion de conversor:
                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($product_price / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($product_price / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {                                             
                                           $money_usd_represent = wordwrap(number_format($product_price / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($product_price / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
//                                           echo wordwrap(number_format($product_price / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
  //                                         } else {
    //                                       echo wordwrap(number_format($product_price / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR<br>";
      //                                     }
      
                                           if (isset($money_default)) {
                                           echo "<b>".wordwrap(number_format($product_price, 2, ",", "."), 20, "<br>", 1)."</b>".$money_default;
                                           } else {
                                           echo "<b>".wordwrap(number_format($product_price, 2, ",", "."), 20, "<br>", 1)."</b> EUR";
                                           }
      
                                           }


                                           if (!isset($_SESSION['basket_quantity'])) { $_SESSION['basket_quantity'] = array(); }
                                           if (!isset($_SESSION['basket_ref'])) { $_SESSION['basket_ref'] = array(); }
                                           if (!isset($_SESSION['basket_img_path'])) { $_SESSION['basket_img_path'] = array(); }
                                           if (!isset($_SESSION['basket_name'])) { $_SESSION['basket_name'] = array(); }
                                           if (!isset($_SESSION['basket_category'])) { $_SESSION['basket_category'] = array(); }
                                           if (!isset($_SESSION['basket_subcategory'])) { $_SESSION['basket_subcategory'] = array(); }
                                           if (!isset($_SESSION['basket_price'])) { $_SESSION['basket_price'] = array(); }
                                           if (!isset($_SESSION['basket_description'])) { $_SESSION['basket_description'] = array(); }

                                           if (!isset($_SESSION['basket_quantity'][$product_ref])) { $_SESSION['basket_quantity'][$product_ref] = "0"; }
                                           if (!isset($_SESSION['basket_ref'][$product_ref])) { $_SESSION['basket_ref'][$product_ref] = $product_ref; }
                                           if (!isset($_SESSION['basket_img_path'][$product_ref])) { $_SESSION['basket_img_path'][$product_ref] = $product_img_path; }
                                           if (!isset($_SESSION['basket_name'][$product_ref])) { $_SESSION['basket_name'][$product_ref] = $product_name; }
                                           if (!isset($_SESSION['basket_category'][$product_ref])) { $_SESSION['basket_category'][$product_ref] = $product_category; }
                                           if (!isset($_SESSION['basket_subcategory'][$product_ref])) { $_SESSION['basket_subcategory'][$product_ref] = $product_subcategory; }
                                           if (!isset($_SESSION['basket_price'][$product_ref])) { $_SESSION['basket_price'][$product_ref] = $product_price; }
                                           if (!isset($_SESSION['basket_description'][$product_ref])) { $_SESSION['basket_description'][$product_ref] = $product_description; }


//                                           $basket_file = "basket.php";

                                           ?>




                                           <br>
                                           <center>
                                           
                                           <table cellspacing="0" cellpadding="0" border="0" align="center" valign="middle">
                                           <tr><td>

                                           <center>
                                           
                                           
                                           <?php

                                           //Visitar basket.php:
                                           if (isset($basket_javascript_popup) && $basket_javascript_popup != "on" || $basket_javascript_popup != "on" || !isset($_SESSION['javascript_support']) || $_SESSION['javascript_support'] != "enabled" || SID || isset($_SESSION['screen_is_undefined']) && $_SESSION['screen_is_undefined'] == "enabled") {
                                           ?>
                                           
                                           <form method="get" action="<?php echo $basket_file; ?>">
                                           
                                           <?php
                                           } elseif (isset($basket_javascript_popup) && $basket_javascript_popup == "on" && isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == "enabled" && !SID) {

                                           if (!isset($_SESSION['screen_is_undefined']) || $_SESSION['screen_is_undefined'] != "enabled") {

                                           //Visitar basket.php en un popup:

                                           if (!isset ($form_count) || $form_count == 0 || $form_count == "") { $form_count = 1; }
                                           elseif (isset($form_count) && $form_count != 0) { $form_count++; }

                                           ?>
                                           
<!--                                           <form method="get" action="javascript:notify_add_item();" onSubmit="<?php echo "javascript:basket_popup('".$basket_file."?act=add&ref=' + form_items_".$form_count.".ref.value + '&quantity=' + form_items_".$form_count.".quantity.value);"; ?>" name="form_items_<?php echo $form_count; ?>">                                           -->
                                               

                                           <script language="JavaScript1.2" type="text/javascript">
                                           <!--
                                           
                                           if (window.name == "basket_popup") {
                                           var basket_popup_form = "<form method=\"get\" action=\"<?php echo $basket_file; ?>\">";
//                                           alert(window.name);
                                           document.write(basket_popup_form);
                                           } else {
                                           var basket_popup_form = "<form method=\"get\" action=\"javascript:notify_add_item();\" onSubmit=\"<?php echo "javascript:basket_popup('".$basket_file."?act=add&ref=' + form_items_".$form_count.".ref.value + '&quantity=' + form_items_".$form_count.".quantity.value);"; ?>\" name=\"form_items_<?php echo $form_count; ?>\">";
//                                           var basket_popup_form = "<form method=\"get\" action=\"<?php echo "javascript:basket_popup('".$basket_file."?act=add&ref=' + form_items_".$form_count.".ref.value + '&quantity=' + form_items_".$form_count.".quantity.value);"; ?>\" onSubmit=\"javascript:notify_add_item();\" name=\"form_items_<?php echo $form_count; ?>\">";
                                           document.write(basket_popup_form);
                                           }
                                                                                      
                                           //-->
                                           
                                           </script>
                                           
                                           <?php
                                           }
                                           }
                                           ?>

                                           
                                           <input type="hidden" name="ref" value="<?php echo urlencode($product_ref); ?>">
                                           <input type="hidden" name="act" value="add">

                                           <b>Can<u>t</u>idad</b>:
                                           <input type="text" value="1" name="quantity" maxlength="10" accesskey="t" size="10" title="Cantidad del producto" id="quantity"><br>
                                           
                                           <input type="submit" value="Poner en cesta" title="Poner producto en la cesta">
                                           
                                          
                                           <?php
                                           if (SID) {
                                           
                                           ?>
                                           <input type="hidden" name="<?php echo session_name(); ?>" value="<?php echo session_id(); ?>">
                                           
                                           <?php
                                           }
                                           ?>

                                           </form>

                                           </center>

                                           </td></tr>
                                           </table>
                                           </center>

                                                                                      




                                           
                                           <?php


                                          
                                           }
                                           
                                         
                                           echo "</td></tr></table><br></td></tr>";

//Cuidadin:
}


                                           }
                                           
                                           else {
                                           
//                                           if (trim($category) == "Ofertas" && isset($product_supply) && $product_supply == "yes") {
    //                                       $items_separated[3] = "Ofertas";
                                           //echo "<table><tr><td>OFERTAAAAAAAAAAA</td></tr></table>";
  //                                         }
                                           
//                                           if ($product_supply == "yes") {
                                           //echo "<table><tr><td>OFERTAAAAAAAAAAA</td></tr></table>";
  //                                         }
                                           
                                           
                                           if (isset($subcategory) && $subcategory == $product_subcategory) {
                                           $products_represent_ok = "on";
                                           }
                                           elseif (!isset($subcategory)) {
                                           $products_represent_ok = "on";

//                                           $subcategories[$product_subcategory] = $product_subcategory;
                                           
                                           }
                                           elseif (isset($subcategory) && $subcategory != $product_subcategory) {
                                           $products_represent_ok = "off";
                                           }
                                           

                                           if (trim($items_separated[3]) == trim($category) && $products_represent_ok == "on") {

                                           $category_empty = 0;

                                           if (isset($subcategory) && $subcategory == $product_subcategory && !isset($show_subcategory_before)) { echo "** Subcategoria: <b>".$product_subcategory."</b><br>"; $show_subcategory_before = "ok"; }
                                           elseif (!isset($subcategory) && $products_represent_ok == "on" && !isset($show_subcategory_before) && $category != $supply_category) { echo "** Todas las subcategorias: <br>"; $show_subcategory_before = "ok"; }
                                           

                                           //vigilar:
                                           if (isset($subcategories) && !isset($show_subcategories_before)) {
                                           
                                           if (!isset($subcategory)) { echo "[ <b>Todas</b> ]: "; }
                                           else {
                                           if (SID) {
                                           echo "<a href=\"".$products_file."?category=".urlencode($category)."&".SID."\" title=\"Todas\">Todas</a>: ";
                                           } else {
                                           echo "<a href=\"".$products_file."?category=".urlencode($category)."\" title=\"Todas\">Todas</a>: ";
                                           }
                                           }
                                           
                                           foreach ($subcategories as $show_subcategories) {
                                                                                      
                                           if (isset($subcategory) && $show_subcategories == $subcategory) {
                                           echo "[ <b>" . trim($show_subcategories) . "</b> ] ";
                                           } else {
                                           if (SID) {
                                           echo "<a href=\"".$products_file."?category=".urlencode($category)."&subcategory=".urlencode($show_subcategories)."&".SID."\" title=\"".trim($show_subcategories)." (".$category.")\">" . trim($show_subcategories) . "</a> ";
                                           } else {
                                           echo "<a href=\"".$products_file."?category=".urlencode($category)."&subcategory=".urlencode($show_subcategories)."\" title=\"".trim($show_subcategories)." (".$category.")\">" . trim($show_subcategories) . "</a> ";
                                           }
                                           
                                           }

                                           }
                                           $show_subcategories_before = "yes";
                                           }

                                           //fin de vigilar.

                                           //PRUEBITA


                                           
                                           //echo "* Encontrados: ".$items_separated[2]."<br>";
                                           
//                                           echo "<tr><td><table border=\"1\" bordercolor=\"#ff0000\" width=\"".$product_table_width."\" cellspacing=\"0\" cellpadding=\"8\"><tr>";
                                           echo "<tr><td><br><table border=\"".$product_table_border."\" width=\"".$product_table_width."\" cellspacing=\"".$product_table_cellspacing."\" cellpadding=\"".$product_table_cellpadding."\" bordercolor=\"".$product_table_border_color."\" bordercolordark=\"".$product_table_border_color_dark."\" bordercolorlight=\"".$product_table_border_color_light."\" style=\"border: ".$product_table_border_css."px solid ".$product_table_border_color."\"><tr>";
                                           
                                           if(isset($product_img_path) && $product_img_path == "auto") {


                                           if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {

                                           if (file_exists($product_and_basket_img_zoom_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension)) {
                                           $product_img_zoom_url = $product_and_basket_img_zoom_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension;
                                           }
                                           elseif (file_exists($product_img_auto_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension)) {
                                           $product_img_zoom_url = $product_img_auto_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension;
                                           }
                                           else {
                                           $product_img_zoom_url = strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension;
                                           }

                                           if (!isset($product_img_zoom_url) || $product_img_zoom_url == "") { $product_img_zoom_url = "unknown.jpg"; }

//                                           if (SID) {
  //                                         $product_img_zoom = "<a href=\"javascript:zoom_img('". $product_img_zoom_url . "?" . SID ."');\">";
    //                                       } else {
                                           $product_img_zoom = "<a href=\"javascript:zoom_img('". $product_img_zoom_url . "');\">";
      //                                     }
                                          
                                           } else {
                                           
                                           if (file_exists($product_and_basket_img_zoom_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension)) {
                                           $product_img_zoom_url = $product_and_basket_img_zoom_path . "" . rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension;
                                           }
                                           elseif (file_exists($product_img_auto_path . "" . strtolower(str_replace("-", "_", $product_ref)). "" . $product_img_auto_extension)) {
                                           $product_img_zoom_url = $product_img_auto_path . "" . rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension;
                                           }
                                           else {
                                           $product_img_zoom_url = rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension;
                                           }

                                           if (!isset($product_img_zoom_url) || $product_img_zoom_url == "") { $product_img_zoom_url = "unknown.jpg"; }

                                           if (SID) {
                                           $product_img_zoom = "<a href=\"" . $product_img_zoom_url . "?" . SID . "\" target=\"_blank\">";
                                           } else {
                                           $product_img_zoom = "<a href=\"" . $product_img_zoom_url ."\" target=\"_blank\">";
                                           }
                                           
                                           }

                                           
//                                           if(isset($product_img_path) && $product_img_path == "auto") {
                                           if (isset($product_img_width) && isset($product_img_height) && is_numeric($product_img_width) && is_numeric($product_img_height)) {
                                           if ($product_img_width == "auto" && $product_img_height == "auto") {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_auto_path."".rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension . "\" alt=\"".$product_name."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           elseif ($product_img_width == "auto" && $product_img_height != "auto") {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_auto_path."".rawurlencode(strtolower(str_replace("-", "_", $product_ref))). "" . $product_img_auto_extension . "\" alt=\"".$product_name."\" height=\"".$product_img_height."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           elseif ($product_img_width != "auto" && $product_img_height == "auto") {
                                           echo "<td align=\"center\" width=\"".$product_img_width."\" valign=\"middle\">".$product_img_zoom."<img src=\"". $product_img_auto_path . "" . rawurlencode(strtolower(str_replace("-", "_", $product_ref))) . "" . $product_img_auto_extension ."\" alt=\"".$product_name."\" width=\"".$product_img_width."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           else {
                                           echo "<td align=\"center\" width=\"".$product_img_width."\" valign=\"middle\">".$product_img_zoom."<img src=\"". $product_img_auto_path ."".rawurlencode(strtolower(str_replace("-", "_", $product_ref)))."".$product_img_auto_extension."\" alt=\"".$product_name."\" width=\"".$product_img_width."\" height=\"".$product_img_height."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           }
                                           else {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_auto_path."".rawurlencode(strtolower(str_replace("-", "_", $product_ref)))."".$product_img_auto_extension."\" alt=\"".$product_name."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
  //                                         }


                                           //echo "<td><img src=\"".$product_ref."\" alt=\"".$product_name."\"></td>";

                                           unset($product_img_zoom_url);
                                           unset($product_img_zoom);
                                           
                                           }
                                           
                                           if(isset($product_img_path) && $product_img_path != "auto") {



                                           if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {
                                           
                                           if (file_exists($product_and_basket_img_zoom_path . "" . $product_img_path)) {
                                           $product_img_zoom_url = $product_and_basket_img_zoom_path . "" . $product_img_path;
                                           }

                                           elseif (file_exists($product_img_path)) {
                                           $product_img_zoom_url = $product_img_path;
                                           }
                                           
                                           else {
                                           
                                           $product_img_zoom_url = $product_img_path;
                                                                                                                                
                                           }

                                           if (!isset($product_img_zoom_url) || $product_img_zoom_url == "") { $product_img_zoom_url = "unknown.jpg"; }

//                                           if (SID) {
  //                                         $product_img_zoom = "<a href=\"javascript:zoom_img('". $product_img_zoom_url . "?" . SID ."');\">";
    //                                       } else {
                                           $product_img_zoom = "<a href=\"javascript:zoom_img('". $product_img_zoom_url . "');\">";
      //                                     }
                                          
                                           } else {
                                           
                                           if (file_exists($product_and_basket_img_zoom_path . "" . $product_img_path)) {
                                           $product_img_zoom_url = $product_and_basket_img_zoom_path . "" . $product_img_path;
                                           }
                                           elseif (file_exists($product_img_path)) {
                                           $product_img_zoom_url = $product_img_path;
                                           }

                                           else {
                                           
                                           $product_img_zoom_url = $product_img_path;
                                                                                                                                
                                           }

                                           if (!isset($product_img_zoom_url) || $product_img_zoom_url == "") { $product_img_zoom_url = "unknown.jpg"; }

                                           if (SID) {
                                           $product_img_zoom = "<a href=\"" . $product_img_zoom_url . "?" . SID . "\" target=\"_blank\">";
                                           } else {
                                           $product_img_zoom = "<a href=\"" . $product_img_zoom_url ."\" target=\"_blank\">";
                                           }
                                           
                                           }



                                 
                                           if (isset($product_img_width) && isset($product_img_height) && is_numeric($product_img_width) && is_numeric($product_img_height)) {
                                           if ($product_img_width == "auto" && $product_img_height == "auto") {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           elseif ($product_img_width == "auto" && $product_img_height != "auto") {
                                           echo "<td align=\"center\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" height=\"".$product_img_height."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           elseif ($product_img_width != "auto" && $product_img_height == "auto") {
                                           echo "<td align=\"center\" width=\"".$product_img_width."\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" width=\"".$product_img_width."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           else {
                                           echo "<td align=\"center\" width=\"".$product_img_width."\" valign=\"middle\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" width=\"".$product_img_width."\" height=\"".$product_img_height."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }
                                           }
                                           else {
                                           echo "<td align=\"center\">".$product_img_zoom."<img src=\"".$product_img_path."\" alt=\"".$product_name."\" title=\"".$product_name."\" hspace=\"0\" vspace=\"0\"><br>ampliar</a><br></td>";
                                           }

                                 //          echo "<td><img src=\"".$product_img_path."\" alt=\"".$product_name."\"></td>";



                                           unset($product_img_zoom_url);
                                           unset($product_img_zoom);

                                 
                                           }
                                           
                                           //echo "<td>";
                                           
                                           if (isset($product_img_width) && is_numeric($product_img_width) && $product_img_width != "auto") {
                                              if (isset($product_table_width) && is_numeric($product_table_width)) {
                                           ?>
                                           <td width="<?php echo $product_table_width - $product_img_width; ?>">
                                           <?php 
                                              }
                                           } else {
                                           echo "<td>";
                                           }
                                           

                                           if(isset($product_supply) && $product_supply == "yes") {
                                           
                                           if (isset($supply_category) && $category != $supply_category) {
                                           
                                           if (SID) {
                                           echo "<b>OFERTA</b> (<a href=\"".$products_file."?category=".$supply_category."&".SID."\" title=\"ver mas ofertas\">ver mas ofertas</a>)<br><br>";
                                           } else {
                                           echo "<b>OFERTA</b> (<a href=\"".$products_file."?category=".$supply_category."\" title=\"ver mas ofertas\">ver mas ofertas</a>)<br><br>";
                                           }
                                           
                                           }
                                           else {
                                           echo "<b>OFERTA</b><br><br>";
                                           }
                                           
                                           }

                                           if($product_name) { echo "Nombre: ".$product_name."<br>"; }

                                           if(isset($product_supply) && $product_supply == "yes") {

                                           if($product_category) {

                                           if ($category == $supply_category ) {

                                           if (SID) {
                                           echo "Categoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&".SID."\" title=\"".$product_category."\">".$product_category."</a><br>";
                                           } else {
                                           echo "Categoria: <a href=\"".$products_file."?category=".urlencode($product_category)."\" title=\"".$product_category."\">".$product_category."</a><br>";
                                           }
                                           
                                           }
                                           
                                           else {
                                           echo "Categoria: ".$product_category."<br>";
                                           }
                                           
                                           
                                           }
                                           if($product_subcategory) {
                                           
                                           if ($category == $supply_category) {
                                           
                                           if (SID) {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."&".SID."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory."</a><br>";
                                           } else {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory."</a><br>";
                                           }
                                           
                                           }
                                           
                                           else {
                                           
                                           if (isset($subcategory)) {
                                           echo "Subcategoria: ".$product_subcategory."<br>";
                                           } else {
                                           if (SID) {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."&".SID."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory."</a><br>";
                                           } else {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory."</a><br>";
                                           }

                                           }
                                           
//                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".$product_subcategory."\">".$product_subcategory."</a><br>";
                                                        
                                           }
                                           
                                           }
                                           
                                           $product_supply = "no";
                                                                                      
                                           } else {
                                           
                                           if($product_category) { echo "Categoria: ".$product_category."<br>"; }
                                           if($product_subcategory) {
                                           if (isset($subcategory)) {
                                           echo "Subcategoria: ".$product_subcategory."<br>";
                                           } else {
                                           if (SID) {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."&".SID."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory."</a><br>";
                                           } else {
                                           echo "Subcategoria: <a href=\"".$products_file."?category=".urlencode($product_category)."&subcategory=".urlencode($product_subcategory)."\" title=\"".$product_subcategory ." (".$product_category.")\">".$product_subcategory."</a><br>";
                                           }
                                           }
                                           }
                                           
                                           }
                                           
                                           if (file_exists($product_description)) { echo "Descripci&oacute;n: "; include $product_description; echo "<br>"; }
                                           elseif($product_description) { echo "Descripci&oacute;n: ".$product_description."<br>"; }
                                           
                                           if($product_ref) { echo "Referencia: ".$product_ref."<br>"; }
                                           if($product_price) {
                                           
                                           //echo "Precio: ".$product_price." ".$product_money."<br>";
                                           
                                                                                      //Seccion Precio con conversion de monedas:
                                           
                                           echo "Precio:<br>";


                                           //Si esta activada la opcion de conversor:
                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($product_price / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($product_price / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($product_price / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {                                           
                                           $money_eur_represent = wordwrap(number_format($product_price / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                            
                                           }
                                     
                                           } else {
                                           
//                                           if (isset($money_default)) {
//                                           echo wordwrap(number_format($product_price / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
  //                                         } else {
    //                                       echo wordwrap(number_format($product_price / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR";
      //                                     }
      
                                           if (isset($money_default)) {
                                           echo "<b>".wordwrap(number_format($product_price, 2, ",", "."), 20, "<br>", 1)."</b>".$money_default;
                                           } else {
                                           echo "<b>".wordwrap(number_format($product_price, 2, ",", "."), 20, "<br>", 1)."</b> EUR";
                                           }
      

                                           }



                                           if (!isset($_SESSION['basket_quantity'])) { $_SESSION['basket_quantity'] = array(); }
                                           if (!isset($_SESSION['basket_ref'])) { $_SESSION['basket_ref'] = array(); }
                                           if (!isset($_SESSION['basket_img_path'])) { $_SESSION['basket_img_path'] = array(); }
                                           if (!isset($_SESSION['basket_name'])) { $_SESSION['basket_name'] = array(); }
                                           if (!isset($_SESSION['basket_category'])) { $_SESSION['basket_category'] = array(); }
                                           if (!isset($_SESSION['basket_subcategory'])) { $_SESSION['basket_subcategory'] = array(); }
                                           if (!isset($_SESSION['basket_price'])) { $_SESSION['basket_price'] = array(); }
                                           if (!isset($_SESSION['basket_description'])) { $_SESSION['basket_description'] = array(); }

                                           if (!isset($_SESSION['basket_quantity'][$product_ref])) { $_SESSION['basket_quantity'][$product_ref] = "0"; }
                                           if (!isset($_SESSION['basket_ref'][$product_ref])) { $_SESSION['basket_ref'][$product_ref] = $product_ref; }
                                           if (!isset($_SESSION['basket_img_path'][$product_ref])) { $_SESSION['basket_img_path'][$product_ref] = $product_img_path; }
                                           if (!isset($_SESSION['basket_name'][$product_ref])) { $_SESSION['basket_name'][$product_ref] = $product_name; }
                                           if (!isset($_SESSION['basket_category'][$product_ref])) { $_SESSION['basket_category'][$product_ref] = $product_category; }
                                           if (!isset($_SESSION['basket_subcategory'][$product_ref])) { $_SESSION['basket_subcategory'][$product_ref] = $product_subcategory; }
                                           if (!isset($_SESSION['basket_price'][$product_ref])) { $_SESSION['basket_price'][$product_ref] = $product_price; }
                                           if (!isset($_SESSION['basket_description'][$product_ref])) { $_SESSION['basket_description'][$product_ref] = $product_description; }



                                           ?>





                                           <br>
                                           <center>
                                           
                                           <table cellspacing="0" cellpadding="0" border="0" align="center" valign="middle">
                                           <tr><td>

                                           <center>
                                           
                                           
                                           <?php

                                           //Visitar basket.php:
                                           if (isset($basket_javascript_popup) && $basket_javascript_popup != "on" || $basket_javascript_popup != "on" || !isset($_SESSION['javascript_support']) || $_SESSION['javascript_support'] != "enabled" || SID || isset($_SESSION['screen_is_undefined']) && $_SESSION['screen_is_undefined'] == "enabled") {
                                           ?>
                                           
                                           <form method="get" action="<?php echo $basket_file; ?>">
                                           
                                           <?php
                                           } elseif (isset($basket_javascript_popup) && $basket_javascript_popup == "on" && isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == "enabled" && !SID) {

                                           if (!isset($_SESSION['screen_is_undefined']) || $_SESSION['screen_is_undefined'] != "enabled") {

                                           //Visitar basket.php en un popup:

                                           if (!isset ($form_count) || $form_count == 0 || $form_count == "") { $form_count = 1; }
                                           elseif (isset($form_count) && $form_count != 0) { $form_count++; }

                                           ?>
                                           
<!--                                           <form method="get" action="<?php echo "javascript:basket_popup('".$basket_file."?act=add&ref=' + form_items_".$form_count.".ref.value);"; ?>" onSubmit="<?php echo "javascript:basket_popup('".$basket_file."?act=add&ref=' + form_items_".$form_count.".ref.value);"; ?>" name="form_items_<?php echo $form_count; ?>"> -->
<!--                                           <form method="get" action="javascript:notify_add_item();" onSubmit="<?php echo "javascript:basket_popup('".$basket_file."?act=add&ref=' + form_items_".$form_count.".ref.value + '&quantity=' + form_items_".$form_count.".quantity.value);"; ?>" name="form_items_<?php echo $form_count; ?>">                                           -->

                                           <script language="JavaScript1.2" type="text/javascript">
                                           <!--
                                           
                                           if (window.name == "basket_popup") {
                                           var basket_popup_form = "<form method=\"get\" action=\"<?php echo $basket_file; ?>\">";
//                                           alert(window.name);
                                           document.write(basket_popup_form);
                                           } else {
                                           var basket_popup_form = "<form method=\"get\" action=\"javascript:notify_add_item();\" onSubmit=\"<?php echo "javascript:basket_popup('".$basket_file."?act=add&ref=' + form_items_".$form_count.".ref.value + '&quantity=' + form_items_".$form_count.".quantity.value);"; ?>\" name=\"form_items_<?php echo $form_count; ?>\">";
//                                           var basket_popup_form = "<form method=\"get\" action=\"<?php echo "javascript:basket_popup('".$basket_file."?act=add&ref=' + form_items_".$form_count.".ref.value + '&quantity=' + form_items_".$form_count.".quantity.value);"; ?>\" name=\"form_items_<?php echo $form_count; ?>\">";
                                           document.write(basket_popup_form);
                                           }
                                                                                      
                                           //-->
                                           
                                           </script>


                                           <?php
                                           }
                                           }
                                           ?>



                                           
                                           <input type="hidden" name="ref" value="<?php echo urlencode($product_ref); ?>">
                                           <input type="hidden" name="act" value="add">

                                           <b>Can<u>t</u>idad</b>:
                                           <input type="text" value="1" name="quantity" maxlength="10" accesskey="t" size="10" title="Cantidad del producto" id="quantity">
                                           <input type="submit" value="Poner en cesta" title="Poner producto en la cesta">
                                           
                                          
                                           <?php
                                           if (SID) {
                                           
                                           ?>
                                           <input type="hidden" name="<?php echo session_name(); ?>" value="<?php echo session_id(); ?>">
                                           
                                           <?php
                                           }
                                           ?>

                                           </form>

                                           </center>

                                           </td></tr>
                                           </table>
                                           </center>



                                          
                                           <?php
                                           
//                                           $product_supply = "no";
                                           
                                           }

                                           echo "</td></tr></table><br></td></tr>";

                                           }

                                           } 

                                           }
                                     
                                         }
                                        
                                         }

                                         }
                                         }

                                         }                                 

                                 }

                                 
//                                 echo "<br>";

                              
                                 }
                             
                              $x++;
                           
                              }

                           
                       }     

                      }
                                          if (isset($category_empty_all) && $category_empty_all == "empty") {
                                          
                                          if (isset($supply_category) && trim($category_separated[0]) == $supply_category) {
                                          
                                          
                                          
                                          echo "<tr><td>";
                                          echo "<table border=\"0\" width=\"".$product_table_width."\" cellspacing=\"0\" cellpadding=\"0\">";
                                          echo "<tr><td>";
                                          
                                          if (SID) {
                                          echo "[ <a href=\"".$products_file."?category=".$supply_category."&".SID."\" title=\"Ver ofertas\">Ver ofertas</a> ]<br><br>";
                                          } else {
                                          echo "[ <a href=\"".$products_file."?category=".$supply_category."\" title=\"Ver ofertas\">Ver ofertas</a> ]<br><br>";
                                          }
                                          
                                          echo "</td></tr></table>";
                                          echo "</td></tr>";
                                                                                    
                                          } else {
                                          
                                          
                                          echo "<tr><td>";
                                          echo "<table border=\"0\" width=\"".$product_table_width."\" cellspacing=\"0\" cellpadding=\"0\">";
                                          echo "<tr><td>";
                                          echo "Categor&iacute;a vacia<br><br>";
//                                          echo trim($category_separated[0])."sfdads";
                                          echo "</td></tr></table>";
                                          echo "</td></tr>";
                                          
                                          }
                                          
                                          }
}

echo "<tr><td>";

//if (isset($category_empty_all) && $category_empty_all != 1) { echo "Categor&iacute;a vacia"; }
if (isset($category_empty) && $category_empty == 1) {

if (isset($subcategory)) {
echo "** Subcategoria: <b>".$subcategory."</b><br>";

                                           //vigilar:
                                           if (isset($subcategories) && !isset($show_subcategories_before)) {

                                           if (!isset($subcategory)) { echo "[ <b>Todas</b> ]: "; }

                                           else {
                                           if(SID) {
                                           echo "<a href=\"".$products_file."?category=".urlencode($category)."&".SID."\" title=\"Todas\">Todas</a>: ";
                                           } else {
                                           echo "<a href=\"".$products_file."?category=".urlencode($category)."\" title=\"Todas\">Todas</a>: ";
                                           }
                                          
                                           foreach ($subcategories as $show_subcategories) {
                                                                                      
                                           if (isset($subcategory) && $show_subcategories == $subcategory) {
                                           echo "[ <b>" . trim($show_subcategories) . "</b> ] ";
                                           } else {
                                           if(SID) {
                                           //Vigilancia:
                                           echo "<a href=\"".$products_file."?category=".urlencode($category)."&subcategory=".urlencode($show_subcategories)."&".SID."\" title=\"".trim($show_subcategories)." (".$category.")\">" . trim($show_subcategories) . "</a> ";
                                           } else {
                                           echo "<a href=\"".$products_file."?category=".urlencode($category)."&subcategory=".urlencode($show_subcategories)."\" title=\"".trim($show_subcategories)." (".$category.")\">" . trim($show_subcategories) . "</a> ";
                                           }
                                           }

                                           }
                                           $show_subcategories_before = "yes";
                                           }

}
                                           //fin de vigilar.
                                           

echo "<br><br>** [ Subcategor&iacute;a vacia ]<br>";

} else {

//echo "** Todas las subcategorias:<br>";
//if (!isset($category) || $category != "all") { echo "** Todas las subcategorias:<br>"; }
if (!isset($category) || $category != "all" && $category != $supply_category) { echo "** Todas las subcategorias:<br>"; }

         if (isset($subcategories) && !isset($show_subcategories_before)) {

//             if (!isset($subcategory)) { echo "[ <b>Todas</b> ]: ";
             if (!isset($subcategory)) { echo "[ <b>Todas</b> ] ";
                $subcategories_plain = implode ($subcategories);
                if (is_array($subcategories) && sizeof($subcategories) >= 1 && trim($subcategories_plain) != "") { echo ": "; }
//                echo $subcategories_plain;

                                           
                  foreach ($subcategories as $show_subcategories) {
                           if(SID) {
                           //Vigilancia:
                           echo "<a href=\"".$products_file."?category=".urlencode($category)."&subcategory=".urlencode($show_subcategories)."&".SID."\" title=\"".trim($show_subcategories)." (".$category.")\">" . trim($show_subcategories) . "</a> ";
                           } else {
                           echo "<a href=\"".$products_file."?category=".urlencode($category)."&subcategory=".urlencode($show_subcategories)."\" title=\"".trim($show_subcategories)." (".$category.")\">" . trim($show_subcategories) . "</a> ";
                           }
                   }



                                           $show_subcategories_before = "yes";
                                           }

}
                                           //fin de vigilar.

//echo "<br><br>* [ Categor&iacute;a vacia ]<br>";
//if (!isset($category) || $category != "all") { echo "<br><br>* [ Categor&iacute;a vacia ]<br>"; }
if (!isset($category) || $category != "all") {
if (isset($supply_category) && $supply_category != $category || !isset($supply_category)) { echo "<br>"; }
echo "<br>* [ Categor&iacute;a vacia ]<br>";
}

}

}

//if (isset($category_empty_all) && $category_empty_all == 1) { echo "Categor&iacute;a vacia"; }

if (isset($search) && $search != "" && !isset($product_search)) {
echo "<b>la b&uacute;squeda no produjo ning&uacute;n resultado</b><br>";
}

echo "<br>*** Fin del listado ***<br><br>";

echo "</td></tr></table>";


}

else {
//Listar menu con categorias y subcategorias existentes.
?>


<?php
echo "Lista con categorias y subcategorias existentes: <br><br>";

$category_empty = 0;

//$category_empty_all = 0;


if ($menu_list_all_option == "on" && $products_file != "" && isset($products_file)) {
if (SID) {
echo "<a href=\"".$products_file."?category=all&".SID."\" title=\"Ver todos\">Ver todos</a><br>";
} else {
echo "<a href=\"".$products_file."?category=all\" title=\"Ver todas\">Ver todos</a><br>";
}
}

//Creando menu:

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
                                 

//                                 echo "<br><a href=\"".$products_file."?category=".urlencode($category_subcategory)."\">".$category_subcategory."</a><br>";

                                 if (isset($supply_category) && $category_subcategory == $supply_category) {
                                 
//                                 echo "[ <a href=\"".$products_file."?category=".$supply_category."\">Ver ofertas</a> ]<br>";
                                 if (SID) {
                                 echo "<br><a href=\"".$products_file."?category=".urlencode($category_subcategory)."&".SID."\" title=\"".$category_subcategory."\"><b>".$category_subcategory."</b></a><b>:</b><br>";
                                 } else {
                                 echo "<br><a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\"><b>".$category_subcategory."</b></a><b>:</b><br>";
                                 }
                                 
                                 } else {
                                 
                                 if (SID) {
                                 echo "<br><a href=\"".$products_file."?category=".urlencode($category_subcategory)."&".SID."\" title=\"".$category_subcategory."\">".$category_subcategory."</a>";
                                 } else {
                                 echo "<br><a href=\"".$products_file."?category=".urlencode($category_subcategory)."\" title=\"".$category_subcategory."\">".$category_subcategory."</a>";
                                 }

                                 if (!isset($category_separated[1]) || trim($category_separated[1]) != "") {
                                 echo ":<br>";
                                 } else {
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
                                 
                                 if (isset($supply_category) && trim($category_separated[0]) == $supply_category) {
                                 
                                                                  
                                 if (SID) {
                                 echo "[ <a href=\"".$products_file."?category=".urlencode($supply_category)."&".SID."\" title=\"Ver ofertas\">Ver ofertas</a> ]<br>";
                                 } else {
                                 echo "[ <a href=\"".$products_file."?category=".urlencode($supply_category)."\" title=\"Ver ofertas\">Ver ofertas</a> ]<br>";
                                 }
                                 
                                 } else {

                                 if (isset($subcategory_real) && trim($subcategory_real) != "") {
                                         if (SID) {                                 
                                         echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."&subcategory=".urlencode($subcategory_real)."&".SID."\" title=\"".$subcategory_real . " (".$category_separated[0].")\">".$subcategory_real."</a><br>";
                                         } else {
                                         echo "* <a href=\"".$products_file."?category=".urlencode($category_separated[0])."&subcategory=".urlencode($subcategory_real)."\" title=\"".$subcategory_real . " (".$category_separated[0].")\">".$subcategory_real."</a><br>";
                                         }
                                 }
                                         
                                         }

                                 }
                                 
if(isset($category_empty) && $category_empty == 1) { echo "<br>"; }

                                 }

                              $x++;
                            
                              }

                              
                       }     

                      }

//                              if ($product_ref && $product_img_path && $product_name && $product_category && $product_subcategory && $product_price && $product_description ) {

}

echo "<br>";

}


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
