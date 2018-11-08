 <?php

 $app->group('/x_especialista', function () use ($app)	{
 	
 		//Retorna el conteo de asignaciones que hayan pasado de tiempo de acuerdo a la prioridad del ticket

		$app->post('/', function () use ($app) {


			$rules=array(
				'ff' =>array(false, "string", 1, 99),
				'fi' =>array(false, "string", 1, 99),		 			 		
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

			//Transformar la fecha de formado MM/DD/AAAA a AAAA-MM-DD
			$fi = substr($params['fi'], -4) . "-" . substr($params['fi'], 0, 2) . "-" . substr($params['fi'], 3, 2);	
			$ff = substr($params['ff'], -4) . "-" . substr($params['ff'], 0, 2) . "-" . substr($params['ff'], 3, 2);	



			//Consulta todos los especialistas
			$usuarios = ORM::for_table('usuarios')			 
				->select('empleado')
				->select('nombre')
				->select('paterno')
				->where('id_departamento','7')				
				->find_many();

			$response = array();

	 		foreach ($usuarios as $key => $value) {

				//Consulta las asignaciones
				$tickets = ORM::for_table('tickets')
					->select('tickets.*')
					->where('id_especialista', $value->empleado)
					->where_lte('tms_creacion', date('Y-m-d', strtotime($ff . '+ 1 days')) )
					->where_gte('tms_creacion', $fi)
					->find_many();

					$tmp = array (
						'especialista' => $value->nombre . " " . $value->paterno,
						'finalizados' => count($tickets),
						'id_especialista' => $value->empleado,
					);
					$response[] = $tmp;

			}

			/*Respuesta del servicio*/
			$app->response->setBody(json_encode($response));
			$app->response->setStatus(200);
			$app->stop();

		});

		/*Respuesta del get*/
		$app->options('/', function () use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	
});
?>