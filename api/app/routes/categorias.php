 <?php

 $app->group('/categorias', function () use ($app)	{

		$app->get('/', function () use ($app) {

			/*Consulta a la base*/
			$categorias = ORM::for_table('categorias')			
				->find_many();

			$response = array();	
	 		foreach ($categorias as $key => $value) {
				$tmp = array(
					'id'     => $value->id,
					'nombre' => $value->nombre
				);
				$response[] = $tmp;
	 		}

			if(empty($response)){
				$response = array (
					'mensaje' => "Sin categorias definidas"
				);
			}
			/*Respuesta del servicio*/
			$app->response->setBody(json_encode($response));			
			$app->response->setStatus(200);
			$app->stop();

		});

		/*Respuesta del get id*/
		$app->options('/', function () use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	
		
});
?>
