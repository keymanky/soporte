 <?php

 $app->group('/asignar', function () use ($app)	{

	$app->post('/', function () use ($app) {

		date_default_timezone_set('America/Mexico_City');

		$rules=array(
			'id' =>array(false, "string", 1, 99),	 			 		
			'especialista' =>array(false, "string", 1, 99),	 			 		
		);


		//Validando parametros
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

		//Para definir la secuencia
			$eventos = ORM::for_table('evento')	
				->select('evento.*')			
				->where('id_ticket',  $params['id'])
				->order_by_desc('evento.secuencia')
				->find_many();

			$max = 1;
			if($eventos){
		 		foreach ($eventos as $key => $value) {
		 			$max =  $value->secuencia + 1;
		 			break;
		 		}
			}

			//Para cerrar el tiempo de los especialistas
			$eventos = ORM::for_table('evento')	
				->select('evento.*')			
				->where('id_ticket',  $params['id'])
				->where_null('tms_cierre')
				->find_many();
				if($eventos){
			 		foreach ($eventos as $key => $value) {
						$fcierre = date('Y-m-d H:i:s');
					 	$value->set('tms_cierre', $fcierre);
					 	$value->save();	
			 		}
				}

		//Insertamos un nuevo registrO			
		 	$ticket = ORM::for_table('evento')->create();
		 	$ticket->id_ticket = $params['id'];		
		 	$ticket->id_especialista = $params['especialista'];
		 	$ticket->secuencia = $max;
		 	$ticket->save();

	 	//Actualizamos el estatus de quien lo atiende
			$tickets = ORM::for_table('tickets')				 
				->select('tickets.*')
				->where('id', $params['id'])
				->find_one();
			$usuario_creacion = $tickets->id_usuario;
		 	$tickets->set('id_especialista', $params['especialista']);
		 	$tickets->save();					 	

	 	//Consultamos info especialista para envio de email
			$admin = ORM::for_table('usuarios')				 
				->select('usuarios.*')
				->where('empleado', $params['especialista'])
				->find_one();

	 	//Consultamos info usuario para envio de email
			$usuario = ORM::for_table('usuarios')				 
				->select('usuarios.*')
				->where('empleado', $usuario_creacion)
				->find_one();				

		//Envio de respuesta
		 	$response = array(
			    'to' => $usuario->mail,
			    'to_name' => $usuario->nombre,
			    'cc' => $admin->mail,
			    'cc_name' => $admin->nombre . " " . $admin->paterno,
			    'subject' => "Detexis | Asignacion solicitud de servicio Ticket No. " . $tickets->id,
			    'content' => "<table>
                                    <tr>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Ticket No.</td>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>". $tickets->id . "</td>
                                    </tr>
                                    <tr>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Cliente</td>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>". $tickets->depto  . "</td>
                                    </tr>                                    
                                    <tr>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Agente:</td>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>". $admin->nombre . " " . $admin->paterno . "<br/>" . $admin->comentario . "</td>
                                    </tr>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Asunto:</td>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>" . $tickets->resumen . "</td>
                                    <tr>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify; font-weight: bold;'>Descripcion</td>
                                        <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: justify;'>" . str_replace('"', "", $tickets->detalle) . "</td>
                                    </tr>
                                </table>",
			    'template' => "ticket_to_assing"
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
				    'msn' => "Detexis ERP, Ticket asignado No. " .  $tickets->id . " " . $tickets->depto
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


		 	$response = array(
		 		'mensaje' =>"La asignacion fue creada" 		
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
