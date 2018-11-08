 <?php

 $app->group('/asignados', function () use ($app)	{

		$app->get('/', function () use ($app) {

			$tickets = ORM::for_table('tickets')		
				->distinct()			 
				->select('id_especialista')
			 	->select('usuarios.nombre', 'un')
			 	->select('usuarios.paterno', 'up')							 
			 	->join('usuarios',array('tickets.id_especialista','=','usuarios.empleado'))	
				->where('estado_especialista','abierto')
				->find_many();

				$response = array();	
		 		foreach ($tickets as $key => $value) {
					$especialistas = ORM::for_table('tickets')				 
						->select('id')			 
						->where('id_especialista',$value->id_especialista)
						->where('estado_especialista','abierto')
						->find_many();
					$tmp = array (
						'especialista' => $value->id_especialista . " " . $value->up,
						'numero' => count($especialistas)
					);
		 			$response[] = $tmp;
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
