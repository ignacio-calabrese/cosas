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
        
        // Función de INSERT, UPDATE y DELETE
        function iudQuery($query) {
            $conn = connect();
            if ($conn->query($query)) {
                $conn->close();
                return TRUE;
            } else {
                die ("Error: " . $conn->error);
                $conn->close();
            }
        }

        // Devuelve el N° de filas afectadas de la sentencia SQL
        function affectedRowsQuery($query) {
            $conn = connect();
            if ($conn->query($query)) {
                $num = $conn->affected_rows;
                $conn->close();
                return $num;
            } else {
                die ("Error: " . $conn->error);
                $conn->close();
            }
        }

        /////////////////////////////////////////////////77777777777777
        
        /// Comprobación de funciones
            $query = "SELECT * FROM productos WHERE IMPORTADO LIKE '%" . $_POST["imp"]. "%';";
	        //$result = mysqli_query(connect(), $query);
            $data_sql = array();
            $error = null;
            $fila = selectQuery($query);
            if($fila->num_rows > 0) {
                //$data_sql = array();
                while ($row = $fila->fetch_array(MYSQLI_ASSOC)) {
                    $subdata = array();
                    $subdata['CODIGOARTICULO'] = $row['CODIGOARTICULO'];
                    $subdata['SECCION'] = $row['SECCION'];
                    $subdata['NOMBREARTICULO'] = $row['NOMBREARTICULO'];
                    $subdata['PRECIO'] = floatval($row['PRECIO']);
                    $subdata['FECHA'] = $row['FECHA'];
                    $subdata['IMPORTADO'] = $row['IMPORTADO'];
                    $subdata['PAISDEORIGEN'] = $row['PAISDEORIGEN'];
                    $subdata['EDITAR'] = '<button alt="Editar" title="Editar" onclick="Editar('.$row['CODIGOARTICULO'].');">EDITAR</button>';
                    $subdata['ELIMINAR'] = '<button alt="Eliminar" title="Eliminar" onclick="Eliminar('.$row['CODIGOARTICULO'].');">Eliminar</button>';
                    $data_sql[] = $subdata;
                }
                $error = null;
            } else {
                $error = "ERROR";
            }
            $json_data = array(
                "draw" => intval(1),
                "recordsTotal" => intval($fila->num_rows),
                "recordsFiltered" => intval($fila->num_rows),
                "data" => $data_sql,
                "error" => $error
            );
            echo json_encode($json_data, JSON_UNESCAPED_UNICODE);
                
 
    ?>