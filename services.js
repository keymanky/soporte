
	angular.module('services',[])
	.factory('tickets_servicios', function ($http) {

		var host = 'http://207.254.73.11:888/detexis/soporte/api';
		return{
			valida_usuario: function (id, password) {
				var json = {};
				json.password = password;
				return $http.post(host + '/usuario/'+id, json);	
			},
			//Todos los tickets asignados en caso de ser de sistemas o todos los tickets creados por el usuario
			consultar_todos_tickets: function(id){
				return $http.get(host + '/tickets_usuario/'+id);
			},
			consultar_todos_tickets_depto: function(id){
				return $http.get(host + '/tickets_depto/'+id);
			},
			consultar_todos_tickets_abiertos: function(){
				return $http.get(host + '/tickets_abiertos/');
			},			
			consultar_categorias: function(){
				return $http.get(host + '/categorias/');
			},
			consultar_subcategorias: function(id){
				return $http.get(host + '/subcategorias/'+id);
			},
			agregar_ticket: function(json){
				return $http.post(host + '/ticket/', json);
			},
			consultar_ticket: function(id){
				return $http.get(host + '/tickets_consulta/' + id);
			},
			consultar_especialistas: function(){
				return $http.get(host + '/especialistas/');
			},
			consultar_usuarios: function(){
				return $http.get(host + '/usuarios/');
			},
			cambiar_email: function(id, obj){
				return $http.post(host + '/mail/' + id, obj);
			},
			cambiar_password: function(id, obj){
				return $http.post(host + '/passwordpp/' + id, obj);
			},			
			cambiar_admin: function(id){
				return $http.get(host + '/admin/' + id);
			},
			cambiar_admin_2: function(id){
				return $http.get(host + '/admin2/' + id);
			},
			cambiar_admin_3: function(id){
				return $http.get(host + '/admin3/' + id);
			},	
			activar: function(id){
				return $http.get(host + '/activar/' + id);
			},
			nueva_categoria: function(obj){
				return $http.post(host + '/nueva_categoria/', obj);
			},
			nueva_subcategoria: function(obj){
				return $http.post(host + '/nueva_subcategoria/' , obj);
			},
			relacionar: function(obj){
				return $http.post(host + '/relacionar_categorias/' , obj);
			},
			buscar_id: function(id, obj){
				return $http.post(host + '/buscar2/' + id, obj);
			},
			buscar_rango: function(id, obj){
				return $http.post(host + '/buscar/' +id , obj);
			},
			cerrar: function(id){
				return $http.get(host + '/cerrar/' +id);
			},
			cerrar_usuario: function(id){
				return $http.get(host + '/cerrar_usuario/' +id);
			},
			reabrir: function(id){
				return $http.get(host + '/reabrir/' +id);
			},			
			asignar: function(obj){
				return $http.post(host + '/asignar/' , obj);
			},
			comentar: function(obj){
				return $http.post(host + '/comentar/' , obj);
			},			
			eventos: function(id){
				return $http.get(host + '/consultar_eventos/' + id);
			},
			consultar_departamentos: function(){
				return $http.get(host + '/consulta_departamentos/');
			},		
			nuevo_usuario: function(obj){
				return $http.post(host + '/nuevo_usuario/' , obj);
			},			
			guardar_comentario: function(obj){
				return $http.post(host + '/guardar_comentario' , obj);
			},
			actualizar_tickets: function(id, obj){
				return $http.post(host + '/tickets_consulta/' + id , obj);
			},
			// enviar_mail: function(obj){
			// 	return $http.post('http://187.176.24.218/mail/api/', obj);
			// },
			consultando_usuario: function(id){
				return $http.get(host + '/usuario_consulta/' + id);
			},
			actualizar_causa: function(id, obj){
				return $http.post(host + '/causa_ticket/' + id, obj);
			}
		}
	});