<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>dialog demo</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  
  <style>
    #mover, #mover2{
        width: 200px;
        height: 200px;
        background-color: #F46628;
    }

    #soltar{
        width: 220px;
        height: 220px;
        border: 2px solid black;
    }
    .soltado{
        background-color: #D62743;
    }
    .hover{
        background-color: blue;
    }

    #resizable{
        width: 200px;
        height: 200px;
        background-color: #EBEBEB;
    }
    #contenedor{
        width: 400px;
        height: 400px;
        border: 2px solid black;
    }

    /* Clases OBLIGATORIAS para que funcione selectable() */
    #select .ui-selecting{background-color: #FECA40;}
    #select .ui-selected{background: #F39814; color: white;}
    #select {list-style-type: none; margin: 0; padding: 0; width: 60%;}
    #select li{margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px;} 
  </style>
</head>
<body>
 
<label for="fecha">FECHA</label>
<input type="text" name="fecha" id="fecha">
 
<div id="mover" class="ui-widget-content">
    <p>Mover</p>
</div>
<div id="mover2" class="ui-widget-content">
    <p>Mover2</p>
</div>

<div id="soltar">
    <p>Soltar aquí</p>
</div>

<div id="contenedor">
    <div id="resizable">
        <p>Cambiar tamaño</p>
    </div>
</div>

<ol id="select">
    <li class="ui-widget-content">Item 1</li>
    <li class="ui-widget-content">Item 2</li>
    <li class="ui-widget-content">Item 3</li>
    <li class="ui-widget-content">Item 4</li>
    <li class="ui-widget-content">Item 5</li>
    <li class="ui-widget-content">Item 6</li>
    <li class="ui-widget-content">Item 7</li>
</ol>
<br>
<div id="resultado"></div>

<hr>
<h1>Widgets</h1>

<h2>Acordeon</h2>
<div id="acordeon">
    <h3>Sección 1</h3>
    <div>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi magni qui earum, ex obcaecati atque, vel, nostrum reiciendis veritatis error placeat voluptas quia adipisci pariatur recusandae est! Reprehenderit, animi quo.</p>
    </div>
    <h3>Sección 2</h3>
    <div>
        <p>Voluptates velit aperiam perspiciatis magni modi, hic totam ullam odio non architecto. Reprehenderit pariatur adipisci earum nisi iusto eum! Iusto quos optio, itaque dicta dolore aliquam! Vel optio voluptatem odio?</p>
    </div>
    <h3>Sección 3</h3>
    <div>
        <p>Qui, dolores amet accusamus eum blanditiis pariatur, inventore cupiditate voluptates ipsum odit labore. Officia eveniet a sint nostrum repellendus commodi amet quo deleniti debitis ea, error quidem magni quod veritatis!</p>
    </div>
</div>

<h2>Autocomplete</h2>
<label for="color">COLOR:</label>
<input type="text" name="color" id="color">


<div id="dialogo" title="Ventana de díalogo">
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic sequi facere enim ipsa suscipit, voluptate unde explicabo quas deleniti labore incidunt illum sunt commodi porro, eos, numquam cupiditate fuga asperiores.
    </p>
</div>
<button id="ventana">Mostrar ventana</button>



<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        $("#fecha")
            .datepicker()
            .datepicker("option", "showAnim", "slide")
            .datepicker("option", "dateFormat", "dd-mm-yy");

        $("#mover").draggable({
            axis: "y",
            cursor: "crosshair",
            revert: true,
            start: function() {
                $(this).text("Al iniciar");
            },
            drag: function() {
                $(this).text("Al mover");
            },
            stop: function() {
                $(this).text("Al detener");
            }
        });

        $("#mover2").draggable();

        $("#soltar").droppable({
            drop: function(event, ui) {
                $(this).addClass("soltado").find("p").text("Elemento soltado");
            }, 
            hoverClass: "hover",
            accept: "#mover"
        });

        $("#resizable").resizable({
            animate: true,
            containment: "#contenedor"
        });

        $("#select").selectable({
            stop: function() {
                var resultado = $("#resultado").empty();
                $(".ui-selected", this).each(function () {
                    var index = $("#select li").index(this);
                    resultado.append("Seleccionaste " + (index + 1));
                });
            }
        });

        var iconos = {
            header: "ui-icon-circle-arrow-e",
            activeHeader: "ui-icon-circle-arrow-s"
        };
        $("#acordeon").accordion({
            icons: iconos
        });

        var colores = ["rojo", "verde", "violeta", "azul", "amarillo", "negro", "blanco", "dorado", "celeste", "rosado"];
        $("#color").autocomplete({
            //source: colores
            source: function(request, respose) {
                $.ajax({
                    url: "consulta_autocompleate_ajax.php",
                    dataType: "json",
                    data: {num : request.term},
                    success: function (data) {
                        respose(data);
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) {
                alert("Seleccionó" + ui.item.label);
            }
        });

        $("#dialogo").dialog({
            autoOpen: false,
            modal: true,
            show: {
                effect: "blind",
                duration: 1000
            },
            hide: {
                effect: "explode",
                duration: 1000
            },
            buttons: {
                "Eliminar": function() {
                    alert("Se pulsó eliminar");
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });
        $("#ventana").click(function() {
            $("#dialogo").dialog("open");
        });
    });
</script>
</body>
</html>