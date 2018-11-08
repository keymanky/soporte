 <?php

 $app->group('/r1', function () use ($app)	{

		$app->get('/', function () use ($app) {

			$tickets = ORM::for_table('tickets')	
				->select('tickets.*')
   				->select('evento.tms_creacion', 'evento_tms_creacion')
   				->select('evento.tms_cierre', 'evento_tms_cierre')
 				->join('evento', array('evento.id_ticket', '=', 'tickets.id'))
				->where('estado','cerrado')
				->find_many();

	 		foreach ($tickets as $key => $value) {


				$tmp = array (
					'id' => $value->id,
					'id_categoria' => $value->id_categoria,
					'id_subcategoria' => $value->id_subcategoria,
					'evento_tms_creacion' => $value->evento_tms_creacion,
					'evento.tms_cierre' => $value->evento_tms_cierre,
				);

			 	$response[] = $tmp;


			}
				//Consulta las asigna

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
