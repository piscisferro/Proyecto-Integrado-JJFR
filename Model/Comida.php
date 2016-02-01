<?php
/**
 * Clase Comida, en este clase tendremos todo lo relacionado con la carga y
 * obtencion de datos de los comida del post en la base de datos.
 *
 * @author Juan Jose Fernandez Romero
 */
require_once "restDB.php";

class Comida {
    // Atributos de clase
    private $id;
    private $nombre;
    private $precio;
    private $fecha;
    
    // Funcion constructor
    public function __construct($nombre, $precio, $fecha, $id = null) {
        // Asignamos los valores del constructor a los atributos
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->fecha = $fecha;
        $this->id = $id;
        
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

    // Funcion setter para todos los atributos, 
    // en el caso de que no se quiera cambiar un atributo, dejar en blanco o en null
    public function setter($nombre=null, $precio=null, $fecha=null, $id=null) {
        
        if ($nombre !== "" && $nombre != null) {
            $this->nombre = $nombre;
        }
        
        if ($precio !== "" && $precio != null) {
            $this->precio = $precio;
        }
        
        if ($fecha !== "" && $fecha != null) {
            $this->fecha = $fecha;
        }
        
        if ($id !== "" && $id != null) {
            $this->id = $id;
        }
    }
    
    // Funcion insert que inserta un nuevo objeto a la base de datos
    public function insert() {
        // Establecemos conexion con la BD
        $conexion = restDB::connectComidaDB();
        
        // Sentencia Insert
        $insert = "INSERT INTO comida (nombre, precio, fecha) VALUES (\"$this->nombre\", "
          . "\"$this->precio\", STR_TO_DATE(\"$this->fecha\", '%d-%m-%Y'))";
        
        // Ejecutamos la sentencia
        $conexion->exec($insert);
    }
    
    // Funcion delete que borra el objeto en la base de datos
    public function delete() {
        // Establecemos conexion con la BD
        $conexion = restDB::connectComidaDB();
        
        // Sentencia para borrar el objeto
        $borrado = "DELETE FROM comida WHERE id=\"".$this->id."\"";
        
        // Ejecutamos la sentencia
        $conexion->exec($borrado);
    }
    
    // Funcion delete que modifica el objeto en la base de datos
    public function update() {
        // Establecemos conexion con la BD
        $conexion = restDB::connectComidaDB();
        
        // Sentencia para modificar el objeto
        $update = "UPDATE comida SET nombre=\"$this->nombre\", precio=\"$this->precio\", fecha=STR_TO_DATE(\"$this->fecha\", '%d-%m-%Y') WHERE id=\"$this->id\"";
        
        // Ejecutamos la sentencia
        $conexion->exec($update);
    }
    
    // Funcion estatica de clase para seleccionar una comida por su ID, devuelve un objeto
    public static function getComidaById($id) {
        // Conectamos a la BD
        $conexion = restDB::connectComidaDB();

        // Sentencia Select
        $seleccion = "SELECT * FROM comida WHERE id=$id";

        // Ejecutamos la sentencia SELECT
        $consulta = $conexion->query($seleccion);

        // Convertimos en objeto la fila recibida
        $registro = $consulta->fetchObject();

        // Guardamos la comida
        $comida = new Comida($registro->nombre, $registro->precio, $registro->fecha, $registro->id);

        // Devolvemos el array comida
        return $comida;   
    }
  
    // Funcion estatica de clase para seleccionar todos los comida de la tabla devuelve un array de objetos
    public static function getComida($orden=null, $filtro=null, $valor=null) {

        // Conectamos a la BD
        $conexion = restDB::connectComidaDB();

        // Si el filtro no viene vacio
        if ($filtro !== "" && $filtro !== null && $valor !== "" && $valor !== null) {
            // Sentencia Select
            $seleccion = "SELECT * FROM comida WHERE $filtro LIKE '$valor'";

        } else {  // Si el filtro viene vacio
            // Sentencia Select
            $seleccion = "SELECT * FROM comida";
        }
        
        // En el caso de que haya algun tipo filtro por orden
        if ($orden !== "" && $orden !== null) {
            $seleccion .= " ORDER BY $orden DESC";
        } else { // Si no hay ningun filtro de orden se ordena alfabeticamente
            $seleccion .= " ORDER BY nombre DESC";
        }

        // Ejecutamos el Select con query (que devuelve los datos, exec solo devuelve filas afectadas)
        $consulta = $conexion->query($seleccion);

        // Inicializamos $comida como array antes del While para evitar error
        $comidas = [];

        // Recorremos todos los registros
        while ($registro = $consulta->fetchObject()) {
          // Creamos objetos y los metemos en el array comida
          $comidas[] = new Comida($registro->nombre, $registro->precio, $registro->fecha, $registro->id);
        }

        // Devolvemos el array comida
        return $comidas;    
    }
}