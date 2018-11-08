 <?php

 $app->group('/nueva_categoria', function () use ($app)	{



	$app->post('/', function () use ($app) {

		$rules=array(
			'nombre' =>array(false, "string", 1, 99),	 			 		
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

		//Insertamos un nuevo registrO			
	 	$ticket = ORM::for_table('categorias')->create();
	 	$ticket->nombre = $params['nombre'];		
	 	$ticket->save();

	 	$response = array(
	 		'mensaje' =>"ok"
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
