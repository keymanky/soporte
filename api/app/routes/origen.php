 <?php

 $app->group('/causa', function () use ($app)	{

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

			$tickets = ORM::for_table('tickets')		
				->distinct()			 
				->select('causa')
				->where_lte('tms_creacion', date('Y-m-d', strtotime($ff . '+ 1 days')) )
				->where_gte('tms_creacion', $fi)			
				->find_many();

				$response = array();	
		 		foreach ($tickets as $key => $value) {
					$causas = ORM::for_table('tickets')				 
						->select('causa')			 
						->where('causa',$value->causa)
						->where_lte('tms_creacion', date('Y-m-d', strtotime($ff . '+ 1 days')) )
						->where_gte('tms_creacion', $fi)						
						->find_many();
					$tmp = array (
						'causa' => $value->causa,
						'numero' => count($causas)
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
