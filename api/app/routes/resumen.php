 <?php

 $app->group('/resumen', function () use ($app)	{

		$app->get('/', function () use ($app) {

			//Consulta todos los especialistas
			$usuarios = ORM::for_table('usuarios')				 
				->select('empleado')
				->where('id_departamento','7')
				->order_by_asc('nombre')
				->find_many();

			$response = array();

	 		foreach ($usuarios as $key => $value) {

				//Consulta los tickets abiertos
				$tickets = ORM::for_table('tickets')		 
					->select('id')
					->where('id_especialista', $value->empleado)
					->where('estado','abierto')
					->find_many();

				//Consulta los tickets abiertos
				$cerrados = ORM::for_table('tickets')		 
					->select('id')
					->where('id_especialista', $value->empleado)
					->where('estado','cerrado')
					->find_many();

				//Consulta los tickets reabiertos
				$reabierto = ORM::for_table('tickets')		 
					->select('id')
					->where('id_especialista', $value->empleado)
					->where('reabierto',1)
					->find_many();

				$tmp = array (
					'especialista' => $value->empleado,
					'asignados' => count($tickets),
					'cerrados' => count($cerrados),
					'reabiertos' => count($reabierto),
				);

			 	$response[] = $tmp;
			 	// 	foreach ($tickets as $key => $value) {
					// 	$especialistas = ORM::for_table('tickets')				 
					// 		->select('id')			 
					// 		->where('id_especialista',$value->id_especialista)
					// 		->where('estado','abierto')
					// 		->find_many();
					// 	$tmp = array (
					// 		'especialista' => $value->empleado,
					// 		'numero' => count($tickets)
					// 	);
			 	// 		$response[] = $tmp;
			 	// 	}
			}


				// $especialistas = ORM::for_table('tickets')				 
				// 	->select('id')			 
				// 	->where('id_especialista',$value->id_especialista)
				// 	->where('estado','abierto')
				// 	->find_many();
				// $tmp = array (
				// 	'especialista' => $value->un . " " . $value->up,
				// 	'numero' => count($especialistas)
				// );
	 		// 	$response[] = $tmp;
	 		// }

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
