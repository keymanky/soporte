 <?php

 $app->group('/usuario_consulta', function () use ($app)	{

		$app->get('/:id', function ($id) use ($app) {

			/*Consulta a la base*/
			$usuario = ORM::for_table('usuarios')	
				->where('empleado',$id)
				->find_one();

			$response = array();	
			if($usuario)
				$response = array(
					'empleado'     => $usuario->empleado,			
					'mail' => $usuario->mail,	
					'password' => $usuario->password	
				);

			if(empty($response)){
				$response = array (
					'mensaje' => "El usuario es incorrecto o esta inactivo"
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
