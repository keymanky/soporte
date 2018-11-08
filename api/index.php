<?php
date_default_timezone_set('America/Mexico_City');
require 'app/lib/Slim/Slim.php';
require 'app/vendor/idiorm.php'; 
require 'app/lib/Validator.php';


\Slim\Slim::registerAutoloader();
$config = require 'config.php';

$app = new \Slim\Slim($config["slim"]);

ORM::configure('mysql:host=localhost;dbname=detexis_soporte;charset=utf8');
ORM::configure('username', 'soporte');
ORM::configure('password', 'Sb8XwRzw_Alfa1810');

ORM::configure('return_result_sets', true);
ORM::configure('id_column_overrides', array('usuarios'=> 'empleado'));
ORM::configure('id_column_overrides', array('tickets'=> 'id'));
ORM::configure('id_column_overrides', array('categorias'=> 'id'));
ORM::configure('id_column_overrides', array('subcategorias'=> 'id'));
ORM::configure('id_column_overrides', array('evento'=> 'id'));

// routes
require 'app/routes/r1.php';
require 'app/routes/usuario.php';
require 'app/routes/departamentos.php';
require 'app/routes/usuario_consulta.php';
require 'app/routes/nuevo_usuario.php';
require 'app/routes/passwordpp.php';
require 'app/routes/tickets_usuario.php';
require 'app/routes/tickets_abiertos.php';
require 'app/routes/ticket.php';
require 'app/routes/ticket_actualizado.php';
require 'app/routes/tickets_consulta.php';
require 'app/routes/tickets_depto.php';
require 'app/routes/categorias.php';
require 'app/routes/subcategorias.php';
require 'app/routes/subir.php';
require 'app/routes/contar.php';
require 'app/routes/asignados.php';
require 'app/routes/usuarios.php';
require 'app/routes/especialistas.php';
require 'app/routes/admin.php';
require 'app/routes/admin2.php';
require 'app/routes/admin3.php';
require 'app/routes/activar.php';
require 'app/routes/mail.php';
require 'app/routes/nueva_categoria.php';
require 'app/routes/nueva_subcategoria.php';
require 'app/routes/relacionar_categorias.php';
require 'app/routes/buscar.php';
require 'app/routes/buscar2.php';
require 'app/routes/cerrar.php';
require 'app/routes/cerrar_usuario.php';
require 'app/routes/asignar.php';
require 'app/routes/comentar.php';
require 'app/routes/consultar_eventos.php';
require 'app/routes/guardar_comentario.php';
require 'app/routes/actualizar_ticket.php';
require 'app/routes/tickets_levantados_dia.php';
require 'app/routes/reabrir.php';
require 'app/routes/resumen.php';
require 'app/routes/caducados.php';
require 'app/routes/caducados_en_vivo.php';
require 'app/routes/levantados.php';
require 'app/routes/origen.php';
require 'app/routes/asignados_y_caducados.php';
require 'app/routes/actualizar_ticket_causa.php';
require 'app/routes/ranking_especialistas.php';
require 'app/routes/x_especialista.php';

$app->contentType('application/json');

// CORS headers
$app->response->headers->set('Access-Control-Allow-Origin', '*');
$app->response->headers->set('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
$app->response->headers->set('Access-Control-Allow-Headers', 'X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version');

$app->run();