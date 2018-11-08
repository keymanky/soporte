 <?php

 $app->group('/relacionar_categorias', function () use ($app)	{



	$app->post('/', function () use ($app) {

		$rules=array(
			'id' =>array(false, "string", 1, 99),	 			 		
			'id_categoria' =>array(false, "string", 1, 99),	 			 		
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

	 	$update= ORM::for_table('subcategorias')->find_one($params['id']);
	 	$update->set('id_categoria',$params['id_categoria']);
	 	$update->save();

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
