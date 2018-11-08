 <?php

 $app->group('/consultar_eventos', function () use ($app)	{

		$app->get('/:id', function ($id) use ($app) {

			// Consultando el ticket
			$ticket = ORM::for_table('tickets')
				->select('tickets.*')
				->where('id', $id)
				->find_one();

			// Consultando los eventos
			$evento = ORM::for_table('evento')
				->select('evento.*')
			 	->select('usuarios.nombre', 'un')
			 	->select('usuarios.paterno', 'up')
			 	->join('usuarios',array('usuarios.empleado','=','evento.id_especialista'))
				->where('id_ticket', $id)
				->order_by_desc('evento.secuencia')
				->find_many();


				$response = array();	
		 		foreach ($evento as $key => $value) {

		 			//Calculando los tiempos
		 			$tiempo = round((strtotime($value->tms_cierre) - strtotime($value->tms_creacion))/60,2);
		 			if($tiempo < 0){
		 				$t_a = time();
		 				$tiempo = round(( $t_a - strtotime($value->tms_creacion))/60,2);
		 			}

		 			//De la caducidad del ticket
					if($ticket){
						if($ticket->prioridad == "alta"){
							$limite = 120;
							if($tiempo > $limite)
								$caducado = "caducado";
							else
								$caducado = "vigente";
						}
						elseif($ticket->prioridad == "media"){
							$limite = 240;	
							if($tiempo > $limite)
								$caducado = "caducado";
							else
								$caducado = "vigente";														
						}
						elseif($ticket->prioridad == "normal"){
							$limite = 1440;		
							if($tiempo > $limite)
								$caducado = "caducado";	
							else
								$caducado = "vigente";																				
						}
					}

		 			//Formato para tiempo consumido
		 			if($tiempo > 119 and $tiempo < 1439){
		 				$despegable = round($tiempo/60, 2) . " horas ";
		 			}else if($tiempo >= 1440){
		 				$dias = floor($tiempo/1440);
		 				$tmp = $dias * 1440;
		 				$despegable = $dias . " dias " . round(($tiempo-$tmp)/60,2) . " horas ";
		 			}
		 			else
		 				$despegable = round($tiempo, 2) . " minutos";

					$tmp = array(
						'id'     => $value->id,
						'tms_creacion'     => $value->tms_creacion,
						'tms_cierre'     => $value->tms_cierre,
						'comentario' => $value->comentario,
						'especialista'     => $value->un . " " . $value->up,
						'id_especialista'     => $value->id_especialista,
						'minutos' => $tiempo,
						'minutos_despegable' => $despegable,
						'caducado' => $caducado,
						'id_evento_padre' => $value->id_evento_padre,
					);
					$response[] = $tmp; 
		 		}

				if(empty($response)){
					$response = array (
						'mensaje' => "El ticket no tiene asignaciones"
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
