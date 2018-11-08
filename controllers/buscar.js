angular.module('buscar_middle', [])
	.controller('buscar', [ '$scope', 'tickets_servicios' , function ($scope, giss_servicios){

		var host = "http://207.254.73.11:888/detexis/soporte/";

		$scope.tickets = "";
		$scope.id = "";
		$scope.usuario = "";

		// //Validando la session
		if(window.localStorage.getItem("det_sop_usuario")){
			$scope.usuario = JSON.parse(localStorage.getItem("det_sop_usuario"));	
			if(window.localStorage.getItem("det_sop_usuario"))
				$scope.tickets = JSON.parse(localStorage.getItem("det_sop_busqueda"));	
				console.log($scope.tickets)
		}else{
			window.location= host;
		}

		$scope.atras = function(){
        window.localStorage.removeItem("det_sop_ticket");			
				if($scope.usuario.id_departamento == 7)
					window.location= host + "monitor_sistemas.html"
				else
					window.location= host + "monitor.html"
		}

		$scope.buscar_id = function(){

			var json = {};
			json.id_usuario = $scope.usuario.id_usuario;

			giss_servicios.buscar_id($scope.id, json).success( function(result){
				window.localStorage.setItem("det_sop_busqueda",JSON.stringify(result));
				location.reload();
			});
		}

		$scope.buscar_rango = function(){
			var fi = document.getElementById("fi_datepicker").value;
			var ff = document.getElementById("ff_datepicker").value;

			anofi = fi.substring(fi.lastIndexOf('/')+1)
			diafi = fi.substring(fi.indexOf('/')+1, fi.lastIndexOf('/'))
			mesfi = fi.substring(0, fi.indexOf('/'))

			mesff = ff.substring(0, ff.indexOf('/'))
			diaff = ff.substring(ff.indexOf('/')+1, ff.lastIndexOf('/'))
			anoff = ff.substring(ff.lastIndexOf('/')+1)


			var json = {};
			json.fi = anofi + '-' + mesfi + '-' + diafi;
			json.ff = anoff + '-' + mesff + '-' + diaff;

			//alert(json.fi + "-" + json.ff);

			giss_servicios.buscar_rango($scope.usuario.id_usuario, json).success( function(result){
				window.localStorage.setItem("det_sop_busqueda",JSON.stringify(result));
				location.reload();
			});
		}

		$scope.consultar_ticket = function(e){
				//window.localStorage.removeItem("det_sop_busqueda");
				giss_servicios.consultar_ticket(e).success( function(data){
					window.localStorage.setItem("det_sop_ticket",data.id);
					//alert(data.id)
					if($scope.usuario.id_departamento == 7)
						window.location= host + "actualizar_sistemas.html"
					else
						window.location= host + "actualizar.html"
				})
		}		

	}])