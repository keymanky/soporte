<?php

 $app->group('/tickets_consulta', function () use ($app)	{

	$app->post('/:id', function ($id) use ($app) {

		$rules=array(
			'asunto' =>array(false, "string", 1, 99),	
			'detalle' =>array(false, "string", 1, 999), 	
			// 'categoria' =>array(false, "string", 1, 99), 
			// 'subcategoria' =>array(false, "string", 1, 99), 
			'prioridad' =>array(false, "string", 1, 99),
			'origen' =>array(false, "string", 1, 99),	 			 		
			'medio' =>array(false, "string", 1, 99),	 			 		
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

		 //Consulta info del ticket
		$tickets = ORM ::for_table('tickets')	
			->select('tickets.*')
			->where('id', $id)			
			->find_one();	

		if($tickets){
		 	$tickets->set("resumen", $params['asunto']);	
		 	$tickets->set("detalle", $params['detalle']);					
		 	// $tickets->set("id_categoria", $params['categoria']);					
		 	// $tickets->set("id_subcategoria", $params['subcategoria']);			
		 	$tickets->set("prioridad", $params['prioridad']);
		 	$tickets->set("causa", $params['origen']);
		 	$tickets->set("medio", $params['medio']);
		 	$tickets->save();
		 	$mensaje = "Se actualizo correctamente el ticket " . $id;
		}else{
		 	$mensaje = "Ocurrio un error al actualizar el ticket  " . $id . " por favor vuelva a intentarlo";
		}


	 	$response = array(
	 		'mensaje' => $mensaje
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
