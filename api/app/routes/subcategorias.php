
 <?php

 $app->group('/subcategorias', function () use ($app)	{

		$app->get('/:id', function ($id) use ($app) {

			if($id > 0){
				/*Consulta a la base*/
				$sub = ORM::for_table('subcategorias')		
					->where('id_categoria',$id)						
					->find_many();
			}else{
				/*Consulta a la base*/
				$sub = ORM::for_table('subcategorias')							
					->find_many();
			}

			$response = array();	
	 		foreach ($sub as $key => $value) {
				$tmp = array(
					'id'     => $value->id,
					'id_categoria' => $value->id_categoria,
					'nombre' => $value->nombre
				);
				$response[] = $tmp; 
	 		}

			if(empty($response)){
				$response = array (
					'mensaje' => "Sin subcategorias definidas"
				);
			}
			/*Respuesta del servicio*/
			$app->response->setBody(json_encode($response));			
			$app->response->setStatus(200);
			$app->stop();

		});

		/*Respuesta del get id*/
		$app->options('/subcategorias', function ($id) use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	
		
});
?>
