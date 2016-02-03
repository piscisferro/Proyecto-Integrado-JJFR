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
    private $imgDir;
    
    // Funcion constructor
    public function __construct($nombre, $precio, $cantidad, $imgDir, $fecha, $id = null) {
        // Asignamos los valores del constructor a los atributos
        $this->nombre = $nombre;
        $this->precio = number_format($precio, 2);
        $this->cantidad = $cantidad;
        $this->imgDir = $imgDir;
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
    
    // Funcion getImgDir
    public function getImgDir() {
        return $this->imgDir;
    }

    
    // Funcion setter para todos los atributos, 
    // en el caso de que no se quiera cambiar un atributo, dejar en blanco o en null
    public function setter($nombre=null, $precio=null, $cantidad=null, $imgDir=null, $fecha=null, $id=null) {
        
        if ($nombre !== "" && $nombre != null) {
            $this->nombre = $nombre;
        }
        
        if ($precio !== "" && $precio != null) {
            $this->precio = $precio;
        }
        
        if ($cantidad !== "" && $cantidad != null) {
            $this->cantidad = $cantidad;
        }
        
        if ($imgDir !== "" && $imgDir !== null) {
            $this->imgDir = $imgDir;
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
        $conexion = restDB::connectDB();
        
        // Sentencia Insert
        $insert = "INSERT INTO bebida (nombre, cantidad, precio, imagen, fecha) VALUES (\"$this->nombre\", "
          . "\"$this->cantidad\", \"$this->precio\", \"$this->imgDir\" , STR_TO_DATE(\"$this->fecha\", '%d-%m-%Y'))";
        
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
        $borrado = "DELETE FROM bebida WHERE id=\"".$this->id."\"";
        
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
        $update = "UPDATE bebida SET nombre=\"$this->nombre\", cantidad=\"$this->cantidad\", precio=\"$this->precio\", imagen=\"$this->imgDir\" , fecha=STR_TO_DATE(\"$this->fecha\", \"%d-%m-%Y\") WHERE id=\"$this->id\"";
        
        // Ejecutamos la sentencia y guardamos la respuesta de la BD
        $resultado = $conexion->query($update);
        
        // Devolvemos la respuesta de la BD
        return $resultado;
    }
    
    // Funcion estatica de clase para seleccionar una bebida por su ID, devuelve un objeto
    public static function getBebidaById($id) {
        // Conectamos a la BD
        $conexion = restDB::connectDB();

        // Sentencia Select
        $seleccion = "SELECT * FROM bebida WHERE id=$id";

        // Ejecutamos la sentencia SELECT
        $consulta = $conexion->query($seleccion);

        // Convertimos en objeto la fila recibida
        $registro = $consulta->fetchObject();

        // Guardamos la bebida
        $bebida = new Bebida($registro->nombre, $registro->precio, $registro->cantidad, $registro->imagen, $registro->fecha, $registro->id);

        // Devolvemos el array bebidas
        return $bebida;   
    }
  
    // Funcion estatica de clase para seleccionar todos los bebidas de la tabla devuelve un array de objetos
    public static function getBebidas($orden=null, $dir=null, $filtro=null, $valor=null, $filtro2=null) {

        // Conectamos a la BD
        $conexion = restDB::connectDB();

        // Si el filtro no viene vacio
        if ($filtro !== "" && $filtro !== null && $valor !== "" && $valor !== null) {
            // Sentencia Select
            $seleccion = "SELECT * FROM bebida WHERE LOWER($filtro) LIKE LOWER('%$valor%')";

        } else {  // Si el filtro viene vacio
            // Sentencia Select
            $seleccion = "SELECT * FROM bebida";
        }
        
        // Si la hay un segundo filtro, se filtra el valor por esa columna tambien
        if ($filtro2 !== "" && $filtro2 !== null && $valor !== null && $valor !== "") {
            $seleccion .= " OR LOWER($filtro2) LIKE LOWER('%$valor%')";
        }
        
        // En el caso de que haya algun tipo filtro por orden
        if ($orden !== "" && $orden !== null) {
            $seleccion .= " ORDER BY $orden $dir";
        } else { // Si no hay ningun filtro de orden se ordena alfabeticamente
            $seleccion .= " ORDER BY nombre $dir";
        }

        // Ejecutamos el Select con query (que devuelve los datos, exec solo devuelve filas afectadas)
        $consulta = $conexion->query($seleccion);

        // Inicializamos $bebidas como array antes del While para evitar error
        $bebidas = [];

        // Recorremos todos los registros
        while ($registro = $consulta->fetchObject()) {
          // Creamos objetos y los metemos en el array bebidas
          $bebidas[] = new Bebida($registro->nombre, $registro->precio, $registro->cantidad, $registro->imagen, $registro->fecha, $registro->id);
        }

        // Devolvemos el array bebidas
        return $bebidas;    
    }
    
    
}