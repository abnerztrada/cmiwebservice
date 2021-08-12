<?php
$functions = array(
    'block_cmi_usuarios' => array(
        'classname' => 'block_cmi_diplomado',
        'methodname' => 'set_roles',
        'classpath' => 'blocks/cmi/externallib.php',
        'description' => 'Añade un usuario a un curso y lo asigna a un grupo',
        'type' => 'write',
        'ajax' => false
    ),
    'block_cmi_get_curso_estatus' => array(
        'classname' => 'block_cmi_diplomado',
        'methodname' => 'get_curso_estatus',
        'classpath' => 'blocks/cmi/externallib.php',
        'description' => 'Obtiene el estado de los alumnos de los cursos',
        'type' => 'write',
        'ajax' => false
    )
);

$services = array(
    'servicio cmi' => array(
        'functions' => array(
          'block_cmi_set_roles',
          'block_cmi_get_curso_estatus'
        ),
        'restrictedusers' => 0,
        'enabled' => 1
    )
);
