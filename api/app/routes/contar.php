 <?php

 $app->group('/contar', function () use ($app)	{

		$app->get('/', function () use ($app) {

			$tickets = ORM::for_table('tickets')	
				->select('tickets.*')	 
				->where('estado','abierto')					
				->order_by_desc('tickets.tms_creacion')
				->find_many();

				if(empty($response)){
					$response = array (
						'numero' => count($tickets)
					);
				}

			/*Respuesta del servicio*/
			$app->response->setBody(json_encode($response));
			$app->response->setStatus(200);
			$app->stop();

		});

		/*Respuesta del get*/
		$app->options('/', function () use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	
});
?>
