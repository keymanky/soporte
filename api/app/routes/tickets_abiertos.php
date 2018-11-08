 <?php

 $app->group('/tickets_abiertos', function () use ($app)	{

		$app->get('/', function () use ($app) {

			$tickets = ORM::for_table('tickets')	
				->select('tickets.*')
			 	->select('categorias.nombre', 'cn')
			 	->select('subcategorias.nombre', 'subn')
			 	->select('usuarios.nombre', 'un')
			 	->select('usuarios.paterno', 'up')
			 	->left_outer_join('categorias',array('categorias.id','=','tickets.id_categoria'))		 		
			 	->left_outer_join('subcategorias',array('subcategorias.id','=','tickets.id_subcategoria'))		 
			 	->left_outer_join('usuarios',array('usuarios.empleado','=','tickets.id_especialista'))		 
				->where('estado','abierto')					
				//->order_by_desc('tickets.tms_creacion')
				->order_by_desc('tickets.id')				
				->find_many();

				$response = array();	
		 		foreach ($tickets as $key => $value) {

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



					$tmp = array(
						'id'     => $value->id,
						'resumen' => $value->resumen,
						'categoria'     => $value->cn,
						'subcategoria' => $value->subn,	
						'estado' => $value->estado,
						'depto' => $value->depto,			
						'asignado' => $value->un . " " . $value->up,			
						'prioridad' => $value->prioridad,	
						'tms_creacion' => $value->tms_creacion,
						'tiempo' => $caducado,
					);
					$response[] = $tmp; 
		 		}

				if(empty($response)){
					$response = array (
						'mensaje' => "No existen tickets abiertos"
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
