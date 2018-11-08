<?php

 $app->group('/cerrar', function () use ($app)	{

		$app->get('/:id', function ($id) use ($app) {
		
		date_default_timezone_set('America/Mexico_City');

		//Validaciones ::: Que tenga almenos una asignacion, tenga un comentario, sea el empleado y que no haya sido cerrado antes

			$asignaciones = ORM::for_table('evento')				 
				->select('evento.*')
				->where('id_ticket', $id)
				->order_by_desc('evento.id')
				->find_many();

			//Consultamos los datos del ticket
				$ticket = ORM::for_table('tickets')				 
					->select('tickets.*')
					->where('id', $id)
					->find_one();


		 	$creador = $ticket->id_usuario;
		 	$especialista = $ticket->id_especialista;
	

			if ( count($asignaciones) <= 0 ) {
				$response = array(
				    'mensaje' => "Debe asignar el ticket antes de cerrarlo"
				);
		 		$app->response->setStatus(200);
		 		$app->response->setBody(json_encode($response));
		 		$app->stop();
			}

			if ( strlen($asignaciones[0]->comentario) < 5 ) {
				$response = array(
				    'mensaje' => "Debe introducir un comentario en la asignacion"
				);
		 		$app->response->setStatus(200);
		 		$app->response->setBody(json_encode($response));
		 		$app->stop();
			}	

			if ( ! ($asignaciones[0]->id_especialista) == $especialista) {
				$response = array(
				    'mensaje' => "Prohibido, usted debe ser el agente encargado"
				);
		 		$app->response->setStatus(200);
		 		$app->response->setBody(json_encode($response));
		 		$app->stop();
			}

			if ( strlen( $ticket->uuid ) > 5 ){
				$response = array(
				    'mensaje' => "El ticket ya fue cerrado anteriormente"
				);
		 		$app->response->setStatus(200);
		 		$app->response->setBody(json_encode($response));
		 		$app->stop();
			}

		//Cerramos el ticket
			$uuid = uniqid();
			$ticket->set('estado_especialista', 'cerrado');
			$ticket->set('estado', 'cerrado');
			$ticket->set('tms_deadline', date('Y-m-d G:i:s', time()));
			$ticket->set('uuid', $uuid);
			$ticket->save();


		//Consulta el admin en turno
		 	$fh_creacion = date("Y-m-d H:i:s");
			$hora = (int) date('H');
			$minuto = (int) date('i');

			if($hora <=6){
				$tipo_admin = 3;
			}else if ($hora >6 and $hora <=14){
				$tipo_admin = 1;
			}else if ($hora >14 and $hora <=22){
				$tipo_admin = 2;
			}else{
				$tipo_admin = 3;
			}

		//Consultamos la info del admin para el envio de email
			$admin = ORM ::for_table('usuarios')	
				->select('usuarios.*')
				->where('es_admin', $tipo_admin)			
				->find_one();					 

		//Consultamos la info del usuario de creacion para el envio de email
			$usuarios = ORM ::for_table('usuarios')	
				->select('usuarios.*')
				->where('empleado', $creador)			
				->find_one();

		//Consultamos la info del especialista
			$especialistas = ORM ::for_table('usuarios')	
				->select('usuarios.*')
				->where('empleado', $especialista)			
				->find_one();			

		//Consultamos el ultimo comentario realizado del especialista
			$evento = ORM ::for_table('evento')	
				->select('evento.*')
				->where('id_ticket', $id)			
				->where('id_especialista', $especialista)			
				->order_by_desc('evento.tms_creacion')
				->find_many();


			if($evento){
				$esp = ORM ::for_table('usuarios')	
							->select('usuarios.*')
							->where('empleado', $evento[0]->id_especialista)			
							->find_one();

				$ultimo_comentario = $esp->nombre . " " . $esp->paterno . " : " . $evento[0]->comentario;
				//$ultimo_comentario = $evento[0]->comentario;

				//CERRAMOS LAS ASIGNACIONES
		 		foreach ($evento as $key => $value) {
					$fcierre = date('Y-m-d H:i:s');
					if(!$value->tms_cierre){
					 	$value->set('tms_cierre', $fcierre);
					 	$value->save();	
					}
		 		}

			}else
				$ultimo_comentario = " fue cerrado sin una asignacion" ;


		//Envio de respuesta
		 	$response = array(
			    'to' => $usuarios->mail,
			    'to_name' => $usuarios->nombre,
			    'cc' => $admin->mail,
			    'cc_name' => $admin->nombre . " " . $admin->paterno,
			    'subject' => "Detexis |  Ticket No. " . $ticket->id . " Cerrado",
			    'content' => "<table>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left; font-weight: bold;'>Ticket No.</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left;'>". $ticket->id  . "</td>
	                                  </tr>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left; font-weight: bold;'>Cliente</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left;'>". $ticket->depto . "</td>
	                                  </tr>
	                                  <tr>
	                                       <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left; font-weight: bold;'>Fecha de Cierre:</td>
	                                       <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left;'>" . $fh_creacion . "</td>
	                                  </tr>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left; font-weight: bold;'>Agente:</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left;'>". $especialistas->nombre . " " . $especialistas->paterno . "</td>
	                                  </tr>
	                                  <tr>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left; font-weight: bold;'>Encuesta:</td>
	                                      <td style='font-family: Optima, sans-serif;color: #585858;font-family: Optima, sans-serif;text-align: left;'>Por favor responda la siguiente encuestra de satisfacci&oacute;n <a href='http://207.254.73.11:888/detexis/encuestas/soporte.php?id=". $uuid  . "'> Aqu&iacute;</a><br/><br/></td>
	                                  </tr>	                                  
	                              </table>",
			    'template' => "ticket_to_close"
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
				    'msn' => "Detexis ERP, Ticket cerrado No. " .  $ticket->id . " " . $ticket->depto
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


		//Respuesta Final
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