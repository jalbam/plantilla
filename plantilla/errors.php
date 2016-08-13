<?php

//Visor de logs
//
//Programa y Web por Joan Alba Maldonado

?>

<html>
<head><title>
Visor de logs - <?php echo date("d/m/Y [H:i:s]"); ?>
</title></head>
<body bgcolor="#ffffff">
Visor de logs
<br>
<?php echo "Fecha y hora actuales: ".date("d/m/Y [H:i:s]"); ?>
<br>
<br>
<?php
if(file_exists("errors.log")) {
   include "errors.log";
   } else {
          echo "<font color=\"#ff0000\">No existe errors.log</font><br>";
          }
?>
</body>
</html>
