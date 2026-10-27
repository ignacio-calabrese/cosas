<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
	
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
	

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.js"></script>



</head>
<body>
<style>
	@keyframes spinner {
		to {transform: rotate(360deg);}
	}
	.spinner:before {
		content: '';
		box-sizing: border-box;
		position: absolute;
		top: 50%;
		left: 50%;
		width: 20px;
		height: 20px;
		margin-top: -10px;
		margin-left: -10px;
		border-radius: 50%;
		border: 2px solid #ccc;
		border-top-color: #333;
		animation: spinner .6s linear infinite;
	}
</style>

	<fieldset>
		<legend>
			<b>Filtros</b>
		</legend>
		<table width="100%">
			<tr>
				<td>
					<b>IMPORTADO: </b>
					<select id="imp">
						<option value="" <?php if($_POST['imp'] == "") echo " selected='selected'";?>>Todos</option>
						<option value="VERDADERO" <?php if($_POST['imp'] == "VERDADERO") echo " selected='selected'";?>>VERDADERO</option>
						<option value="FALSO" <?php if($_POST['imp'] == "FALSO") echo " selected='selected'";?>>FALSO</option>
					</select>
				</td>
			</tr>
			<tr>
		</table>
	</fieldset>

	<div id="listados">
		<table id="table_productos">
			<thead>
				<tr>
					<th>CODIGOARTICULO</th>
					<th>SECCION</th>
					<th>NOMBREARTICULO</th>
					<th>PRECIO</th>
					<th>FECHA</th>
					<th>IMPORTADO</th>
					<th>PAISDEORIGEN</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
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
				$query = "SELECT * FROM productos WHERE IMPORTADO LIKE '%" . $_POST["imp"]. "%';";
				$fila = selectQuery($query);
				if($fila->num_rows > 0) {
					while ($row = $fila->fetch_array(MYSQLI_ASSOC)) {
					?>
					<tr>
						<td><?php echo $row['CODIGOARTICULO'];?></td> 
						<td><?php echo $row['SECCION'];?></td>
						<td><?php echo $row['NOMBREARTICULO'];?></td>
						<td><?php echo $row['PRECIO'];?></td>
						<td><?php echo $row['FECHA'];?></td>
						<td><?php echo $row['IMPORTADO'];?></td>
						<td><?php echo $row['PAISDEORIGEN'];?></td>
						<td><button alt="Editar" title="Editar" onclick="Editar(<?php echo $row['CODIGOARTICULO']?>);">EDITAR</button></td>
						<td><button alt="Eliminar" title="Eliminar" onclick="Eliminar(<?php echo$row['CODIGOARTICULO']?>);">Eliminar</button></td>
					</tr>
					<?php
					} 
				}
				?>
			</tbody>
		</table>
	</div>
<script>
    $(document).ready(function(){
		$('#imp').on('change', function(){ 
			$('body').load('datatable_front.php', {
				imp: $('#imp').val()
			});
		});
		$("#table_productos").DataTable({
				pageLength: 10,
				order: [[ 0, "asc" ]],
				processing: true,
				serverSide: false,
				columns: [
					{data: "CODIGOARTICULO", 
					render: function(data, type, row, meta) {
      					return '<a href="'+data+'">'+data+'</a>';
    				}},
					{data: "SECCION"},
					{data: "NOMBREARTICULO"},
					{data: "PRECIO",
					render: function(data, type, row, meta){
						return '$' + data;
					}},
					{data: "FECHA", 
					render: function(data, type, row, meta)  {
						var dateObj = new Date(data);
						var month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
						var date = ('0' + (dateObj.getDate()+1)).slice(-2);
						var year = dateObj.getFullYear();
						return (date + '/' + month + '/' + year);
					}},
					{data: "IMPORTADO"},
					{data: "PAISDEORIGEN"},
					{data: "EDITAR"},
					{data: "ELIMINAR"},
				],
				searching: true, // bFilter: true,
				lengthChange: true, //bLengthChange: true,
				info: true, //bInfo: true,
				columnDefs: [{
					targets: '_all', 
					visible: true,
				  	orderable: true,
				},
				{ 
					targets: [0,7,8], 
					type: "html" 
				},],
				language: {
					search:         "Buscar:",
					searchPlaceholder: "Buscar ",
					lengthMenu: `Se muestran <select >
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="50">50</option>
							<option value="-1">Todos</option>
						</select> registros`,
					loadingRecords: '&nbsp;',
					processing: '<div class="spinner"></div>',
					zeroRecords:    "No se encontraron resultados",
					emptyTable:     "Ningún dato disponible en esta tabla",
					info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
					infoFiltered:   "(filtrado de un total de _MAX_ registros)",
					infoPostFix:    "",
					url:            "",
					decimal: ",",
					thousands:  ",",
					paginate: {
						first:    "Primero",
						last:     "Último",
						next:     "<b>\u003E</b>",
						previous: "<b>\u003C</b>"
					},
					aria: {
						sortAscending:  ": Activar para ordenar la columna de manera ascendente",
						sortDescending: ": Activar para ordenar la columna de manera descendente"
					}
				}
			}, function(){
				$('#table_productos').removeClass('sorting_asc');
			});
		});
</script>
</body>
</html>