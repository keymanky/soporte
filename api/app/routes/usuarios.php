 <?php

 $app->group('/usuarios', function () use ($app)	{

		$app->get('/', function () use ($app) {

			/*Consulta a la base*/
			$usuario = ORM::for_table('usuarios')			
				->order_by_asc('usuarios.empleado')					
				->find_many();

			$response = array();	
			if($usuario){

		 		foreach ($usuario as $key => $value) {

		 			// if($value->activo)
		 			// 	$str = " (Activo) ";
		 			// else
		 			// 	$str = " (Inactivo) ";

					$tmp = array(
						'empleado'     => $value->empleado,
						'nombre' => $value->empleado . " " .$value->paterno . " " . $value->nombre
					);
					$response[] = $tmp; 
		 		}

			}	

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
