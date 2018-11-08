 <?php

 $app->group('/guardar_comentario', function () use ($app)	{

		$app->post('', function () use ($app) {

		$rules=array(
			'id' =>array(false, "string", 1, 99),	 			 		
			'comentario' =>array(false, "string", 1, 999),	 			 		
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

		date_default_timezone_set('America/Mexico_City');
		$fh_creacion = date("Y-m-d H:i:s");

		ORM::configure('id_column_overrides', array('evento'=> 'id'));
		$eventos = ORM::for_table('evento')				 
			->select('evento.*')
			->where('id', $params['id'])
			->find_one();

		$ticket = $eventos->id_ticket;

	 	$eventos->set('comentario', $params['comentario']);
	 	$eventos->save();	

	 	//Consultamos la info de ticket para enviar el email al usuario de creacion y al especialista que lo tenga
			$tickets = ORM::for_table('tickets')				 
				->select('tickets.*')
				->where('id', $ticket)
				->find_one();

	 	//Consultamos info especialista para envio de email
			$admin = ORM::for_table('usuarios')				 
				->select('usuarios.*')
				->where('empleado', $tickets->id_especialista)
				->find_one();

	 	//Consultamos info usuario para envio de email
			$usuario = ORM::for_table('usuarios')				 
				->select('usuarios.*')
				->where('empleado', $tickets->id_usuario)
				->find_one();	

		//Envio de notificacion
		 	$response = array(
			    'to' => $usuario->mail,
			    'to_name' => $usuario->nombre,
			    'cc' => $admin->mail,
			    'cc_name' => $admin->nombre . " " . $admin->paterno,
			    'subject' => "Detexis | El agente comento aceca de su ticket . " . $tickets->id,
			    'content' => "<table>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Ticket No.</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>". $tickets->id  . "</td>
	                                  </tr>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Agente:</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>". $admin->nombre . " " . $admin->paterno . "</td>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Comentario</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;font-weight: bold;'>" . str_replace('"', '', $params['comentario'] ).  "</td>
	                                  </tr>
	                                  <tr>
	                                       <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Fecha de Creacion:</td>
	                                       <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>" . $fh_creacion . "</td>
	                                  </tr>	                                  
	                              </table>",
			    'template' => "ticket_comment_specialist"
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
				    'msn' => "Detexis ERP, Nuevo comentario sobre el ticket No. " .  $tickets->id . " " . substr(str_replace('"', '', $params['comentario'] ), 0, 25) . "..."
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

		//Resultado final
			$response = array (
				'mensaje' => 'ok'		
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
