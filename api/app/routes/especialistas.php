 <?php

 $app->group('/especialistas', function () use ($app)	{

		$app->get('/', function () use ($app) {

			/*Consulta a la base*/
			$usuario = ORM::for_table('usuarios')	
				->where('id_departamento',7)			
				->find_many();

			$response = array();	
			if($usuario){

		 		foreach ($usuario as $key => $value) {

		 			if($value->es_admin)
		 				$str = " (Admin" .  $value->es_admin .  ") ";
		 			else
		 				$str = "  ";

					$tmp = array(
						'empleado'     => $value->empleado,
						'nombre' => $value->nombre . " " . $value->paterno . $str,
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
