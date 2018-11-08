 <?php

 $app->group('/activar', function () use ($app)	{

		$app->get('/:id', function ($id) use ($app) {

		ORM::configure('id_column_overrides', array('usuarios'=> 'empleado'));
		$usuarios = ORM::for_table('usuarios')				 
			->select('usuarios.*')
			->where('empleado', $id)
			->find_one();

	 	$usuarios->set('activo', !$usuarios->activo);
	 	$usuarios->save();	
		
		if(!$usuarios->activo){
			$msn = "desactivado";
		}
		else
			$msn = "activado";


		$response = array (
			'mensaje' => 'El usuario fue ' . $msn
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
