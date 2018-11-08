<?php

 $app->group('/tickets_consulta', function () use ($app)	{

	$app->get('/:id', function ($id) use ($app) {

		 //Consulta info del ticket
			$tickets = ORM ::for_table('tickets')	
					->select('tickets.*')
					->where('id', $id)			
					->find_one();

			if(!$tickets){
				$response = array (
					'mensaje' => "Ticket incorrecto"
				);
				$app->response->setStatus(200);
				$app->response->setBody(json_encode($response));
				$app->stop();	
			}

		 //Consulta el id del especialista
			$usuarios = ORM ::for_table('usuarios')	
					->select('usuarios.*')
					->where('empleado', $tickets->id_especialista)			
					->find_one();	

				if($usuarios)
					$nombre_especialista = $usuarios->nombre . " " . $usuarios->paterno;
				else
					$nombre_especialista = " ";

		 //Consulta la info del usuario creacion
			$uc = ORM ::for_table('usuarios')	
				->select('usuarios.*')
				->where('empleado', $tickets->id_usuario)			
				->find_one();

				if($uc)
					$usuario_puesto = $uc->depto;
				else
					$usuario_puesto = "Desconocido";

		 //Consulta info categoria
			$categorias = ORM ::for_table('categorias')	
						->select('categorias.*')
						->where('id', $tickets->id_categoria)			
						->find_one();			

				if($categorias)
					$cat_nombre = $categorias->nombre;
				else
					$cat_nombre = " ";

		 //Consulta info subcategoria
			$subcategorias = ORM ::for_table('subcategorias')	
							->select('subcategorias.*')
							->where('id', $tickets->id_subcategoria)			
							->find_one();

				if($subcategorias)
					$subcat_nombre = $subcategorias->nombre;
				else
					$subcat_nombre = " ";			

	 	$response = array(
	 		'id' => $tickets->id,
	 		'id_reabierto' => $tickets->id_ticket_reabierto,
	 		'resumen' => $tickets->resumen,
	 		'detalle' => $tickets->detalle,
	 		'id_categoria' => $tickets->id_categoria,
	 		'categoria_nombre' => $cat_nombre,
	 		'id_subcategoria' => $tickets->id_subcategoria,
	 		'categorias_nombre' => $cat_nombre,
	 		'subcategorias_nombre' => $subcat_nombre,
	 		'estado' => $tickets->estado,
	 		'estado_e' => $tickets->estado_especialista,
	 		'estado_usuario' => $tickets->estado_usuario,
	 		'id_usuario' => $tickets->id_usuario,
	 		'puesto' => $uc->puesto,
	 		'nomina' => $uc->empleado,
	 		'email' => $uc->mail,
	 		'ip' => $uc->ip,
	 		'usuario_creacion' => $tickets->usuario_creacion,
	 		'usuario_puesto' => $usuario_puesto,
	 		'prioridad' => $tickets->prioridad,
	 		'tms_creacion' => $tickets->tms_creacion,
	 		'tms_deadline' => $tickets->tms_deadline,
	 		'tms_deadline' => $tickets->tms_deadline,
	 		'id_especialista' => $tickets->id_especialista,
	 		'nombre_especialista' => $nombre_especialista,
	 		'depto' => $tickets->depto,
	 		'archivo' => $tickets->archivo,
	 		'causa' => $tickets->causa,
	 		'medio' => $tickets->medio,
	 		'TV' => $uc->ID_TeamViewer
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
