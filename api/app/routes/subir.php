 <?php

 $app->group('/subir', function () use ($app)	{



	$app->post('/', function () use ($app) {

		$rules=array(
			'id' =>array(false, "string", 1, 99), 	 					 							
			'archivo' =>array(false, "string", 1, 99)		 			 		
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
				
	 	$update= ORM::for_table('tickets')->find_one($params['id']);

	 	if(!$update){
	 		$app->response->setStatus(400);
	 		$error = array('error'=>array('correo'=>"El id del ticket es incorrecto"));
	 		$app->response->setBody(json_encode($error));
	 		$app->stop();
	 	}
	 	$update->set('archivo',$params['archivo']);
	 	$update->save();	

	 	$response = array(
	 		'mensaje' =>"Se adjunto correctamente el archivo"
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
