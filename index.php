 <?php 
// Cargamos LIGA3
require_once 'LIGA3/LIGA.php';

// Personalizo una conexión a la base de datos (servidor, usuario, contraseña, schema)
BD('localhost', 'base', 'base', 'AppTareas');
 
// Configuramos la entidad a usar
$tabla = 'Tareas';
$liga  = LIGA($tabla,'order by nombre');

//Si es una petición asíncrona sólo muestro la respuesta
if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
// Eliminar el registro seleccionado
 if (isset($_GET['id'])) {
   $resp = $liga->eliminar($_GET['id']);
   if ($resp == 1) {
    echo 'Borrado con exito!';
   }
  } else {
   echo 'Error en la operación.';
  }
  //Insertar un nuevo registro
  
  // Actualizar un registro
  
 exit(0);
}

// Imprimo las etiquetas HTML iniciales
// 3.3 AJAX con LIGA.js
HTML::cabeceras(array(
  'title'      =>'Ajax y Liga',
  'description'=>'Página de pruebas para AJAX y LIGA 3',
  'css'        =>'util/LIGA.css',
  'style'      =>'label { width:100px; }'
  ));
  
// Guardo el bufer para colocarlo en el layout
ob_start();

echo '<p style="text-align:center"><font color="#6600CC">AppTareas</font></p>';
echo "<HR>";

  // Tabla con instancias
  $cols = array('*','-id','acción'=>'<a class="borrar" href="?id=@[id]">Borrar</a>');
  $join = array('depende'=>$liga);
  $pie  = '<th colspan="@[numCols]">Total de instancias: <span id="numReg">@[numReg]</span> </th>';
  echo "\n";
  echo '<form id="lista-form">';
  echo "\n";
  HTML::tabla($liga, 'Instancias de '.$tabla, $cols, true, $join,$pie);
  echo "</form>\n";
  echo "<br>\n\n";
	 
  $cont = ob_get_clean();
 

// Estuctura el cuerpo de la página
HTML::cuerpo(array('cont'=>$cont));
?>
<script
  src="https://code.jquery.com/jquery-3.5.0.min.js"
  integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
  crossorigin="anonymous"></script>
<script src="App.js">
</script>
<?php
// Cierre de etiquetas HTML
HTML::pie();
?>
