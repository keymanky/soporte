angular.module('actualizar_middle', [])
  .controller('actualizar', [ '$scope', 'tickets_servicios' , function ($scope, giss_servicios){

    var host = "http://207.254.73.11:888/detexis/soporte/";

    //Variables globales
      $scope.tickets = "";
      $scope.especialistas = "";
      $scope.aadmin = "";
      $scope.eventos = "";

    //Validando la session y consultando la informacion inicial
        if(window.localStorage.getItem("det_sop_usuario")){

          $scope.usuario = JSON.parse(localStorage.getItem("det_sop_usuario"));

          giss_servicios.consultar_ticket(localStorage.getItem("det_sop_ticket")).success( function(data){
            $scope.tickets = data;
            //console.log(data);
              giss_servicios.consultar_especialistas().success( function(result){
                $scope.especialistas = result;
                  giss_servicios.eventos($scope.tickets.id).success( function(eventos){
                    $scope.eventos = eventos;
                    console.log($scope.eventos);
                    //alert(Math.abs($scope.eventos.tms_creacion - $scope.eventos.tms_cierre))
                  });  
              });
          })

        }else{
          window.location= host;
        }

    //Boton atras
      $scope.atras = function(){
        window.localStorage.removeItem("det_sop_ticket");
        $scope.tickets = undefined;
        if($scope.usuario.id_departamento == 7)
          window.location= host + "monitor_sistemas.html"
        else
          window.location= host + "monitor.html"
      }

    //Boton actualizar
      $scope.submit = function() {

        disable_();
        
        //alert($scope.tickets.id  + " problema:" + $scope.asunto + " detalle " + $scope.tickets.detalle+ " id cat " + $scope.tickets.id_categoria + " id sub"  + $scope.tickets.id_subcategoria + " " + $scope.tickets.causa + " " + $scope.tickets.medio);

        var id = $scope.tickets.id;
        var json = {};
        json.asunto = $scope.tickets.resumen;
        json.detalle = $scope.tickets.detalle; 
        // json.categoria = $scope.tickets.id_categoria;
        // json.subcategoria = $scope.tickets.id_subcategoria;
        json.prioridad = $scope.tickets.prioridad;
        json.origen = $scope.tickets.causa;
        json.medio = $scope.tickets.medio;

        giss_servicios.actualizar_tickets(id,json).success( function(result){
          alert(result.mensaje);
          enable_();
        });
      };

    //Boton reasignar
      $scope.asignar = function() {
          disable_();
          var json = {};
          json.id = $scope.tickets.id;
          json.especialista = $scope.aadmin;

          giss_servicios.asignar(json).success( function(result){
              alert(result.mensaje);
              giss_servicios.eventos($scope.tickets.id).success( function(eventos){
                $scope.eventos = eventos;
                window.location.reload();
              });

          }); 
      };    

    //Boton Cerrar
      $scope.cerrar = function() {
        disable_();
        document.getElementById("cerrar").style.visibility = "hidden";
        giss_servicios.cerrar($scope.tickets.id).success( function(result){
              // var json2 = {};
              // json2.to = result.to;
              // json2.to_nombre = result.to_nombre;
              // json2.cc = result.cc;
              // json2.cc_nombre = result.cc_nombre;
              // json2.subject = result.subject;
              // json2.from_name = result.from_name;
              // json2.from = result.from;
              // json2.contenido = result.contenido;
              // json2.plantilla = result.plantilla;
              // giss_servicios.enviar_mail(json2);
          alert(result.mensaje);              
          window.location = host + 'monitor_sistemas.html';
        }); 
      };

    //Boton comentar
      $scope.guardar_comentario = function(id,com, es) {

        if(es == $scope.usuario.id_usuario){
            window.localStorage.setItem("det_sop_id_evento",JSON.stringify(id));        
            window.localStorage.setItem("det_sop_comentario",JSON.stringify(com));     
            window.open ("evento.html","Guardar comentario", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=400, height=400")        
        }else{
            alert("No puede modificar esto");
        }

      }


      // $scope.cerrar_usuario = function(id) {
      //   giss_servicios.cerrar_usuario(id).success( function(result){
      //     alert(result.mensaje)
      //   }); 
      //   window.location = host + 'monitor.html'
      //   //alert(id)        
      // };

      // $scope.reabrir = function(id) {
      //   giss_servicios.reabrir(id).success( function(result){
      //     alert(result.mensaje)
      //     window.location = host + 'monitor.html'
      //   }); 
      // };  

   
      // //Retro Alimentar
      //   $scope.retroalimentar = function(id,com, es) {
      //       var json = {};
      //       json.id = com;
      //       json.id_padre = id;
      //       json.usuario = es;
      //       console.log($scope.tickets.id_usuario);
      //       giss_servicios.comentar(json).success( function(){
      //         window.alert("Operacion realizada con exito");
      //         // window.localStorage.setItem("id_evento",JSON.stringify(id));        
      //         // window.localStorage.setItem("comentario",JSON.stringify(com));        
      //         // window.open ("evento.html","Guardar comentario", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=400, height=400")        
      //       });          
      //   }; 
  }])