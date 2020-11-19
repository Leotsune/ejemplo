 <?php 
// Cargamos LIGA3
require_once 'LIGA3/LIGA.php';

// Personalizo una conexión a la base de datos (servidor, usuario, contraseña, schema)
BD('localhost', 'base', 'base', 'AppTareas');
 
// Configuramos la entidad a usar
$tabla = 'Tareas';
$liga  = LIGA($tabla,'order by nombre'); 

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
 $cols = array('*', 'acción'=>'<a href="?borrar=@[0]">Borrar</a>');
 $join = array('depende'=>$liga);
 $pie  = '<th colspan="@[numCols]">Total de instancias: @[numReg]</th>';
 HTML::tabla($liga, 'Instancias de '.$tabla, $cols, true, $join,$pie);
 echo "<br>\n\n";

 $campos = array('*');
 
 // Formulario para crear nuevas instancias
 $props  = array('form'=>'method="POST" action="accion=insertar.php"',
	  'input[nombre]'=>array('required'=>'required'));
 HTML::forma($liga,'Registro de '.$tabla,$campos,$props,TRUE,$_POST);
 echo "<br>\n\n";
 
 
 // Formulario para modificar instancias
 $props  = array('form'=>array('method'=>'POST', 'action'=>'accion=modificar.php'), 'prefid'=>'algo',
	  'input[nombre]'=>array('required'=>'required'));
 $cual   = !empty($_POST['cual']) ? $_POST['cual'] : '';
 $select = HTML::selector($liga, 1, array('select'=>array('name'=>'cual', 'id'=>'algocual'),
						 'option'=>array('value'=>'@[0]'),
						 "option@si('$cual'=='@[0]')"=>array('selected'=>'selected')), array('depende'=>$liga)
		   );
 $campos = array('cual'=>$select, '*', '-fecha');
 HTML::forma($liga, 'Modificar '.$tabla, $campos, $props, true);

$cont = ob_get_clean();

// Estuctura el cuerpo de la página
HTML::cuerpo(array('cont'=>$cont));

// Cierre de etiquetas HTML
HTML::pie();

?>
