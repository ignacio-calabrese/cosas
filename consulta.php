<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
</head>
<body>
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
        
        /// Comprobacio´n de funciones
        if(isset($_POST["send"])) { 
            $query = "SELECT * FROM productos LIMIT " . $_POST['num'] ;
            echo "<table border='1'>";
            $fila = selectQuery($query);
            if($fila->num_rows > 0) {
                while ($row = $fila->fetch_array(MYSQLI_ASSOC)) {
                    echo "<tr>";  
                    echo "<td>" .$row['CODIGOARTICULO']. "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
    
            ///////
            echo "<hr>";
            //////
            echo "<table border='1'>";
            $fila = selectQuery($query);
            if($fila->num_rows > 0) {
                while ($row = $fila->fetch_array(MYSQLI_ASSOC)) {
                    echo "<tr>";  
                    echo "<td>" .$row['CODIGOARTICULO']. "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                
                echo affectedRowsQuery($query);
                echo iudQuery($query); 
            }

        } else {
            echo('
                <form action=' . $_SERVER["PHP_SELF"] . ' method="post">
                    <label for="num">Cantidad de resultados</label>
                    <input type="number" name="num" id="num" min="1">
                    <input type="submit" name="send" id="send" value="Enviar">
                </form>
            ');
        }

    // 
    ?> 
    <script>
        /*$(document).ready(function(){
            $("#send").submit(function(event){
                alert("hhhh");
               $.post("consulta.php", {data: serialize()}, function(data) {
                    $(body).html(data);
               });
               event.preventDefault();
            });
        });*/
    </script>
</body>
</html>