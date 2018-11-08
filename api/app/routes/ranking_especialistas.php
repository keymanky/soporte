 <?php

 $app->group('/ranking_especialistas', function () use ($app)	{

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

			$respuestas = ORM::for_table('respuesta')		
				->distinct()
				->select('id_Especialista')
				->where_lte('tms_creacion', date('Y-m-d', strtotime($ff . '+ 1 days')) )
				->where_gte('tms_creacion', $fi)			
				->find_many();

				// $response = array (
				// 	'respuestas' => count($respuestas)
				// );		

				$response = array();
					
		 		foreach ($respuestas as $key => $value) {

					$ranking = ORM::for_table('respuesta')
						->select('respuesta')
						->select('peso')
						->select('id_Especialista')
					 	->select('usuarios.nombre', 'un')
					 	->select('usuarios.paterno', 'up')					 	
						->join('usuarios',array('respuesta.id_especialista','=','usuarios.empleado'))
						->where('id_Especialista', $value->id_Especialista)						
						->where_lte('tms_creacion', date('Y-m-d', strtotime($ff . '+ 1 days')) )
						->where_gte('tms_creacion', $fi)			
						->find_many();

						$i =0;
						$n = count($ranking);
						$calificacion = 0;

						for ($i=0; $i < $n ; $i++) {
							$tmp = $ranking[$i]->respuesta * $ranking[$i]->peso;
							$calificacion = $calificacion + $tmp;
						}					

						$tmp = array (
							'especialista' => $ranking[0]->un . " " . substr($ranking[0]->up, 0,1),
							'calificacion' => $calificacion
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
