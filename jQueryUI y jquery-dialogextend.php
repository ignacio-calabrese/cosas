<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>dialog demo</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="jquery.dialogextend.min.js"></script>
</head>
<body>
 
<button id="opener">open the dialog</button>
<style>
.ui-widget-header {
    border: 1px solid #aaaaaa;
    background: #cccccc url(images/ui-bg_highlight-soft_75_cccccc_1x100.png) 50% 50% repeat-x !important;
    color: #222222;
    font-weight: bold;
}
.ui-dialog-buttonpane{
    background: #cccccc url(images/ui-bg_highlight-soft_75_cccccc_1x100.png) 50% 50% repeat-x !important;
}
.ui-dialog-buttonset .custom{
    color: rgb(201, 76, 76) !important;
    border: 1px solid blue;
    background:red;
}

.ui-dialog-buttonset .ui-corner-all:nth-child(2) {
    background:yellow;
}
</style>
 
<script>

    // $j permite reabrir la modal
    var $j = jQuery.noConflict();

    $j( "#opener" ).click(function() {
        $j('<div id="dialog"></div>').appendTo("body");
        $j("#dialog").dialog({ 
            create:function () {
                $j(".ui-dialog-title").after('<button id="button" onclick=alert("click");><img src="favicon.ico" width="20" height="20" alt=""></button>');
                $j(".ui-dialog-buttonset").find(".ui-button").eq(0)
                .removeClass("ui-corner-all").addClass("custom");
            },
            open: function () {
                $j(this).load("consulta.php",{
                    send: $j("#send").val(),
                    num: $j("#num").val()
                });
            },
            beforeClose: function(){
                if(confirm("Cerrar ventana?")){
                    return true;
                } else{
                    return false;
                }
            }, 
            close: function(event, ui){
                $j(this).remove();        
            },
            classes: {
                "ui-dialog": "ui-corner-all",
                "ui-dialog-titlebar": "ui-corner-all",
            },
            modal: true,
            width: 1100,
            height: 600,
            resizable: true,
            title: "Dialog con contenido de archivo externo",
            autoOpen: false,
            show: { effect: "blind", duration: 800 },
            dialogClass: "no-close",
            draggable: true,
            buttons: [{
                    id: "id_0",
                    text: "addClass",      
                    click: function() {
                         
                    }
                },
                {
                    id: "id_1",
                    class: "custom",
                    text: "CERRAR",      
                    click: function() {
                        //$("#dialog").remove();  
                        $j("button.ui-dialog-titlebar-close").trigger("click"); 
                    }
                },
                {   
                    id: "id_2",
                    text: "Enviar (Ver en otra ventana)",       
                    click: function() {
                        $j( "#send" ).trigger("click");  
                    }
                },
                {   
                    id: "id_3",
                    text: "Enviar (Ver en modal)",       
                    click: function() {
                        $j(this).load("consulta.php",{
                            send: $j("#send").val(),
                            num: $j("#num").val()
                        }); 
                    }
                }
            ] 
    }).dialogExtend({
        "closable" : true,
        "maximizable" : true,
        "minimizable" : true,
        "collapsable" : true,
        "dblclick" : "collapse",
        "titlebar" : "transparent",
        "minimizeLocation" : "right",
        "icons" : {
          "close" : "ui-icon-circle-close",
          "maximize" : "ui-icon-circle-plus",
          "minimize" : "ui-icon-circle-minus",
          "collapse" : "ui-icon-triangle-1-s",
          "restore" : "ui-icon-bullet"
        },
        "load" : function(evt, dlg){ alert(evt.type); },
        "beforeCollapse" : function(evt, dlg){ alert(evt.type); },
        "beforeMaximize" : function(evt, dlg){ alert(evt.type); },
        "beforeMinimize" : function(evt, dlg){ alert(evt.type); },
        "beforeRestore" : function(evt, dlg){ alert(evt.type); },
        "collapse" : function(evt, dlg){ alert(evt.type); },
        "maximize" : function(evt, dlg){ alert(evt.type); },
        "minimize" : function(evt, dlg){ alert(evt.type); },
        "restore" : function(evt, dlg){ alert(evt.type); }
      }).dialog("open");
        
    });

    
</script>
 
</body>
</html>