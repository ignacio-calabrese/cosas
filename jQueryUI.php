<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>dialog demo</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
 
<button id="opener">open the dialog</button>
<div id="dialog"></div>
 
<script>
    //$("#dialog").load("consulta.php");
    $( "#dialog" ).dialog({ 
        modal: true,
        open: function () {
            $(this).load("consulta.php");
        },         
        height: 400,
        width: 400,
        resizable: true,
        title: "I'm a dialog",
        autoOpen: false,
        show: { effect: "blind", duration: 800 },
        dialogClass: "no-close",
        buttons: [{
                text: "CERRAR",       
                click: function() {
                    $( this ).dialog( "close" );
                }
        }] 
    });
    $( "#opener" ).click(function() {
        $( "#dialog" ).dialog( "open" );
    });

    
</script>
 
</body>
</html>