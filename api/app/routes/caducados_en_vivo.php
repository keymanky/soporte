 <?php

 $app->group('/caducados_en_vivo', function () use ($app)	{

		$app->get('/', function () use ($app) {

			//Consulta todos los especialistas
			$usuarios = ORM::for_table('usuarios')				 
				->select('empleado')
				->select('nombre')
				->select('paterno')
				->where('id_departamento','7')
				->find_many();

			$response = array();

	 		foreach ($usuarios as $key => $value) {
				$en_tiempo = 0;
				$en_destiempo = 0;

				$tickets = ORM::for_table('tickets')	 
					->select('tickets.*')
					->where('id_especialista', $value->empleado)					
					->where('estado_especialista', "abierto")					
					->find_many();

					$i =0;
					$n = count($tickets);
					$variable = 0;

					for ($i=0; $i < $n ; $i++) {
						$evento = ORM::for_table('evento')	 
							->select('evento.*')
							->where('id_ticket', $tickets[$i]->id)
							->where('id_especialista', $value->empleado)						
							->order_by_desc('evento.secuencia')		
							->find_many();
						
						if(count($evento)>0){
			 				//Calculando los tiempos

					 			$tiempo = round((strtotime($evento[0]->tms_cierre) - strtotime($evento[0]->tms_creacion))/60,2);
					 			if($tiempo < 0){
					 				$t_a = time();
					 				$tiempo = round(( $t_a - strtotime($evento[0]->tms_creacion))/60,2);
								}
					 			//De la caducidad del ticket
									if($tickets[$i]->prioridad == "alta"){
										$limite = 120;
										if($tiempo > $limite)
											$caducado = "caducado";
										else
											$caducado = "vigente";
									}
									elseif($tickets[$i]->prioridad == "media"){
										$limite = 240;	
										if($tiempo > $limite)
											$caducado = "caducado";
										else
											$caducado = "vigente";														
									}
									elseif($tickets[$i]->prioridad == "normal"){
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
							//$variable = $variable + $evento[0]->id;
						}
					}

						
				$tmp = array (
					'usuario' => $value->nombre . "  " .$value->paterno,
					'numero' => $en_destiempo,
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
