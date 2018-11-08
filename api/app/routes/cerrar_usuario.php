 <?php

 $app->group('/cerrar_usuario', function () use ($app)	{

		$app->get('/:id', function ($id) use ($app) {
		$usuarios = ORM::for_table('tickets')				 
			->select('tickets.*')
			->where('id', $id)
			->find_one();

	 		$usuarios->set('estado_usuario', 'cerrado');
	 		$usuarios->set('estado', 'cerrado');

	 	$usuarios->save();	

		$response = array (
			'mensaje' => 'cerrado con exito'
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
