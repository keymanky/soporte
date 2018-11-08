angular.module('evento_middle', [])
	.controller('evento', [ '$scope', 'tickets_servicios' , function ($scope, giss_servicios){

		var host = "http://207.254.73.11:888/detexis/soporte/";
		$scope.id = JSON.parse(localStorage.getItem("det_sop_id_evento"));
		$scope.id_ticket = localStorage.getItem("det_sop_ticket");
		$scope.comentario = JSON.parse(localStorage.getItem("det_sop_comentario"));
		$scope.empleado = "";
		$scope.causa = "";

		$scope.guardar = function(){
			disable_();
			var json={};
			json.id = $scope.id;
			json.comentario = $scope.comentario;
			//alert($scope.id_ticket + " " + $scope.causa);

			var json2={};
			json2.causa = $scope.causa;

			giss_servicios.actualizar_causa($scope.id_ticket,json2).success( function(r){
				console.log(r);
			});

			giss_servicios.guardar_comentario(json).success( function(result){
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
			  	window.close();
			});
		}
	}])