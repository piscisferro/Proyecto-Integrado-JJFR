<?php
/**
 * Clase Comida, en este clase tendremos todo lo relacionado con la carga y
 * obtencion de datos de los comida del post en la base de datos.
 *
 * @author Juan Jose Fernandez Romero
 */
require_once "restDB.php";

class Comida {
    // Numero de filas que tiene la tabla
    private static $numRows;
    
    // Atributos de clase
    private $id;
    private $nombre;
    private $precio;
    private $ingredientes;
    private $fecha;
    private $imgDir;
    
    // Funcion constructor
    public function __construct($nombre, $precio, $ingredientes, $imgDir, $fecha, $id = null) {
        // Asignamos los valores del constructor a los atributos
        $this->nombre = $nombre;
        $this->precio = number_format($precio, 2);
        $this->ingredientes = $ingredientes;
        $this->imgDir = $imgDir;
        $this->fecha = $fecha;
        $this->id = $id;
        
    }
    
    // Funcion getNumRows
    public static function getNumRows() {
        return self::$numRows;
    }
 
    // Funcion getId
    public function getId() {
        return $this->id;
    }

    // Funcion getNombre
    public function getNombre() {
        return $this->nombre;
    }

    // Funcion getPrecio
    public function getPrecio() {
        return $this->precio;
    }

    // Funcion getFecha
    public function getFecha() {
        return $this->fecha;
    }
    
    // Funcion getIngrendientes
    public function getIngredientes() {
        return $this->ingredientes;
    }
    
    // Funcion getImgDir
    public function getImgDir() {
        return $this->imgDir;
    }

    
    
    // Funcion setter para todos los atributos, 
    // en el caso de que no se quiera cambiar un atributo, dejar en blanco o en null
    public function setter($nombre=null, $precio=null, $ingredientes=null, $imgDir=null, $fecha=null) {
        
        if ($nombre !== "" && $nombre != null) {
            $this->nombre = $nombre;
        }
        
        if ($precio !== "" && $precio != null) {
            $this->precio = $precio;
        }
        
        if ($ingredientes !== "" && $ingredientes != null) {
            $this->ingredientes = $ingredientes;
        }
        
        if ($imgDir !== "" && $imgDir !== null) {
            $this->imgDir = $imgDir;
        }
        
        if ($fecha !== "" && $fecha != null) {
            $this->fecha = $fecha;
        }
    }
    
    // Funcion insert que inserta un nuevo objeto a la base de datos
    public function insert() {
        // Establecemos conexion con la BD
        $conexion = restDB::connectDB();
        
        // Sentencia Insert
        $insert = "INSERT INTO comida (nombre, precio, ingredientes, imagen, fecha) VALUES (\"$this->nombre\", "
          . "\"$this->precio\", \"$this->ingredientes\", \"$this->imgDir\" ,STR_TO_DATE(\"$this->fecha\", '%d-%m-%Y'))";
        
        // Ejecutamos la sentencia y guardamos la respuesta de la BD
        $resultado = $conexion->query($insert);
        
        // Devolvemos la respuesta de la BD
        return $resultado;
    }
    
    // Funcion delete que borra el objeto en la base de datos
    public function delete() {
        // Establecemos conexion con la BD
        $conexion = restDB::connectDB();
        
        // Sentencia para borrar el objeto
        $borrado = "DELETE FROM comida WHERE id=\"".$this->id."\"";
        
        // Ejecutamos la sentencia y guardamos la respuesta de la BD
        $resultado = $conexion->query($borrado);
        
        // Devolvemos la respuesta de la BD
        return $resultado;
    }
    
    // Funcion delete que modifica el objeto en la base de datos
    public function update() {
        // Establecemos conexion con la BD
        $conexion = restDB::connectDB();
        
        // Sentencia para modificar el objeto
        $update = "UPDATE comida SET nombre=\"$this->nombre\", precio=\"$this->precio\", ingredientes=\"$this->ingredientes\", imagen=\"$this->imgDir\" ,fecha=STR_TO_DATE(\"$this->fecha\", \"%d-%m-%Y\") WHERE id=\"$this->id\"";
        
        // Ejecutamos la sentencia y guardamos la respuesta de la BD
        $resultado = $conexion->query($update);
        
        // Devolvemos la respuesta de la BD
        return $resultado;
    }
    
    
    // Funcion estatica de clase para seleccionar una comida por su ID, devuelve un objeto
    public static function getComidaById($id) {
        // Conectamos a la BD
        $conexion = restDB::connectDB();

        // Sentencia Select
        $seleccion = "SELECT * FROM comida WHERE id=$id";

        // Ejecutamos la sentencia SELECT
        $consulta = $conexion->query($seleccion);

        // Convertimos en objeto la fila recibida
        $registro = $consulta->fetchObject();

        // Guardamos la comida
        $comida = new Comida($registro->nombre, $registro->precio, $registro->ingredientes, $registro->imagen, $registro->fecha, $registro->id);

        // Devolvemos el array comida
        return $comida;   
    }
  
    // Funcion estatica de clase para seleccionar todos los comida de la tabla devuelve un array de objetos
    public static function getComida($pagina = 0, $paginasVisualizadas = 10, $orden=null, $dir=null, $filtro=null, $valor=null, $filtro2=null) {

        // Conectamos a la BD
        $conexion = restDB::connectDB();

        // Si el filtro no viene vacio
        if ($filtro !== "" && $filtro !== null && $valor !== "" && $valor !== null) {
            // Sentencia Select
            $seleccion = "SELECT * FROM comida WHERE LOWER($filtro) LIKE LOWER('%$valor%')";
            $cuentaFilas = "SELECT count(id) FROM comida WHERE LOWER($filtro) LIKE LOWER('%$valor%')";

        } else {  // Si el filtro viene vacio
            // Sentencia Select
            $seleccion = "SELECT * FROM comida";
            $cuentaFilas = "SELECT count(id) FROM comida";
        }
        
        // Si la hay un segundo filtro, se filtra el valor por esa columna tambien
        if ($filtro2 !== "" && $filtro2 !== null && $valor !== null && $valor !== "") {
            $seleccion .= " OR LOWER($filtro2) LIKE LOWER('%$valor%')";
            $cuentaFilas .= " OR LOWER($filtro2) LIKE LOWER('%$valor%')";
        }
        
        // En el caso de que haya algun tipo filtro por orden
        if ($orden !== "" && $orden !== null) {
            $seleccion .= " ORDER BY $orden $dir";
        } else { // Si no hay ningun filtro de orden se ordena alfabeticamente
            $seleccion .= " ORDER BY nombre $dir";
        }
        
        // Offset y Limit to para las paginas
        $offset = $pagina * $paginasVisualizadas;
        $seleccion .= " LIMIT $paginasVisualizadas OFFSET $offset";

        // Ejecutamos el Select con query (que devuelve los datos, exec solo devuelve filas afectadas)
        $consulta = $conexion->query($seleccion);

        
        // Ejecuta el contar filas sql
        $consultaFilas = $conexion->query($cuentaFilas);
        // Guardamos el resultado en numFilas y lo pasa a string
        $numFilas = $consultaFilas->fetchColumn();
        // Guardamos el numero de filas en el atributo del objeto
        Comida::$numRows = $numFilas;
        
        // Inicializamos $comida como array antes del While para evitar error
        $comidas = [];

        // Recorremos todos los registros
        while ($registro = $consulta->fetchObject()) {
          // Creamos objetos y los metemos en el array comida
          $comidas[] = new Comida($registro->nombre, $registro->precio, $registro->ingredientes, $registro->imagen, $registro->fecha, $registro->id);
        }

        // Devolvemos el array comida
        return $comidas;    
    }
}