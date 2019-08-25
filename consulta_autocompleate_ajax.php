
    <?php

        $host = "localhost";
        $usuario = "root";
        $clave = "7126";
        $nombreDB = "pruebas";

        // Crear conexión
        function connect() {
            global $host , $usuario , $clave , $nombreDB;
            $conn = new mysqli($host , $usuario , $clave , $nombreDB) 
            OR die("Error de Conexión: " . $conn->connect_errno() . " " . $conn->connect_error());
    
            if (!$conn->set_charset("utf8")) {
                echo "Error:", $conn->error;
                exit();
            } 
            return $conn;
        }

        // Devuelve resultset de SELECT
        function selectQuery($query){
            $conn = connect(); 
            $resultset = $conn->query($query, MYSQLI_STORE_RESULT);
            $data = $resultset;
            $resultset = null;// $resultset->close();
            $conn->close();
            return $data;
        }
       
        $num = $_GET['num'];
        $query = "SELECT * FROM productos WHERE CODIGOARTICULO LIKE '%$num%'";
            $fila = selectQuery($query);
            $datos = array();
            while ($row = $fila->fetch_array(MYSQLI_ASSOC)) {
                $datos[] = $row['CODIGOARTICULO'];
            }
            echo json_encode($datos);
    ?> 
    