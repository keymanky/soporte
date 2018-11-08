 <?php

 $app->group('/tickets_usuario', function () use ($app)	{

		$app->get('/:id', function ($id) use ($app) {

			/*Consulta la info del usuario para saber si es de sistemas o normal*/
			$usuario = ORM::for_table('usuarios')	
				->select('usuarios.*')		
				->where('empleado',$id)			
				->find_one();

			if(!$usuario){
					$response = array (
					'mensaje' => "Usuario incorrecto"
				);
			}
			else{
				if($usuario->id_departamento == 7){
					/*Consulta la info del ticket*/
						$tickets = ORM::for_table('tickets')	
							->select('tickets.*')
						 	->select('categorias.nombre', 'cn')
						 	->select('subcategorias.nombre', 'subn')
						 	->join('categorias',array('categorias.id','=','tickets.id_categoria'))
						 	->join('subcategorias',array('subcategorias.id','=','tickets.id_subcategoria'))		 
							->where('estado','abierto')
							->where('id_especialista',$id)	
							->order_by_desc('tickets.id')
							->find_many();

							$response = array();	
					 		foreach ($tickets as $key => $value) {

					 			//Calculando los tiempos
					 			$tiempo = round((strtotime($value->tms_deadline) - strtotime($value->tms_creacion))/60,2);
					 			if($tiempo < 0){
					 				$t_a = time();
					 				$tiempo = round(( $t_a - strtotime($value->tms_creacion))/60,2);
					 			}

								if($value->prioridad == "alta"){
									$limite = 120;
									if($tiempo > $limite)
										$caducado = "caducado";
									else
										$caducado = "vigente";
								}
								elseif($value->prioridad == "media"){
									$limite = 240;	
									if($tiempo > $limite)
										$caducado = "caducado";
									else
										$caducado = "vigente";														
								}
								elseif($value->prioridad == "normal"){
									$limite = 1440;		
									if($tiempo > $limite)
										$caducado = "caducado";	
									else
										$caducado = "vigente";																				
								}


								$tmp = array(
									'id'     => $value->id,
									'resumen' => $value->resumen,
									'categoria'     => $value->cn,
									'subcategoria' => $value->subn,	
									'estado' => $value->estado,
									'estado_especialista' => $value->estado_especialista,
									'depto' => $value->depto,			
									'asignado' => $usuario->nombre . " " . $usuario->paterno,			
									'prioridad' => $value->prioridad,	
									'tms_creacion' => $value->tms_creacion,
									'caducado' => $caducado,
								);
								$response[] = $tmp; 
					 		}
				}else{
					/*Consulta la info del ticket*/
					$tickets = ORM::for_table('tickets')	
						->select('tickets.*')
					 	->select('categorias.nombre', 'cn')
					 	->select('subcategorias.nombre', 'subn')
					 	->select('usuarios.nombre', 'un')
					 	->select('usuarios.paterno', 'up')
					 	->join('categorias',array('categorias.id','=','tickets.id_categoria'))		 		
					 	->join('subcategorias',array('subcategorias.id','=','tickets.id_subcategoria'))		 
					 	->join('usuarios',array('usuarios.empleado','=','tickets.id_especialista'))		 
						->where('estado','abierto')			
						->where('id_usuario',$id)			
						->order_by_desc('tickets.id')
						->find_many();

						$response = array();	
				 		foreach ($tickets as $key => $value) {
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
								'caducado' => "vigente",								
							);
							$response[] = $tmp; 
				 		}
				}
				if(empty($response)){
					$response = array (
						'mensaje' => "El usuario no tiene tickets abiertos"
					);
				}
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
