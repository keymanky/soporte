 <?php

 $app->group('/mail', function () use ($app)	{

	$app->post('/:id', function ($id) use ($app) {

		$rules=array(
			'mail' =>array(false, "string", 1, 99),	 			 		
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

		 //Consulta el id del especialista
		ORM::configure('id_column_overrides', array('usuarios'=> 'empleado'));
		$usuario = ORM ::for_table('usuarios')
			->select('usuarios.*')
			->where('empleado', $id)		
			->find_one();	

	 	$usuario->set('mail', $params['mail']);
	 	$usuario->save();	
	
		$response = array (
			'mensaje' => 'actualizado con exito'
		);	


		 $app->response->setStatus(200);
		 $app->response->setBody(json_encode($response));	
	});

	 /*Respuesta del post*/
	$app->options('/', function () use ($app){
	 	$app->response->setStatus(200);
	 	$app->response->setBody(json_encode(array('message' => 'ok')));
	});

});
?>
