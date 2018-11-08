 <?php

 $app->group('/usuario', function () use ($app)	{

		$app->post('/:id', function ($id) use ($app) {


			$rules=array(
				'password' =>array(false, "string", 1, 21), 	 						 			 		
			);


			 $v = new Validator($app->request->getBody(), $rules);
			 $params = $v->validate();

			 if(count($v->getErrors()) > 0){
			 	foreach ($v->getErrors() as $key => $value) {
			 		$response = array("error" => array($key => "campo incorrecto"));
			 		$app->response->setStatus($v->getCode());
			 		$app->response->setBody(json_encode($response));
			 		$app->stop();
			 	}
			 }


			/*Consulta a la base*/
			$usuario = ORM::for_table('usuarios')
 			 	->select('usuarios.*')							 
 			 	->select('departamentos.*')							 
 			 	->join('departamentos',array('usuarios.id_departamento','=','departamentos.id'))
				//->where('password',$params['password'])
				->where('cuenta',$id)
				->find_one();

			$response = array();
			if($usuario){
				if ($usuario->password == $params['password']) {
					$response = array(
						'id_usuario'     => $usuario->empleado,
						'cuenta'     => $usuario->cuenta,
						'nombre' => $usuario->nombre,
						'paterno'     => $usuario->paterno,
						'materno' => $usuario->materno,	
						'puesto' => $usuario->puesto,		
						'mail' => $usuario->mail,	
						'es_admin' => $usuario->es_admin,			
						'id_departamento' => $usuario->id_departamento,
						'depto_nombre' => $usuario->depto_nombre,
						'notificacion' => $usuario->notificacion,		
						'ip'=>$usuario->ip,
						'celular'=>$usuario->celular,
						'telefono'=>$usuario->telefono,
						'comentario'=>$usuario->comentario,
						'activo'=>$usuario->activo,
						'ID_TeamViewer'=>$usuario->ID_TeamViewer,
					);
				}else{
					$response = array (
						'mensaje' => "La contraseña es incorrecta"
					);					
				}
			}


			if(empty($response)){
				$response = array (
					'mensaje' => "El usuario es incorrecto"
				);
			}
			if($usuario)
				if( $usuario->password != $params['password']){
					$response = array (
						'mensaje' => "Password incorrecto"
					);
				}			

			/*Respuesta del servicio*/
			$app->response->setBody(json_encode($response));			
			$app->response->setStatus(200);
			$app->stop();

		});

		/*Respuesta del get id*/
		$app->options('/:id', function () use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	

});
?>
