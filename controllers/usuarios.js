angular.module('usuarios_middle', [])
	.controller('usuarios', [ '$scope', 'tickets_servicios' , function ($scope, giss_servicios){

		var host = "http://207.254.73.11:888/detexis/soporte/";
		$scope.empleado = "";
		$scope.especialistas = "";
		$scope.departamentos = "";
		$scope.usuarios = "";
	    $scope.email_seleccionado = "";
	    $scope.aadmin = "";
	    $scope.email = "";
	    $scope.new_email = "";
	    $scope.usuario_seleccionado_email = "";
	    $scope.usuario_seleccionado_password = "";
	    $scope.d = "";

		$scope.ncuenta = "";
		$scope.nnombre = "";
		$scope.npaterno = "";
		$scope.nmaterno = "";
		$scope.npuesto = "";
		$scope.ncorreo = "";
		$scope.npass = "";
		$scope.ncelular = "";
		$scope.ntelefono = "";
		$scope.nidTeamViewer = "";

		//Validando la session
			if(window.localStorage.getItem("det_sop_usuario")){
				$scope.usuario = JSON.parse(localStorage.getItem("det_sop_usuario"));	
				window.localStorage.removeItem("det_sop_ticket");		
			}else{
				window.location= host;
			}

		//Servicios cargados al inicio de la pagina
			giss_servicios.consultar_especialistas().success( function(result){
				$scope.especialistas = result;
				console.log(result)
			});
			giss_servicios.consultar_usuarios().success( function(result){
				$scope.usuarios = result;
				console.log(result)
			});		
			giss_servicios.consultar_departamentos().success( function(result){
				$scope.departamentos = result;
				console.log(result)
			});			

		//Cambiar el tipo de admin
			$scope.admin = function(tipo) {
				if(tipo == 1){
					giss_servicios.cambiar_admin($scope.aadmin).success( function(result){
						location.reload();
					});	
				}
				if(tipo == 2){
					giss_servicios.cambiar_admin_2($scope.aadmin).success( function(result){
						location.reload();
					});	
				}
				if(tipo == 3){
					giss_servicios.cambiar_admin_3($scope.aadmin).success( function(result){
						location.reload();
					});	
				}							
	      	};

	    //Enable disable user
			$scope.activar = function() {
				giss_servicios.activar($scope.usuarios.empleado).success( function(result){
					alert(result.mensaje)
					//location.reload();
				});	
	      	};

	    //Change Email User
			$scope.email = function() {
				$scope.json ={}
				$scope.json.mail = $scope.usuario_seleccionado_email
				giss_servicios.cambiar_email($scope.usuarios.empleado,$scope.json).success( function(result){
					alert(result.mensaje)
				});	
	      	};

	    //Change Password User
			$scope.password = function() {
				$scope.json ={}
				$scope.json.password = $scope.usuario_seleccionado_password
				giss_servicios.cambiar_password($scope.usuarios.empleado,$scope.json).success( function(result){
					alert(result.mensaje)
				});	
	      	};

	    //Get mail and password user when change id user
	      	$scope.seleccionarusuario = function(id){
				giss_servicios.consultando_usuario(id).success( function(result){
		    		$scope.usuario_seleccionado_email = result.mail;
		    		$scope.usuario_seleccionado_password = result.password;				
				});      		
	      	};

      	$scope.guardar_usuario = function(){

      		//alert($scope.d);

      		var tmpjson = {};

      		tmpjson.cuenta = $scope.ncuenta;
      		tmpjson.nombre = $scope.nnombre;
      		tmpjson.paterno = $scope.npaterno;
      		tmpjson.puesto = $scope.npuesto;
      		tmpjson.password = $scope.npass;
      		tmpjson.mail = $scope.ncorreo;
      		tmpjson.id_departamento = $scope.d;

			if ($scope.materno === "") {
				tmpjson.materno = "N/A";
			}else{
				tmpjson.materno = $scope.nmaterno;
			}

			if ($scope.celular === "") {
				tmpjson.celular = " ";
			}else{
				tmpjson.celular = $scope.ncelular;
			}

			if ($scope.telefono === "") {
				tmpjson.telefono = " ";
			}else{
				tmpjson.telefono = $scope.ntelefono;
			}			

			if ($scope.idTeamViewer === "") {
				tmpjson.idTeamViewer = " ";
			}else{
				tmpjson.idTeamViewer = $scope.nidTeamViewer;
			}


			console.log(tmpjson);
      		
			giss_servicios.nuevo_usuario(tmpjson).success( function(result){
				alert(result.mensaje);
			});	      		
      		//alert("-" + empleado.length + nombre + paterno + materno + puesto + email + pass + d + "-" + $scope.nombre_depto_seleccionado);
      	};
	}])