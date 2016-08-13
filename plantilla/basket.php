<?php

session_name('basket');
session_start('basket');

//4081

//echo "Sesion: ".$_SESSION["process_send_text"]."<br>";
//echo "Get: ".$_GET["process_send_text"]."<br>";

$this_file = "basket.php";

if (file_exists("config.txt")) { include "config.txt"; }
//else { require $index_file; }

//if (file_exists($money_file)) {
//include $money_file;
//} else {
//include "money.txt";
//}


//Se establece el limite maximo de ejecucion (solo tiene efecto si no esta en safe-mode:
if (isset($set_time_limit) && $set_time_limit != "" && is_numeric($set_time_limit)) { set_time_limit($set_time_limit); }




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




if (file_exists($money_file)) {
include $money_file;
}

if (isset($product_money) && $product_money != "EUR" && $product_money != "USD") { $product_money = "EUR"; }

if (isset($basket_dot_is_dec) && $basket_dot_is_dec == "off" && isset($_GET['quantity'])) {
$_GET['quantity'] = str_replace(".", "", $_GET['quantity']);
}

//if (isset($basket_allow_decs) && $basket_allow_decs == "on" && isset($_GET['quantity'])) {
if (isset($money_dec_symbol) && $money_dec_symbol != "" && isset($_GET['quantity'])) {
$_GET['quantity'] = str_replace($money_dec_symbol, ".", $_GET['quantity']);
}
//}

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
if (isset($_GET['quantity'])) { $quantity = $_GET['quantity']; if($quantity == "") { $_GET['quantity'] = "0"; $quantity = "0"; } }
if (isset($_GET['quantity_mod'])) { $quantity_mod = $_GET['quantity_mod']; }
}


$change_resolution_page = "?change_resolution=ok";

$last_page_visited_vars = $_GET;

$last_page_visited_vars_x = 0;

if (isset($last_page_visited_vars) && $last_page_visited_vars != "") {

foreach ($last_page_visited_vars as $last_page_visited_vars_separated => $last_page_visited_vars_separated_result) {

if (trim(urlencode($last_page_visited_vars_separated)) != "change_resolution" && trim(urlencode($last_page_visited_vars_separated)) != "table_width_var" && trim(urlencode($last_page_visited_vars_separated)) != session_name() && trim(urlencode($last_page_visited_vars_separated)) != "act" && trim(urlencode($last_page_visited_vars_separated)) != "ref" && trim(urlencode($last_page_visited_vars_separated)) != "quantity") {
$change_resolution_page .= "&" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));
}

}

$last_page_visited_vars_x ++;
}


//echo urldecode($change_resolution_page);

if (!isset($_SESSION['change_resolution_page_session'])) { $_SESSION['change_resolution_page_session'] = $change_resolution_page; }

if (!isset($products_file) || $products_file == "") { $products_file = "products.php"; }

if (!isset($basket_file) || $basket_file == "") { $basket_file = $this_file; }

if (!isset($basket_edit_button) || $basket_edit_button == "") { 
$basket_edit_button = "Editar"; 
}

if (!isset($basket_delete_button) || $basket_delete_button == "") {
$basket_delete_button = "Borrar";
}

if (!isset($_SESSION['basket_quantity'])) { $_SESSION['basket_quantity'] = array(); }
if (!isset($_SESSION['basket_ref'])) { $_SESSION['basket_ref'] = array(); }
if (!isset($_SESSION['basket_img_path'])) { $_SESSION['basket_img_path'] = array(); }
if (!isset($_SESSION['basket_name'])) { $_SESSION['basket_name'] = array(); }
if (!isset($_SESSION['basket_category'])) { $_SESSION['basket_category'] = array(); }
if (!isset($_SESSION['basket_subcategory'])) { $_SESSION['basket_subcategory'] = array(); }
if (!isset($_SESSION['basket_price'])) { $_SESSION['basket_price'] = array(); }
if (!isset($_SESSION['basket_description'])) { $_SESSION['basket_description'] = array(); }

if (isset($_SESSION['prod_mod'])) { unset($_SESSION['prod_mod']); }

if (isset($supply_category)) { $supply_category = trim($supply_category); }


//Conversor de monedas:

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



//Comprobar la existencia de las variables en config.txt:
if (!isset($background) && !isset($bgcolor)) { $bgcolor = "#aaaadd"; $background = "off"; } 
if (!isset($font_color)) { $font_color = "#333333"; }
if (!isset($font_color_title)) { $font_color_title = "#aa0000"; }
if (!isset($font_size)) { $font_size = "4"; }
if (!isset($font_size_title)) { $font_color = "2"; }



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

if ($table_width == $page_width_less_than_640x480) { $basket_table_width = $basket_table_width_less_than_640x480; }
if ($table_width == $page_width_640x480) { $basket_table_width = $basket_table_width_640x480; }
if ($table_width == $page_width_800x600) { $basket_table_width = $basket_table_width_800x600; }
if ($table_width == $page_width_1024x768) { $basket_table_width = $basket_table_width_1024x768; }
if ($table_width == $page_width_1280x1024) { $basket_table_width = $basket_table_width_1280x1024; }
if ($table_width == $page_width_more_than_1280x1024) { $basket_table_width = $basket_table_width_more_than_1280x1024; }

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

}





//Pedido:





//Calculamos si la cesta esta vacia:

$basket_send_is_empty = "yes";

if (isset($_SESSION['basket_ref'])) {

foreach ($_SESSION['basket_ref'] as $ref_actual) {

if (isset($ref_actual) && $_SESSION['basket_quantity'][$ref_actual] != "0") {

$basket_send_is_empty = "no";

}

}

}



if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
$basket_send_is_empty = "no";
}

if (isset($basket_send_is_empty) && $basket_send_is_empty == "yes" || !isset($basket_send_is_empty)) {
//if (isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {

unset($basket_send_is_empty);

if (isset($_GET['step']) && $_GET['step'] == "2") {
$_GET['step'] = "1";
}



//echo "Cesta vacia";

}





if (isset($_GET['manual']) && !isset($_GET['process']) || isset($_GET['manual']) && isset($_GET['process']) && $_GET['process'] != "ok") {
$_GET['process'] = "ok";
}

if (isset($_GET['step']) && !isset($_GET['process']) || isset($_GET['stepl']) && isset($_GET['process']) && $_GET['process'] != "ok") {
$_GET['process'] = "ok";
}

if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "off" || isset($_GET['manual']) && $_GET['manual'] == "ok" && !isset($user_can_send_order_manually)) {
$_GET['manual'] = "no";
//if (isset($_GET['step'])) { $_GET['step'] = "1"; }
}


if (!isset($_GET['step']) || isset($_GET['step']) && $_GET['step'] != "2" && $_GET['step'] != "3") {
$_GET['step'] = "1";
}

//Cuidadete:
//if (!isset($_GET['step']) && isset($_GET['manual']) && $_GET['manual'] == "ok" || isset($_GET['step']) && $_GET['step'] == "1" && isset($_GET['manual']) && $_GET['manual'] == "ok") {
//$_GET['step'] = "1";
//$_GET['manual'] = "no";
//}

//echo $_GET['manual'];


//Calcular datos enviados por el formulario de step=1, y si esta correcto hacer step=2 (kon  pertinentes) o si da error kambiar a step=1.
                         if (isset($_GET['process']) && $_GET['process'] == "ok") {
                         
                        
                         if (isset($_GET['step']) && $_GET['step'] == "2" || isset($_GET['step']) && $_GET['step'] == "3") {






//Calculamos si la cesta esta vacia:
$basket_send_is_empty = "yes";

if (isset($_SESSION['basket_ref'])) {

foreach ($_SESSION['basket_ref'] as $ref_actual) {

if (isset($ref_actual) && $_SESSION['basket_quantity'][$ref_actual] != "0") {

$basket_send_is_empty = "no";

}

}

}

if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
$basket_send_is_empty = "no";
}

if (isset($basket_send_is_empty) && $basket_send_is_empty == "yes" || !isset($basket_send_is_empty)) {

unset($basket_send_is_empty);

//echo "Cesta vacia";

//$_GET['step'] = 1;

} 




                         
                         //Segundo paso:
                         // Opcion de seguir comprando siempre.
                         // Si la cesta esta vacia: ir a step=1
                         // Se muestra cesta de compra y datos (boton editar para volver a step=1).
                         // Se muestran impuestos fuera de zona (si se ha seleccionado la casilla y si no se avisa por si a caso).

                         $process_form_errors = "";
                         $process_form_alerts = "";

if (!isset($_GET['additional_cost_outside'])) {
$_GET['additional_cost_outside'] = "off";
}


if (!isset($_GET['shipment'])) {
$_GET['shipment'] = "1";
}


if (!isset($_GET['payment'])) {
$_GET['payment'] = "1";
}


                         if (!isset($_GET['process_send_name']) || isset($_GET['process_send_name']) && trim($_GET['process_send_name']) == "") {
                         $_GET['step'] = "1";
                         $process_form_errors .= "<br>Falta rellenar el campo <b>Nombre</b>";
                         } 


                         if (!isset($_GET['process_send_address']) || isset($_GET['process_send_address']) && trim($_GET['process_send_address']) == "") {
                         $_GET['step'] = "1";
                         $process_form_errors .= "<br>Falta rellenar el campo <b>Direccion</b>";
                         } 


                         if (!isset($_GET['process_send_location']) || isset($_GET['process_send_location']) && trim($_GET['process_send_location']) == "") {
                         $_GET['step'] = "1";
                         $process_form_errors .= "<br>Falta rellenar el campo <b>Localidad</b>";
                         } 

                         if (!isset($_GET['process_send_cp']) || isset($_GET['process_send_cp']) && trim($_GET['process_send_cp']) == "") {
                         
                         if (isset($cp_is_requiered_to_order) && $cp_is_requiered_to_order != "off" | !isset($cp_is_requiered_to_order)) {

                         $_GET['step'] = "1";
                         $process_form_errors .= "<br>Falta rellenar el campo <b>Codigo Postal</b>";
                         
                         } elseif (isset($cp_is_requiered_to_order) && $cp_is_requiered_to_order == "off") {
                         $process_form_alerts .= "<br>Falta rellenar el campo <b>Codigo Postal</b>";
                         }

                         } 


                         if (!isset($_GET['process_send_country']) || isset($_GET['process_send_country']) && trim($_GET['process_send_country']) == "") {
                         $_GET['step'] = "1";
                         $process_form_errors .= "<br>Falta rellenar el campo <b>Pais</b>";
                         } 

//address, location, cp, country

                         if (!isset($_GET['process_send_email']) || isset($_GET['process_send_email']) && trim($_GET['process_send_email']) == "") {
//                         $_GET['step'] = "1";
//                         $process_form_errors .= "<br>No se introdujo <b>E-Mail</b>";
                         $process_form_alerts .= "<br>No se introdujo <b>E-Mail</b>";
                         } 

                         if (!isset($_GET['process_send_tel']) || isset($_GET['process_send_tel']) && trim($_GET['process_send_tel']) == "") {
//                         $_GET['step'] = "1";
//                         $process_form_errors .= "<br>No se introdujo <b>Telefono</b>";
                         $process_form_alerts .= "<br>No se introdujo <b>Telefono</b>";
                         } 

                         if (!isset($_GET['process_send_text']) || isset($_GET['process_send_text']) && trim($_GET['process_send_text']) == "") {

                         if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
                         $_GET['step'] = "1";
                         $process_form_errors .= "<br>Falta rellenar el campo <b>Pedido</b> (obligatorio en pedido manual)";
                         } else {
                         $process_form_alerts .= "<br>Falta rellenar el campo <b>Comentarios</b>";
                         }

                         } 
                        
                         if (isset($_GET['process_send_email']) && !ereg("^[^@ ]+@[^@ ]+.[^@ .]+$", $_GET['process_send_email']) && trim($_GET['process_send_email']) != "") {
                         $process_form_alerts .= "<br>El <b>E-Mail</b> introducido <b>podria no ser valido</b>";
                         }
                         
                         if (isset($_GET['process_send_tel']) && !is_numeric($_GET['process_send_tel']) && trim($_GET['process_send_tel']) != "") {
                         $process_form_alerts .= "<br>El <b>Telefono</b> introducido <b>no es numerico</b>";
                         }

                         if(isset($_GET['process_send_tel']) && trim($_GET['process_send_tel']) == "" && isset($_GET['process_send_email']) && trim($_GET['process_send_email']) == "" || !isset($_GET['process_send_tel']) && !isset($_GET['process_send_email'])) {

                         $process_form_errors .= "<br>Falta rellenar el campo <b>Telefono</b> o el de <b>E-Mail</b> (al menos uno de ellos es necesario)";
                                                  
                         $_GET['step'] = "1";
                         
                         }

                         if (isset($process_form_errors) && $process_form_errors == "") {

//                         echo "Step 2";

                         }
                       
                         
                         } elseif (isset($_GET['step']) && $_GET['step'] == "3") {

                         
                         //Tercer y ultimo paso:
                         // Comprobar si $_GET['type'] == "manual".
                         // Todo como en contacto:
                         // · Si todo es correcto, enviar E-Mail.
                         // · Si da error al enviar E-Mail, logear error y enviar E-Mail a $error_email.
                         // · Si da error al enviar E-Mail de error, logear.
                         // Utilizar anti-flood como en contacto.
                         // Enviar trace-route.
                         

//                         echo "Step 3";

                         }
                         
                         }




if (isset($doctype)) {
echo $doctype;
} else {
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


            <title><?php readfile($title_file); ?> - Cesta de Compra</title>

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
function zoom_img(image_zoom) {
<?php
if (SID) {
?>
//var load_zoom_window = window.open(escape(imagen_zoom) + '?<?php echo SID; ?>','_blank','scrollbars=yes,menubar=no,height=<?php echo $product_and_basket_popup_zoom_window_height; ?>,width=<?php echo $product_and_basket_popup_zoom_window_width; ?>,resizable=yes,toolbar=no,location=no,status=no');
var load_zoom_window = window.open(image_zoom + '?<?php echo SID; ?>','_blank','scrollbars=yes,menubar=no,height=<?php echo $product_and_basket_popup_zoom_window_height; ?>,width=<?php echo $product_and_basket_popup_zoom_window_width; ?>,resizable=yes,toolbar=no,location=no,status=no');
<?php
} else {
?>
//var load_zoom_window = window.open(escape(imagen_zoom),'_blank','scrollbars=yes,menubar=no,height=<?php echo $product_and_basket_popup_zoom_window_height; ?>,width=<?php echo $product_and_basket_popup_zoom_window_width; ?>,resizable=yes,toolbar=no,location=no,status=no');
var load_zoom_window = window.open(image_zoom,'_blank','scrollbars=yes,menubar=no,height=<?php echo $product_and_basket_popup_zoom_window_height; ?>,width=<?php echo $product_and_basket_popup_zoom_window_width; ?>,resizable=yes,toolbar=no,location=no,status=no');
<?php
}
?>
load_zoom_window.focus();
}

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
      <body text="<?php echo $basket_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
      <?php
      }
      if (isset($content_invert) && $content_invert == "on") {
         ?>
         <body text="<?php echo $basket_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;" dir="rtl"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
         <?php
         }
      } else {
             if ($general_bg{0} == "#") { 
                if (isset($content_invert) && $content_invert == "off") {
                ?>
                <body bgcolor="<?php echo $general_bg; ?>" text="<?php echo $basket_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                <?php
                }
                if (isset($content_invert) && $content_invert == "on") {
                ?>
                <body bgcolor="<?php echo $general_bg; ?>" text="<?php echo $basket_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;" dir="rtl"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                <?php
                }
                } else {
                       if (isset($content_invert) && $content_invert == "off") {
                       ?>
                       <body background="<?php echo $general_bg ?>" text="<?php echo $basket_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
                       <?php
                       }
                       if (isset($content_invert) && $content_invert == "on") {
                       ?>
                       <body background="<?php echo $general_bg ?>" text="<?php echo $basket_general_text ?>" link="<?php echo $general_link ?>" alink="<?php echo $general_alink ?>" vlink="<?php echo $general_vlink ?>" leftmargin="<?php echo $general_left_margin ?>" topmargin="<?php echo $general_top_margin ?>" marginwidth="<?php echo $general_margin_width ?>" marginheight="<?php echo $general_margin_height ?>" onLoad="window.defaultStatus='<?php readfile($title_file);?>&copy;'; return true;" dir="rtl"<?php if($bg_fixed == "on") { echo " bgproperties=\"fixed\">"; } else { echo ">"; }?>
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
             echo "<td width=\"" .$td_menu_width. "\" align=\"center\" valign=\"top\">";
      } else {
             if ($menu_bg{0} == "#") { 
             echo "<td width=\"".$td_menu_width."\" align=\"center\" valign=\"top\" bgcolor=\"$menu_bg\">";
                } else {
             echo "<td width=\"".$td_menu_width."\" align=\"center\" valign=\"top\" background=\"$menu_bg\">";
                       }
      }

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
<font color="<?php echo $font_color_little_title ?>" size="<?php echo $font_size_little_title ?>">
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


$category_content = file($category_file);

if (isset($menu_view_basket) && $menu_view_basket == "on") {



if (isset($_GET['process']) && $_GET['process'] != "ok" || !isset($_GET['process'])) {

echo "= [ <b>Mi cesta</b> ] =<br><br>";

} elseif (isset($_GET['process']) && $_GET['process'] == "ok") {









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


}

//}



if (isset($process_page) && $process_page == "on" && isset($process_file)) {
//if (!isset($contact_file) || $contact_file == "") { $contact_file == "contact.php"; }

//if ($this_file == $process_file) {
if ($this_file == $process_file && isset($_GET['process']) && $_GET['process'] == "ok") {

echo "= <b>Pedido</b> =<br><br>";

} else {

if (SID) {
echo "<a href=\"".$process_file."?process=ok&".SID."\" title=\"Realizar Pedido\" class=\"menu\" accesskey=\"p\"><b><u>P</u>edido</b></a><br><br>";
} else {
echo "<a href=\"".$process_file."?process=ok\" title=\"Realizar Pedido\" class=\"menu\" accesskey=\"p\"><b><u>P</u>edido</b></a><br><br>";
}
}
}


if ($menu_list_all_option == "on" && $products_file != "" && isset($products_file)) {

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
                                         
                                         if (isset($supply_category) && trim($category_separated[0]) != trim($supply_category) && trim($subcategory_real) != "") {
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

}

if (isset($contact_email) && $contact_email != "off" && isset($contact_file)) {
if ($contact_page == "on") {
if (SID) {
echo "<br><a href=\"".$contact_file."?".SID."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><b><u>C</u>ontacto</b></a><br><br>";
} else {
echo "<br><a href=\"".$contact_file."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><b><u>C</u>ontacto</b></a><br><br>";
}
} else {
echo "<br><a href=\"mailto:".$contact_email."\" title=\"".$contact_email."\" class=\"menu\" accesskey=\"c\"><b><u>C</u>ontacto</b></a><br><br>";
}
}

                       
                         
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
                         ?>
                         <table width="<?php echo $td_body_width - $table_margin; ?>" border="0" align="center" valign="top" cellspacing="<?php echo $table_cellspacing; ?>" cellpadding="<?php echo $table_cellpadding; ?>">
                         <tr><td align="left" width="<?php echo $td_body_width - $table_margin; ?>">
                         <?php


//Fin del menu.


//Comienza basket:

//Add item:
if (isset($_GET) && isset($_GET['act']) && $_GET['act'] == "add" && isset($_GET['ref'])) {

$ref = urldecode($_GET['ref']);

if (isset($_GET['quantity'])) {

if ($_GET['quantity']{0} == ".") { $_GET['quantity'] = "0" . $_GET['quantity']; }

if (isset($basket_allow_decs) && $basket_allow_decs == "off") {
$quantity_array = explode(".", $_GET['quantity']);
$_GET['quantity'] = $quantity_array[0];

$_GET['quantity'] = trim(urldecode($_GET['quantity']));

if ($_GET['quantity'] > 0 && $_GET['quantity'] < 1) { $_GET['quantity'] = 1; }
}

if ($_GET['quantity'] < 0) { $_GET['quantity'] = 1; }
if ($_GET['quantity'] == 0 || $_GET['quantity'] == "") { $_GET['quantity'] = 1; }

}
if (isset($_SESSION['basket_quantity'][$ref]) && $_SESSION['basket_quantity'][$ref] != "0") {
//echo "El producto ya existe<br>";
if (isset($_GET['quantity']) && is_numeric($_GET['quantity'])) { $_SESSION['basket_quantity'][$ref] = $_SESSION['basket_quantity'][$ref] + $_GET['quantity']; }
//cuidado con esto:
else { $_SESSION['basket_quantity'][$ref] = $_SESSION['basket_quantity'][$ref] + 1; }
} else {
//echo "El producto no existia<br>";

if (is_numeric($_GET['quantity'])) { $_SESSION['basket_quantity'][$ref] = $_GET['quantity']; }
else { $_SESSION['basket_quantity'][$ref] = 1; }
}

}
//Fin de Add item.


//Editar o Borrar item:
if (isset($_GET) && isset($_GET['quantity_mod']) && isset($_GET['ref'])) {

$ref = urldecode($_GET['ref']);

if (isset($_GET['act']) && trim($_GET['act']) == trim($basket_delete_button)) {
//echo "se borraaaaaa: ";
//echo $_GET['quantity_mod'];

$_SESSION['basket_quantity'][$ref] = "0";

}

if(!isset($_GET['act']) || trim($_GET['act']) == trim($basket_edit_button)) {
//echo "se editaaaaaa: ";
//echo $_GET['quantity_mod'];

if (isset($basket_dot_is_dec) && $basket_dot_is_dec == "off") {
$_GET['quantity_mod'] = str_replace(".", "", $_GET['quantity_mod']);
}

if (isset($money_dec_symbol) && $money_dec_symbol != "") {
$_GET['quantity_mod'] = str_replace($money_dec_symbol, ".", $_GET['quantity_mod']);
}

if ($_GET['quantity_mod']{0} == ".") { $_GET['quantity_mod'] = "0" . $_GET['quantity_mod']; }

if (isset($basket_allow_decs) && $basket_allow_decs == "off") {

if (isset($_GET['quantity_mod']) && $_GET['quantity_mod'] > 0 && $_GET['quantity_mod'] < 1) { $_GET['quantity_mod'] = 1; unset($_SESSION['prod_mod']); }

$quantity_mod_array = explode(".", $_GET['quantity_mod']);
$_GET['quantity_mod'] = $quantity_mod_array[0];
}

$_GET['quantity_mod'] = trim(urldecode($_GET['quantity_mod']));

if (is_numeric($_GET['quantity_mod']) && $_GET['quantity_mod'] != $_SESSION['basket_quantity'][$ref] && $_GET['quantity_mod'] >= 0) {
$_SESSION['prod_mod'] = $ref;

$_SESSION['basket_quantity'][$ref] = $_GET['quantity_mod'];

}

}

}
//Fin de Editar o Borrar item.


//Depuracion de variables:
//echo "<br><br><br>";

//if(isset($_GET)) { print_r($_GET); }
//echo "<br><br>";
//if(isset($_POST)) { print_r($_POST); }
//echo "<br><br>";
//if(isset($_SESSION)) { print_r($_SESSION); }

echo "<br>";
//Fin de depuracion de variables.



//Se muestra la tabla:
if (isset($_SESSION['basket_ref'])) {


                         if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok" || !isset($user_can_send_order_manually) || $user_can_send_order_manually == "off") {


                         if (isset($_GET['step']) && $_GET['step'] == "1" || !isset($_GET['step']) || isset($_GET['step']) && $_GET['step'] != "2" && $_GET['step'] != "3" || !isset($_GET['process'])) {

//                         if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok" || !isset($user_can_send_order_manually) || $user_can_send_order_manually != "off") {

                         
//                         if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
                         

                         //La cesta de compra esta vacia (comprobarlo!), se muestra opcion manual (si $user_can_send_order_manually == "on"):
                         // Formulario tipo AlbaPatchowork.com
                         // Enviar a ?step=3&type=manual

//                         echo "Step 1 manual";

//                         } elseif (!isset($process_form_errors) || isset($process_form_errors) && $process_form_errors == "") {
                         if (!isset($process_form_errors) || isset($process_form_errors) && $process_form_errors == "") {

                         
                         //Primer paso:
                         // Opcion de seguir comprando siempre.
                         // Si esta vacia la cesta de compra, mostrar opcion manual (enlace a $this_file?step=1&basket=void) (si $user_can_send_order_manually == "on").
                         // Si la cesta no esta vacia:
                         // · Enseñar cesta de compra (sin poder modificarla, aunque con una opcion de modificarla: enlace a basket_file).
                         // · Poner formulario para rellenar (rellenado automatico si ya existen variables de sesion del form de contacto).
                         // · Casilla de impuestos fuera de zona (se debe marcar para sumar el impuesto).


                         if (isset($_GET['step']) && $_GET['step'] == "1" || !isset($_GET['step']) || isset($_GET['step']) && $_GET['step'] != "2" && $_GET['step'] != "3") {

                         if (isset($_GET['process']) && $_GET['process'] == "ok") {

//                         echo "Step 1<br>";
                         
                         }
                         
                         }





//echo "<br>";
if (!isset($_GET['process']) || isset($_GET['process']) && $_GET['process'] != "ok") {

if (isset($_SESSION['last_page_visited']) && $_SESSION['last_page_visited'] != "") {
   echo "<a href=\"".$_SESSION['last_page_visited']."\">Seguir comprando</a>";
   } else {
          if (isset($products_file) && $products_file != "") {

             if (SID) {
             echo "<a href=\"".$products_file."?category=all&".SID."\">Seguir comprando</a>";
             } else {
             echo "<a href=\"".$products_file."?category=all\">Seguir comprando</a>";
             }

          } else {
                 if (SID) {
                 echo "<a href=\"products.php?category=all&".SID."\">Seguir comprando</a>";
                 } else {
                 echo "<a href=\"products.php?category=all\">Seguir comprando</a>";
                 }

          }
//Cuidao:

     }

//}

                         
if (isset($process_file)) {

   if (SID) {
   echo " - <a href=\"".$this_file."?process=ok&".SID."\">Realizar compra</a>";
   } else {
   echo " - <a href=\"".$this_file."?process=ok\">Realizar compra</a>";
   }

} else {
  if (SID) {
     echo " - <a href=\"basket.php?process=ok&".SID."\">Realizar compra</a>";
     } else {
     echo " - <a href=\"basket.php?process=ok\">Realizar compra</a>";
     }

//Cuidao:
}


echo "<br><br><br>";

}


//Pedido:

                         if (isset($_GET['process']) && $_GET['process'] == "ok") {
                         



                         if (isset($_GET['step']) && $_GET['step'] == "1" || !isset($_GET['step']) || isset($_GET['step']) && $_GET['step'] != "2" && $_GET['step'] != "3") {






                         

                         //La cesta de compra esta vacia (comprobarlo!), se muestra opcion manual (si $user_can_send_order_manually == "on"):
                         // Formulario tipo AlbaPatchowork.com
                         // Enviar a ?step=3&type=manual

//                         echo "Step 1 manual";

//                         } else {

                         //Primer paso:
                         // Opcion de seguir comprando siempre.
                         // Si esta vacia la cesta de compra, mostrar opcion manual (enlace a $this_file?step=1&basket=void) (si $user_can_send_order_manually == "on").
                         // Si la cesta no esta vacia:
                         // · Enseñar cesta de compra (sin poder modificarla, aunque con una opcion de modificarla: enlace a basket_file).
                         // · Poner formulario para rellenar (rellenado automatico si ya existen variables de sesion del form de contacto).
                         // · Casilla de impuestos fuera de zona (se debe marcar para sumar el impuesto).



//echo "Opcion de seguir comprando y de modificar tabla";


//Calculamos si la cesta esta vacia:
$basket_send_is_empty = "yes";

if (isset($_SESSION['basket_ref'])) {

foreach ($_SESSION['basket_ref'] as $ref_actual) {

if (isset($ref_actual) && $_SESSION['basket_quantity'][$ref_actual] != "0") {

$basket_send_is_empty = "no";

}

}

}

if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
$basket_send_is_empty = "no";
}

if (isset($basket_send_is_empty) && $basket_send_is_empty == "no") {
//if (isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {

unset($basket_send_is_empty);

if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok" || isset($user_can_send_order_manually) && $user_can_send_order_manually == "off" || !isset($user_can_send_order_manually)) {
//if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {


echo "Porfavor, asegurese de que el contenido de la cesta de compra es correcto y <b>rellene el <a href=\"#form\">formulario</a> de mas abajo</b>. Si lo desea, puede ";
if (SID) {
echo "<a href=\"".$basket_file."?".SID."\">modificar la cesta de compra</a>";
} else {
echo "<a href=\"".$basket_file."\">modificar la cesta de compra</a>";
}

echo "<br><br>";

}


}








//}

}

}





//echo "<center>";

//echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">";
echo "<table width=\"".$basket_table_width."\" border=\"".$basket_table_border."\" cellspacing=\"".$basket_table_cellspacing."\" cellpadding=\"".$basket_table_cellpadding."\" bordercolordark=\"".$basket_table_border_color_dark."\" bordercolorlight=\"".$basket_table_border_color_light."\" bordercolor=\"".$basket_table_border_color."\" style=\"border: ".$basket_table_border_css."px solid ".$basket_table_border_color."\">";

echo "<tr><td align=\"left\">";

//echo "<center>";
echo "<table border=\"0\" cellspacing=\"".$basket_table_cellspacing."\" cellpadding=\"".$basket_table_cellpadding."\">";
echo "<tr><td align=\"left\">";
echo "<b>Cesta de compra:</b>";
echo "</td></tr></table>";

echo "</td></tr>";
echo "<tr><td align=\"left\">";
//echo "<center>";

echo "<table width=\"".$basket_table_width."\" border=\"".$basket_table_border."\" cellspacing=\"".$basket_table_cellspacing."\" cellpadding=\"".$basket_table_cellpadding."\" bordercolordark=\"".$basket_table_border_color_dark."\" bordercolorlight=\"".$basket_table_border_color_light."\" bordercolor=\"".$basket_table_border_color."\" style=\"border: ".$basket_table_border_css."px solid ".$basket_table_border_color."\">";

echo "<tr>";
echo "<td><font size=\"2\"><center>Ref.</center></font></td>";
echo "<td><font size=\"2\"><center>Foto</center></font></td>";
echo "<td><font size=\"2\"><center>Nombre</center></font></td>";
//echo "<td><font size=\"2\"><center>Desc.</center></font></td>";
echo "<td><font size=\"2\"><center>Clas.</center></font></td>";
echo "<td><font size=\"2\"><center>PVP</center></font></td>";
echo "<td><font size=\"2\"><center>PVP x Cantidad</center></font></td>";
echo "<td><font size=\"2\"><center>Cantidad</center></font></td>";
echo "</tr>";

$_SESSION['total_price'] = 0;

foreach ($_SESSION['basket_ref'] as $ref_actual) {

if (isset($ref_actual) && $_SESSION['basket_quantity'][$ref_actual] != "0") {

$basket_empty = "off";

echo "<tr>";
echo "<td valign=\"middle\"><font size=\"2\"><center><b>".nl2br(wordwrap($ref_actual,  4, "<br>", 1))."</b></center></font></td>";

echo "<td valign=\"middle\"><font size=\"2\"><center>";


if ($_SESSION['basket_img_path'][$ref_actual] == "auto") {

   if (file_exists($product_and_basket_img_zoom_path . strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])). "" . $product_img_auto_extension)) {
      if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {
      echo "<a href=\"javascript:zoom_img('".$product_and_basket_img_zoom_path . strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])). "" . $product_img_auto_extension."');\">";
      } else {
        if (SID) {
        echo "<a href=\"".$product_and_basket_img_zoom_path . rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension. "?" . SID . "\" target=\"_blank\">";
        } else {
        echo "<a href=\"".$product_and_basket_img_zoom_path . rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension."\" target=\"_blank\">";
        }
        }
   }

      elseif (file_exists($product_img_auto_path . strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])). "" . $product_img_auto_extension)) {
             if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {
             echo "<a href=\"javascript:zoom_img('".$product_img_auto_path . strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])). "" . $product_img_auto_extension."');\">";
             } else {
               if (SID) {
               echo "<a href=\"".$product_img_auto_path . rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension."?" . SID . "\" target=\"_blank\">";
               } else {
               echo "<a href=\"".$product_img_auto_path . rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension."\" target=\"_blank\">";
               }
               }
      }


      elseif (file_exists(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])) . "" . $product_img_auto_extension)) {

             if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {
             echo "<a href=\"javascript:zoom_img('".strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])). "" . $product_img_auto_extension."');\">";
             } else {
               if (SID) {
               echo "<a href=\"".rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension."?" . SID . "\" target=\"_blank\">";
               } else {
               echo "<a href=\"".rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension."\" target=\"_blank\">";
               }
               }
      }


      elseif (file_exists($basket_img_auto_path ."". strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])) . "" . $product_img_auto_extension)) {
             if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {
             echo "<a href=\"javascript:zoom_img('".$basket_img_auto_path . strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])). "" . $product_img_auto_extension."');\">";
             } else {
               if (SID) {
               echo "<a href=\"".$basket_img_auto_path . rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension."?" . SID . "\" target=\"_blank\">";
               } else {
               echo "<a href=\"".$basket_img_auto_path . rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension."\" target=\"_blank\">";
               }

               }

      }
//}

  //    else {
     //      if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {
       //    echo "<a href=\"javascript:zoom_img('".$basket_img_auto_path . $_SESSION['basket_ref'][$ref_actual]. "" . $product_img_auto_extension."');\">";
         //  } else {
           //  echo "<a href=\"".$basket_img_auto_path . $_SESSION['basket_ref'][$ref_actual]. "" . $product_img_auto_extension."\" target=\"_blank\">";
          // }
//echo $_SESSION['basket_img_path'][$ref_actual];          
    //  }

//}

//echo "<img src=\"".$basket_img_auto_path . $_SESSION['basket_ref'][$ref_actual]. "" . $product_img_auto_extension . "\" width=\"".$basket_img_width."\" height=\"".$basket_img_height."\" alt=\"".$_SESSION['basket_name'][$ref_actual]."\" title=\"".$_SESSION['basket_name'][$ref_actual]."\" hspace=\"0\" vspace=\"0\">";
//}


if (file_exists($basket_img_auto_path . strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])). "" . $product_img_auto_extension)) {
echo "<img src=\"".$basket_img_auto_path . rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension . "\" width=\"".$basket_img_width."\" height=\"".$basket_img_height."\" alt=\"".$_SESSION['basket_name'][$ref_actual]."\" title=\"".$_SESSION['basket_name'][$ref_actual]."\" border=\"1\" hspace=\"0\" vspace=\"0\">";
echo "<br>ampliar</a>";
}
elseif (file_exists($product_img_auto_path . strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])) . "" . $product_img_auto_extension)) {
echo "<img src=\"".$product_img_auto_path . rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))). "" . $product_img_auto_extension . "\" width=\"".$basket_img_width."\" height=\"".$basket_img_height."\" alt=\"".$_SESSION['basket_name'][$ref_actual]."\" title=\"".$_SESSION['basket_name'][$ref_actual]."\" border=\"1\" hspace=\"0\" vspace=\"0\">";
echo "<br>ampliar</a>";
}
elseif (file_exists(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])) . "" . $product_img_auto_extension)) {
echo "<img src=\"".rawurlencode(strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual]))) . "" . $product_img_auto_extension . "\" width=\"".$basket_img_width."\" height=\"".$basket_img_height."\" alt=\"".$_SESSION['basket_name'][$ref_actual]."\" title=\"".$_SESSION['basket_name'][$ref_actual]."\" border=\"1\" hspace=\"0\" vspace=\"0\">";
echo "<br>ampliar</a>";
}
else {
echo strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])) . $product_img_auto_extension;

if (file_exists($product_and_basket_img_zoom_path . strtolower(str_replace("-", "_", $_SESSION['basket_ref'][$ref_actual])). "" . $product_img_auto_extension)) {
echo "</a>";
}

}


} 

//else {
//echo $_SESSION['basket_img_path'][$ref_actual];
//}


//}

elseif ($_SESSION['basket_img_path'][$ref_actual] != "auto") {

if (file_exists($product_and_basket_img_zoom_path . $_SESSION['basket_img_path'][$ref_actual])) {
   if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {
       echo "<a href=\"javascript:zoom_img('". $product_and_basket_img_zoom_path . $_SESSION['basket_img_path'][$ref_actual] ."');\">";
       } else {
       if (SID) {
       echo "<a href=\"" . $product_and_basket_img_zoom_path . $_SESSION['basket_img_path'][$ref_actual] . "?" . SID .  "\" target=\"_blank\">";
       } else {
       echo "<a href=\"" . $product_and_basket_img_zoom_path . $_SESSION['basket_img_path'][$ref_actual] . "\" target=\"_blank\">";
       }
       }
}

elseif (file_exists($_SESSION['basket_img_path'][$ref_actual])) {
       if (isset($_SESSION['javascript_support']) && $_SESSION['javascript_support'] == 'enabled' && isset($javascript_detect) && $javascript_detect == "on") {
       echo "<a href=\"javascript:zoom_img('". $_SESSION['basket_img_path'][$ref_actual]."');\">";
       } else {
       if (SID) {
       echo "<a href=\"" . $_SESSION['basket_img_path'][$ref_actual] . "?" . SID . "\" target=\"_blank\">";
       } else {
       echo "<a href=\"" . $_SESSION['basket_img_path'][$ref_actual] . "\" target=\"_blank\">";
       }
       }
}


if (file_exists($basket_img_auto_path . $_SESSION['basket_img_path'][$ref_actual])) {
   echo "<img src=\"".$basket_img_auto_path . $_SESSION['basket_img_path'][$ref_actual]."\" width=\"".$basket_img_width."\" height=\"".$basket_img_height."\" alt=\"".$_SESSION['basket_name'][$ref_actual]."\" title=\"".$_SESSION['basket_name'][$ref_actual]."\" border=\"1\" hspace=\"0\" vspace=\"0\">";
   echo "<br>ampliar</a>";
}


elseif (file_exists($_SESSION['basket_img_path'][$ref_actual])) {
       echo "<img src=\"". $_SESSION['basket_img_path'][$ref_actual] ."\" width=\"".$basket_img_width."\" height=\"".$basket_img_height."\" alt=\"".$_SESSION['basket_name'][$ref_actual]."\" title=\"".$_SESSION['basket_name'][$ref_actual]."\" border=\"1\" hspace=\"0\" vspace=\"0\">";
       echo "<br>ampliar</a>";
}


//elseif (file_exists($product_and_basket_img_zoom_path . $_SESSION['basket_img_path'][$ref_actual])) {
  //     echo "<img src=\"".$product_and_basket_img_zoom_path . $_SESSION['basket_img_path'][$ref_actual]."\" width=\"".$basket_img_width."\" height=\"".$basket_img_height."\" alt=\"".$_SESSION['basket_name'][$ref_actual]."\" title=\"".$_SESSION['basket_name'][$ref_actual]."\" border=\"1\" hspace=\"0\" vspace=\"0\">";
    //   echo "<br>ampliar</a>";
//}

else {
     echo $_SESSION['basket_img_path'][$ref_actual];
if (file_exists($product_and_basket_img_zoom_path . $_SESSION['basket_img_path'][$ref_actual])) {
echo "</a>";
}
}

}


echo "</center></font></td>";

echo "<td valign=\"middle\"><font size=\"2\"><b>". nl2br(strip_tags($_SESSION['basket_name'][$ref_actual])) . "</b></font></td>";
//echo "<td valign=\"top\"><font size=\"2\"><i>".nl2br(strip_tags(wordwrap($_SESSION['basket_description'][$ref_actual], 9, "<br>", 1)))."</i></font></td>";
//echo "<td valign=\"top\"><font size=\"2\"><i>".nl2br(strip_tags($_SESSION['basket_description'][$ref_actual]))."</i></font></td>";

echo "<td valign=\"middle\"><font size=\"2\"><center>";

if (SID) {
echo "<a href=\"".$products_file."?category=".urlencode($_SESSION['basket_category'][$ref_actual])."&subcategory=".urlencode($_SESSION['basket_subcategory'][$ref_actual])."&".SID."\" title=\"".$_SESSION['basket_category'][$ref_actual]." (".$_SESSION['basket_subcategory'][$ref_actual].")\">".nl2br(wordwrap($_SESSION['basket_subcategory'][$ref_actual], 11, "<br>", 1))."</a>";
echo "<br>(<a href=\"".$products_file."?category=".urlencode($_SESSION['basket_category'][$ref_actual])."&".SID."\" title=\"".$_SESSION['basket_category'][$ref_actual]."\">".nl2br(wordwrap($_SESSION['basket_category'][$ref_actual], 11, "<br>", 1))."</a>)";
} else {
echo "<a href=\"".$products_file."?category=".urlencode($_SESSION['basket_category'][$ref_actual])."&subcategory=".urlencode($_SESSION['basket_subcategory'][$ref_actual])."\" title=\"".$_SESSION['basket_category'][$ref_actual]." (".$_SESSION['basket_subcategory'][$ref_actual].")\">".nl2br(wordwrap($_SESSION['basket_subcategory'][$ref_actual], 11, "<br>", 1))."</a>";
echo "<br>(<a href=\"".$products_file."?category=".urlencode($_SESSION['basket_category'][$ref_actual])."\" title=\"".$_SESSION['basket_category'][$ref_actual]."\">".nl2br(wordwrap($_SESSION['basket_category'][$ref_actual], 11, "<br>", 1))."</a>)";
}

echo "</center></font></td>";

echo "<td valign=\"middle\">";
echo "<font size=\"2\">";

if (isset($_SESSION['product_basket_supply'][$ref_actual]) && $_SESSION['product_basket_supply'][$ref_actual] == "yes") {
echo "<center><b><i>Oferta</i></b></center><br>";
}

//echo $_SESSION['basket_price'][$ref_actual];

//echo "<b>".nl2br(number_format($_SESSION['basket_price'][$ref_actual], $money_dec, $money_dec_symbol, $money_miles_symbol));


                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b>".$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "<br><b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";

                                           $money_eur_represent = "<br><b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b>".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual], 2, ",", "."), 10, "<br>", 1)."</b>".$money_default;
                                           } else {
                                           echo "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual], 2, ",", "."), 10, "<br>", 1)."</b> EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor



//echo "<br><br>";

//echo "(" . number_format($_SESSION['basket_price'][$ref_actual], $money_dec, $money_dec_symbol, $money_miles_symbol)." x ".$_SESSION['basket_quantity'][$ref_actual]." = ". number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual], $money_dec, $money_dec_symbol, $money_miles_symbol) . ")";

//echo "(" . nl2br(wordwrap(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual], $money_dec, $money_dec_symbol, $money_miles_symbol),  5, "<br>", 1)) . ")";

//echo "<br>";
//echo "</td>";
//echo "<td>";
//echo $_SESSION['basket_price'][$ref_actual]." x ".$_SESSION['basket_quantity'][$ref_actual]." = ". $_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual];
echo "</font>";
echo "</td>";

echo "<td valign=\"middle\">";
echo "<font size=\"2\">";

//echo "<b>".nl2br(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual], $money_dec, $money_dec_symbol, $money_miles_symbol))."</b>";


                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b>".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "<br><b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = "<br><b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b>".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b>".$money_default;
    //                                       } else {
      //                                     echo "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1)."</b> EUR<br>";
        //                                   }
        
                                                   if (isset($money_default)) {
                                           echo "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual], 2, ",", "."), 10, "<br>", 1)."</b>".$money_default;
                                           } else {
                                           echo "<b>".wordwrap(number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual], 2, ",", "."), 10, "<br>", 1)."</b> EUR";
                                           }

                                           }


                                           //Fin de la opcion del conversor


echo "</font>";
echo "</td>";

$_SESSION['total_price'] = $_SESSION['total_price'] + $_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual];

?>
<td>

<center>

<?php

                         if (isset($_GET['process']) && $_GET['process'] == "ok") {
                         
                         if (isset($_GET['step']) && $_GET['step'] == "1" || !isset($_GET['step']) || isset($_GET['step']) && $_GET['step'] != "2" && $_GET['step'] != "3") {
                         

                         if (isset($_SESSION['basket_quantity'][$ref_actual]) && $_SESSION['basket_quantity'][$ref_actual] != "") {
                         echo "<b>".$_SESSION['basket_quantity'][$ref_actual]."</b>";
                         }

                         }
                         
                         } else {

?>


<table cellspacing="0" cellpadding="0" border="1">

<tr><td align="center" valign="middle">

<form method="get" action="<?php echo $basket_file; ?>" style="display:inline;">

<input type="hidden" name="ref" value="<?php echo $ref_actual; ?>">


<input type="text" name="quantity_mod" value="<?php if (isset($money_dec_symbol) && $money_dec_symbol != "") { echo str_replace(".", $money_dec_symbol, $_SESSION['basket_quantity'][$ref_actual]); } else { echo $_SESSION['basket_quantity'][$ref_actual]; } ?>" size="6" title="Cantidad del producto"><br><input type="submit" value="<?php echo $basket_edit_button ?>" name="act" title="Modificar cantidad del producto"><br><input type="submit" value="<?php echo $basket_delete_button; ?>" name="act" title="Eliminar producto"><br>

<?php
if (SID) {
?>
<input type="hidden" name="<?php echo session_name(); ?>" value="<?php echo session_id(); ?>">
<?php
}
?>
</form>


</td></tr>


<?php
if ( isset( $_SESSION['prod_mod'] ) && $ref_actual == $_SESSION['prod_mod'] ) {
echo "<tr><td><center><font size=\"2\"><b>modif.</b></font></center></td></tr>";
unset($_SESSION['prod_mod']);
}
?>

</table>

<?php

}

?>


</center>
</td>

<?php

echo "</tr>";
 }
}


echo "</table></center>";
echo "</td></tr>";


echo "<tr><td align=\"left\" valign=\"top\">";

//echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" align=\"left\">";

//echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";
echo "<table width=\"". $basket_table_width . "\" border=\"".$basket_table_border."\" cellspacing=\"".$basket_table_cellspacing."\" cellpadding=\"".$basket_table_cellpadding."\" bordercolordark=\"".$basket_table_border_color_dark."\" bordercolorlight=\"".$basket_table_border_color_light."\" bordercolor=\"".$basket_table_border_color."\" style=\"border: ".$basket_table_border_css."px solid ".$basket_table_border_color."\">";

//Vigilancia:
//echo "<tr><td valign=\"top\">";

//echo "<br>";

if (isset($_SESSION['total_price']) && $_SESSION['total_price'] > 0  ) {

//Vigilancia:
echo "<tr><td valign=\"top\" align=\"left\">";

echo "<b>Suma:</b><br>";
//echo "EUR ".number_format($_SESSION['total_price'], $money_dec, $money_dec_symbol, $money_miles_symbol) ."<br>";




                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($_SESSION['total_price'] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($_SESSION['total_price'] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
    //                                       } else {
      //                                     echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR<br>";
        //                                   }
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($_SESSION['total_price'], 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($_SESSION['total_price'], 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

        
                                           }


                                           //Fin de la opcion del conversor











//Aplicar descuentos a $_SESSION['total_price']:


if (isset($supply_on_total_money_requiered) && $supply_on_total_money_requiered != "off" && $supply_on_total_money_requiered != "") {

if (isset($_SESSION['total_price']) && $_SESSION['total_price'] > $supply_on_total_money_requiered) {

//echo "Cantidad requerida (".$supply_on_total_money_requiered.") superada. Se aplica descuento de: ".$supply_on_total_money_to_discount;

$_SESSION['total_price'] = $_SESSION['total_price'] - $supply_on_total_money_to_discount;

echo "<br><b>Descuento:</b><br>";




//echo "- ".$supply_on_total_money_to_discount."<br>";



                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
    //                                       } else {
      //                                     echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR<br>";
        //                                   }
                                           if (isset($money_default)) {
                                           echo "- ".wordwrap(number_format($supply_on_total_money_to_discount, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo "- ".wordwrap(number_format($supply_on_total_money_to_discount, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

        
                                           }


                                           //Fin de la opcion del conversor







if (isset($supply_on_total_money_requiered) && $supply_on_total_money_requiered == "0") {
//echo "(aplicamos este descuento a todos los pedidos)<br>";
} elseif (isset($supply_on_total_money_requiered) && $supply_on_total_money_requiered > 0) {
//echo "(hemos aplicado este descuento porque su compra superaba los: ".$supply_on_total_money_requiered.")<br>";
}

}

}


if (isset($supply_on_total_money_requiered_percent) && $supply_on_total_money_requiered_percent != "off" && $supply_on_total_money_requiered_percent != "") {

if (isset($_SESSION['total_price']) && $_SESSION['total_price'] > $supply_on_total_money_requiered_percent) {

//echo "Cantidad requerida (".$supply_on_total_money_requiered.") superada. Se aplica descuento de: ".$supply_on_total_money_to_discount;

echo "<br><b>Descuento (".$supply_on_total_money_to_discount_percent."%):</b><br>";

$supply_on_total_money_discount_percent_represent = ($_SESSION['total_price'] * $supply_on_total_money_to_discount_percent) / 100;

//Aplicamos descuento:
$_SESSION['total_price'] = $_SESSION['total_price'] - $supply_on_total_money_discount_percent_represent;


//$pene = 30 * 5 / 100;










//echo "- ".$supply_on_total_money_discount_percent_represent."<br>";



                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = "- ".wordwrap(number_format($supply_on_total_money_discount_percent_represent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "- ".wordwrap(number_format($supply_on_total_money_discount_percent_represent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = "- ".wordwrap(number_format($supply_on_total_money_discount_percent_represent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = "- ".wordwrap(number_format($supply_on_total_money_discount_percent_represent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
    //                                       } else {
      //                                     echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR<br>";
        //                                   }
                                           if (isset($money_default)) {
                                           echo "- ".wordwrap(number_format($supply_on_total_money_discount_percent_represent, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo "- ".wordwrap(number_format($supply_on_total_money_discount_percent_represent, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

        
                                           }


                                           //Fin de la opcion del conversor






unset($supply_on_total_money_discount_percent_represent);

//echo "(hemos aplicado este descuento porque su compra superaba los: ".$supply_on_total_money_requiered_percent.")<br>";

if (isset($supply_on_total_money_requiered_percent) && $supply_on_total_money_requiered_percent == "0") {
//echo "(aplicamos este descuento a todos los pedidos)<br>";
} elseif (isset($supply_on_total_money_requiered_percent) && $supply_on_total_money_requiered_percent > 0) {
//echo "(hemos aplicado este descuento porque su compra superaba los: ".$supply_on_total_money_requiered_percent.")<br>";
}

}

//$supply_on_total_money_to_discount


}
//\$supply_on_total_money_requiered = "25";
//\$supply_on_total_money_requiered_percent = "50";

//La cantidad de dinero que se descuenta al superar la cantidad especificada mas arriba:
//\$supply_on_total_money_to_discount = "10";
//\$supply_on_total_money_to_discount_percent = "5";







if (isset($taxes_percent) && isset($taxes_percent_text) && is_numeric($taxes_percent) && $taxes_percent_text != "off") {

//$_SESSION['total_price'] = 1000;
//echo "el ivisima: " . $_SESSION['total_price'];

echo "<br><b>".$taxes_percent_text . " (</b>" . $taxes_percent . "%<b>)</b>:<br>";
//echo "EUR ".number_format($_SESSION['total_price'] * $taxes_percent / 100, $money_dec, $money_dec_symbol, $money_miles_symbol) . " (" . $taxes_percent . "%) <br>";





                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = "+ ".wordwrap(number_format(($_SESSION['total_price'] * $taxes_percent / 100) / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "+ ".wordwrap(number_format(($_SESSION['total_price'] * $taxes_percent / 100) / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = "+ ".wordwrap(number_format(($_SESSION['total_price'] * $taxes_percent / 100) / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = "+ ".wordwrap(number_format(($_SESSION['total_price'] * $taxes_percent / 100) / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo wordwrap(number_format(($_SESSION['total_price'] * $taxes_percent / 100) / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1) ."".$money_default;
    //                                       } else {
      //                                     echo wordwrap(number_format(($_SESSION['total_price'] * $taxes_percent / 100) / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1) ." EUR<br>";
        //                                   }

                                           if (isset($money_default)) {
//                                           echo "<b>".wordwrap(number_format($_SESSION['total_price'], 2, ",", "."), 10, "<br>", 1)."</b>".$money_default;
                                           echo "+ ".wordwrap(number_format($_SESSION['total_price'] * $taxes_percent / 100, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           echo "+ ".wordwrap(number_format($_SESSION['total_price'] * $taxes_percent / 100, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }


                                           }


                                           //Fin de la opcion del conversor



$_SESSION['total_price'] = $_SESSION['total_price'] + ($_SESSION['total_price'] * $taxes_percent) / 100;

}





if (isset($taxes) && isset($taxes_text) && is_numeric($taxes) && $taxes_text != "off") {

$_SESSION['total_price'] = $_SESSION['total_price'] + $taxes;

echo "<br><b>".$taxes_text . ":</b><br>";
//echo "EUR ".number_format($taxes, $money_dec, $money_dec_symbol, $money_miles_symbol) . "<br>";





                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = "+ ".wordwrap(number_format($taxes / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "+ ".wordwrap(number_format($taxes / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = "+ ".wordwrap(number_format($taxes / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = "+ ".wordwrap(number_format($taxes / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo wordwrap(number_format($taxes / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
    //                                       } else {
      //                                     echo wordwrap(number_format($taxes / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR<br>";
        //                                   }
        
                                           if (isset($money_default)) {
                                           echo "+ ".wordwrap(number_format($taxes, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo "+ ".wordwrap(number_format($taxes, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor



}


//echo "<br>";

if (isset($supply_on_total_money_requiered) && $supply_on_total_money_requiered != "off" && $supply_on_total_money_requiered != "") {

if($supply_on_total_money_requiered == "0") {
echo "<br><br>* Se aplicara a <b>todos los pedidos</b> un <b>descuento</b> de:<br>";


//echo "<b>".$supply_on_total_money_to_discount."".$money_default."</b>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
    //                                       } else {
      //                                     echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR<br>";
        //                                   }
                                           if (isset($money_default)) {
                                           echo "- ".wordwrap(number_format($supply_on_total_money_to_discount, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo "- ".wordwrap(number_format($supply_on_total_money_to_discount, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

        
                                           }


                                           //Fin de la opcion del conversor


}

if($supply_on_total_money_requiered > 0) {

//echo "<br>* Se aplicara a los <b>pedidos superiores</b> a <b>".$supply_on_total_money_requiered."".$money_default."</b> un <b>descuento</b> de <b>".$supply_on_total_money_to_discount."".$money_default."</b>";

echo "<br><br>* Se aplicara a los <b>pedidos superiores</b> (sin contar impuestos) a:<br>";

//echo "<b>".$supply_on_total_money_requiered."".$money_default."</b><br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_requiered / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_requiered / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_requiered / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_requiered / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
    //                                       } else {
      //                                     echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR<br>";
        //                                   }
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($supply_on_total_money_requiered, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($supply_on_total_money_requiered, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

        
                                           }


                                           //Fin de la opcion del conversor


echo "un <b>descuento</b> de:<br>";
//echo "<b>".$supply_on_total_money_to_discount."".$money_default."</b>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = "- ".wordwrap(number_format($supply_on_total_money_to_discount / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
    //                                       } else {
      //                                     echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR<br>";
        //                                   }
                                           if (isset($money_default)) {
                                           echo "- ".wordwrap(number_format($supply_on_total_money_to_discount, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo "- ".wordwrap(number_format($supply_on_total_money_to_discount, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

        
                                           }


                                           //Fin de la opcion del conversor



}
}

if (isset($supply_on_total_money_requiered_percent) && $supply_on_total_money_requiered_percent != "off" && $supply_on_total_money_requiered_percent != "") {
if($supply_on_total_money_requiered_percent == "0") {
echo "<br><br>* Se aplicara a <b>todos los pedidos</b> un <b>descuento</b> del <b>".$supply_on_total_money_to_discount_percent."%</b>";
}
if($supply_on_total_money_requiered_percent > 0) {
echo "<br><br>* Se aplicara a los <b>pedidos superiores</b> (sin contar impuestos) a:<br>";

//echo "<b>".$supply_on_total_money_requiered_percent."".$money_default."</b><br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_requiered_percent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_requiered_percent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_requiered_percent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_requiered_percent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_default;
    //                                       } else {
      //                                     echo wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)." EUR<br>";
        //                                   }
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($supply_on_total_money_requiered_percent, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($supply_on_total_money_requiered_percent, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

        
                                           }


                                           //Fin de la opcion del conversor


echo "un <b>descuento</b> del <b>".$supply_on_total_money_to_discount_percent."%</b>";
}
}


//Vigilancia:
echo "</td>";

}


//echo "<br>";

//echo "<center><table border=\"1\"><tr><td><b>Total: <b>" . number_format($_SESSION['total_price'], $money_dec, $money_dec_symbol, $money_miles_symbol) . "</td></tr></table></center>";

//echo "<br>";

//Cuidadete:
//}

//Vigilancia:
//echo "</td>";

echo "<td align=\"left\" valign=\"top\">";

if (!isset($basket_empty) || $basket_empty != "off") {

echo "<center><i><b>no contiene productos</b></i></center><br>"; unset($basket_empty);

if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {

if (isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {

echo "Si la cesta de compra no le funciona o no le parece conveniente, puede realizar un ";

if (SID) {
echo "<a href=\"".$this_file."?process=ok&manual=ok&".SID."\">pedido manual</a>";
} else {
echo "<a href=\"".$this_file."?process=ok&manual=ok\">pedido manual</a>";
}

echo " (<b>no recomendamos</b> esta opcion, a no ser que <b>no pueda utilizar la cesta de compra</b>)<br><br>";

}

}

}

//echo "<br>";
//echo "<center><table border=\"1\"><tr><td><b>Total: <b>" . number_format($_SESSION['total_price'], $money_dec, $money_dec_symbol, $money_miles_symbol) . "</td></tr></table></center>";

echo "<table border=\"1\" cellspacing=\"".$basket_table_cellspacing."\" cellpadding=\"".$basket_table_cellpadding."\"><tr><td><b>TOTAL:</b></td></tr>";

echo "<tr><td>";
//echo "EUR <b>".number_format($_SESSION['total_price'], $money_dec, $money_dec_symbol, $money_miles_symbol) . "</b><br>";
//echo "USD ";



                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           }
                                           
                                           } else {
                                           
  //                                         if (isset($money_default)) {
//                                           echo "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_default;
    //                                       } else {
      //                                     echo "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b> EUR<br>";
        //                                   }
        
                                           if (isset($money_default)) {
                                           echo "<b>".wordwrap(number_format($_SESSION['total_price'], 2, ",", "."), 10, "<br>", 1)."</b>".$money_default."<br>";
                                           } else {
                                           echo "<b>".wordwrap(number_format($_SESSION['total_price'], 2, ",", "."), 10, "<br>", 1)."</b> EUR<br>";
                                           }
        

                                           }


                                           //Fin de la opcion del conversor



if (isset($additional_cost_outside_text) && isset($additional_cost_outside) && $additional_cost_outside_text != "" && $additional_cost_outside != "" && $additional_cost_outside_text != "off" && $additional_cost_outside != "off" && is_numeric($additional_cost_outside)) {
echo "<br>";
echo "<center><b>".$additional_cost_outside_text.":</b><br>";

//Indicar en euros y en usd:
//echo "+".$additional_cost_outside."</center>";






                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                           if (isset($money_eur_valor)) {
                                           echo "+ ".wordwrap(number_format($additional_cost_outside / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_eur_symbol."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

  //                                         $money_usd_represent = "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol;
//                                           echo $money_usd_represent."<br>";

                                          echo "+ ".wordwrap(number_format($additional_cost_outside / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol."<br>";

                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           if (isset($money_usd_valor)) {
//                                           $money_usd_represent = "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol;
  //                                         echo $money_usd_represent."<br>";

                                          echo "+ ".wordwrap(number_format($additional_cost_outside / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_usd_symbol."<br>";

                                           }
                                           
                                           if (isset($money_eur_valor)) {
//                                           $money_eur_represent = "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_eur_symbol;
  //                                         echo $money_eur_represent."<br>";
                                           echo "+ ".wordwrap(number_format($additional_cost_outside / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_symbol_separator."".$money_eur_symbol."<br>";  
                                           }
                                           }
                                           
                                           } else {
                                           
//                                           if (isset($money_default)) {
  //                                         echo "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b>".$money_default;
    //                                       } else {
      //                                     echo "<b>".wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."</b> EUR<br>";
        //                                   }
        
                                           if (isset($money_default)) {
                                           echo "+ ".wordwrap(number_format($additional_cost_outside, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           echo "+ ".wordwrap(number_format($additional_cost_outside, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
        
        
                                           }



}

//kakisima
//}

echo "</td></tr>";
echo "</table><br>";

echo "</td>";
echo "</tr></table>";

//echo "</td></tr></table>";

echo "</td></tr></table>";

//echo "</center>";
//}

//Cuidadete:
}

//else { echo "cesta vacia!"; }
//Fin de tabla.


//echo "<br><br>";

if (!isset($_GET['process']) || isset($_GET['process']) && $_GET['process'] != "ok") {

echo "<br><br>";

if (isset($_SESSION['last_page_visited']) && $_SESSION['last_page_visited'] != "") {
echo "<a href=\"".$_SESSION['last_page_visited']."\">Seguir comprando</a>";
} else {
if (isset($products_file) && $products_file != "") {

if (SID) {
echo "<a href=\"".$products_file."?category=all&".SID."\">Seguir comprando</a>";
} else {
echo "<a href=\"".$products_file."?category=all\">Seguir comprando</a>";
}

} else {
if (SID) {
echo "<a href=\"products.php?category=all&".SID."\">Seguir comprando</a>";
} else {
echo "<a href=\"products.php?category=all\">Seguir comprando</a>";
}

}
}

if (isset($process_file)) {

if (SID) {
echo " - <a href=\"".$this_file."?process=ok&".SID."\">Realizar compra</a>";
} else {
echo " - <a href=\"".$this_file."?process=ok\">Realizar compra</a>";
}

} else {
if (SID) {
echo " - <a href=\"basket.php?process=ok&".SID."\">Realizar compra</a>";
} else {
echo " - <a href=\"basket.php?process=ok\">Realizar compra</a>";

}
}

//echo "</td></tr></table>";

echo "<br><br><br>";



if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {

if (isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {

echo "Si la cesta de compra no le funciona o no le parece conveniente, puede realizar un ";

if (SID) {
echo "<a href=\"".$this_file."?process=ok&manual=ok&".SID."\">pedido manual</a>";
} else {
echo "<a href=\"".$this_file."?process=ok&manual=ok\">pedido manual</a>";
}

echo " (<b>no recomendamos</b> esta opcion, a no ser que <b>no pueda utilizar la cesta de compra</b>)<br><br>";

}

}


echo "<br><br><br>";

}


//Pedido antes:
//blablablabla

}

}

}





//Pedido:
                         if (isset($_GET['process']) && $_GET['process'] == "ok") {







//                         if (isset($_GET['process']) && $_GET['process'] == "ok") {
                         
                        
                         if (isset($_GET['step']) && $_GET['step'] == "2") {





                         
                         //Segundo paso:
                         // Opcion de seguir comprando siempre.
                         // Si la cesta esta vacia: ir a step=1
                         // Se muestra cesta de compra y datos (boton editar para volver a step=1).
                         // Se muestran impuestos fuera de zona (si se ha seleccionado la casilla y si no se avisa por si a caso).

                         if (isset($process_form_errors) && $process_form_errors == "") {

//                         echo "Step 2";




                         if (!isset($_GET['process_send_tel']) || isset($_GET['process_send_tel']) && $_GET['process_send_tel'] == "") {
                         $_GET['process_send_tel'] = "";
                         }
                   
                         if (!isset($_GET['process_send_email']) || isset($_GET['process_send_email']) && $_GET['process_send_email'] == "") {
                         $_GET['process_send_email'] = "";
                         }

                         if (!isset($_GET['process_send_text']) || isset($_GET['process_send_text']) && $_GET['process_send_text'] == "") {
                         $_GET['process_send_text'] = "";
                         }





if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually != "off") {

echo "<b>Pedido manual:</b><br><br>";



$basket_send_is_empty = "yes";

if (isset($_SESSION['basket_ref'])) {

foreach ($_SESSION['basket_ref'] as $ref_actual) {

if (isset($ref_actual) && $_SESSION['basket_quantity'][$ref_actual] != "0") {

$basket_send_is_empty = "no";

}

}

}


//if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
//$basket_send_is_empty = "no";
//}

if (isset($basket_send_is_empty) && $basket_send_is_empty == "no") {
//if (isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {

unset($basket_send_is_empty);

echo "<b>Atencion:</b> se ha detectado que la ";

if (SID) {
echo "<a href=\"".$basket_file."?".SID."\">cesta de compra</a>";
} else {
echo "<a href=\"".$basket_file."\">cesta de compra</a>";
}

echo " podria no estar vacia. Solo aconsejamos la modalidad de pedido manual cuando la cesta de compra no funciona.<br><br>";

//echo "Cesta vacia";

}


}



                         echo "Por favor asegurese de que la informacion que se va a enviar es la correcta. La utilizaremos para poder ponernos en contacto con usted en caso necesario<br>";

                         echo "<br><table cellspacing=\"0\" cellpadding=\"5\" border=\"1\"><tr><td>";
                         
                         echo "<b>Este es el E-Mail que se va a enviar</b>:</td></tr><tr><td><br>";
                        
                         echo "Nombre:<br><b>".nl2br(wordwrap(urldecode($_GET['process_send_name']), 35, "<br>", 1))."</b><br><br>";
                         echo "E-Mail:<br><b>".nl2br(wordwrap(urldecode($_GET['process_send_email']), 35, "<br>", 1))."</b><br><br>";
                         echo "Telefono:<br><b>".nl2br(wordwrap(urldecode($_GET['process_send_tel']), 35, "<br>", 1))."</b><br><br>";
                         echo "Direccion:<br><b>".nl2br(wordwrap(urldecode($_GET['process_send_address']), 35, "<br>", 1))."</b><br><br>";
                         echo "Localidad:<br><b>".nl2br(wordwrap(urldecode($_GET['process_send_location']), 35, "<br>", 1))."</b><br><br>";
                         echo "Codigo Postal:<br><b>".nl2br(wordwrap(urldecode($_GET['process_send_cp']), 35, "<br>", 1))."</b><br><br>";
                         echo "Pais:<br><b>".nl2br(wordwrap(urldecode($_GET['process_send_country']), 35, "<br>", 1))."</b><br><br>";
//address, location, cp, country

//                         echo "Asunto:<br><b>".nl2br(wordwrap(urldecode($_GET['process_send_subject']), 35, "<br>", 1))."</b><br><br>";
                         echo "Comentarios:<br><b>".nl2br(wordwrap(urldecode($_GET['process_send_text']), 35, "<br>", 1))."</b><br><br>";








if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {

//Calculamos si la cesta esta vacia:

$basket_send_is_empty = "yes";

if (isset($_SESSION['basket_ref'])) {

foreach ($_SESSION['basket_ref'] as $ref_actual) {

if (isset($ref_actual) && $_SESSION['basket_quantity'][$ref_actual] != "0") {

if (isset($total_basket_send)) {
$total_basket_send = $total_basket_send + ($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual]);
} else {
$total_basket_send = $_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual];
}


}



}

echo "<br>";

if (isset($total_basket_send)) {



//Aplicar descuentos:

if (isset($supply_on_total_money_requiered) && $supply_on_total_money_requiered != "off" && $supply_on_total_money_requiered != "") {
if ($total_basket_send > $supply_on_total_money_requiered) {
if (isset($supply_on_total_money_to_discount) && $supply_on_total_money_to_discount != "" && $supply_on_total_money_to_discount != "off") {

//echo "<b>Descuento</b>: ".$supply_on_total_money_to_discount."<br><br>";

$total_basket_send  = $total_basket_send - $supply_on_total_money_to_discount;

//echo "<br><br>desciento:".$supply_on_total_money_to_discount."<br><br>";

}
}
}


if (isset($supply_on_total_money_requiered_percent) && $supply_on_total_money_requiered_percent != "off" && $supply_on_total_money_requiered_percent != "") {
if ($total_basket_send > $supply_on_total_money_requiered_percent) {
if (isset($supply_on_total_money_to_discount_percent) && $supply_on_total_money_to_discount_percent != "" && $supply_on_total_money_to_discount_percent != "off") {
$basket_supply_percent = $total_basket_send * $supply_on_total_money_to_discount_percent / 100;

//echo "<br><br>desciento percent:".$basket_supply_percent."<br><br>";

//echo "<b>Descuento percent</b>: ".$basket_supply_percent."<br><br>";

$total_basket_send  = $total_basket_send - $basket_supply_percent;
}
}
}


//Aplicar impuestos:

//echo "Total <b>con descuentos</b>: ".$total_basket_send."<br><br>";


if (isset($taxes_percent) && isset($taxes_percent) && is_numeric($taxes_percent) && $taxes_percent_text != "off") {
$basket_taxes_percent = $total_basket_send * $taxes_percent / 100;
//echo "<br><br>".$basket_taxes_percent."<br><br>";
$total_basket_send = $total_basket_send + $basket_taxes_percent;

//Cuidado:
}

if (isset($taxes) && isset($taxes_text) && is_numeric($taxes) && $taxes_text != "off") {
$total_basket_send = $total_basket_send + $taxes;
//echo "<b>Impuesto: </b>: ".$taxes."<br><br>";
}

//echo "<b>Impuesto: </b>: ".$basket_taxes_percent."<br><br>";

//}



//echo "Total <b>sin impuestos</b>: ".$total_basket_send."";








}

echo "Total <b>sin impuestos</b>:<br>";







                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($total_basket_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($total_basket_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($total_basket_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($total_basket_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($total_basket_send, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           echo wordwrap(number_format($total_basket_send, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor









echo "<br>";

}

}






//impuestos por forma de pago:
if (isset($shipment_different_methods) && $shipment_different_methods == "on") {

if (isset($_GET['shipment']) && $_GET['shipment'] != "") {

if ($_GET['shipment'] == 1 && isset($shipment_method_1) && $shipment_method_1 != "" && $shipment_method_1 != "off" && isset($shipment_method_2_text) && $shipment_method_1_text != "" && $shipment_method_1 != "off") {
$shipment_method_send = $shipment_method_1;
$shipment_method_send_text = $shipment_method_1_text;
}

if ($_GET['shipment'] == 2 && isset($shipment_method_2) && $shipment_method_2 != "" && $shipment_method_2 != "off" && isset($shipment_method_2_text) && $shipment_method_2_text != "" && $shipment_method_2 != "off") {
$shipment_method_send = $shipment_method_2;
$shipment_method_send_text = $shipment_method_2_text;
}

if ($_GET['shipment'] == 3 && isset($shipment_method_3) && $shipment_method_3 != "" && $shipment_method_3 != "off" && isset($shipment_method_3_text) && $shipment_method_3_text != "" && $shipment_method_3 != "off") {
$shipment_method_send = $shipment_method_3;
$shipment_method_send_text = $shipment_method_3_text;
}

if ($_GET['shipment'] == 4 && isset($shipment_method_4) && $shipment_method_4 != "" && $shipment_method_4 != "off" && isset($shipment_method_4_text) && $shipment_method_4_text != "" && $shipment_method_4 != "off") {
$shipment_method_send = $shipment_method_4;
$shipment_method_send_text = $shipment_method_4_text;
}

if ($_GET['shipment'] == 5 && isset($shipment_method_5) && $shipment_method_5 != "" && $shipment_method_5 != "off" && isset($shipment_method_5_text) && $shipment_method_5_text != "" && $shipment_method_5 != "off") {
$shipment_method_send = $shipment_method_5;
$shipment_method_send_text = $shipment_method_5_text;
}


if (isset($shipment_method_send_text) && $shipment_method_send_text != "" && $shipment_method_send_text != "off" && isset($shipment_method_send) && $shipment_method_send != "" && $shipment_method_send != "off")
//echo "Impuesto/descuento por <b>forma de envio</b>:<br>* ".$shipment_method_send_text.": ".$shipment_method_send;

echo "Impuesto/descuento por <b>forma de envio</b>:<br>* ".$shipment_method_send_text.":<br>";


                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($shipment_method_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($shipment_method_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($shipment_method_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($shipment_method_send, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           echo wordwrap(number_format($shipment_method_send, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor


echo "<br>";

//if (isset($total_basket_send) && isset($shipment_method_send)) {
//if($shipment_method_send < 0) {
//$total_basket_send = $total_basket_send - $shipment_method_send;
//} elseif($shipment_method_send > 0) {
if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {
$total_basket_send = $total_basket_send + $shipment_method_send;
//}
//}

}

unset($shipment_method_send_text);
unset($shipment_method_send);

}


}
//fin de impuestos por forma de pago.





//impuestos por forma de envio:
if (isset($payment_different_methods) && $payment_different_methods == "on") {

if (isset($_GET['payment']) && $_GET['payment'] != "") {

if ($_GET['payment'] == 1 && isset($payment_method_1) && $payment_method_1 != "" && $payment_method_1 != "off" && isset($payment_method_2_text) && $payment_method_1_text != "" && $payment_method_1 != "off") {
$payment_method_send = $payment_method_1;
$payment_method_send_text = $payment_method_1_text;
}

if ($_GET['payment'] == 2 && isset($payment_method_2) && $payment_method_2 != "" && $payment_method_2 != "off" && isset($payment_method_2_text) && $payment_method_2_text != "" && $payment_method_2 != "off") {
$payment_method_send = $payment_method_2;
$payment_method_send_text = $payment_method_2_text;
}

if ($_GET['payment'] == 3 && isset($payment_method_3) && $payment_method_3 != "" && $payment_method_3 != "off" && isset($payment_method_3_text) && $payment_method_3_text != "" && $payment_method_3 != "off") {
$payment_method_send = $payment_method_3;
$payment_method_send_text = $payment_method_3_text;
}

if ($_GET['payment'] == 4 && isset($payment_method_4) && $payment_method_4 != "" && $payment_method_4 != "off" && isset($payment_method_4_text) && $payment_method_4_text != "" && $payment_method_4 != "off") {
$payment_method_send = $payment_method_4;
$payment_method_send_text = $payment_method_4_text;
}

if ($_GET['payment'] == 5 && isset($payment_method_5) && $payment_method_5 != "" && $payment_method_5 != "off" && isset($payment_method_5_text) && $payment_method_5_text != "" && $payment_method_5 != "off") {
$payment_method_send = $payment_method_5;
$payment_method_send_text = $payment_method_5_text;
}


if (isset($payment_method_send_text) && $payment_method_send_text != "" && $payment_method_send_text != "off" && isset($payment_method_send) && $payment_method_send != "" && $payment_method_send != "off")
//echo "Impuesto/descuento por <b>forma de pago</b>:<br>* ".$payment_method_send_text.": ".$payment_method_send;


echo "Impuesto/descuento por <b>forma de pago</b>:<br>* ".$payment_method_send_text.":<br>";



                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($payment_method_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($payment_method_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($payment_method_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($payment_method_send, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           echo wordwrap(number_format($payment_method_send, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor





echo "<br>";

if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {

if (isset($total_basket_send) && isset($payment_method_send)) {

//secho $payment_method_send."<br>";

//if($payment_method_send < 0) {
//echo "menor<br>";
//$total_basket_send = $total_basket_send - $payment_method_send;
//} elseif ($payment_method_send > 0) {
//echo "mayor<br>";
$total_basket_send = $total_basket_send + $payment_method_send;
//}
}

}

unset($payment_method_send_text);
unset($payment_method_send);

}


}
//fin de impuestos por forma de envio.




//impuestos por fuera de zona:
if (isset($additional_cost_outside_text) && isset($additional_cost_outside) && $additional_cost_outside_text != "" && $additional_cost_outside != "" && $additional_cost_outside_text != "off" && $additional_cost_outside != "off" && is_numeric($additional_cost_outside)) {


if (isset($_GET['additional_cost_outside']) && $_GET['additional_cost_outside'] != "" && $_GET['additional_cost_outside'] == "on") {
echo "Impuesto/descuento <b>fuera de zona</b>:<br>";
echo "* ".$additional_cost_outside_text.":<br>";
//$additional_cost_outside



                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($additional_cost_outside / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($additional_cost_outside / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($additional_cost_outside / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($additional_cost_outside / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($additional_cost_outside, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           echo wordwrap(number_format($additional_cost_outside, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor




if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {

//if ($total_basket_send)
$total_basket_send = $total_basket_send + $additional_cost_outside;

}

echo "<br>";

}

}
//fin de impuestos por fuera de zona.






if (isset($total_basket_send)) {
if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {


//echo "Total <b>con impuestos</b>: ".$total_basket_send;
//echo "<br><br>";

echo "Total <b>con impuestos</b>:<br>";







                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($total_basket_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($total_basket_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($total_basket_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($total_basket_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($total_basket_send, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           echo wordwrap(number_format($total_basket_send, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor









echo "<br>";




}
}




                         if (isset($process_form_alerts) && $process_form_alerts != "") {
                         
                         echo "<center><table cellspacing=\"0\" cellpadding=\"5\" border=\"1\"><tr><td><b>AVISO</b>:";
                         echo $process_form_alerts."</td></tr></table></center>";
                         
                         }                         

                         $_SESSION['process_send_name'] = trim($_GET['process_send_name']);
                         $_SESSION['process_send_email'] = trim($_GET['process_send_email']);
                         $_SESSION['process_send_tel'] = trim($_GET['process_send_tel']);
//                         $_SESSION['process_send_subject'] = trim($_GET['process_send_subject']);
                         $_SESSION['process_send_address'] = trim($_GET['process_send_address']);
                         $_SESSION['process_send_location'] = trim($_GET['process_send_location']);                         
                         $_SESSION['process_send_cp'] = trim($_GET['process_send_cp']);
                         $_SESSION['process_send_country'] = trim($_GET['process_send_country']);

                         $_SESSION['shipment'] = trim($_GET['shipment']);
                         $_SESSION['payment'] = trim($_GET['payment']);

                         $_SESSION['additional_cost_outside'] = trim($_GET['additional_cost_outside']);


//address, location, cp, country
                         $_SESSION['process_send_text'] = trim($_GET['process_send_text']);
                         
                         echo "<br><center><form action=\"".$this_file."\" method=\"get\" style=\"display:inline;\">";

                         echo "<input type=\"hidden\" name=\"process\" value=\"ok\">";
                         echo "<input type=\"hidden\" name=\"step\" value=\"1\">";

                         if (isset($_GET['manual']) && $_GET['manual'] == "ok") {
                         ?>
                         <input type="hidden" name="manual" value="ok">
                         <?php
                         }

                         echo "<input type=\"hidden\" name=\"process_send_name\" value=\"".urlencode($_SESSION['process_send_name'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_email\" value=\"".urlencode($_SESSION['process_send_email'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_tel\" value=\"".urlencode($_SESSION['process_send_tel'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_address\" value=\"".urlencode($_SESSION['process_send_address'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_location\" value=\"".urlencode($_SESSION['process_send_location'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_cp\" value=\"".urlencode($_SESSION['process_send_cp'])."\">";


                         echo "<input type=\"hidden\" name=\"shipment\" value=\"".urlencode($_SESSION['shipment'])."\">";
                         echo "<input type=\"hidden\" name=\"payment\" value=\"".urlencode($_SESSION['payment'])."\">";


                         echo "<input type=\"hidden\" name=\"process_send_country\" value=\"".urlencode($_SESSION['process_send_country'])."\">";

                         echo "<input type=\"hidden\" name=\"additional_cost_outside\" value=\"".urlencode($_SESSION['additional_cost_outside'])."\">";

//address, location, cp, country
//                         echo "<input type=\"hidden\" name=\"contact_send_subject\" value=\"".urlencode($_SESSION['process_send_subject'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_text\" value=\"".urlencode($_SESSION['process_send_text'])."\">";

                         if (SID) {
                         ?>
                         <input type="hidden" name="<?php echo session_name(); ?>" value="<?php echo session_id(); ?>">
                         <?php
                         }

                         echo "<input type=\"submit\" name=\"submit\" value=\"Editar\"></form></center>";
                         
                         echo "</td></tr><tr><td>";
                         
                         echo "<br>";
//                         echo "<center><form action=\"".$this_file."\" method=\"get\" style=\"display:inline;\"><input type=\"hidden\" name=\"process_send_form\" value=\"send\">";
                         echo "<center><form action=\"".$this_file."\" method=\"get\" style=\"display:inline;\">";
                         echo "<input type=\"hidden\" name=\"process\" value=\"ok\">";
                         echo "<input type=\"hidden\" name=\"step\" value=\"3\">";

                         if (isset($_GET['manual']) && $_GET['manual'] == "ok") {
                         ?>
                         <input type="hidden" name="manual" value="ok">
                         <?php
                         }


                         echo "<input type=\"hidden\" name=\"process_send_name\" value=\"".urlencode($_SESSION['process_send_name'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_email\" value=\"".urlencode($_SESSION['process_send_email'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_tel\" value=\"".urlencode($_SESSION['process_send_tel'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_address\" value=\"".urlencode($_SESSION['process_send_address'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_location\" value=\"".urlencode($_SESSION['process_send_location'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_cp\" value=\"".urlencode($_SESSION['process_send_cp'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_country\" value=\"".urlencode($_SESSION['process_send_country'])."\">";

                         echo "<input type=\"hidden\" name=\"additional_cost_outside\" value=\"".urlencode($_SESSION['additional_cost_outside'])."\">";


                         echo "<input type=\"hidden\" name=\"payment\" value=\"".urlencode($_SESSION['payment'])."\">";
                         echo "<input type=\"hidden\" name=\"shipment\" value=\"".urlencode($_SESSION['shipment'])."\">";

//address, location, cp, country
//                         echo "<input type=\"hidden\" name=\"contact_send_subject\" value=\"".urlencode($_SESSION['process_send_subject'])."\">";
                         echo "<input type=\"hidden\" name=\"process_send_text\" value=\"".urlencode($_SESSION['process_send_text'])."\">";


                         echo "Si esta deacuerdo, pulse el siguiente boton:<br><input type=\"submit\" name=\"submit\" value=\"Enviar\">";

                         if (SID) {
                         ?>
                         <input type="hidden" name="<?php echo session_name(); ?>" value="<?php echo session_id(); ?>">
                         <?php
                         }

                         echo "</form></center>";

                         echo "</td></tr></table><br>";






                         }


                     
                         
                         } elseif (isset($_GET['step']) && $_GET['step'] == "3") {

                         
                         //Tercer y ultimo paso:
                         // Comprobar si $_GET['type'] == "manual".
                         // Todo como en contacto:
                         // · Si todo es correcto, enviar E-Mail.
                         // · Si da error al enviar E-Mail, logear error y enviar E-Mail a $error_email.
                         // · Si da error al enviar E-Mail de error, logear.
                         // Utilizar anti-flood como en contacto.
                         // Enviar trace-route.










                         if (!isset($_SESSION['process_send_name'])) { $_SESSION['process_send_name'] = ""; }
                         if (!isset($_SESSION['process_send_email'])) { $_SESSION['process_send_email'] = ""; }
                         if (!isset($_SESSION['process_send_tel'])) { $_SESSION['process_send_tel'] = ""; }
                         if (!isset($_SESSION['process_send_address'])) { $_SESSION['process_send_address'] = ""; }
                         if (!isset($_SESSION['process_send_location'])) { $_SESSION['process_send_location'] = ""; }
                         if (!isset($_SESSION['process_send_cp'])) { $_SESSION['process_send_cp'] = ""; }
                         if (!isset($_SESSION['process_send_country'])) { $_SESSION['process_send_country'] = ""; }

                         if (!isset($_SESSION['additional_cost_outside'])) { $_SESSION['additional_cost_outside'] = ""; }

                         if (!isset($_SESSION['payment'])) { $_SESSION['payment'] = ""; }
                         if (!isset($_SESSION['shipment'])) { $_SESSION['shipment'] = ""; }                         

//address, location, cp, country
//                         if (!isset($_SESSION['process_send_subject'])) { $_SESSION['process_send_subject'] = ""; }
                         if (!isset($_SESSION['process_send_text'])) { $_SESSION['process_send_text'] = ""; }

                         
                         if (isset($_GET['manual']) && $_GET['manual'] == "ok") {
                         $process_email_text =  "<html><head><title>[Pedido manual] (enviado por: " . urldecode($_SESSION['process_send_name']) . ") - E-Mail enviado desde la web " . $title_web . "</title></head><body>\n\n\n";
                         } else {
                         $process_email_text =  "<html><head><title>[Pedido] (enviado por: " . urldecode($_SESSION['process_send_name']) . ") - E-Mail enviado desde la web " . $title_web . "</title></head><body>\n\n\n";                         
                         }

                         if (isset($send_emails_format) && $send_emails_format == "html") {

                         if (isset($_GET['manual']) && $_GET['manual'] == "ok") {
                         $process_email_text .= "<center><h3>[Pedido manual] (enviado por: " . urldecode($_SESSION['process_send_name']) . ") - E-Mail enviado desde la web " . $title_web . "</h3></center><br><br><br>";
                         } else {
                         $process_email_text .= "<center><h3>[Pedido] (enviado por: " . urldecode($_SESSION['process_send_name']) . ") - E-Mail enviado desde la web " . $title_web . "</h3></center><br>";
                         }
                         
                         }                         



                         $process_email_text .= "<center>Fecha de envio: [<b>".date("H:i:s")."</b>] <b>".date("d/m/Y")."</b></center><br><br><br>";


                         $process_email_text .= "Nombre: <br><b>".urldecode($_SESSION['process_send_name'])."</b><br><br>";
                         $process_email_text .= "E-Mail: <br><b>".urldecode($_SESSION['process_send_email'])."</b><br><br>";
                         $process_email_text .= "Telefono: <br><b>".urldecode($_SESSION['process_send_tel'])."</b><br><br>";

                         $process_email_text .= "Direccion: <br><b>".urldecode($_SESSION['process_send_address'])."</b><br><br>";
                         $process_email_text .= "Localidad: <br><b>".urldecode($_SESSION['process_send_location'])."</b><br><br>";
                         $process_email_text .= "Codigo Postal: <br><b>".urldecode($_SESSION['process_send_cp'])."</b><br><br>";
                         $process_email_text .= "Pais: <br><b>".urldecode($_SESSION['process_send_country'])."</b><br><br>";
//address, location, cp, country

//                         $process_email_text .= "Asunto: <br><b>".urldecode($_SESSION['process_send_subject'])."</b><br><br>";

                         //Poner contenido de cesta de compra:


                         if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
                         $process_email_text .= "Pedido (<b>manual</b>): <br><b>".urldecode(nl2br($_SESSION['process_send_text']))."</b><br><br>";
                         } else {
                         //Cuidado de las lineas
                         $process_email_text .= "Texto: <br><b>".urldecode(nl2br($_SESSION['process_send_text']))."</b><br><br>";
                         }




if (isset($_SESSION['total_price_send'])) { unset($_SESSION['total_price_send']); }



$process_email_text .= "Cesta de compra: <br>\n";

if (isset($_SESSION['basket_ref'])) {

$process_email_text .= "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";

if (isset($send_emails_format) && $send_emails_format == "html") {
$process_email_text .= "<tr>";
$process_email_text .= "<td><center>Ref</center></td>";
$process_email_text .= "<td><center>Nombre</center></td>";
$process_email_text .= "<td><center>Cantidad</center></td>";
$process_email_text .= "<td><center>PVP (unidad)</center></td>";
$process_email_text .= "<td><center>PVP (total)</center></td>";
$process_email_text .= "</tr>\n\n";
}

$basket_is_empty_send = "yes";

foreach ($_SESSION['basket_ref'] as $ref_actual) {

if (isset($ref_actual) && $_SESSION['basket_quantity'][$ref_actual] != "0") {

$basket_is_empty_send = "no";

//if (!isset($_SESSION['total_price'])) { $_SESSION['total_price'] = 0; }

$_SESSION['total_price_send'] = 0;

$process_email_text .= "<tr>";

if (isset($_SESSION['basket_ref'][$ref_actual])) {
$process_email_text .= "<td>";
if (isset($send_emails_format) && $send_emails_format == "html") {
$process_email_text .= "<center><b>".$_SESSION['basket_ref'][$ref_actual]."</b></center>";
} else {
$process_email_text .= "<center><b>Ref: ".$_SESSION['basket_ref'][$ref_actual]."</b></center>";
}
$process_email_text .= "</td>\n";
}

if (isset($_SESSION['basket_name'][$ref_actual])) {
$process_email_text .= "<td>";
if (isset($send_emails_format) && $send_emails_format == "html") {
$process_email_text .= "<center><b>".$_SESSION['basket_name'][$ref_actual]."</b></center>";
} else {
$process_email_text .= "<center><b>Nombre: ".$_SESSION['basket_name'][$ref_actual]."</b></center>";
}
$process_email_text .= "</td>\n";
}

if (isset($_SESSION['basket_quantity'][$ref_actual])) {
$process_email_text .= "<td>";
if (isset($send_emails_format) && $send_emails_format == "html") {
$process_email_text .= "<center><b>".$_SESSION['basket_quantity'][$ref_actual]."</b></center>";
} else {
$process_email_text .= "<center><b>Cantidad: ".$_SESSION['basket_quantity'][$ref_actual]."</b></center>";
}
$process_email_text .= "</td>\n";
}

if (isset($ref_actual) && isset($_SESSION['basket_price'][$ref_actual])) {
$process_email_text .= "<td>";
if (isset($send_emails_format) && $send_emails_format == "html") {
$process_email_text .= "<center><b>".number_format($_SESSION['basket_price'][$ref_actual], $money_dec, $money_dec_symbol, $money_miles_symbol)."</b></center>";
$process_email_text .= "</td>\n";
$process_email_text .= "<td>";
$process_email_text .= "<center><b>".number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual], $money_dec, $money_dec_symbol, $money_miles_symbol)."</b></center>";
} else {
$process_email_text .= "<center><b>PVP (unidad): ".number_format($_SESSION['basket_price'][$ref_actual], $money_dec, $money_dec_symbol, $money_miles_symbol)."</b></center>";
$process_email_text .= "</td>\n";
$process_email_text .= "<td>";
$process_email_text .= "<center><b>PVP (total): ".number_format($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual], $money_dec, $money_dec_symbol, $money_miles_symbol)."</b></center>";
}
$process_email_text .= "</td>\n";

//total a enviar:
if (isset($_SESSION['basket_quantity'][$ref_actual]) && isset($_SESSION['total_price_send'])) { $_SESSION['total_price_send'] = $_SESSION['total_price_send'] + $_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual]; }



if (isset($total_basket_send)) {
$total_basket_send = $total_basket_send + ($_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual]);
} else {
$total_basket_send = $_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual];
}


}

$process_email_text .= "</tr>\n";

//                                           $money_eur_represent = wordwrap(number_format($_SESSION['total_price'] / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
//$_SESSION['total_price'] = $_SESSION['total_price'] + $_SESSION['basket_price'][$ref_actual] * $_SESSION['basket_quantity'][$ref_actual];

//}

} //Fin if de quantity
} //Fin foreach

if (!isset($basket_is_empty_send) || isset($basket_is_empty_send) && $basket_is_empty_send == "yes") { $process_email_text .= "<tr>La cesta no contiene productos.</tr>\n"; }

$process_email_text .= "</table>";

//$process_email_text .= "<table border=\"1\"><tr><td><center>Total:<b> ";
$process_email_text .= "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\"><tr><td><center>";

//Calcular el total aqui, sumando iva, etc. ->

//if (isset($ref_actual) && isset($_SESSION['basket_price'][$ref_actual]) && isset($_SESSION['total_price_send'])) {
if (isset($_SESSION['total_price_send']) && $_SESSION['total_price_send'] != "") {


//$process_email_text .= number_format($_SESSION['total_price_send'], $money_dec, $money_dec_symbol, $money_miles_symbol);











//Aplicar descuentos:

if (isset($supply_on_total_money_requiered) && $supply_on_total_money_requiered != "off" && $supply_on_total_money_requiered != "") {
if ($total_basket_send > $supply_on_total_money_requiered) {
if (isset($supply_on_total_money_to_discount) && $supply_on_total_money_to_discount != "" && $supply_on_total_money_to_discount != "off") {

$process_email_text .= "<b>Descuento</b>:<br>";

//.$supply_on_total_money_to_discount." (ya que supera los ".$supply_on_total_money_requiered.")";






                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_to_discount / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_to_discount / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_to_discount / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_to_discount / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($supply_on_total_money_to_discount, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($supply_on_total_money_to_discount, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor





$process_email_text .= "<b>ya que supera los</b>:<br>";
//$supply_on_total_money_requiered






                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_requiered / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_requiered / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_requiered / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_requiered / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($supply_on_total_money_requiered, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($supply_on_total_money_requiered, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor




$process_email_text .= "<br><br>";



$total_basket_send  = $total_basket_send - $supply_on_total_money_to_discount;

//echo "<br><br>desciento:".$supply_on_total_money_to_discount."<br><br>";

}
}
}


if (isset($supply_on_total_money_requiered_percent) && $supply_on_total_money_requiered_percent != "off" && $supply_on_total_money_requiered_percent != "") {
if ($total_basket_send > $supply_on_total_money_requiered_percent) {
if (isset($supply_on_total_money_to_discount_percent) && $supply_on_total_money_to_discount_percent != "" && $supply_on_total_money_to_discount_percent != "off") {
$basket_supply_percent = $total_basket_send * $supply_on_total_money_to_discount_percent / 100;

$process_email_text .= "<b>Descuento percent (".$supply_on_total_money_to_discount_percent."%)</b>:<br>";






                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($basket_supply_percent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($basket_supply_percent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($basket_supply_percent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($basket_supply_percent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($basket_supply_percent, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($basket_supply_percent, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor




//.$basket_supply_percent."%








$process_email_text .= "<b>ya que supera los</b>:<br>";



// (ya que supera los ".$supply_on_total_money_requiered_percent.")<br><br>";






                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_requiered_percent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_requiered_percent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($supply_on_total_money_requiered_percent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($supply_on_total_money_requiered_percent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($supply_on_total_money_requiered_percent, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($supply_on_total_money_requiered_percent, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor



$process_email_text .= "<br><br>";


//echo "<b>Descuento percent</b>: ".$basket_supply_percent."<br><br>";

$total_basket_send  = $total_basket_send - $basket_supply_percent;
}
}
}


//Aplicar impuestos:

//echo "Total <b>con descuentos</b>: ".$total_basket_send."<br><br>";


if (isset($taxes_percent) && isset($taxes_percent) && is_numeric($taxes_percent) && $taxes_percent_text != "off") {
$basket_taxes_percent = $total_basket_send * $taxes_percent / 100;
$process_email_text .= "<b>Impuesto percent (</b>".$taxes_percent_text.", ".$taxes_percent."%<b>)</b>:<br>";

//.$basket_taxes_percent.")<br><br>";






                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($basket_taxes_percent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($basket_taxes_percent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($basket_taxes_percent / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($basket_taxes_percent / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($basket_taxes_percent, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($basket_taxes_percent, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor




$process_email_text .= "<br><br>";







$total_basket_send = $total_basket_send + $basket_taxes_percent;
}


if (isset($taxes) && isset($taxes_text) && is_numeric($taxes) && $taxes_text != "off") {
$total_basket_send = $total_basket_send + $taxes;

$process_email_text .= "<b>Impuesto (</b>".$taxes_text."<b>)</b>:<br>";







                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($taxes / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($taxes / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($taxes / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($taxes / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($taxes, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($taxes, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor


$process_email_text .= "<br><br>";

}

//echo "<b>Impuesto: </b>: ".$basket_taxes_percent."<br><br>";


//echo "Total <b>sin impuestos</b>: ".$total_basket_send."";








//}

$process_email_text .= "Total <b>sin impuestos</b>:<br>";







                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($total_basket_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($total_basket_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($total_basket_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($total_basket_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($total_basket_send, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($total_basket_send, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor









//$process_email_text .= "<br>";











unset($_SESSION['total_price_send']);

} else {
$process_email_text .= "<b>Total</b>: indefinido";
}

$process_email_text .= "</b></center></td></tr></table><br><br>";



} //Fin if basket_ref





































//impuestos por forma de pago:
if (isset($shipment_different_methods) && $shipment_different_methods == "on") {

if (isset($_GET['shipment']) && $_GET['shipment'] != "") {

if ($_GET['shipment'] == 1 && isset($shipment_method_1) && $shipment_method_1 != "" && $shipment_method_1 != "off" && isset($shipment_method_2_text) && $shipment_method_1_text != "" && $shipment_method_1 != "off") {
$shipment_method_send = $shipment_method_1;
$shipment_method_send_text = $shipment_method_1_text;
}

if ($_GET['shipment'] == 2 && isset($shipment_method_2) && $shipment_method_2 != "" && $shipment_method_2 != "off" && isset($shipment_method_2_text) && $shipment_method_2_text != "" && $shipment_method_2 != "off") {
$shipment_method_send = $shipment_method_2;
$shipment_method_send_text = $shipment_method_2_text;
}

if ($_GET['shipment'] == 3 && isset($shipment_method_3) && $shipment_method_3 != "" && $shipment_method_3 != "off" && isset($shipment_method_3_text) && $shipment_method_3_text != "" && $shipment_method_3 != "off") {
$shipment_method_send = $shipment_method_3;
$shipment_method_send_text = $shipment_method_3_text;
}

if ($_GET['shipment'] == 4 && isset($shipment_method_4) && $shipment_method_4 != "" && $shipment_method_4 != "off" && isset($shipment_method_4_text) && $shipment_method_4_text != "" && $shipment_method_4 != "off") {
$shipment_method_send = $shipment_method_4;
$shipment_method_send_text = $shipment_method_4_text;
}

if ($_GET['shipment'] == 5 && isset($shipment_method_5) && $shipment_method_5 != "" && $shipment_method_5 != "off" && isset($shipment_method_5_text) && $shipment_method_5_text != "" && $shipment_method_5 != "off") {
$shipment_method_send = $shipment_method_5;
$shipment_method_send_text = $shipment_method_5_text;
}


if (isset($shipment_method_send_text) && $shipment_method_send_text != "" && $shipment_method_send_text != "off" && isset($shipment_method_send) && $shipment_method_send != "" && $shipment_method_send != "off")
//echo "Impuesto/descuento por <b>forma de envio</b>:<br>* ".$shipment_method_send_text.": ".$shipment_method_send;

$process_email_text .= "Impuesto/descuento por <b>forma de envio</b>:<br>* ".$shipment_method_send_text.":<br>";


                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($shipment_method_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($shipment_method_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($shipment_method_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($shipment_method_send, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($shipment_method_send, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor


$process_email_text .= "<br>";

//if (isset($total_basket_send) && isset($shipment_method_send)) {
//if($shipment_method_send < 0) {
//$total_basket_send = $total_basket_send - $shipment_method_send;
//} elseif($shipment_method_send > 0) {

if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {
$total_basket_send = $total_basket_send + $shipment_method_send;
}

//}

//}

unset($shipment_method_send_text);
unset($shipment_method_send);

}


}
//fin de impuestos por forma de pago.





//impuestos por forma de envio:
if (isset($payment_different_methods) && $payment_different_methods == "on") {

if (isset($_GET['payment']) && $_GET['payment'] != "") {

if ($_GET['payment'] == 1 && isset($payment_method_1) && $payment_method_1 != "" && $payment_method_1 != "off" && isset($payment_method_2_text) && $payment_method_1_text != "" && $payment_method_1 != "off") {
$payment_method_send = $payment_method_1;
$payment_method_send_text = $payment_method_1_text;
}

if ($_GET['payment'] == 2 && isset($payment_method_2) && $payment_method_2 != "" && $payment_method_2 != "off" && isset($payment_method_2_text) && $payment_method_2_text != "" && $payment_method_2 != "off") {
$payment_method_send = $payment_method_2;
$payment_method_send_text = $payment_method_2_text;
}

if ($_GET['payment'] == 3 && isset($payment_method_3) && $payment_method_3 != "" && $payment_method_3 != "off" && isset($payment_method_3_text) && $payment_method_3_text != "" && $payment_method_3 != "off") {
$payment_method_send = $payment_method_3;
$payment_method_send_text = $payment_method_3_text;
}

if ($_GET['payment'] == 4 && isset($payment_method_4) && $payment_method_4 != "" && $payment_method_4 != "off" && isset($payment_method_4_text) && $payment_method_4_text != "" && $payment_method_4 != "off") {
$payment_method_send = $payment_method_4;
$payment_method_send_text = $payment_method_4_text;
}

if ($_GET['payment'] == 5 && isset($payment_method_5) && $payment_method_5 != "" && $payment_method_5 != "off" && isset($payment_method_5_text) && $payment_method_5_text != "" && $payment_method_5 != "off") {
$payment_method_send = $payment_method_5;
$payment_method_send_text = $payment_method_5_text;
}


if (isset($payment_method_send_text) && $payment_method_send_text != "" && $payment_method_send_text != "off" && isset($payment_method_send) && $payment_method_send != "" && $payment_method_send != "off")
//echo "Impuesto/descuento por <b>forma de pago</b>:<br>* ".$payment_method_send_text.": ".$payment_method_send;


$process_email_text .= "Impuesto/descuento por <b>forma de pago</b>:<br>* ".$payment_method_send_text.":<br>";



                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($payment_method_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($payment_method_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($payment_method_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($payment_method_send, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($payment_method_send, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor





$process_email_text .= "<br>";

//if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {

if (isset($total_basket_send) && isset($payment_method_send)) {

//secho $payment_method_send."<br>";

//if($payment_method_send < 0) {
//echo "menor<br>";
//$total_basket_send = $total_basket_send - $payment_method_send;
//} elseif ($payment_method_send > 0) {
//echo "mayor<br>";
$total_basket_send = $total_basket_send + $payment_method_send;
//}
}

//}

unset($payment_method_send_text);
unset($payment_method_send);

}


}
//fin de impuestos por forma de envio.




//impuestos por fuera de zona:
if (isset($additional_cost_outside_text) && isset($additional_cost_outside) && $additional_cost_outside_text != "" && $additional_cost_outside != "" && $additional_cost_outside_text != "off" && $additional_cost_outside != "off" && is_numeric($additional_cost_outside)) {


if (isset($_GET['additional_cost_outside']) && $_GET['additional_cost_outside'] != "" && $_GET['additional_cost_outside'] == "on") {
$process_email_text .= "Impuesto/descuento <b>fuera de zona</b> (<b>CHECKBOX ACTIVADO</b>):<br>";
} else {
$process_email_text .= "Impuesto/descuento <b>fuera de zona</b> (<b>CHECKBOX DESACTIVADO</b>):<br>";
}

$process_email_text .= "* ".$additional_cost_outside_text.":<br>";
//$additional_cost_outside



                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($additional_cost_outside / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($additional_cost_outside / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($additional_cost_outside / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($additional_cost_outside / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($additional_cost_outside, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($additional_cost_outside, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor




if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {
$total_basket_send = $total_basket_send + $additional_cost_outside;
}

$process_email_text .= "<br>";

}

//}
//fin de impuestos por fuera de zona.






if (isset($total_basket_send)) {
//if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok") {


//echo "Total <b>con impuestos</b>: ".$total_basket_send;
//echo "<br><br>";


$process_email_text .= "<br><table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";

$process_email_text .= "Total <b>con impuestos</b>:<br>";







                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($total_basket_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($total_basket_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = wordwrap(number_format($total_basket_send / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           $process_email_text .= $money_usd_represent."<br>";

                                           $money_eur_represent = wordwrap(number_format($total_basket_send / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           $process_email_text .= $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           $process_email_text .= wordwrap(number_format($total_basket_send, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           $process_email_text .= wordwrap(number_format($total_basket_send, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor




$process_email_text .= "</td></tr></table>";




$process_email_text .= "<br>";



}
//}

















                         //Envio del E-Mail de confirmacion al cliente:                         

                         $process_email_text_reply = "<html><head><title>E-Mail enviado a ".$title_web." (Pedido)</title></head>\n\n";
                         $process_email_text_reply .= "<body>";
                         $process_email_text_reply .= "<h3>Pedido enviado correctamente</h3>\n\n";

                         $process_email_text_reply .= "<b>En caso de error, por favor, haganoslo saber lo antes posible enviandonos un E-Mail a: <a href=\"".$business_email."\">".$business_email."</a>";
                         
                         if (isset($contact_tlf) && $contact_tlf != "" && $contact_tlf != "off") {
                         $process_email_text_reply .= " o bien utilizando nuestro numero de telefono: ".$contact_tlf;
                         }
                         
                         $process_email_text_reply .= "</b><br><br><br>";

                         $process_email_text_reply .= "<b>Este es el texto que se ha enviado</b>:<br><br>";
                         $process_email_text_reply .= $process_email_text;
                         $process_email_text_reply .= "</body></html>";

                         $process_send_headers_reply ="Date: ".date("l j F Y, G:i")."\r\n"; 
                         $process_send_headers_reply .="MIME-Version: 1.0\r\n"; 
                         $process_send_headers_reply .="From: ".$title_web."<".$business_email.">\r\n";
                         $process_send_headers_reply .="Return-path: " . $email_error . "\r\n";
                         $process_send_headers_reply .="Reply-To: " . $business_email . "\r\n";
                         $process_send_headers_reply .="Errors-To: " . $email_error . "\r\n";
                         $process_send_headers_reply .="X-Personal_name: ".$title_web."\r\n";
                         $process_send_headers_reply .= "X-Mailer:PHP/".phpversion()."\r\n"; 

                         if (isset($send_emails_format) && $send_emails_format != "html" || !isset($send_emails_format)) {
                         $process_email_text_reply = strip_tags(eregi_replace("<br>", "\n", $process_email_text_reply));
                         } elseif (isset($send_emails_format) && $send_emails_format == "html") {
                         $process_send_headers_reply .="Content-type: text/html; charset=iso-8859-1\r\n"; 
                         }



                         if (isset($_SESSION['process_send_email']) && $_SESSION['process_send_email'] != "") {
                         $process_email_reply_var = @mail(urldecode($_SESSION['process_send_email']), "[".$title_web."] E-Mail de Pedido enviado correctamente: " . urldecode($_SESSION['process_send_subject']), $process_email_text_reply, $process_send_headers_reply);
                         }

















//}




                         if(isset($spy_route_client) && $spy_route_client == "on" && isset($_SESSION['spy_route']) && $_SESSION['spy_route'] != "") {
                         
                         if (isset($send_emails_format) && $send_emails_format == "html") { $process_email_text .= "<br><br>".nl2br($_SESSION['spy_route'])."<br><br>"; }
                         else { $process_email_text .= "<br><br>".$_SESSION['spy_route']."<br><br>"; }
                         }
                         
                         $process_email_text .= "</body></html>";

//                         if (!isset($title_web)) { $title_web = "Company Title"; }

                          $process_send_headers ="Date: ".date("l j F Y, G:i")."\r\n"; 
                          $process_send_headers .="MIME-Version: 1.0\r\n"; 
//                          $contact_send_headers .="From: ".urldecode($_SESSION['contact_send_name'])."<".urldecode($_SESSION['contact_send_email']).">º\r\n";

                          if (isset($_SESSION['process_send_email']) && $_SESSION['process_send_email'] != "") {
                          $process_send_headers .="From: ".urldecode($_SESSION['process_send_name'])."<".urldecode($_SESSION['process_send_email']).">\r\n";
                          } else {
                          $process_send_headers .="From: ".urldecode($_SESSION['process_send_name'])."<unknown@unknown.un>\r\n";
                          }

                          //Esto creo que es para que te envien notificacion de no se pudo enviar:
//                          $contact_send_headers .="Return-path: " . urldecode($_SESSION['contact_send_email']) . "\r\n";
                          $process_send_headers .="Return-path: " . $email_error . "\r\n";

                          if (isset($_SESSION['process_send_email']) && $_SESSION['process_send_email'] != "") {
                          $process_send_headers .="Reply-To: " . urldecode($_SESSION['process_send_email']) . "\r\n";
                          } else {
                          $process_send_headers .="Reply-To: unknown@unknown.un\r\n";
                          }

                          $process_send_headers .="Errors-To: " . $email_error . "\r\n";

                          //Faltan cabeceras: Cc, etc. para enviar replicas por si el primer E-Mail falla.

                          if (isset($email_cc) && $email_cc != "" && $email_cc != "off") {
                          $process_send_headers .="Cc: " . $email_cc . "\r\n";
                          }

                          if (isset($email_bcc) && $email_bcc != "" && $email_bcc != "off") {
                          $process_send_headers .="Bcc: " . $email_bcc . "\r\n";
                          }

                          $process_send_headers .="X-Personal_name: ".urldecode($_SESSION['process_send_name'])."\r\n";
                          
                          $process_send_headers .= "X-Mailer:PHP/".phpversion()."\r\n"; 


                          
                          //Cuidado de las lineas:
                          if (isset($send_emails_format) && $send_emails_format != "html" || !isset($send_emails_format)) {

                          $process_email_text = strip_tags(eregi_replace("<br>", "\n", $process_email_text));
                                                 
                          } elseif (isset($send_emails_format) && $send_emails_format == "html") {
                          $process_send_headers .="Content-type: text/html; charset=iso-8859-1\r\n"; 
                          }


                         if (!isset($emails_max)) { $emails_max = "25"; }
                         if (!isset($emails_max_expire_secs)) { $emails_max_expire_secs = "300"; }




                               //Cuidado con el siguiente if:
                               
                               if(isset($_SESSION['email_flood']) && $_SESSION['email_flood'] >= $emails_max && !isset($_SESSION['first_email_flood'])) {

                               //echo "<br>Se crea temporizador<br>";

                               $_SESSION['first_email_flood'] = time();

                               }


              
                         if (isset($_SESSION['first_email_flood'])) { $_SESSION['first_email_rest'] = time() - $_SESSION['first_email_flood']; }


                         if(isset($_SESSION['first_email_rest']) && $_SESSION['first_email_rest'] > $emails_max_expire_secs) { $_SESSION['email_flood'] = 0;
                         //$_SESSION['first_email_flood'] = time();

                         //Cuidado:
                         unset($_SESSION['first_email_flood']);

                         }

                         if (!isset($_SESSION['email_flood']) || isset($_SESSION['email_flood']) && $_SESSION['email_flood'] < $emails_max) {

                         if (isset($_GET['manual']) && $_GET['manual'] == "ok") {
                         $process_email_var = @mail($business_email, "[Pedido manual] (enviado por: " . urldecode($_SESSION['process_send_name']).") - E-Mail enviado desde la web ".$title_web, $process_email_text, $process_send_headers);
                         } else {
                         $process_email_var = @mail($business_email, "[Pedido] (enviado por: " . urldecode($_SESSION['process_send_name']).") - E-Mail enviado desde la web ".$title_web, $process_email_text, $process_send_headers);
                         }

//                         $contact_email_var = @mail("sdafdasfdsa@sadfsadfasdfasdfasdfsadfds.com", "[Contacto] " . urldecode($_SESSION['contact_send_subject'])." (enviado por: ".urldecode($_SESSION['contact_send_name']).") - E-Mail enviado desde la web ".$title_web, $contact_email_text, $contact_send_headers);
                         $process_email_var_ok = "ok";

                         //Cuidado:
//                         unset($_SESSION['first_email_flood']);
                         unset($_SESSION['first_email_rest']);
                         

                         }  else {

                         $first_email_rest_operation = $emails_max_expire_secs - $_SESSION['first_email_rest'];

                         echo "Ha enviado demasiados E-Mails (".$emails_max." emails). No puede enviar mas hasta dentro de: ".$first_email_rest_operation." segundos.<br>";
                        
                         $process_email_var_ok = "flood";
                         $process_email_var = "flood";

                         }

                         if($process_email_var && isset($process_email_var_ok) && $process_email_var_ok == "ok") {

                         echo "<b>E-Mail enviado correctamente</b> (enviado a <a href=\"mailto:".$business_email."?subject='email_en_pedido'\">".$business_email."</a>)";




                         if ($process_email_reply_var) {
                         echo "<br>Se le envio una notificacion de conformacion a su direccion.";
                         } else {
                         echo "<br>No se le pudo enviar una notificacion de confirmacion a su direccion.";
                         }





//                         echo "<br><br>Puede consultar las diversas formas de contactar con nosotros, siempre que sea posible, en la seccion de ";
                         echo "<br><br>Si lo desea, puede consultar las diversas formas de contactar con nosotros, siempre que sea posible, en la seccion de ";

                         if (SID) {
                         echo "<a href=\"".$contact_file."?".SID."\">Contacto</a>";
                         } else {
                         echo "<a href=\"".$contact_file."\">Contacto</a>";
                         }

                               if(isset($_SESSION['first_email_flood'])) {
                               if(isset($_SESSION['first_email_rest']) && $_SESSION['first_email_rest'] > $emails_max_expire_secs) { $_SESSION['email_flood'] = 0; $_SESSION['first_email_flood'] = time(); }
                               } elseif(!isset($_SESSION['first_email_flood'])) {


                               //Cuidado con el siguiente if:
                               
                               if(isset($_SESSION['email_flood']) && $_SESSION['email_flood'] >= $emails_max) {

                               echo "<br>Se crea temporizador<br>";

                               $_SESSION['first_email_flood'] = time();                         

                               }

                               }

//                         if (isset($_SESSION['spy_ip']) && $_SESSION['spy_ip'] == $_SERVER['REMOTE_ADDR'] && isset($_SESSION['spy_browser']) && $_SESSION['spy_browser'] == $_SERVER["HTTP_USER_AGENT"]) {
                         if (isset($_SESSION['email_flood']) && $_SESSION['email_flood'] >= 1) {

                         $_SESSION['email_flood']++;

                         }
//                         elseif(!isset($_SESSION['spy_ip']) || !isset($_SESSION['spy_browser'])) {
  //                       $_SESSION['email_flood'] = 1;
    //                     }
                         else {
                         $_SESSION['email_flood'] = 1;
                         }
                         
                         }

                         else {
                         //Falta: enviar un email al administrador ($error_mail) en caso de error.
                         echo "<br><b><u>Error</u></b>: <b>No se pudo enviar el E-Mail</b>";
                         
                         $process_error_type = "error sin especificar";
                         
                         if (isset($process_email_var_ok) && $process_email_var_ok == "flood" && isset($process_email_var) && $process_email_var == "flood") {
                         echo " - (posible ataque de flood)";

                         $first_email_rest_operation = $emails_max_expire_secs - $_SESSION['first_email_rest'];

                         $process_error_type = " - posible ataque de flood (".$_SESSION['email_flood']." emails. Tiempo de castigo: ".$emails_max_expire_secs." segundos, faltan: ".$first_email_rest_operation.")";
                         }



                         if (isset($_GET['manual']) && $_GET['manual'] == "ok") {
                         $process_email_error_var = @mail($email_error, "ERROR AL ENVIAR: [Pedido manual] (enviado por: ".urldecode($_SESSION['process_send_name']).") - E-Mail enviado desde la web ".$title_web." ".$contact_error_type, $process_email_text, $process_send_headers);
                         } else {
                         $process_email_error_var = @mail($email_error, "ERROR AL ENVIAR: [Pedido] (enviado por: ".urldecode($_SESSION['process_send_name']).") - E-Mail enviado desde la web ".$title_web." ".$contact_error_type, $process_email_text, $process_send_headers);
                         }
                         
                         
                         if($process_email_error_var) { echo "<br><br><b>Se envio una notificacion del error</b>"; }
                         else {
                         echo "<br><br><b><u>No</u> se pudo enviar una notificacion del error.</b>";
                       
                         }                                                 
                         
                         echo "<br><br>Puede intentar ";
                         
                         if (SID) {
                         echo "<a href=\"".$this_file."?".SID."&process=ok\">";
                         } else {
                         echo "<a href=\"".$this_file."?process=ok\">";
                         }
                         
                         echo "volver a enviar el E-Mail</a> o bien escribirnos a <a href=\"mailto:".$business_email."?subject=error_pedido\">".$business_email."</a>";
//                         echo "<br><br>Tambien puede consultar otras formas de contacto, siempre que sea posible, obteniendo los datos necesarios en esta misma pagina";
//                         echo "<br><br>Tambien puede consultar otras formas de contacto, siempre que sea posible, en la seccion de ";
                         echo "<br><br>Si lo desea, puede consultar las diversas formas de contactar con nosotros, siempre que sea posible, en la seccion de ";
                         if (SID) {
                         echo "<a href=\"".$contact_file."?".SID."\">Contacto</a>";
                         } else {
                         echo "<a href=\"".$contact_file."\">Contacto</a>";
                         }

                        
                         }
                        
//                         }







                         

//                         echo "Step 3";

                         }
                         
//                         }







                         if (isset($_GET['step']) && $_GET['step'] == "1" || !isset($_GET['step']) || isset($_GET['step']) && $_GET['step'] != "2" && $_GET['step'] != "3") {

//                         if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
                         

                         //La cesta de compra esta vacia (comprobarlo!), se muestra opcion manual (si $user_can_send_order_manually == "on"):
                         // Formulario tipo AlbaPatchowork.com
                         // Enviar a ?step=3&type=manual

//                         echo "Step 1 manual";



//                         } else {


                         //Primer paso:
                         // Opcion de seguir comprando siempre.
                         // Si esta vacia la cesta de compra, mostrar opcion manual (enlace a $this_file?step=1&basket=void) (si $user_can_send_order_manually == "on").
                         // Si la cesta no esta vacia:
                         // · Enseñar cesta de compra (sin poder modificarla, aunque con una opcion de modificarla: enlace a basket_file).
                         // · Poner formulario para rellenar (rellenado automatico si ya existen variables de sesion del form de contacto).
                         // · Casilla de impuestos fuera de zona (se debe marcar para sumar el impuesto).



//echo $_GET['step'];




//Calculamos si la cesta esta vacia:

$basket_send_is_empty = "yes";

if (isset($_SESSION['basket_ref'])) {

foreach ($_SESSION['basket_ref'] as $ref_actual) {

if (isset($ref_actual) && $_SESSION['basket_quantity'][$ref_actual] != "0") {

$basket_send_is_empty = "no";

}

}

}


if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
$basket_send_is_empty = "no";
}

//if (isset($_GET['manual']) && $_GET['manual'] != "ok") {
//$basket_send_is_empty = "no";
//}

//if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
//$basket_send_is_empty = "yes";
//}

if (isset($basket_send_is_empty) && $basket_send_is_empty == "yes" || !isset($basket_send_is_empty)) {
//if (isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {

unset($basket_send_is_empty);

//echo "Cesta vacia";

echo "<br><br><i>La cesta de compra <b>no contiene productos</b></i>.<br>"; unset($basket_empty);

if (isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
echo "Si la cesta de compra no le funciona o no le parece conveniente, puede realizar un ";

if (SID) {
echo "<a href=\"".$this_file."?process=ok&manual=ok&".SID."\">pedido manual</a>";
} else {
echo "<a href=\"".$this_file."?process=ok&manual=ok\">pedido manual</a>";
}

echo " (<b>no recomendamos</b> esta opcion, a no ser que <b>no pueda utilizar la cesta de compra</b>)<br><br>";
}


} else {
unset($basket_send_is_empty);


if (!isset($_GET['manual']) || isset($_GET['manual']) && $_GET['manual'] != "ok" || !isset($user_can_send_order_manually) || isset($user_can_send_order_manually) && $user_can_send_order_manually == "off") {
//echo "<br><br>";
//echo "Opcion de seguir comprando y de modificar tabla";
if (SID) {
echo "<a href=\"".$basket_file."?".SID."\">Modificar cesta de compra</a>";
} else {
echo "<a href=\"".$basket_file."\">Modificar cesta de compra</a>";
}


echo "<br><br><br>";

echo "<a name=\"form\"></a>";
echo "<b>Si la cesta de compra es correcta, rellene el siguiente formulario para completar el pedido:</b><br><br>";

} elseif (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually != "off") {

echo "<b>Pedido manual:</b><br><br>";



$basket_send_is_empty = "yes";

if (isset($_SESSION['basket_ref'])) {

foreach ($_SESSION['basket_ref'] as $ref_actual) {

if (isset($ref_actual) && $_SESSION['basket_quantity'][$ref_actual] != "0") {

$basket_send_is_empty = "no";

}

}

}


//if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {
//$basket_send_is_empty = "no";
//}

if (isset($basket_send_is_empty) && $basket_send_is_empty == "no") {
//if (isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {

unset($basket_send_is_empty);

//echo "<b>Atencion:</b> se ha detectado que la cesta de compra podria no estar vacia. Solo aconsejamos la modalidad de pedido manual cuando la cesta de compra no funciona.<br><br>";

echo "<b>Atencion:</b> se ha detectado que la ";

if (SID) {
echo "<a href=\"".$basket_file."?".SID."\">cesta de compra</a>";
} else {
echo "<a href=\"".$basket_file."\">cesta de compra</a>";
}

echo " podria no estar vacia. Solo aconsejamos la modalidad de pedido manual cuando la cesta de compra no funciona.<br><br>";



}


}

echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\"><tr><td>";
echo "<b>Formulario</b> con sus datos:";
echo "</td></tr>";

echo "<tr><td>";

//if (isset($_SESSION['contact_send_name']) && $_SESSION['contact_send_name'] != "" && !isset($_SESSION['contact_send_name']) || isset($__SESSION['contact_send_name']) && $__SESSION['contact_send_name'] != "" && isset($_GET['contact_send_name']) && $_GET['contact_send_name'] != "") { $_GET['process_send_name'] = $__SESSION['contact_send_name']; }
//if (isset($_SESSION['contact_send_email']) && $_GET['contact_send_email'] != "" && !isset($_GET['contact_send_email']) || isset($_GET['contact_send_email']) && $_GET['contact_send_email'] != "" && isset($_GET['contact_send_email']) && $_GET['contact_send_email'] != "") { $_GET['process_send_email'] = $__SESSION['contact_send_email']; }
//if (isset($_SESSION['contact_send_tel']) && $_GET['contact_send_tel'] != "" && !isset($_GET['contact_send_tel']) || isset($_GET['contact_send_tel']) && $_GET['contact_send_tel'] != "" && isset($_GET['contact_send_tel']) && $_GET['contact_send_tel'] != "") { $_GET['process_send_tel'] = $__SESSION['contact_send_tel']; }
//if (isset($_SESSION['contact_send_subject']) && $_GET['contact_send_subject'] != "" && !isset($_GET['contact_send_subject']) || isset($_GET['contact_send_subject']) && $_GET['contact_send_subject'] != "" && isset($_GET['contact_send_subject']) && $_GET['contact_send_subject'] != "") { $_GET['process_send_subject'] = $__SESSION['contact_send_subject']; }
//if (isset($_SESSION['contact_send_text']) && $_GET['contact_send_text'] != "" && !isset($_GET['contact_send_text']) || isset($_GET['contact_send_text']) && $_GET['contact_send_text'] != "" && isset($_GET['contact_send_text']) && $_GET['contact_send_text'] != "") { $_GET['process_send_text'] = $__SESSION['contact_send_text']; }





                         if (isset($_SESSION['process_send_name']) && !isset($_GET['process_send_name'])) { $_GET['process_send_name'] = $_SESSION['process_send_name']; }
                         if (isset($_SESSION['process_send_email']) && !isset($_GET['process_send_email'])) { $_GET['process_send_email'] = $_SESSION['process_send_email']; }
                         if (isset($_SESSION['process_send_tel']) && !isset($_GET['process_send_tel'])) { $_GET['process_send_tel'] = $_SESSION['process_send_tel']; }
                         if (isset($_SESSION['process_send_address']) && !isset($_GET['process_send_address'])) { $_GET['process_send_address'] = $_SESSION['process_send_address']; }
                         if (isset($_SESSION['process_send_location']) && !isset($_GET['process_send_location'])) { $_GET['process_send_location'] = $_SESSION['process_send_location']; }
                         if (isset($_SESSION['process_send_cp']) && !isset($_GET['process_send_cp'])) { $_GET['process_send_cp'] = $_SESSION['process_send_cp']; }
                         if (isset($_SESSION['process_send_country']) && !isset($_GET['process_send_country'])) { $_GET['process_send_country'] = $_SESSION['process_send_country']; }


                         if (isset($_SESSION['additional_cost_outside']) && !isset($_GET['additional_cost_outside'])) { $_GET['additional_cost_outside'] = $_SESSION['additional_cost_outside']; }


//                         if (isset($_SESSION['process_send_subject']) && !isset($_GET['process_send_subject'])) { $_GET['process_send_subject'] = $_SESSION['process_send_subject']; }
                         if (isset($_SESSION['process_send_text']) && !isset($_GET['process_send_text'])) { $_GET['process_send_text'] = $_SESSION['process_send_text']; }

//address, location, cp, country



                         if (isset($process_form_errors) && $process_form_errors != "") { echo "<table cellspacing=\"0\" cellpadding=\"5\" border=\"1\"><tr><td><b>ERROR en formulario</b>:<br>"; echo $process_form_errors; echo "</td></tr></table><br>"; } ?>

                         <form action="<?php echo $this_file; ?>" method="get" style="display:inline;">

                         <input type="hidden" name="step" value="2">
                         <input type="hidden" name="process" value="ok">

                         <?php
                         if (isset($_GET['manual']) && $_GET['manual'] == "ok") {
                         ?>
                         <input type="hidden" name="manual" value="ok">
                         <?php
                         }
                         ?>
                         
                         
                         <br>
                         <label for="process_send_name" accesskey="n">
                         Su <b><u>N</u>ombre</b>:<br>
                         <input type="text" name="process_send_name"<?php if(isset($_GET['process_send_name'])) { echo " value=\"".urldecode($_GET['process_send_name'])."\""; } elseif(isset($_SESSION['process_send_name'])) { echo " value=\"".urldecode($_SESSION['process_send_name'])."\""; } elseif(isset($_SESSION['contact_send_name'])) { echo " value=\"".urldecode($_SESSION['contact_send_name'])."\""; } ?> id="process_send_name" accesskey="n">
                         </label>
                         
                         <br><br>
                         <label for="process_send_email" accesskey="m">
                         Su <b>E-<u>M</u>ail</b> (si lo considera necesario):<br>
                         <input type="text" name="process_send_email"<?php if(isset($_GET['process_send_email'])) { echo " value=\"".urldecode($_GET['process_send_email'])."\""; } elseif(isset($_SESSION['process_send_email'])) { echo " value=\"".urldecode($_SESSION['process_send_email'])."\""; } elseif(isset($_SESSION['contact_send_email'])) { echo " value=\"".urldecode($_SESSION['contact_send_email'])."\""; } ?> id="process_send_email" accesskey="m">
                         </label>
                         
                         <br><br>
                         <label for="process_send_tel" accesskey="t">
                         Su/s <b><u>T</u>elefono</b>/<b>s</b> (si lo considera necesario):<br>
                         <input type="text" name="process_send_tel"<?php if(isset($_GET['process_send_tel'])) { echo " value=\"".urldecode($_GET['process_send_tel'])."\""; } elseif(isset($_SESSION['process_send_tel'])) { echo " value=\"".urldecode($_SESSION['process_send_tel'])."\""; } elseif(isset($_SESSION['contact_send_tel'])) { echo " value=\"".urldecode($_SESSION['contact_send_tel'])."\""; } ?> id="process_send_tel" accesskey="t">
                         </label>

                         <br><br>
                         <label for="process_send_address" accesskey="d">
                         Su <b><u>D</u>ireccion</b>:<br>
                         <input type="text" name="process_send_address"<?php if(isset($_GET['process_send_address'])) { echo " value=\"".urldecode($_GET['process_send_address'])."\""; } elseif(isset($_SESSION['process_send_address'])) { echo " value=\"".urldecode($_SESSION['process_send_address'])."\""; } elseif(isset($_SESSION['contact_send_address'])) { echo " value=\"".urldecode($_SESSION['contact_send_address'])."\""; } ?> id="process_send_address" accesskey="d">
                         </label>

                         <br><br>
                         <label for="process_send_location" accesskey="l">
                         Su <b><u>L</u>ocalidad</b>:<br>
                         <input type="text" name="process_send_location"<?php if(isset($_GET['process_send_location'])) { echo " value=\"".urldecode($_GET['process_send_location'])."\""; } elseif(isset($_SESSION['process_send_location'])) { echo " value=\"".urldecode($_SESSION['process_send_location'])."\""; } elseif(isset($_SESSION['contact_send_location'])) { echo " value=\"".urldecode($_SESSION['contact_send_location'])."\""; } ?> id="process_send_location" accesskey="l">
                         </label>

                         <br><br>
                         <label for="process_send_cp" accesskey="p">
                         Su <b>Codigo <u>P</u>ostal</b>:<br>
                         <input type="text" name="process_send_cp"<?php if(isset($_GET['process_send_cp'])) { echo " value=\"".urldecode($_GET['process_send_cp'])."\""; } elseif(isset($_SESSION['process_send_cp'])) { echo " value=\"".urldecode($_SESSION['process_send_cp'])."\""; } elseif(isset($_SESSION['contact_send_cp'])) { echo " value=\"".urldecode($_SESSION['contact_send_cp'])."\""; } ?> id="process_send_cp" accesskey="p">
                         </label>

                         <br><br>
                         <label for="process_send_country" accesskey="a">
                         Su <b>P<u>a</u>is</b>:<br>
                         <input type="text" name="process_send_country"<?php if(isset($_GET['process_send_country'])) { echo " value=\"".urldecode($_GET['process_send_country'])."\""; } elseif(isset($_SESSION['process_send_country'])) { echo " value=\"".urldecode($_SESSION['process_send_country'])."\""; } elseif(isset($_SESSION['contact_send_country'])) { echo " value=\"".urldecode($_SESSION['contact_send_country'])."\""; } ?> id="process_send_country" accesskey="a">
                         </label>

                         <!--
                         <br><br><b>Asunto</b> o Tema:<br>
                         <input type="text" name="process_send_subject"<?php if(isset($_GET['process_send_subject'])) { echo " value=\"".urldecode($_GET['process_send_subject'])."\""; } elseif(isset($_SESSION['process_send_subject'])) { echo " value=\"".urldecode($_SESSION['process_send_subject'])."\""; } elseif(isset($_SESSION['contact_send_subject'])) { echo " value=\"".urldecode($_SESSION['contact_send_subject'])."\""; } ?>>
                         -->
                         
<?php
if (isset($additional_cost_outside_text) && $additional_cost_outside_text != "off" && $additional_cost_outside_text != "" && isset($additional_cost_outside) && $additional_cost_outside != "off" && $additional_cost_outside_text != "") {
?>

<br>

<label for="additional_cost_outside">
<input type="checkbox" name="additional_cost_outside"<?php if (isset($_SESSION['additional_cost_outside']) && $_SESSION['additional_cost_outside'] == "on" || isset($_GET['additional_cost_outside']) && $_GET['additional_cost_outside'] == "on") { echo " CHECKED"; } ?> id="additional_cost_outside">

<?php


echo "<b>".$additional_cost_outside_text."</b>:<br>";
echo "</label>";



                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
//                                           echo "Manda EUR<br><br>";
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = "+ ".wordwrap(number_format($additional_cost_outside / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
//nl2br(wordwrap($ref_actual,  4, "<br>", 1))
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = "+ ".wordwrap(number_format($additional_cost_outside / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {
//                                           echo "Manda USD<br><br>";

                                           $money_usd_represent = "+ ".wordwrap(number_format($additional_cost_outside / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";

                                           $money_eur_represent = "+ ".wordwrap(number_format($additional_cost_outside / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 10, "<br>", 1).$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo "+ ".wordwrap(number_format($additional_cost_outside, 2, ",", "."), 10, "<br>", 1).$money_default;
                                           } else {
                                           echo "+ ".wordwrap(number_format($additional_cost_outside, 2, ",", "."), 10, "<br>", 1)." EUR";
                                           }
                                           }


                                           //Fin de la opcion del conversor










?>






<?php
} else {
?>


                         <br>
                         <br>

<?php
}

if (isset($_GET['manual']) && $_GET['manual'] == "ok" && isset($user_can_send_order_manually) && $user_can_send_order_manually == "on") {


echo "<label for=\"process_send_text\" accesskey=\"i\">";
echo "<br>Su <b>Ped<u>i</u>do</b> de forma manual:<br>Porfavor, acuerdese de indicar <b>Referencia</b>, <b>Nombre</b> y <b>Cantidad</b> de cada producto.<br>";

?>
                         <textarea cols="35" rows="5" name="process_send_text" id="process_send_text" accesskey="i"><?php if(isset($_GET['process_send_text'])) { echo urldecode($_GET['process_send_text']); } elseif(isset($_SESSION['process_send_text'])) { echo urldecode($_SESSION['process_send_text']); } ?></textarea>
                         </label>
<?php

} else {
?>
                         
                         <label for="process_send_text" accesskey="s">
                         <br><b>Comentario<u>s</u></b>:<br>

                         <textarea cols="35" rows="5" name="process_send_text" id="process_send_text" accesskey="s"><?php if(isset($_GET['process_send_text'])) { echo urldecode($_GET['process_send_text']); } elseif(isset($_SESSION['process_send_text'])) { echo urldecode($_SESSION['process_send_text']); } ?></textarea>
                         </label>

<?php
}
?>






<br>

<?php
if (isset($shipment_different_methods) && $shipment_different_methods == "on") {
?>
<br>
<br>

<label for="shipment" accesskey="f">
<b><u>F</u>orma de envio</b>:<br>

<select name="shipment" id="shipment" accesskey="f">


<?php
if (isset($shipment_method_1_text) && $shipment_method_1_text != "off" && $shipment_method_1_text != "" && isset($shipment_method_1) && $shipment_method_1 != "off" && $shipment_method_1 != "") {
if (isset($_GET['shipment']) && is_numeric($_GET['shipment']) && $_GET['shipment'] == 1) {
echo "<option value=\"1\" selected>".$shipment_method_1_text." (".$shipment_method_1.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"1\">".$shipment_method_1_text." (".$shipment_method_1.strip_tags($money_default).")</option>";
}
}
if (isset($shipment_method_2_text) && $shipment_method_2_text != "off" && $shipment_method_2_text != "" && isset($shipment_method_2) && $shipment_method_2 != "off" && $shipment_method_2 != "") {
if (isset($_GET['shipment']) && is_numeric($_GET['shipment']) && $_GET['shipment'] == 2) {
echo "<option value=\"2\" selected>".$shipment_method_2_text." (".$shipment_method_2.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"2\">".$shipment_method_2_text." (".$shipment_method_2.strip_tags($money_default).")</option>";
}
}
if (isset($shipment_method_3_text) && $shipment_method_3_text != "off" && $shipment_method_3_text != "" && isset($shipment_method_3) && $shipment_method_3 != "off" && $shipment_method_3 != "") {
if (isset($_GET['shipment']) && is_numeric($_GET['shipment']) && $_GET['shipment'] == 3) {
echo "<option value=\"3\" selected>".$shipment_method_3_text." (".$shipment_method_3.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"3\">".$shipment_method_3_text." (".$shipment_method_3.strip_tags($money_default).")</option>";
}
}
if (isset($shipment_method_4_text) && $shipment_method_4_text != "off" && $shipment_method_4_text != "" && isset($shipment_method_4) && $shipment_method_4 != "off" && $shipment_method_4 != "") {
if (isset($_GET['shipment']) && is_numeric($_GET['shipment']) && $_GET['shipment'] == 4) {
echo "<option value=\"4\" selected>".$shipment_method_4_text." (".$shipment_method_4.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"4\">".$shipment_method_4_text." (".$shipment_method_4.strip_tags($money_default).")</option>";
}
}
if (isset($shipment_method_5_text) && $shipment_method_5_text != "off" && $shipment_method_5_text != "" && isset($shipment_method_5) && $shipment_method_5 != "off" && $shipment_method_5 != "") {
if (isset($_GET['shipment']) && is_numeric($_GET['shipment']) && $_GET['shipment'] == 5) {
echo "<option value=\"5\" selected>".$shipment_method_5_text." (".$shipment_method_5.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"5\">".$shipment_method_5_text." (".$shipment_method_5.strip_tags($money_default).")</option>";
}
}
?>

</select>
</label>

<br>

<?php
}
?>















<?php
if (isset($shipment_different_methods) && $shipment_different_methods == "on") {
echo "<font size=\"2\">";

if (isset($shipment_method_1_text) && $shipment_method_1_text != "off" && $shipment_method_1_text != "" && isset($shipment_method_1) && $shipment_method_1 != "off" && $shipment_method_1 != "") {

echo "* <b>".$shipment_method_1_text."</b>:";

if ($shipment_method_1 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_1 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($shipment_method_1 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($shipment_method_1 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_1 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($shipment_method_1, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($shipment_method_1, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}

if (isset($shipment_method_2_text) && $shipment_method_2_text != "off" && $shipment_method_2_text != "" && isset($shipment_method_2) && $shipment_method_2 != "off" && $shipment_method_2 != "") {
echo "* <b>".$shipment_method_2_text."</b>:";

if ($shipment_method_2 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_2 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($shipment_method_2 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($shipment_method_2 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_2 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($shipment_method_2, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($shipment_method_2, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}
if (isset($shipment_method_3_text) && $shipment_method_3_text != "off" && $shipment_method_3_text != "" && isset($shipment_method_3) && $shipment_method_3 != "off" && $shipment_method_3 != "") {
echo "* <b>".$shipment_method_3_text."</b>:";

if ($shipment_method_3 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_3 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($shipment_method_3 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($shipment_method_3 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_3 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($shipment_method_3, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($shipment_method_3, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}
if (isset($shipment_method_4_text) && $shipment_method_4_text != "off" && $shipment_method_4_text != "" && isset($shipment_method_4) && $shipment_method_4 != "off" && $shipment_method_4 != "") {
echo "* <b>".$shipment_method_4_text."</b>:";

if ($shipment_method_4 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_4 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($shipment_method_4 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($shipment_method_4 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_4 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($shipment_method_4, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($shipment_method_4, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}
if (isset($shipment_method_5_text) && $shipment_method_5_text != "off" && $shipment_method_5_text != "" && isset($shipment_method_5) && $shipment_method_5 != "off" && $shipment_method_5 != "") {
echo "* <b>".$shipment_method_5_text."</b>:";

if ($shipment_method_5 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_5 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($shipment_method_5 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($shipment_method_5 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($shipment_method_5 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($shipment_method_5, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($shipment_method_5, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}
?>


</font>

<?php
}
?>











<?php
if (isset($payment_different_methods) && $payment_different_methods == "on") {
?>
<br>
<br>

<label for="payment" accesskey="r">
<b>Fo<u>r</u>ma de pago</b>:<br>

<select name="payment" id="payment" accesskey="r">


<?php
if (isset($payment_method_1_text) && $payment_method_1_text != "off" && $payment_method_1_text != "" && isset($payment_method_1) && $payment_method_1 != "off" && $payment_method_1 != "") {
if (isset($_GET['payment']) && is_numeric($_GET['payment']) && $_GET['payment'] == 1) {
echo "<option value=\"1\" selected>".$payment_method_1_text." (".$payment_method_1.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"1\">".$payment_method_1_text." (".$payment_method_1.strip_tags($money_default).")</option>";
}
}
if (isset($payment_method_2_text) && $payment_method_2_text != "off" && $payment_method_2_text != "" && isset($payment_method_2) && $payment_method_2 != "off" && $payment_method_2 != "") {
if (isset($_GET['payment']) && is_numeric($_GET['payment']) && $_GET['payment'] == 2) {
echo "<option value=\"2\" selected>".$payment_method_2_text." (".$payment_method_2.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"2\">".$payment_method_2_text." (".$payment_method_2.strip_tags($money_default).")</option>";
}
}
if (isset($payment_method_3_text) && $payment_method_3_text != "off" && $payment_method_3_text != "" && isset($payment_method_3) && $payment_method_3 != "off" && $payment_method_3 != "") {
if (isset($_GET['payment']) && is_numeric($_GET['payment']) && $_GET['payment'] == 3) {
echo "<option value=\"3\" selected>".$payment_method_3_text." (".$payment_method_3.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"3\">".$payment_method_3_text." (".$payment_method_3.strip_tags($money_default).")</option>";
}
}
if (isset($payment_method_4_text) && $payment_method_4_text != "off" && $payment_method_4_text != "" && isset($payment_method_4) && $payment_method_4 != "off" && $payment_method_4 != "") {
if (isset($_GET['payment']) && is_numeric($_GET['payment']) && $_GET['payment'] == 4) {
echo "<option value=\"4\" selected>".$payment_method_4_text." (".$payment_method_4.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"4\">".$payment_method_4_text." (".$payment_method_4.strip_tags($money_default).")</option>";
}
}
if (isset($payment_method_5_text) && $payment_method_5_text != "off" && $payment_method_5_text != "" && isset($payment_method_5) && $payment_method_5 != "off" && $payment_method_5 != "") {
if (isset($_GET['payment']) && is_numeric($_GET['payment']) && $_GET['payment'] == 5) {
echo "<option value=\"5\" selected>".$payment_method_5_text." (".$payment_method_5.strip_tags($money_default).")</option>";
} else {
echo "<option value=\"5\">".$payment_method_5_text." (".$payment_method_5.strip_tags($money_default).")</option>";
}
}
?>

</select>

</label>

<br>


<?php
}
?>


















<?php
if (isset($payment_different_methods) && $payment_different_methods == "on") {
echo "<font size=\"2\">";

if (isset($payment_method_1_text) && $payment_method_1_text != "off" && $payment_method_1_text != "" && isset($payment_method_1) && $payment_method_1 != "off" && $payment_method_1 != "") {

echo "* <b>".$payment_method_1_text."</b>:";

if ($payment_method_1 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_1 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($payment_method_1 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($payment_method_1 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_1 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($payment_method_1, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($payment_method_1, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}

if (isset($payment_method_2_text) && $payment_method_2_text != "off" && $payment_method_2_text != "" && isset($payment_method_2) && $payment_method_2 != "off" && $payment_method_2 != "") {
echo "* <b>".$payment_method_2_text."</b>:";

if ($payment_method_2 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_2 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($payment_method_2 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($payment_method_2 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_2 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($payment_method_2, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($payment_method_2, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}
if (isset($payment_method_3_text) && $payment_method_3_text != "off" && $payment_method_3_text != "" && isset($payment_method_3) && $payment_method_3 != "off" && $payment_method_3 != "") {
echo "* <b>".$payment_method_3_text."</b>:";

if ($payment_method_3 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_3 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($payment_method_3 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($payment_method_3 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_3 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($payment_method_3, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($payment_method_3, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}
if (isset($payment_method_4_text) && $payment_method_4_text != "off" && $payment_method_4_text != "" && isset($payment_method_4) && $payment_method_4 != "off" && $payment_method_4 != "") {
echo "* <b>".$payment_method_4_text."</b>:";

if ($payment_method_4 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_4 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($payment_method_4 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($payment_method_4 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_4 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($payment_method_4, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($payment_method_4, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}
if (isset($payment_method_5_text) && $payment_method_5_text != "off" && $payment_method_5_text != "" && isset($payment_method_5) && $payment_method_5 != "off" && $payment_method_5 != "") {
echo "* <b>".$payment_method_5_text."</b>:";

if ($payment_method_5 == "0") { echo "<br>Gratuito<br>"; }  else {

                                           echo "<br>";

                                           //Si esta activada la opcion de conversor:

                                           if ($money_converter == "on" && file_exists($money_file)) {
                                           
                                           //Si la moneda que manda es EUR:
                                           if (isset($product_money) && $product_money == "EUR") {
                                             
                                             if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_5 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           
                                           if (isset($money_usd_valor)) {

                                           $money_usd_represent = wordwrap(number_format($payment_method_5 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }
                                           
                                           }


                                           //Si la moneda que manda es USD:
                                           if (isset($product_money) && $product_money == "USD") {

                                           if (isset($money_usd_valor)) {
                                           $money_usd_represent = wordwrap(number_format($payment_method_5 / $money_usd_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_usd_symbol;
                                           echo $money_usd_represent."<br>";
                                           }

                                           if (isset($money_eur_valor)) {
                                           $money_eur_represent = wordwrap(number_format($payment_method_5 / $money_eur_valor, $money_dec, $money_dec_symbol, $money_miles_symbol), 20, "<br>", 1)."".$money_symbol_separator."".$money_eur_symbol;
                                           echo $money_eur_represent."<br>";
                                           }
                                           }
                                           
                                           } else {
                                           
                                           if (isset($money_default)) {
                                           echo wordwrap(number_format($payment_method_5, 2, ",", "."), 10, "<br>", 1).$money_default."<br>";
                                           } else {
                                           echo wordwrap(number_format($payment_method_5, 2, ",", "."), 10, "<br>", 1)." EUR<br>";
                                           }

                                           }


                                           //Fin de la opcion del conversor

}

//echo "<br>";

}
?>


</font>

<?php
}
?>















                         
                         <br>
                         <br>

                         
                         <center><input type="submit" name="submit" value="Enviar E-Mail"></center>

                         <?php
                         if (SID) {
                         ?>
                         <input type="hidden" name="<?php echo session_name(); ?>" value="<?php echo session_id(); ?>">
                         <?php
                         }
                         ?>
                                                  
                         </form>
                         


</td></tr></table>
<br>
                         <?php





}

}

//}

} //Fin de cesta no vacia


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
