 <?php

 $app->group('/ticket', function () use ($app)	{



	$app->post('/', function () use ($app) {

		$rules=array(
			'asunto' =>array(false, "string", 1, 99),
			'detalle' =>array(false, "string", 1, 999),
			'categoria' =>array(false, "string", 1, 99), 
			'subcategoria' =>array(false, "string", 1, 99),
			'id_usuario' =>array(false, "string", 1, 99),
			'depto_nombre' =>array(false, "string", 1, 99),
			'usuario_creacion' =>array(false, "string", 1, 99),
			'usuario_email' =>array(false, "string", 1, 99),
			'prioridad' =>array(false, "string", 1, 99),
			'origen' =>array(false, "string", 1, 99),	 			 		
			'medio' =>array(false, "string", 1, 99),		 			 		
			'archivo' =>array(false, "string", 1, 99),		 			 		
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

		//Calcula el tipo de admin
			date_default_timezone_set('America/Mexico_City');
			$hora = (int) date('H');
			$minuto = (int) date('i');
			$fh_creacion = date("Y-m-d H:i:s");

			if($hora <=6){
				$tipo_admin = 3;
			}else if ($hora >6 and $hora <=14){
				$tipo_admin = 1;
			}else if ($hora >14 and $hora <=22){
				$tipo_admin = 2;
			}else{
				$tipo_admin = 3;
			}

		//Consulta el id del admin
			$admin = ORM ::for_table('usuarios')	
				->select('usuarios.*')		
				->where('es_admin', $tipo_admin)
				->find_one();		

		//Insertamos un nuevo registrO	
		 	$ticket = ORM::for_table('tickets')->create();
		 	$ticket->resumen = $params['asunto'];		
		 	$ticket->detalle = $params['detalle'];								
		 	$ticket->id_categoria = $params['categoria'];					
		 	$ticket->id_subcategoria = $params['subcategoria'];		
		 	$ticket->id_usuario = $params['id_usuario'];
		 	$ticket->usuario_creacion = $params['usuario_creacion'];		
		 	$ticket->depto = $params['depto_nombre'];		
		 	$ticket->prioridad = $params['prioridad'];
		 	$ticket->causa = $params['origen'];
		 	$ticket->medio = $params['medio'];
		 	$ticket->id_especialista = $admin->empleado;
		 	$ticket->archivo = $params['archivo'];
		 	$ticket->tms_creacion = $fh_creacion;
		 	$ticket->save();

	 	//Consulta el id del admin
			$categorias = ORM::for_table('categorias')
				->select('categorias.*')
				->where('id', $params['categoria'])
				->find_one();

			$subcategoria = ORM ::for_table('subcategorias')
				->select('subcategorias.*')
				->where('id', $params['subcategoria'])
				->find_one();

		//Envio de respuesta
		 	$response = array(
			    'to' => $params['usuario_email'],
			    'to_name' => $params['usuario_creacion'],
			    'cc' => $admin->mail,
			    'cc_name' => $admin->nombre . " " . $admin->paterno,
			    'subject' => "Detexis | Nueva solicitud de servicio Ticket No. " . $ticket->id(),
			    'content' => "<table>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Ticket No.</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>". $ticket->id()  . "</td>
	                                  </tr>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Cliente</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>". $params['depto_nombre'] . "</td>
	                                  </tr>
	                                  <tr>
	                                       <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Fecha de Creacion:</td>
	                                       <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>" . $fh_creacion . "</td>
	                                  </tr>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Agente:</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>". $admin->nombre . " " . $admin->paterno . "</td>
	                                  </tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Asunto:</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>" . $params['asunto'] . "</td>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Categoria</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>" . $categorias->nombre . "  >  " . $subcategoria->nombre .  "</td>
	                                  </tr>
	                              </table>",
			    'template' => "ticket_new"
		 	);

			$ch = curl_init( 'http://207.254.73.11:888/detexis/mail/api/');
			# Setup request to send json via POST.
			$payload = json_encode( $response );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			# Return response instead of printing.
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			# Send request.
			$result = curl_exec($ch);
			curl_close($ch);

		//Envio de msn text
			if ( strlen($admin->celular) == 10) {
			 	$response = array(
				    'numero' => $admin->celular,
				    'msn' => "Detexis ERP, Nuevo ticket por asignar No. " .  $ticket->id() . " " . $params['depto_nombre']
			 	);

				$ch = curl_init( 'http://207.254.73.11:888/detexis/msn/api/newMsn');
				# Setup request to send json via POST.
				$payload = json_encode( $response );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
				curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
				# Return response instead of printing.
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				# Send request.
				$result = curl_exec($ch);
				curl_close($ch);				
			}
			

		//Respuesta final
		 	$response = array(
		 		'mensaje' =>"Su nueva petición a sido registrada con el número #" . $ticket->id(),
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
