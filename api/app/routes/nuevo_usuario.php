 <?php

 $app->group('/nuevo_usuario', function () use ($app)	{

	$app->post('/', function () use ($app) {

		$rules=array(
			'cuenta' =>array(false, "string", 0, 20),
			'nombre' =>array(false, "string", 0, 999),
			'paterno' =>array(false, "string", 0, 99),
			'materno' =>array(false, "string", 0, 99),
			'puesto' =>array(false, "string", 0, 99),
			'mail' =>array(false, "string", 0, 99),
			'password' =>array(false, "string", 0, 99),		 			 		
			'celular' =>array(false, "string", 0, 99),	 			 		
			'telefono' =>array(false, "string", 0, 99),		 		
			'idTeamViewer' =>array(false, "string", 0, 99),	 		
			'id_departamento' =>array(false, "string", 0, 99),
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


		//Insertamos un nuevo registro	
		try {

				$existe = ORM::for_table('usuarios')
					->select('usuarios.*')
					->where('cuenta', $params['cuenta'])
					->find_many();

				if(count($existe) > 0){

					$response = array(
						'mensaje' =>"La cuenta del usuario ya existe, favor de intentar con otra"
					);

				}else{

						$usuario = ORM::for_table('usuarios')
							->select('usuarios.*')					
							->where('id_departamento', $params['id_departamento'])
							->find_many();			
						$total = count($usuario) +1;

					 	$ticket = ORM::for_table('usuarios')->create();
					 	$ticket->cuenta = $params['cuenta'];		
					 	$ticket->nombre = $params['nombre'];								
					 	$ticket->paterno = $params['paterno'];								
					 	$ticket->materno = $params['materno'];								
					 	$ticket->puesto = $params['puesto'];								
					 	$ticket->mail = $params['mail'];
					 	$ticket->password = $params['password'];			
					 	$ticket->celular = $params['celular'];				
					 	$ticket->telefono = $params['telefono'];							
					 	$ticket->ID_TeamViewer = $params['idTeamViewer'];							
					 	$ticket->id_departamento = $params['id_departamento'];								
					 	$ticket->save();

					 	$response = array(
					 		'mensaje' => 'Usuario agregado con exito, ahora el departamento tiene ' . $total . ' usuarios'
					 	);
				}


				 $app->response->setStatus(200);
				 $app->response->setBody(json_encode($response));			 	

			} catch (Exception $e) {
			 	$response = array(
						'mensaje' =>"Error interno " . $e
					);

				 $app->response->setStatus(200);
				 $app->response->setBody(json_encode($response));	
			}	
	
	});

	 /*Respuesta del post*/
	$app->options('/', function () use ($app){
	 	$app->response->setStatus(200);
	 	$app->response->setBody(json_encode(array('message' => 'ok')));
	});



});

?>
