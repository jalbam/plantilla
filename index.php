<?php
//if (!session_is_registered('basket')) {
session_name('basket');
session_start('basket');
//session_start();
//}
//Programa y Web por Joan Alba Maldonado
//
//Falta: si $money_file_is_a_url, si esta a "on" tratar como una url.
//Plantilla soportada y testeada sobre:
//Explorer, NetPositive, Opera, Netscape, Mozilla, Firefox, Dillo, Konqueror, Nautilus, Lynx, Links, W3C, Safari, Voyager, WebTV, Pocket Explorer, ...
//OS Servidor: Windows XP Pro (Apache), BeOS (Robin), Ubuntu Linux (Apache: LAMPP)...
//OS Cliente: Windows XP (navegadores...), BeOS (navegadores...), QNX (navegadores...), FreeBSD, etc.
//Resoluciones y tamaños de la pantalla: ... . Se han testeado maximizado y en formato ventana. 
//(falta definir versiones de navegadores, servidores -apache, etc.- y de sistemas operativos).

//Falta por soportar: varios idiomas y posibilidad de añadir mas (con posibilidad de cambiar logo de bandera con variables).
//representar el html en mejor aspecto
//convertir caracteres especiales a &eacute; &ntilde; etc.
//el errors.php puede dar error si el tiempo de ejekucion del archivo errors.txt excede del establecido en la konfiguracion de PHP.
//
//Crear items.txt, category.txt, etc. solo si $db_type = "text" (a no ser que utilice los .txt para actualizar la BD de mySQL).
//
//Pasar los .txt a .php y proteger asi su acceso, y en config.php o en files.php -> $pwd_file = "password.php" (p.ej.) (y en edit forzar cambio de password la
//primera vez que se inicie).
//
//Considerar pasar conversor de monedas sobre texto y no sobre variables -> texto_a_representar:valor_respecto_al_master (p.ej. EUR <img src=\"eur.gif\">:1.5)
//
//Archivo llamado files.txt (o files.php mejor).
//
//Truncar palabras para Firefox en el menu y en las tablas de productos, etc.
//
//Fondo tabla y td con $body_bg (los ke se usan para ke vaya IE 3.0).
//
//posibilidad de quitar el menu (\$menu = "off") y tambien de setear \$shopping = "off" (desactivar tienda)
//hacer que en body.txt puedan utilizarle $variables sin tener que llamar a php, invocar echo y cerrarlo.

//hacerlo por sesiones (almacenar paginas visitadas, a ke horas, en ke orden (traceroute del cliente), donde ha hecho click, etc. enviarlo por mail junto al
//formulario de pedido y si no hay pedido al menos almacenarlo en un archivo de texto (guests.txt?)
//backups de los archivos de konfiguracion, etc. antes de modifikarlos, i si hai algun error o no existe el principal rekurrir a ellos, i si no krearlos komo
//se hace siempre
//posibilidad de listar todos los produktos desde el menu (i de desaktivar esta opcion)
//detektar si se soporta javaskript o no; si se soporta, añadir inmediatamente el produkto a la cesta, i poder abrir en otras ventanas la imagen del produkto
//ampliada.

//comprobar ke todas las variables estan seteadas

//pensar algo para ke no de error en exceso del tiempo de ejekucion de items.txt
//posibilidad de poner imagen fija en tag <body> (que no haga scroll)
//variables para meta-tags
//poner CSS
//en vez de añadir archivo CSS, poder definirlo en config (aprobechando variables generales) y poner el css aki (index.htm).
//posibilidad de poner "on" y "On" y "ON" y "oN" y komo sea, etc. da igual las mayus i las minus
//subkategorias en los produktos
//konversion de monedas
//Falta: Comprobar si existen o no products.php, pedido,php, etc..
//if (!session_is_registered('basket')) {
//session_name('basket');
//session_start('basket');
//}



$this_file = "index.php";

//if (SID) {
//$_SESSION['last_page_visited'] = $this_file . "?" . SID;
//} else {
//$_SESSION['last_page_visited'] = $this_file;
//}

//$last_page_visited_vars = $_GET;
//$last_page_visited_vars = $HTTP_GET_VARS;

//$last_page_visited_vars_x = 0;

//if (isset($last_page_visited_vars) && $last_page_visited_vars != "") {

//foreach ($last_page_visited_vars as $last_page_visited_vars_separated => $last_page_visited_vars_separated_result) {

//if ($last_page_visited_vars_x == 0) {
//$_SESSION['last_page_visited'] .= "?" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));
//echo $last_page_visited_vars_x[0];
//} else {
//$_SESSION['last_page_visited'] .= "&" . trim(urlencode($last_page_visited_vars_separated)) . "=" . trim(urlencode($last_page_visited_vars_separated_result));
//}

//$last_page_visited_vars_x ++;
//}

//}


$_SESSION['last_page_visited'] = $this_file;

$change_resolution_page = "?change_resolution=ok";

$last_page_visited_vars = $_GET;
//$last_page_visited_vars = $HTTP_GET_VARS;

$last_page_visited_vars_x = 0;

if (isset($last_page_visited_vars) && $last_page_visited_vars != "") {

foreach ($last_page_visited_vars as $last_page_visited_vars_separated => $last_page_visited_vars_separated_result) {


//echo "\"".trim(urlencode($last_page_visited_vars_separated))."\"";

if (trim(urlencode($last_page_visited_vars_separated)) != "change_resolution" && trim(urlencode($last_page_visited_vars_separated)) != "table_width_var" && trim(urlencode($last_page_visited_vars_separated)) != session_name()) {
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


//echo $_SESSION['last_page_visited'];

//Creacion mediante heredoc de las variables en config.txt, por si no existiera el archivo:
$config_file = "config.txt";
$config_default = <<<EOD
<?php
//Programa y Web por Joan Alba Maldonado


//Para que una variable apunte a otra, debe asegurarse que esta otra esta definida con anterioridad.
//Puede ser necesario alterar el orden de representacion de las siguientes variables para tal fin.

//Se establece el limite de ejecucion maximo. Cero (0) lo pondra a infinito. Funciona a no ser que PHP este en safe-mode (puede ponerse a "off"):
\$set_time_limit = "0";

//Titulo de la web:
\$title_web = "Company Title";

//Primera Pagina web, el indice:
\$index_file = "index.php";

//Archivo para almacenar errores:
\$errors_file = "errors.txt";

//Archivo para almacenar CSS:
\$css_file = "default.css";

//Archivo que contiene el titulo/nombre de la empresa (leer languages.txt para mas informacion sobre idiomas):
\$title_file = "title.txt";

//Autor de la web (se utilizara en la variable correspondiente de meta-tags, mas abajo, a no ser que se indique lo contrario):
\$author_web = "Joan Alba Maldonado";

//Programa con que se edito la web (se utilizara en la variable correspondiente de meta-tags, mas abajo, a no ser que se indique lo contrario):
\$generator_web = "MAX's HTML Beauty++ 2004";

//Lenguaje que utiliza la web (se utilizara en la variable correspondiente de meta-tags, mas abajo, a no ser que se indique lo contrario):
\$language_web = "Spanish";

//Lenguaje que utiliza la web, abreviado (se utilizara en la variable correspondiente de meta-tags, mas abajo, a no ser que se indique lo contrario):
\$language_short_web = "es";

//Archivo que contiene el codigo del menu:
\$menu_file = "menu.txt";

//TAG DOCTYPE que define el tipo de documento (no alterar si no se esta seguro):
\$doctype = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";

//Informacion que se utilizara para generar meta-tags (pueden setearse a "off"). No pasarse de 10 palabras en keywords ni mas de 150 caracteres en description:
\$meta_title = \$title_web;
\$meta_subject = "Tema del sitio web";
\$meta_description = "Descripcion del sitio web";
\$meta_keywords = "Palabra1, Palabra2, Palabra3, Palabra4, Palabra5, Palabra6, Palabra7, Palabra8, Palabra9, Palabra10";
\$meta_author = \$author_web;
\$meta_generator = \$generator_web;
\$meta_distribution = "global";
\$meta_robots = "all";
\$meta_revisit = "1 day";
\$meta_revisit_after = "1 day";
\$meta_mademail = "drogaslibres@hotmail.com";
\$meta_language = \$language_web;
\$meta_language_short = \$language_short_web;
\$meta_url = "http://www.empresa.com/";

//Si esta en "on", detectara si el navegador soporta Javascript (creando una variable llamada \$_SESSION['javascript_support'] en "enabled" si es afirmativo):
\$javascript_detect = "on";

//Invertir los contenidos (ademas, barra de desplazamiento a la izquierda en Explorer):
//Puede dar problemas inesperados si se setea a "on". No lo soportan todos los navegadores.
\$content_invert = "off";

//El color hexadecimal #RRGGBB de la fuente utilizada por defecto en la pagina (fuera de tablas o cuando no se aplica \$font_color):
\$general_text = "#333333";

//El color de la fuente utilizada por defecto en products.php:
\$products_general_text = \$general_text;

//El color de la fuente utilizada por defecto en basket.php:
\$basket_general_text = \$general_text;

//El color de los links en la web (cuando no se aplica CSS o \$css_file = "off")
//link = enlace normal, alink = enlace activado, vlink = enlace visitado:
\$general_link = "#5555cc";
\$general_alink = "#ffffff";
\$general_vlink = \$general_link;

//El color y las propiedades de los links de la web (excepto el menu), se utilizan en CSS y substituye a los generales de arriba en caso de ser soportado:
\$css_link = "color:#5555cc; text-decoration:underline; font-family:arial; font-weight:normal; background-style:transparent; layer-background-style:transparent;";
\$css_link_visited = "off";
\$css_link_hover = "color:#ff0000; text-decoration:none; font-family:arial; font-weight:normal; background-style:transparent; layer-background-style:transparent;";
\$css_link_active = "color:#ffffff; text-decoration:none; font-family:arial; font-weight:normal; background-style:transparent; layer-background-style:transparent;";

//El color y las propiedades de los links del menu, se utilizan en CSS:
\$css_menu_link = "color:#5555cc; text-decoration:none; font-family:arial; font-weight:normal; background-style:transparent; layer-background-style:transparent;";
\$css_menu_link_visited = "off";
\$css_menu_link_hover = "color:#ff0000; text-decoration:underline; font-family:arial; font-weight:normal; background-style:transparent; layer-background-style:transparent;";
\$css_menu_link_active = "color:#ffffff; text-decoration:none; font-family:arial; font-weight:normal; background-style:transparent; layer-background-style:transparent;";

//Margenes para body (algunos solo funcionan en ciertos navegadores)
//Para Microsoft Internet Explorer y basados: left_margin = margen izquierdo, top_margin = margen superior
//Para Netscape, Mozilla y basados: margin_width = margen lateral (izquierdo), margin_height = margen vertical (superior):
\$general_left_margin = "0";
\$general_top_margin = "10";
\$general_margin_width = \$general_left_margin;
\$general_margin_height = \$general_top_margin;

//Margenes que substituyen a los de arriba en caso de ser soportado CSS (px = pixels):
\$margin_top = \$general_top_margin."px";
\$margin_left = \$general_left_margin."px";
\$margin_right = "0px";
\$margin_bottom = "10px";

//Variable que define el color hexadecimal #RRGGBB del fondo de la pagina (rojo, verde, azul).
//Para ser un color debe comenzar por el caracter #. De lo contrario, se tratara como una imagen.
//No se aplicara si esta en "off":
\$general_bg = "#aaaadd";

//Si se pone a on, al hacer scrolling la imagen de fondo no se movera (en caso de que exista):
\$bg_fixed = "off";

//El espacio en pixels que ocupa una linea de texto en vertical. Se utiliza en CSS. Formato [Numero_de_pixels]px (p.ej.: "20px"). Puede estar en "off"
//(Por defecto esta en "off" pos posibles problemas en Clue v4.2):
\$line_height = "off";

//Propiedades de los colores del Scrollbar (solo funciona en Explorer, al menos de momento). Se utiliza en CSS. En hexadecimal, formato #RRGGBB:
\$scrollbar_face_color = "#dddddd";
\$scrollbar_shadow_color = "#eeeeee";
\$scrollbar_highlight_color = "#ffffff";
\$scrollbar_3dlight_color = "#bbbbbb";
\$scrollbar_darkshadow_color = "#aaaaaa";
\$scrollbar_track_color = "#ffffff";
\$scrollbar_arrow_color = "#aaaaff";

//El color hexadecimal #RRGGBB de la fuente utilizada por defecto en la pagina:
//Por defecto, el mismo que en \$body_text:
\$font_color = \$general_text;

//El color hexadecimal #RRGGBB de la fuente utilizada para el titulo en la pagina:
\$font_color_title = "#aa0000";

//El color de la fuente utilizada en el titulo del menu:
\$font_color_little_title = \$font_color_title;

//El tamaño de la fuente standard (del 1 al 7, el 7 es el mas grande):
\$font_size = "2";

//El tamaño de la fuente del titulo (del 1 al 7, el 7 es el mas grande):
\$font_size_title = "6";

//El tamaño de la fuente del titulo en el menu:
\$font_size_little_title = \$font_size + 1;

//El nombre de la imagen del logotipo.
\$logo_file = "img/logo/logo.jpg";

//El tamaño horizontal de la imagen indicada en \$logo
\$logo_width = "600";

//El tamaño vertical de la imagen indicada en \$logo
\$logo_height = "100";

//El tamaño horizontal de la tabla general (la que incluye menu.txt y body.txt).
//Se reparte a razon de un 25% para el menu, y un 75% para el cuerpo. Debe ser un numero entero.
//Por defecto, el mismo que \$logo_width:
\$table_width = \$logo_width;

//El ancho de la tabla que contiene los productos en concreto :
\$product_table_width = \$table_width - 230;

//El ancho de la tabla de la cesta de compra:
\$basket_table_width = \$product_table_width;

\$basket_table_cellspacing = "0";
\$basket_table_cellpadding = "5";

//Poner en on para que el usuario pueda alternar entre resoluciones:
\$user_can_alternate_page_width = "on";

//Activa la deteccion automatica de la resolucion mediante javascript (pero puede dar error en algunos navegadores antiguos -> undefined screen, etc.).
//Requiere \$javascript_detect = "on";
\$javascript_autodetect_resolution = "on";

//Especificar una imagen distinta de Logotipo al cambiar de resolucion (para dejar la misma, especificar "auto" como imagen). No poner a "off".
//(Funciona solo si \$user_can_alternate_page_width = "on"):
\$logo_file_less_than_640x480 = "img/logo/less640.jpg";
\$logo_width_less_than_640x480 = "430";
\$logo_height_less_than_640x480 = "80";
\$logo_file_640x480 = \$logo_file;
\$logo_width_640x480 = \$logo_width;
\$logo_height_640x480 = \$logo_height;
\$logo_file_800x600 = "img/logo/800.jpg";
\$logo_width_800x600 = "720";
\$logo_height_800x600 = "120";
\$logo_file_1024x768 = "img/logo/1024.jpg";
\$logo_width_1024x768 = "880";
\$logo_height_1024x768 = "125";
\$logo_file_1280x1024 = "img/logo/1280.jpg";
\$logo_width_1280x1024 = "1024";
\$logo_height_1280x1024 = "135";
\$logo_file_more_than_1280x1024 = "img/logo/more1280.jpg";
\$logo_width_more_than_1280x1024 = "1400";
\$logo_height_more_than_1280x1024 = "145";

//Resoluciones soportadas, para que el usuario pueda alternarlas (si \$user_can_alternate_page_width = "on"). Poner el valor de width entre comillas:
//Nota: no poner a "off", para desactivar: comentar con //
\$page_width_less_than_640x480 = \$logo_width_less_than_640x480;
\$page_width_640x480 = \$logo_width_640x480;
\$page_width_800x600 = \$logo_width_800x600;
\$page_width_1024x768 = \$logo_width_1024x768;
\$page_width_1280x1024 = \$logo_width_1280x1024;
\$page_width_more_than_1280x1024 = \$logo_width_more_than_1280x1024;

//El tamaño horizontal de la tabla que contiene los productos al alternar las resoluciones:
\$product_table_width_less_than_640x480 = \$page_width_less_than_640x480 - 140;
\$product_table_width_640x480 = \$product_table_width;
\$product_table_width_800x600 = \$page_width_800x600 - 250;
\$product_table_width_1024x768 = \$page_width_1024x768 - 300;
\$product_table_width_1280x1024 = \$page_width_1280x1024 - 340;
\$product_table_width_more_than_1280x1024 = \$page_width_more_than_1280x1024 - 420;

//Ancho de la tabla basket segun la resolucion:
\$basket_table_width_less_than_640x480 = \$product_table_width_less_than_640x480;
\$basket_table_width_640x480 = \$product_table_width_640x480;
\$basket_table_width_800x600 = \$product_table_width_800x600;
\$basket_table_width_1024x768 = \$product_table_width_1024x768;
\$basket_table_width_1280x1024 = \$product_table_width_1280x1024;
\$basket_table_width_more_than_1280x1024 = \$product_table_width_more_than_1280x1024;

//El borde de la tabla de la cesta de compra (0 = ninguno):
\$basket_table_border = "1";
\$basket_table_border_css = "1";

//El color del borde de la tabla de la cesta de compra (no se aplica si \$basket_table_border esta a 0):
\$basket_table_border_color = "#848fc8";
\$basket_table_border_color_dark = "#848fc8";
\$basket_table_border_color_light = "#848fc8";

//El color (#RRGGBB) o la imagen de fondo de la tabla (se aplican las mismas reglas que en \$general_bg):
\$table_bg = "#aaaaff";

//El borde de la tabla (0 = ninguno):
\$table_border = "0";
\$table_border_css = "0";

//El color del borde de la tabla (no se aplica si \$table_border esta a 0):
\$table_border_color = "#ff0000";
\$table_border_color_dark = "#ff0000";
\$table_border_color_light = "#ff0000";

//Espacio entre celdas (\$table_cellspacing), y espacio entre el comienzo de la celda y el contenido (\$table_cellpaddig).
//Se recomienda dejar a 0, y solo cambiar \$table_margin:
\$table_cellspacing = "0";
\$table_cellpadding = "0";
\$table_margin = "25";

//El color (#RRGGBB) o la imagen de fondo para el menu (se superpone a \$table_bg):
\$menu_bg = "#ffaaaa";

//El color (#RRGGBB) o la imagen de fondo para el cuerpo (se superpone a \$table_bg). Por defecto, lo mismo que \$table_bg:
\$body_bg = \$table_bg;

//Telefono de contacto de la empresa (poner a "off" para desactivar):
\$contact_tlf = "+034 123 123 456";

//Calle, Avenida, etc. de localizacion de la empresa (poner a "off" para desactivar):
\$contact_street_location = "c/13 Rue del Percebe nº69 6º9ª";

//Ciudad, provincia, etc. de localizacion de la empresa (poner a "off" para desactivar):
\$contact_city_location = "Cambrils (Tarragona)";

//Pais de localizacion de la empresa (poner a "off" para desactivar):
\$contact_country_location = "Espa&ntilde;a";

//Codigo postal de la empresa (poner a "off" para desactivar):
\$contact_cp = "43850";

//El NIF de la empresa (poner a "off" para desactivar):
\$contact_nif = "NIF: 123456789";

//Codigo del distrito postal (Apartado de correos) de la empresa (poner a "off" para desactivar):
\$contact_pd = "off";

//E-Mail de contacto:
\$contact_email = "drogaslibres@gmail.com";

//E-Mail para las compras:
\$business_email = "drogaslibres@gmail.com";

//E-Mail para enviar las estadisticas, el dia 1 de cada mes. Para desactivar, poner en "off":
\$stats_email = "drogaslibres@gmail.com";

//E-Mail para enviar los errores (siempre que uno ocurra, se envia un E-Mail). Para desactivar, poner en "off":
\$email_error = "drogaslibres@gmail.com";

//Al enviar E-Mails esde la web, puede hacer que se envie una copia oculta a la siguiente direccion (puede ponerse a "off"):
\$email_bcc = "drogaslibres@gmail.com";

//Al enviar E-Mails esde la web, puede hacer que se envie una copia sin ocultar a la siguiente direccion (puede ponerse a "off"):
\$email_cc = "off";

//Elegir el formato con el que llegaran los pedidos, comentarios enviados en la seccion contactos, etc.
//Puede ser "html" (para HTML) o "text" (texto plano):
\$send_emails_format = "html";

//Indica si es necesario ("on") o no ("off") indicar el codigo postal para enviar un pedido:
\$cp_is_requiered_to_order = "on";

//El Anti-flood al enviar E-Mails (incluye seccion Contacto y Pedido). Sirven para una misma sesion, con una misma IP y un mismo navegador:
\$emails_max_expire_secs = "300"; //Despues de este periodo, que comienza a contar desde el primer E-Mail enviado, el contador de flood se pone a cero.
\$emails_max = "25"; //El maximo de E-Mails que se pueden enviar en el periodo de tiempo.

//Si se activa a "on", se creara un log con la ruta que ha realizado cada cliente y al recibir un E-Mail tambien se recibira un log individual de cada uno:
\$spy_route_client = "on";

//Si esta en "on", el link "Contacto" del menu ira directo a una pagina donde poder enviar E-Mail por PHP.
//Si esta en "off", ira directo al E-Mail con mailto (necesario cliente de E-Mail):
\$contact_page = "on";
\$contact_file = "contact.php";

//Si esta en "on", el link "Pedido" del menu ira directo a una pagina donde poder formalizar el pedido realizado con la cesta de compra o sin ella en caso
//de que esta no funcionara:
\$process_page = "on";
\$process_file = "basket.php";

//Define si el usuario puede enviar pedidos manualmente en caso de que la cesta de compra este vacia (por si esta falla, cosa poco probable):
\$user_can_send_order_manually = "on";

//Tipo de base de datos para los productos. Puede ser "text" para un archivo de texto ASCII (items.txt) o "mysql" para mySQL.
//Formato archivo de texto: Referencia:Localizacion_Imagen:Nombre_Producto:Categoria:Subcategoria:Precio:'Descripcion'|
//Localizacion_Imagen puede estar en AUTO, y entonces se buscara imagenes con el mismo nombre que la referencia (pasando caracteres - a _, etc.).
\$db_type = "text";

//Archivo que contiene los productos (solo si \$db_type = "text";):
//Formato archivo de texto: Referencia:Localizacion_Imagen:Nombre_Producto:Categoria:Subcategoria:Precio:"Descripcion";
\$items_file = "items.txt";

//Archivo de texto que contiene la categoria de productos (se crearan links en menu.txt). Solo funciona si \$db_type = "text";.
//Formato de archivo de texto: Categoria_1: Subcategoria1, Subcategoria2, Subcategoria3| (creara enlaces a \$products_file?category={CATEGORIA})
//Falta: Comprobar si existen o no products.php, pedido,php, etc..
//Archivo para listar los productos:
\$category_file = "category.txt";

//Archivo que contiene el visualizador de productos (solo si \$db_type = "text";):
\$products_file = "products.php";

//Pagina de formalizacion del pedido y cesta de compra:
\$basket_file = "basket.php";

//Activa o desactiva el conversor de monedas:
\$money_converter = "on";

//Moneda por defecto en caso de tener el conversor a "off" (se muestra al lado del precio) y tambien para especificar descuentos al superar una cantidad determinada:
\$money_default = " EUR <img src=\"img/money/eur.gif\" width=\"20\" height=\"15\" alt=\"EUR\" title=\"EUR\" hspace=\"0\" vspace=\"0\">";

//Indica un archivo o una URL con el archivo de money.txt:
\$money_file = "money.txt";

//Indica si \$money_file es una URL ("yes") o es un archivo ("no"):
\$money_file_is_url = "no";

//Activar o desactivar el titulo con todas las categorias y subcategorias que se visualizan:
\$product_title = "on";

//El ancho (width) y el largo (heidht) de las imagenes de los productos. Si se pone en "auto" sera el tama&ntilde;o real:
\$product_img_width = "120";
\$product_img_height = "120";

//El ancho y el largo de las imagenes de los productos en la cesta de compra (si se pone a "auto", sera el tamaño real):
\$basket_img_width = "40";
\$basket_img_height = "40";

//El ancho y largo de la ventana emergente al ampliar una foto en basket y en products (solo si se soporta javscript):
\$product_and_basket_popup_zoom_window_width = "610";
\$product_and_basket_popup_zoom_window_height = "450";

//El directorio donde se buscaran las imagenes al estar en "auto" (dejar en blanco "" si se desea, no existe "off"):
\$product_img_auto_path = "img/items/";

//Directorio donde se almacenan las imagenes en miniatura de los productos (para la cesta de compra):
\$basket_img_auto_path = \$product_img_auto_path . "mini/";

//Extension de las imagenes automaticas:
\$product_img_auto_extension = ".jpg";

//El directorio donde se almacenan las capturas de las imagenes en grande (para verlas ampliadas), tanto en
//products como en basket:
\$product_and_basket_img_zoom_path = \$product_img_auto_path . "zoom/";

//Posibilidad de introducir decimales en la cesta de compra:
\$basket_allow_decs = "off";

//Define si el punto "." es un simbolo para marcar decimales en basket:
\$basket_dot_is_dec = "on";

//Define si abrir una ventana emergente con basket utilizando javascript al poner un producto en la cesta (siempre que esten activadas las cookies):
\$basket_javascript_popup = "off";

//Define si la ventana popup con basket se abre con el mismo tamaño que la resolucion que se utilice (requiere \$basket_javascript_popup = "on"):
//Se recomienda dejar a "off" ya que puede dar problemas con navegadores como Opera, FireFox, etc.
\$basket_javascript_popup_fit_to_screen = "off";

//Define si ampliar la ventana popup con basket hasta hacerlo fullscreen o no (requiere \$basket_javascript_popup = "on").
//Se recomienda dejar a "off" y setear solamente \$basket_javascript_popup_fit_to_screen a "on" como substituto:
\$basket_javascript_popup_fullscreen = "off";

//Si se pone "on" se listara la opcion "VER TODOS" en el menu (de lo contrario, setear a "off"):
\$menu_list_all_option = "on";

//Poner a "on" para mostrar la opcion "Mi cesta" en el menu:
\$menu_view_basket = "on";

//Si se pone "on" se listara la opcion de BUSQUEDA en el menu (de lo contrario, setear a "off"):
\$menu_search_form = "on";

//Poner en "on" para listar las subcategorias en el menu:
\$menu_show_subcategories = "off";

//Propiedades de la tabla de los productos:
\$product_table_cellspacing = "0";
\$product_table_cellpadding = "8";
\$product_table_border = "2";
\$product_table_border_css = "2";
\$product_table_border_color = "#848fc8";
\$product_table_border_color_dark = "#848fc8";
\$product_table_border_color_light = "#848fc8";

//Esta es la categoria donde se almacenan las ofertas (debe estar en category.txt, por ejemplo asi -> Ofertas:|).
\$supply_category = "Ofertas";

//Impuestos (gastos de envio, mano de obra, servicio, IVA, etc.) que se suman al total del pedido.
//\$taxes equivale a un precio fijo que se suma al total (como 5 euros de gastos de envio), y \$taxes_percent un porcentaje del
//total que se suma al total (como 16 por ciento de IVA).
//\$taxes_text y \$taxes_percent_text equivalen a la explicacion de porque se aplica estos impuestos.
//Pueden estar a "off":
\$taxes_text = "Servicio";
\$taxes = "5";
\$taxes_percent_text = "IVA";
\$taxes_percent = "16";

//Impuestos aplicados fuera de una zona especifica (para desactivar, poner las dos variables en "off"):
\$additional_cost_outside_text = "Fuera de la Peninsula Iberica";
\$additional_cost_outside = "8";

//Activa o desactiva la opcion de poder elegir entre diversas formas de envio:
\$shipment_different_methods = "on";

//Diversas formas de envio (si \$shipment_different_methods = "on"):
\$shipment_method_1_text = "Transporte normal (una o dos semanas)";
\$shipment_method_1 = "0";
\$shipment_method_2_text = "Transporte semi-urgente 48 horas";
\$shipment_method_2 = "5";
\$shipment_method_3_text = "Transporte urgente en 24 horas";
\$shipment_method_3 = "10";
\$shipment_method_4_text = "Transporte urgente con seguro";
\$shipment_method_4 = "20";
\$shipment_method_5_text = "off";
\$shipment_method_5 = "off";

//Activa o desactiva la opcion de poder elegir entre diversas formas de pago:
\$payment_different_methods = "on";

//Diversas formas de pago (si \$shipment_different_methods = "on"):
\$payment_method_1_text = "Contrareembolso";
\$payment_method_1 = "0";
\$payment_method_2_text = "Transferencia bancaria";
\$payment_method_2 = "-5";
\$payment_method_3_text = "off";
\$payment_method_3 = "off";
\$payment_method_4_text = "off";
\$payment_method_4 = "off";
\$payment_method_5_text = "off";
\$payment_method_5 = "off";

//Descuentos que se aplican al superar una cantidad requerida en el total sin contar impuestos (poner a cero (0) para aplicar a todos los perdidos, poner a "off" para no utilizar descuentos).
//Se recomienda solo utilizar uno de los dos:
\$supply_on_total_money_requiered = "25";
\$supply_on_total_money_requiered_percent = "50";

//La cantidad de dinero que se descuenta al superar la cantidad especificada sin contar impuestos mas arriba:
\$supply_on_total_money_to_discount = "10";
\$supply_on_total_money_to_discount_percent = "5";

//Si se activa a "on", se mostraran los descuentos en el indice:
\$show_discounts_on_index = "on";

//Texto que aparece en los dos botones de la cesta de compra: 
\$basket_edit_button = "Editar";
\$basket_delete_button = "Borrar";

?>
EOD;

//Las siguientes lineas son para que no se confunda el editor de textos al colorear (MAX's HTML Beauty++ 2004):
?>
<?php

$config_default_represent = str_replace("<","&lt;",$config_default);
$config_default_represent = str_replace(">","&gt;",$config_default_represent);

//Incluir config.txt:
if (!file_exists($config_file)) {
   if (!isset($errors)) { $errors = ""; }
   $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>EL ARCHIVO</b> ".$config_file." <b><u>NO EXISTE</u> Y SE CREAR&Aacute; CON EL TEXTO</b><i> ".$config_default_represent."</i></font><br>";
   $config = fopen($config_file, "a+");
   fwrite($config,$config_default);
} else { 
       $config = fopen($config_file, "a+");
       //echo "(*) <b>EL ARCHIVO</b> ".$config_file."<b>EXISTE</b><br>";
       }

//Incluir variables de config.txt al programa:
include "config.txt";


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

//if($spy_get_vars_x == 0) {
//$spy_get_vars .= "?".$spy_get_vars_name."=".$spy_get_vars_value;
//} else {
//$spy_get_vars .= "&".$spy_get_vars_name."=".$spy_get_vars_value;
//}

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

//Comprobar la existencia de las variables en config.txt:
if (!isset($background) && !isset($bgcolor)) { $bgcolor = "#aaaadd"; $background = "off"; } 
if (!isset($font_color)) { $font_color = "#333333"; }
if (!isset($font_color_title)) { $font_color_title = "#aa0000"; }
if (!isset($font_size)) { $font_size = "4"; }
if (!isset($font_size_title)) { $font_color = "2"; }


//$money_file = "money.txt";
if (!isset($money_file)) { $money_file = "money.txt"; }
if ($money_file_is_url == "no") {
$money_default =<<<EOD
<?php

//Monedas permitidas: EUR (Euro), USD (Dolares Americanos).
\$product_money = "EUR";

//El espacio que hay despues del precio y del symbol (sea texto o imagen):
\$money_symbol_separator = " ";

//Ancho y alto de la imagen de symbol, si existe (puede ser "auto"):
\$money_img_width = "20";
\$money_img_height = "15";

//Simbolo milesimal, decimal y numero de decimales que se representaran (0 = ninguno):
\$money_miles_symbol = ".";
\$money_dec_symbol = ",";
\$money_dec = "2";

//Valores respecto a \$product_money (como symbol puede utilizarse un texto o una imagen):
\$money_eur_valor = "1";
\$money_eur_symbol = "EUR <img src=\"img/money/eur.gif\" width=\"20\" height=\"15\" alt=\"EUR\" title=\"EUR\" hspace=\"0\" vspace=\"0\">";

\$money_usd_valor = "1.280";
\$money_usd_symbol = "img/money/usadol.gif";

?>
EOD;

//Las siguientes lineas son para que no se confunda el editor de textos al colorear (MAX's HTML Beauty++ 2004):
?>
<?php 

$money_default_represent = str_replace("<","&lt;",$money_default);
$money_default_represent = str_replace(">","&gt;",$money_default_represent);
if(!file_exists($money_file)) { 
   if (!isset($errors)) { $errors = ""; }
   $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>EL ARCHIVO</b> ".$money_file." <b><u>NO EXISTE</u> Y SE CREAR&Aacute; CON EL TEXTO</b><i> ".$money_default_represent."</i></font><br>";
   $money_file_open = fopen($money_file, "a+");
   fwrite($money_file_open,$money_default);
} else { $money_file_open = fopen($money_file, "a+"); }
fclose($money_file_open);
//$money_content = file($money_file);

}


$robots_file = "robots.txt";
$robots_default =<<<EOD
User-agent: *
Disallow: 
EOD;
$robots_default_represent = str_replace("<","&lt;",$robots_default);
$robots_default_represent = str_replace(">","&gt;",$robots_default_represent);
if(!file_exists($robots_file)) { 
   if (!isset($errors)) { $errors = ""; }
   $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>EL ARCHIVO</b> ".$robots_file." <b><u>NO EXISTE</u> Y SE CREAR&Aacute; CON EL TEXTO</b><i> ".$robots_default_represent."</i></font><br>";
   $robots_file_open = fopen($robots_file, "a+");
   fwrite($robots_file_open,$robots_default);
} else { $robots_file_open = fopen($robots_file, "a+"); }
fclose($robots_file_open);
//$robots_content = file($robots_file);


$langiso_file = "language.txt";
$langiso_default =<<<EOD
AA "Afar"
AB "Abkhazian"
AF "Afrikaans"
AM "Amharic"
AR "Arabic"
AS "Assamese"
AY "Aymara"
AZ "Azerbaijani"
BA "Bashkir"
BE "Byelorussian"
BG "Bulgarian"
BH "Bihari"
BI "Bislama"
BN "Bengali" "Bangla"
BO "Tibetan"
BR "Breton"
CA "Catalan"
CO "Corsican"
CS "Czech"
CY "Welsh"
DA "Danish"
DE "German"
DZ "Bhutani"
EL "Greek"
EN "English" "American"
EO "Esperanto"
ES "Spanish"
ET "Estonian"
EU "Basque"
FA "Persian"
FI "Finnish"
FJ "Fiji"
FO "Faeroese"
FR "French"
FY "Frisian"
GA "Irish"
GD "Gaelic" "Scots Gaelic"
GL "Galician"
GN "Guarani"
GU "Gujarati"
HA "Hausa"
HI "Hindi"
HR "Croatian"
HU "Hungarian"
HY "Armenian"
IA "Interlingua" IE "Interlingue"
IK "Inupiak"
IN "Indonesian"
IS "Icelandic"
IT "Italian"
IW "Hebrew"
JA "Japanese"
JI "Yiddish"
JW "Javanese"
KA "Georgian"
KK "Kazakh"
KL "Greenlandic"
KM "Cambodian"
KN "Kannada"
KO "Korean"
KS "Kashmiri"
KU "Kurdish"
KY "Kirghiz"
LA "Latin"
LN "Lingala"
LO "Laothian"
LT "Lithuanian"
LV "Latvian" "Lettish"
MG "Malagasy"
MI "Maori"
MK "Macedonian"
ML "Malayalam"
MN "Mongolian"
MO "Moldavian"
MR "Marathi"
MS "Malay"
MT "Maltese"
MY "Burmese"
NA "Nauru"
NE "Nepali"
NL "Dutch"
NO "Norwegian"
OC "Occitan"
OM "Oromo" "Afan"
OR "Oriya"
PA "Punjabi"
PL "Polish"
PS "Pashto" "Pushto"
PT "Portuguese"
QU "Quechua" RM "Rhaeto-Romance"
RN "Kirundi"
RO "Romanian"
RU "Russian"
RW "Kinyarwanda"
SA "Sanskrit"
SD "Sindhi"
SG "Sangro"
SH "Serbo-Croatian"
SI "Singhalese"
SK "Slovak"
SL "Slovenian"
SM "Samoan"
SN "Shona"
SO "Somali"
SQ "Albanian"
SR "Serbian"
SS "Siswati"
ST "Sesotho"
SU "Sudanese"
SV "Swedish"
SW "Swahili"
TA "Tamil"
TE "Tegulu"
TG "Tajik"
TH "Thai"
TI "Tigrinya"
TK "Turkmen"
TL "Tagalog"
TN "Setswana"
TO "Tonga"
TR "Turkish"
TS "Tsonga"
TT "Tatar"
TW "Twi"
UK "Ukrainian"
UR "Urdu"
UZ "Uzbek"
VI "Vietnamese"
VO "Volapuk"
WO "Wolof"
XH "Xhosa"
YO "Yoruba"
ZH "Chinese"
ZU "Zulu" 
EOD;
$langiso_default_represent = str_replace("<","&lt;",$langiso_default);
$langiso_default_represent = str_replace(">","&gt;",$langiso_default_represent);
if(!file_exists($langiso_file)) { 
   if (!isset($errors)) { $errors = ""; }
   $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>EL ARCHIVO</b> ".$langiso_file." <b><u>NO EXISTE</u> Y SE CREAR&Aacute; CON EL TEXTO</b><i> ".$langiso_default_represent."</i></font><br>";
   $langiso_file_open = fopen($langiso_file, "a+");
   fwrite($langiso_file_open,$langiso_default);
} else { $langiso_file_open = fopen($langiso_file, "a+"); }
fclose($langiso_file_open);
//$langiso_content = file($langiso_file);


$category_default =<<<EOD
Categoria: Subcategoria1, Subcategoria2, Subcategoria3, etc|
Ofertas:|
Telas: Magicas, Rojas, Verdes, Azules|
Bromas: Cachondeo, Raras, Otros|
Pizzas: Cuatro quesos, Napolitana, Margarita, Cuatro estaciones|
Idioteces: gominolas,remendones,palancas|
koñerias:lacasitos, hermonoides, romoninindinguis|
nada:nada,nada2,nada3|
 çñ Marico na das: n a d a, nada2, nadisima|
M&aacute;s co&ntilde;er&iacute;as:asd&aacute;s|
EOD;
$category_default_represent = str_replace("<","&lt;",$category_default);
$category_default_represent = str_replace(">","&gt;",$category_default_represent);
if(!file_exists($category_file)) { 
   if (!isset($errors)) { $errors = ""; }
   $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>EL ARCHIVO</b> ".$category_file." <b><u>NO EXISTE</u> Y SE CREAR&Aacute; CON EL TEXTO</b><i> ".$category_default_represent."</i></font><br>";
   $category_file_open = fopen($category_file, "a+");
   fwrite($category_file_open,$category_default);
} else { $category_file_open = fopen($category_file, "a+"); }
fclose($category_file_open);
$category_content = file($category_file);


$items_default =<<<EOD
Referencia:Localizacion_Imagen:Nombre_Producto:Categoria:Subcategoria:Precio:'Descripcion'|

1Ab:auto:Tela magica:Telas:Magicas:12.5:'desc.txt'|

3Dc:auto:*Gato volador:Bromas:Otros:6.45:'Descripcion del producto 3Dc'|
5Ab : kk.gif : Platano de mentira : Bromas : Otros : 9.25: 'Texto explicativo de un pene' |

6JdfgfdgL:img.jpg:*Tela rojisima:Telas:Rojas:21.10:'tela.txt'|

234ñññ-_-03sfdJL:algo.jpg:*Pizza loca:Pizzas:Cuatro estaciones:6.69:'tela.txt'|

ref1:imagen:nombra:nada:nada:5342:'safds'|
ref2:imagen:*nombrí:nada:nada:1345:'safds'|
ref3:imagen:nombró:nada:nada2:534345:'safds'|

1Ab2:auto:Tela magica:Telas:Magicas:12.52:'desc.txt'|
ref4:imagen:nombre: çñ Marico na das:n a d a:5:'safds'|

yas69:auto:*La Pornochacha Yasmina:Bromas:Raras:0.1:'Pornochacha que hara las delicias del mas exigente amo.'|

696969:auto:Tela de Paquito el Lefatero:Telas:Magicas:99.2:'Menenllefante y gallifante a la par que exhuverante paquito, all&iacute; donde los haya. Ni m&aacute;s ni menos, nengk.'|

referencia:auto:una simple pruebita nom&aacute;s:M&aacute;s co&ntilde;er&iacute;as:asd&aacute;s:0:'<font color="#ff0000" size="5"><blink>hola</blink></font>'|
EOD;
$items_default_represent = str_replace("<","&lt;",$items_default);
$items_default_represent = str_replace(">","&gt;",$items_default_represent);
if(!file_exists($items_file)) { 
   if (!isset($errors)) { $errors = ""; }
   $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>EL ARCHIVO</b> ".$items_file." <b><u>NO EXISTE</u> Y SE CREAR&Aacute; CON EL TEXTO</b><i> ".$items_default_represent."</i></font><br>";
   $items_file_open = fopen($items_file, "a+");
   fwrite($items_file_open,$items_default);
} else { $items_file_open = fopen($items_file, "a+"); }
fclose($items_file_open);
$items_content = file($items_file);

if (!isset($title_web)) {
$title_web = "Company Title";
}

$title_default = $title_web;

$title_default_represent = str_replace("<","&lt;",$title_default);
$title_default_represent = str_replace(">","&gt;",$title_default_represent);

//<a href="option1.htm" alt="option.htm" title="option.htm">Option 1</a>
$menu_default =<<<EOD
<?php
if(SID) {
?>
<a href="option1.htm?<?php echo SID; ?>" title="Option1" class="menu" onMouseOver="window.status='Option1'; return true;" onMouseOut="window.status='<?php readfile(\$title_file); ?>'; return true;" accesskey="o"><b><u>O</u>ption 1</b></a>
<?php 
} else {
?>
<a href="option1.htm" title="Option1" class="menu" onMouseOver="window.status='Option1'; return true;" onMouseOut="window.status='<?php readfile(\$title_file); ?>'; return true;" accesskey="o"><b><u>O</u>ption 1</b></a>
<?php
}
?>
<br><br>
EOD;
$menu_default_represent = str_replace("<","&lt;",$menu_default);
$menu_default_represent = str_replace(">","&gt;",$menu_default_represent);

$body_file = "body.txt";
$body_default =<<<EOD
<center><font color="<?php echo \$font_color_title?>" size="<?php echo \$font_size_title?>">
<?php readfile(\$title_file); ?>
</font></center>
<p>
<font color="<?php echo \$font_color?>" size="<?php echo \$font_size?>">
Texto en la web
</font>
</p>
<p>
<font color="<?php echo \$font_color?>" size="<?php echo \$font_size + 1?>">
<?php
echo "&copy; ";
readfile(\$title_file);
echo "<br>";
if (isset(\$contact_nif) && \$contact_nif != "off") { echo \$contact_nif."<br>"; }
if (isset(\$contact_street_location) && \$contact_street_location != "off") { echo \$contact_street_location."<br>"; }
if (isset(\$contact_cp) && \$contact_cp != "off") { echo \$contact_cp." "; }
if (isset(\$contact_city_location) && \$contact_city_location != "off") { echo \$contact_city_location."<br>"; }
if (isset(\$contact_country_location) && \$contact_country_location != "off") { echo \$contact_country_location."<br><br>"; }
if (isset(\$contact_pd) && \$contact_pd != "off") { echo "Distrito postal: ".\$contact_pd."<br><br>"; }
if (isset(\$contact_tlf) && \$contact_tlf != "off") { echo \$contact_tlf."<br>"; }
if (isset(\$contact_email) && \$contact_email != "off") { echo "<a href=\"mailto:".\$contact_email."\" title=\"".\$contact_email."\">".\$contact_email."</a><br>"; }
?>
</font>
</p>
<br>
EOD;
$body_default_represent = str_replace("<","&lt;",$body_default);
$body_default_represent = str_replace(">","&gt;",$body_default_represent);


//Las siguientes lineas son para que no se confunda el editor de textos al colorear (MAX's HTML Beauty++ 2004):
?>
<?php
 
if (!file_exists($title_file)) {
   if (!isset($errors)) { $errors = ""; }
   $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>EL ARCHIVO</b> ".$title_file." <b><u>NO EXISTE</u> Y SE CREAR&Aacute; CON EL TEXTO</b><i> ".$title_default_represent."</i></font><br>";
   $title = fopen($title_file, "a+");
   fwrite($title,$title_default);
//   $company = readfile($title_file);
   fclose($title);
} else { 
       $title = fopen($title_file, "a+");
//       $company = readfile($title_file);
       fclose($title);
       //echo "(*) <b>EL ARCHIVO</b> ".$title_file." <b>EXISTE</b><br>";
       }

if (!file_exists($menu_file)) {
   if (!isset($errors)) { $errors = ""; }
   $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>EL ARCHIVO</b> ".$menu_file." <b><u>NO EXISTE</u> Y SE CREAR&Aacute; CON EL TEXTO</b><i> ".$menu_default_represent."</i></font><br>";
   $menu = fopen($menu_file, "a+");
   fwrite($menu,$menu_default);
} else { 
       $menu = fopen($menu_file, "a+");
       //echo "(*) <b>EL ARCHIVO</b> ".$menu_file." <b>EXISTE</b><br>";
       }
       
if (!file_exists($body_file)) {
   if (!isset($errors)) { $errors = ""; }
   $errors .= "<font color=\"#000000\" size=\"3\" face=\"arial\">(</font><font color=\"#ff0000\" size=\"3\" face=\"arial\">ERROR</font><font color=\"#000000\" size=\"3\" face=\"arial\">)</font><font color=\"#aa0000\" size=\"3\" face=\"arial\"> ". date("d/m/Y [H:i:s]") ." </font><font color=\"#000000\" size=\"3\" face=\"arial\"> <b>EL ARCHIVO</b> ".$body_file." <b><u>NO EXISTE</u> Y SE CREAR&Aacute; CON EL TEXTO</b><i> ".$body_default_represent."</i></font><br>";
   $body = fopen($body_file, "a+");
   fwrite($body,$body_default);
} else { 
       $body = fopen($body_file, "a+");
       //echo "(*) <b>EL ARCHIVO</b> ".$body_file." <b>EXISTE</b><br>";
       }



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
  echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&screen_width=\" + screen.width + \"&screen_height=\" + screen.height + \"&table_width_var=auto&" . session_name() . "=". session_id() ."\";\n";
//  echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&screen_width=\" + screen.width + \"&table_width_var=auto&" . session_name() . "=". session_id() ."\";\n";
} else {
  echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&" . session_name() . "=". session_id() ."\";\n";
  }

  } else {
if (isset($javascript_autodetect_resolution) && $javascript_autodetect_resolution == "on") {
//echo "  location.href=\"".$this_file."?javascript_support=enabled&screen_width=\" + screen.width;\n";
echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&screen_width=\" + screen.width + \"&screen_height=\" + screen.height + \"&table_width_var=auto\";\n";
//echo "  location.href=\"".$this_file. $_SESSION['change_resolution_page_session'] . "&javascript_support=enabled&screen_width=\" + screen.width + \"&table_width_var=auto\";\n";
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
//if (!isset($contact_file) || $contact_file == "") { $contact_file == "contact.php"; }

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

                         include $body_file;

                         
                         if (isset($show_discounts_on_index) && $show_discounts_on_index == "on") {
                         
                         
























//echo "<br>";

if (isset($supply_on_total_money_requiered) && $supply_on_total_money_requiered != "off" && $supply_on_total_money_requiered != "" || $supply_on_total_money_requiered_percent && $supply_on_total_money_requiered_percent != "off" && $supply_on_total_money_requiered_percent != "") {


echo "<br><b>Descuentos</b>:<br>";

if (file_exists($money_file)) {
include $money_file;
}



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





if($supply_on_total_money_requiered == "0") {
echo "<br>* Se aplicara a <b>todos los pedidos</b> un <b>descuento</b> de:<br>";


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

echo "<br>* Se aplicara a los <b>pedidos superiores</b> (sin contar impuestos) a:<br>";

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
echo "<br>* Se aplicara a <b>todos los pedidos</b> un <b>descuento</b> del <b>".$supply_on_total_money_to_discount_percent."%</b>";
}
if($supply_on_total_money_requiered_percent > 0) {
echo "<br>* Se aplicara a los <b>pedidos superiores</b> (sin contar impuestos) a:<br>";

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
