 <?php

 $app->group('/buscar', function () use ($app)	{

		$app->post('/:id', function ($id) use ($app) {

			$comillas = '"';
			$rules=array(
				'fi' =>array(false, "string", 1, 99),	 			 		
				'ff' =>array(false, "string", 1, 99),	 			 		
			);


			 $v = new Validator($app->request->getBody(), $rules);
			 $params = $v->validate();

			 if(count($v->getErrors()) > 0){
			 	foreach ($v->getErrors() as $key => $value) {
			 		$response = array("error" => array($key => "campo incorrecto"));
			 		$app->response->setStatus($v->getCode());
			 		$app->response->setBody(json_encode($response));
			 		$app->stop();
			 	}
			 }

			$usuario = ORM::for_table('usuarios')	
				->select('usuarios.*')		
				->where('empleado',$id)			
				->find_one();

			$departamentos = ORM::for_table('departamentos')	
				->select('departamentos.*')		
				->where('id', $usuario->id_departamento)			
				->find_one();

			if(!$usuario){
					$response = array (
					'mensaje' => "Usuario incorrecto"
				);
			}else{

				/*Consulta a la base*/
				if($usuario->id_departamento == 7){
					$ticket = ORM::for_table('tickets')
						->select('tickets.*')
					 	->select('categorias.nombre', 'cn')
					 	->select('subcategorias.nombre', 'subn')
						->select('usuarios.nombre', 'un')
						->select('usuarios.paterno', 'up')	 
					 	->left_outer_join('categorias',array('categorias.id','=','tickets.id_categoria'))
					 	->left_outer_join('subcategorias',array('subcategorias.id','=','tickets.id_subcategoria'))	
						->left_outer_join('usuarios',array('usuarios.empleado','=','tickets.id_especialista'))	
						->where_lte('tms_creacion', date('Y-m-d', strtotime($params['ff'] . '+ 1 days')) )
						->where_gte('tms_creacion', $params['fi'])
						->order_by_desc('tickets.tms_creacion')
						->find_many();
				}else{
					$ticket = ORM::for_table('tickets')	
						->select('tickets.*')
					 	->select('categorias.nombre', 'cn')
					 	->select('subcategorias.nombre', 'subn')
						->select('usuarios.nombre', 'un')
						->select('usuarios.paterno', 'up')	 
					 	->left_outer_join('categorias',array('categorias.id','=','tickets.id_categoria'))
					 	->left_outer_join('subcategorias',array('subcategorias.id','=','tickets.id_subcategoria'))	
						->left_outer_join('usuarios',array('usuarios.empleado','=','tickets.id_especialista'))
						->where('depto', $departamentos->depto_nombre)
						->where_lte('tms_creacion', date('Y-m-d', strtotime($params['ff'] . '+ 1 days')))
						->where_gte('tms_creacion', $params['fi'])						
						->order_by_desc('tickets.tms_creacion')
						->find_many();
				}

					$response = array();	
			 		foreach ($ticket as $key => $value) {
						$tmp = array(
							'id'     => $value->id,
							'resumen' => $value->resumen,
							'categoria' => $value->cn,
							'subcategoria' => $value->subn,	
							'estado' => $value->estado,
							'depto' => $value->depto,			
							'asignado' => $value->un . " " . $value->up,			
							'prioridad' => $value->prioridad,	
							'tms_creacion' => $value->tms_creacion
						);
						$response[] = $tmp; 
			 		}

				if(empty($response)){
					$response = array (
						'mensaje' => "No se encontraron resultados"
					);
				}
			}

			/*Respuesta del servicio*/
			$app->response->setBody(json_encode($response));
			$app->response->setStatus(200);
			$app->stop();

		});

		/*Respuesta del get*/
		$app->options('/:id', function ($id) use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	

		$app->options('/:id', function ($id) use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	
});
?>
