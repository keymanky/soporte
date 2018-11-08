 <?php

 $app->group('/ticket', function () use ($app)	{



	$app->post('/', function () use ($app) {

		$rules=array(
			'asunto' =>array(false, "string", 1, 99),
			'detalle' =>array(false, "string", 1, 99), 	
			'categoria' =>array(false, "string", 1, 99), 
			'subcategoria' =>array(false, "string", 1, 99), 
			'id_usuario' =>array(false, "string", 1, 99),
			'depto' =>array(false, "string", 1, 99),
			'usuario_creacion' =>array(false, "string", 1, 99),
			'usuario_email' =>array(false, "string", 1, 99),
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

		 //Consulta el id del especialista
		$especialistas = ORM ::for_table('especialistas')	
			->select('especialistas.*')
			->where('es_admin',"1")			
			->find_one();	

		 //Consulta el id del admin
		$admin = ORM ::for_table('usuarios')	
			->select('usuarios.*')
			->where('empleado', $especialistas->id_empleado)			
			->find_one();					 

		//Insertamos un nuevo registrO			
	 	$ticket = ORM::for_table('tickets')->create();
	 	$ticket->resumen = $params['asunto'];		
	 	$ticket->detalle = $params['detalle'];								
	 	$ticket->id_categoria = $params['categoria'];					
	 	$ticket->id_subcategoria = $params['subcategoria'];		
	 	$ticket->id_usuario = $params['id_usuario'];		
	 	$ticket->usuario_creacion = $params['usuario_creacion'];		
	 	$ticket->depto = $params['depto'];		
	 	$ticket->prioridad = $params['prioridad'];
	 	$ticket->causa = $params['origen'];
	 	$ticket->medio = $params['medio'];
	 	$ticket->id_especialista = $especialistas->id_empleado;
	 	$ticket->save();

		

	 	//Enviamos el email
		$post = [
		    'to' => $params['usuario_email'],
		    'to_nombre' => $params['usuario_creacion'],
		    'cc' => $admin->mail,
		    'cc_nombre' => $admin->nombre . " " . $admin->paterno,
		    'subject' => "Nueva solicitud de servicio (Sistema de tickets soporte-loma)",
		    'from_name' => "Sistema de tickets soporte-loma",
		    'from' => "soporte@soporte-loma.com.mx",
		    'contenido' => "Su nueva solicitud o ticket quedo registrado exitosamente con el #" . $ticket->id() . " y el asunto:<br/> " . $params['asunto']
		];		

		$ch = curl_init( 'http://187.176.24.218/mail/api/' );
		# Setup request to send json via POST.
		$payload = json_encode( $post );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);

	 	$response = array(
	 		'mensaje' =>"Su nueva petición a sido registrada con el número #" . $ticket->id(),
	 		'id' => $ticket->id(),
	 		'mas' => $post
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
