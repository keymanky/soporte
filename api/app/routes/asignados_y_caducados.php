 <?php

 $app->group('/asignados_caducados', function () use ($app)	{

		$app->get('/', function () use ($app) {

			$response = array();	

			//Consultamos todos los distintos especialistas que tengan tickets abiertos
			$especialistas = ORM::for_table('tickets')		
				->distinct()			 
				->select('id_especialista')
			 	->select('usuarios.nombre', 'un')
			 	->select('usuarios.paterno', 'up')							 
			 	->join('usuarios',array('tickets.id_especialista','=','usuarios.empleado'))	
				->where('estado_especialista','abierto')
				->find_many();

				//Para cada especialista consulta todos sus tickets
		 		foreach ($especialistas as $key => $value) {

					$ticket = ORM::for_table('tickets')				 
						->select('id')			 
						->select('prioridad')		 
						->select('tms_creacion')		 
						->where('id_especialista',$value->id_especialista)
						->where('estado_especialista','abierto')
						->find_many();

						//Para cada ticket abierto consulta su ultimo ticket $iel especialista
						$i =0;
						$n = count($ticket);
						$variable = 0;
						$en_tiempo = 0;
						$en_destiempo = 0;							

						for ($i=0; $i < $n ; $i++) {
							

						 			$tiempo = round((strtotime($ticket[$i]->tms_cierre) - strtotime($ticket[$i]->tms_creacion))/60,2);
						 			if($tiempo < 0){
						 				$t_a = time();
						 				$tiempo = round(( $t_a - strtotime($ticket[$i]->tms_creacion))/60,2);
									}

						 			//De la caducidad del ticket
										if($ticket[$i]->prioridad == "alta"){
											$limite = 120;
											if($tiempo > $limite)
												$caducado = "caducado";
											else
												$caducado = "vigente";
										}
										elseif($ticket[$i]->prioridad == "media"){
											$limite = 240;	
											if($tiempo > $limite)
												$caducado = "caducado";
											else
												$caducado = "vigente";														
										}
										elseif($ticket[$i]->prioridad == "normal"){
											$limite = 1440;		
											if($tiempo > $limite)
												$caducado = "caducado";	
											else
												$caducado = "vigente";
										}

										if($caducado == "caducado")
											$en_destiempo = $en_destiempo + 1;
										else
											$en_tiempo = $en_tiempo + 1;

						}

					$tmp = array (
						'especialista' => $value->un . " " . $value->up,
						'total' => count($ticket),
						'caducados' => $en_destiempo,						
						'tiempo' => $en_tiempo,						
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
