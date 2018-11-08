angular.module('nuevo_middle', [])
	.controller('nuevo', [ '$scope', 'tickets_servicios' , function ($scope, giss_servicios){

		var host = "http://207.254.73.11:888/detexis/soporte/";

		//Variables globales
			$scope.tickets = "";
			$scope.tickets_depto = "";
			$scope.CurrentDate = new Date();
			$scope.categorias = "";
			$scope.subcategorias = "";
			$scope.idcategoriaseleccionada = "";
			$scope.idsubcategoriaseleccionada = "";
			$scope.origen = "Desconocido";
			$scope.medio = "Sistema de tickets";
			$scope.prioridad = "normal";
        	window.localStorage.removeItem("det_sop_ticket");


		//Validando la session
			if(window.localStorage.getItem("det_sop_usuario")){
				$scope.usuario = JSON.parse(localStorage.getItem("det_sop_usuario"));	

				giss_servicios.consultar_categorias().success( function(data){
					$scope.categorias = data;
					console.log($scope.categorias)
				});	

			}else{
				window.location= host;
			}


		//Metodo que se ejecuta al envio de la peticion
			$scope.submit = function() {

				
				if(! $scope.idcategoriaseleccionada){
					alert("Seleccione una categoria")
					return -1
				}
				if(! $scope.idsubcategoriaseleccionada){
					alert("Seleccione una subcategoria")      	
					return -1
				}
				if(! $scope.prioridad){
					alert("Seleccione la prioridad")      	
					return -1
				}
				if(! $scope.origen){
					alert("Seleccione el origen del problema")      	
					return -1
				}
				if(! $scope.medio){
					alert("Seleccione el medio de reporte de este problema")      	
					return -1
				} 
				/*
		      	if(window.localStorage.getItem("archivo")){
		      		alert("adjunte un archivo")
		      		return -1
		      	}*/

		      	$scope.json = {};	
		      	$scope.json.asunto = $scope.asunto;
		      	$scope.json.detalle = $scope.detalle;
		      	$scope.json.categoria = $scope.idcategoriaseleccionada;
		      	$scope.json.subcategoria = $scope.idsubcategoriaseleccionada;
		      	$scope.json.id_usuario = $scope.usuario.id_usuario;
		      	$scope.json.depto_nombre = $scope.usuario.depto_nombre;
		      	$scope.json.usuario_creacion = $scope.usuario.nombre + " " + $scope.usuario.paterno;
		      	$scope.json.usuario_email = $scope.usuario.mail;
		      	$scope.json.prioridad = $scope.prioridad;
		      	$scope.json.origen = $scope.origen;
		      	$scope.json.medio = $scope.medio;

		      	//Get the name file
			      	var x = window.localStorage.getItem("archivo");
			      	$scope.json.archivo = x;
			      	if(! $scope.json.archivo)
			      		$scope.json.archivo = " ";
			      	console.log($scope.json);

				//Bloqueamos la pagina
					document.getElementById("btn_guardar").disabled = true;
					document.getElementById("trabajando").style.visibility = "visible";
					document.getElementById("problema").disabled = true;
					document.getElementById("detalle").disabled = true;
					document.getElementById("categoria").disabled = true;
					document.getElementById("subcategoria").disabled = true;
					document.getElementById("prioridad").disabled = true;
					document.getElementById("medio").disabled = true;
					console.log($scope.json)

				//Inserta la peticion, y envia el correo electronico
				giss_servicios.agregar_ticket($scope.json).success(function (respuesta){
						alert(respuesta.mensaje);
						window.localStorage.removeItem("archivo");
					    window.close();
				});
			};

		//Otros metodos
			$scope.seleccionarcategoria = function (e){
				giss_servicios.consultar_subcategorias(e).success( function(data){
					$scope.subcategorias = data;
					$scope.idcategoriaseleccionada = e;
					$scope.idsubcategoriaseleccionada = "";
					console.log($scope.categorias)
				});	
		    };

			$scope.seleccionarsubcategoria = function (e){
					$scope.idsubcategoriaseleccionada = e;
		    };
		//}
	}])