 <?php

 $app->group('/tickest_levantados_dia', function () use ($app)	{

		$app->get('/', function () use ($app) {

		$fecha = time();	
		$inicio_anio = 2012;
		$fin_anio = intval(date("Y"));

		$inicio_mes = 9;
		$fin_mes = intval(date("n"));

		$response = array();

		for ($i=$inicio_anio; $i <= $fin_anio ; $i++) { 

			if($i == $fin_anio)
				$limite = $fin_mes;
			else
				$limite =12;

			if($i == $inicio_anio)
				$inicio = $inicio_mes;
			else
				$inicio = 1;

			for ($j=$inicio ; $j <= $limite ; $j++) {
				if($j == $limite) 
					$max_dias = intval(date("j"));
				else
					$max_dias = cal_days_in_month(CAL_GREGORIAN, $j, $i);
				for ($k=1; $k <= $max_dias; $k++) { 
					if(strlen($k) == 1)
						$k = "0" . $k;
					if(strlen($j) == 1)
						$j = "0" . $j;	
					$tickets = ORM::for_table('tickets')				 
						->select('tickets.id')
						->where_like('tms_creacion', '%' . $i . '-' . $j . '-' . $k .'%')
						->find_many();	
					$dato  = array();
					$dato[0] = "Date.UTC(" . $i . "," . $j . "," . $k . ")";
					$dato[1] = count($tickets);
					array_push($response,$dato);
				}
			}
		}

			/*Respuesta del servicio*/
			$app->response->setBody(json_encode($response));			
			$app->response->setStatus(200);
			$app->stop();

		});

		/*Respuesta del get id*/
		$app->options('', function () use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	

});
?>
