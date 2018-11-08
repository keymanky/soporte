angular.module('categorias_middle', [])
	.controller('categorias', [ '$scope', 'tickets_servicios' , function ($scope, giss_servicios){

		var host = "http://207.254.73.11:888/detexis/soporte/";
        window.localStorage.removeItem("det_sop_ticket");
		$scope.empleado = "";
		$scope.categorias = "";
		$scope.new_categoria = "";
		$scope.new_subcategoria = "";
		$scope.subcategoria = "";
		$scope.categoria = "";

		// //Validando la session
		if(window.localStorage.getItem("det_sop_usuario")){
			$scope.usuario = JSON.parse(localStorage.getItem("det_sop_usuario"));			
		}else{
			window.location= host;
		}

		giss_servicios.consultar_categorias().success( function(data){
			$scope.categorias = data;
		});	

		giss_servicios.consultar_subcategorias(0).success( function(data){
			$scope.subcategorias = data;
		});	

		$scope.nueva_categoria = function(){
			//alert($scope.new_categoria)
			var json = {};
			json.nombre = $scope.new_categoria;			
				giss_servicios.nueva_categoria(json).success( function(data){
				location.reload();					
				});	
		}

		$scope.nueva_subcategoria = function(){
			// console.log("ddd")
			// alert($scope.new_subcategoria)
			var json = {};
			json.nombre = $scope.new_subcategoria;				
				giss_servicios.nueva_subcategoria(json).success( function(data){
				});	
			location.reload();					
		}

		$scope.guarda_relacion = function(){
			var json = {};
			json.id = $scope.subcategoria;
			json.id_categoria = $scope.categoria;
			//console.log(json)
			//alert($scope.categoria + " " + $scope.subcategoria)
				giss_servicios.relacionar(json).success( function(data){
				});	
				//location.reload();					
		}

	}])