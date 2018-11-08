 <?php

 $app->group('/consulta_departamentos', function () use ($app)	{

		$app->get('/', function () use ($app) {

			//Consulta los deptos existentes
			$deptos = ORM ::for_table('departamentos')	
				->select('departamentos.id')
				->select('departamentos.depto_nombre')	
				->order_by_asc('departamentos.depto_nombre')	
				->find_many();

			$response = array();	
			if($deptos){

		 		foreach ($deptos as $key => $value) {

					$tmp = array(
						'id_departamento' => $value->id,
						'depto' => $value->depto_nombre,
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
