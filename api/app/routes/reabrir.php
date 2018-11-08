 <?php

 $app->group('/reabrir', function () use ($app)	{

		$app->get('/:id', function ($id) use ($app) {
		$t1 = ORM::for_table('tickets')				 
			->select('tickets.*')
			->where('id', $id)
			->find_one();

	 		$t1->set('estado_usuario', 'cerrado');
	 		$t1->set('estado', 'cerrado');

	 	$t1->save();	


	 	$ticket = ORM::for_table('tickets')->create();
	 	$ticket->resumen = $t1->resumen;		
	 	$ticket->detalle = $t1->detalle;								
	 	$ticket->id_categoria = $t1->id_categoria;					
	 	$ticket->id_subcategoria = $t1->id_subcategoria;		
	 	$ticket->estado = "abierto";
	 	$ticket->estado_usuario = "abierto";
	 	$ticket->estado_especialista = "abierto";
	 	$ticket->tms_deadline = "0000-00-00 00:00:00";
	 	$ticket->id_usuario = $t1->id_usuario;		
	 	$ticket->usuario_creacion = $t1->usuario_creacion;		
	 	$ticket->depto = $t1->depto;		
	 	$ticket->prioridad = $t1->prioridad;
	 	$ticket->causa = $t1->causa;
	 	$ticket->medio = $t1->medio;
	 	$ticket->id_especialista = $t1->id_especialista;
	 	$ticket->archivo = $t1->archivo;
	 	$ticket->reabierto = 1;
	 	$ticket->id_ticket_reabierto = $id;
	 	$ticket->save();
		$nuevo = $ticket->id();

		// Consultando los eventos
		$evento = ORM::for_table('evento')
			->select('evento.*')
			->where('id_ticket', $id)					
			->find_many();

	 		foreach ($evento as $key => $value) {

			 	$evento = ORM::for_table('evento')->create();
			 	$evento->tms_creacion= $value->tms_creacion;		
			 	$evento->id_ticket= $nuevo;		
			 	$evento->tms_cierre = $value->tms_cierre;
			 	$evento->comentario = $value->comentario;					
			 	$evento->id_especialista = $value->id_especialista;		
			 	$evento->id_evento_padre = $value->id_evento_padre;
			 	$evento->secuencia = $value->secuencia;
			 	$evento->save();
	 		}


		$response = array (
			'mensaje' => 'Se ha cerrado este ticket y se ha abierto uno nuevo con el #' . $ticket->id()
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
