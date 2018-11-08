 <?php

 $app->group('/comentar', function () use ($app)	{



	$app->post('/', function () use ($app) {

		$rules=array(
			'id' =>array(false, "string", 1, 99),	 			 		
			'id_padre' =>array(false, "string", 1, 99),	 			 		
			'usuario' =>array(false, "string", 1, 99),	 			 		
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


			/*Consulta la secuencia*/
			$eventos = ORM::for_table('evento')	
				->select('evento.*')			
				->where('id',  $params['id_padre'])
				->find_one();


		//Insertamos un nuevo registrO			
	 	$ticket = ORM::for_table('evento')->create();
	 	$ticket->id_ticket = $params['id'];		
	 	$ticket->id_especialista = $params['usuario'];		
	 	$ticket->id_evento_padre = $params['id_padre'];		
	 	$ticket->secuencia = $eventos->secuencia + 1;		
	 	$ticket->save();
					 	

	 	$response = array(
	 		'mensaje' =>"El comentario fue creado"
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
