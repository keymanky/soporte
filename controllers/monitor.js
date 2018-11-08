angular.module('monitor_middle', [])
	.controller('monitor', [ '$scope', 'tickets_servicios' , function ($scope, giss_servicios){

		var host = "http://207.254.73.11:888/detexis/soporte/";

		//Variables globales
			$scope.json = {};
			$scope.json2 = {};
			$scope.usuario = {};
			$scope.usuario.empleado = "";
			$scope.tickets = "";
			$scope.tickets_depto = "";
        	window.localStorage.removeItem("det_sop_ticket");
		

		//Validando la session
			if(window.localStorage.getItem("det_sop_usuario")){
				$scope.usuario = JSON.parse(localStorage.getItem("det_sop_usuario"));

				giss_servicios.consultar_todos_tickets($scope.usuario.id_usuario).success( function(data){
					$scope.tickets = data;
					console.log($scope.tickets)
				});

				giss_servicios.consultar_todos_tickets_depto($scope.usuario.id_usuario).success( function(data){
					$scope.tickets_depto = data;
					console.log($scope.tickets_depto)					
				});	
			
			}else{
				window.location= host;
			}


			$scope.salir = function (){
				localStorage.clear();
				window.location= host;
			}

			$scope.consultar_ticket = function(e){
				window.localStorage.removeItem("det_sop_ticket");
				giss_servicios.consultar_ticket(e).success( function(data){
					//console.log(data);
					window.localStorage.setItem("det_sop_ticket",data.id);
					//alert(data.id)
					if($scope.usuario.id_departamento == 7)
						window.location= host + "actualizar_sistemas.html"
					else
						window.location= host + "actualizar.html"
				})
			}
	}])