 <?php

 $app->group('/admin', function () use ($app)	{

		$app->get('/:id', function ($id) use ($app) {
			ORM::configure('id_column_overrides', array('usuarios'=> 'empleado'));
			$usuarios = ORM::for_table('usuarios')				 
				->select('usuarios.*')
				->where('es_admin', 1)
				->find_one();

			if($usuarios){			
			 	$usuarios->set('es_admin', 0);
			 	$usuarios->save();	
			}	


			$usuarios = ORM::for_table('usuarios')				 
				->select('usuarios.*')
				->where('empleado', $id)
				->find_one();

		 	$usuarios->set('es_admin', 1);
		 	$usuarios->save();	
			$response = array (
				'mensaje' => 'ok'
			);
			
			/*Respuesta del servicio*/
			$app->response->setBody(json_encode($response));			
			$app->response->setStatus(200);
			$app->stop();

		});

		/*Respuesta del get id*/
		$app->options('/:id', function () use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	

});
?>
