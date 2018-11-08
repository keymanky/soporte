angular.module('login_middle', [])
	.controller('login', [ '$scope', 'tickets_servicios' , function ($scope, giss_servicios){

		var host = "http://207.254.73.11:888/detexis/soporte/";

		$scope.cuenta = "";
		$scope.password = "";

		$scope.entrar = function(){
			disable_();
			giss_servicios.valida_usuario($scope.cuenta, $scope.password).success( function(result){
				console.log(result)
				if(result.cuenta){
					if (result.activo == 1) {
						// alert("ok")						
						window.localStorage.setItem("det_sop_usuario",JSON.stringify(result));
						if(result.depto_nombre === "DETEXIS")											
							window.location= host + "monitor_sistemas.html";	
						else					
							window.location= host + "monitor.html";	
					}
					else
						alert("El usuario se encuentra inactivo favor de avisar a detexis")
				}else
					alert(result.mensaje)

				enable_();
			});
		}
	}])