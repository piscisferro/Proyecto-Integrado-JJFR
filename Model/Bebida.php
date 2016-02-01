<?php
/**
 * Clase Bebida, en este clase tendremos todo lo relacionado con la carga y
 * obtencion de datos de los bebidas del post en la base de datos.
 *
 * @author Juan Jose Fernandez Romero
 */
require_once "restDB.php";

class Bebida {
    // Atributos de clase
    private $id;
    private $nombre;
    private $precio;
    private $cantidad;
    private $fecha;
    
    // Funcion constructor
    public function __construct($nombre, $precio, $cantidad, $fecha, $id = null) {
        // Asignamos los valores del constructor a los atributos
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
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

    // Funcion getCantidad
    public function getCantidad() {
        return $this->cantidad;
    }

    // Funcion getFecha
    public function getFecha() {
        return $this->fecha;
    }

    // Funcion setter para todos los atributos, 
    // en el caso de que no se quiera cambiar un atributo, dejar en blanco o en null
    public function setter($nombre=null, $precio=null, $cantidad=null, $fecha=null, $id=null) {
        
        if ($nombre !== "" && $nombre != null) {
            $this->nombre = $nombre;
        }
        
        if ($precio !== "" && $precio != null) {
            $this->precio = $precio;
        }
        
        if ($cantidad !== "" && $cantidad != null) {
            $this->cantidad = $cantidad;
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
        $conexion = restDB::connectBebidaDB();
        
        // Sentencia Insert
        $insert = "INSERT INTO bebida (nombre, cantidad, precio, fecha) VALUES (\"$this->nombre\", "
          . "\"$this->cantidad\", \"$this->precio\", STR_TO_DATE(\"$this->fecha\", '%d-%m-%Y'))";
        
        // Ejecutamos la sentencia
        $conexion->exec($insert);
    }
    
    // Funcion delete que borra el objeto en la base de datos
    public function delete() {
        // Establecemos conexion con la BD
        $conexion = restDB::connectBebidaDB();
        
        // Sentencia para borrar el objeto
        $borrado = "DELETE FROM bebida WHERE id=\"".$this->id."\"";
        
        // Ejecutamos la sentencia
        $conexion->exec($borrado);
    }
    
    // Funcion delete que modifica el objeto en la base de datos
    public function update() {
        // Establecemos conexion con la BD
        $conexion = restDB::connectBebidaDB();
        
        // Sentencia para modificar el objeto
        $update = "UPDATE bebida SET nombre=\"$this->nombre\", cantidad=\"$this->cantidad\", precio=\"$this->precio\", fecha=STR_TO_DATE(\"$this->fecha\", '%d-%m-%Y') WHERE id=\"$this->id\"";
        
        // Ejecutamos la sentencia
        $conexion->exec($update);
    }
    
    // Funcion estatica de clase para seleccionar una bebida por su ID, devuelve un objeto
    public static function getBebidaById($id) {
        // Conectamos a la BD
        $conexion = restDB::connectBebidaDB();

        // Sentencia Select
        $seleccion = "SELECT * FROM bebida WHERE id=$id";

        // Ejecutamos la sentencia SELECT
        $consulta = $conexion->query($seleccion);

        // Convertimos en objeto la fila recibida
        $registro = $consulta->fetchObject();

        // Guardamos la bebida
        $bebida = new Bebida($registro->nombre, $registro->precio, $registro->cantidad, $registro->fecha, $registro->id);

        // Devolvemos el array bebidas
        return $bebida;   
    }
  
    // Funcion estatica de clase para seleccionar todos los bebidas de la tabla devuelve un array de objetos
    public static function getBebidas($orden=null, $filtro=null, $valor=null) {

        // Conectamos a la BD
        $conexion = restDB::connectBebidaDB();

        // Si el filtro no viene vacio
        if ($filtro !== "" && $filtro !== null && $valor !== "" && $valor !== null) {
            // Sentencia Select
            $seleccion = "SELECT * FROM bebida WHERE $filtro LIKE '$valor'";

        } else {  // Si el filtro viene vacio
            // Sentencia Select
            $seleccion = "SELECT * FROM bebida";
        }
        
        // En el caso de que haya algun tipo filtro por orden
        if ($orden !== "" && $orden !== null) {
            $seleccion .= " ORDER BY $orden DESC";
        } else { // Si no hay ningun filtro de orden se ordena alfabeticamente
            $seleccion .= " ORDER BY nombre DESC";
        }

        // Ejecutamos el Select con query (que devuelve los datos, exec solo devuelve filas afectadas)
        $consulta = $conexion->query($seleccion);

        // Inicializamos $bebidas como array antes del While para evitar error
        $bebidas = [];

        // Recorremos todos los registros
        while ($registro = $consulta->fetchObject()) {
          // Creamos objetos y los metemos en el array bebidas
          $bebidas[] = new Bebida($registro->nombre, $registro->precio, $registro->cantidad, $registro->fecha, $registro->id);
        }

        // Devolvemos el array bebidas
        return $bebidas;    
    }
    
    
}