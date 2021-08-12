<?php
require_once($CFG->libdir . "/externallib.php");
require_once('../../config.php');
class block_cmi_diplomado extends external_api
{
    public static function set_roles_parameters()
    {
        return new external_function_parameters(
            array(
                'users' => new external_multiple_structure(
                    new external_single_structure(
                        array(
                            'username' => new external_value(PARAM_TEXT,'USERNAME'),
                            'firstname' => new external_value(PARAM_TEXT,'FISTNAME'),
                            'lastname' => new external_value(PARAM_TEXT,'LASTNAME'),
                            'email' => new external_value(PARAM_TEXT,'EMAIL'),
                            'department' => new external_value(PARAM_TEXT,'DEPARTMENT', VALUE_OPTIONAL),
                            'posicion' => new external_value(PARAM_TEXT,'POSITION', VALUE_OPTIONAL),
                            'unidad' => new external_value(PARAM_TEXT,'UNIDAD', VALUE_OPTIONAL),
                            'centrocosto' => new external_value(PARAM_TEXT,'CENTROCOSTO', VALUE_OPTIONAL),
                            'jefeinmediato' => new external_value(PARAM_TEXT,'JEFEINMEDIATO', VALUE_OPTIONAL),
                            'fecha' => new external_value(PARAM_INT,'FECHA', VALUE_OPTIONAL),
                            'status' => new external_value(PARAM_INT,'STATUS', VALUE_OPTIONAL),

                        )
                    )
                )
            )
        );
    }

    public static function set_roles($data)
    {
        global $DB, $CFG;
        $params = self::validate_parameters(self::set_roles_parameters(), array('users'=>$data));

        foreach($data as $dt )
        {
            $error = array(
                'error' => 0,
                'username' => $dt["username"],
                'mensaje' => ''
            );

            $user = $DB->get_record('user', array('username' => $dt["username"]));
                        if(!$user)
                        {
                             $user = create_user_record($dt["username"], 'CMI123', $auth = 'manual');
                             if(!$user)
                             return json_encode(array(
                                 'error' => 1,
                                 'username' => $dt["username"],
                                 'mensaje' => 'Error al crear el usuario'
                             ));
                        }

                $user->firstname = $dt["firstname"];
                $user->lastname = $dt["lastname"];
                $user->email = $dt["email"];
                if($dt["department"]) $user->department = $dt["department"];
                if($dt["status"]) $user->suspended = $dt["status"];
                $user->timemodified = time();

                update_user_record($user->username);
                $personalizados->id=$user->id;
                if($dt["posicion"]){
                  $campo=$DB->get_record('user_info_data', array('fieldid' =>"5",'userid' =>$user->id));
                    if($campo){
                      $campo->data=$dt["posicion"];
                      $actualizar=$DB->update_record('user_info_data', $campo);
                      if( !$actualizar)
                      return json_encode(array(
                          'error' => 1,
                          'username' => $dt["username"],
                          'mensaje' => 'Error al actualizar la posición'
                      ));
                    }else{
                      $campo = new stdClass;
                      $campo->userid=$user->id;
                      $campo->fieldid='35';
                      $campo->data=$dt["posicion"];
                      $campo->dataformat='0';
                      $id = $DB->insert_record('user_info_data', $campo);
                      if( !$id )
                      return json_encode(array(
                          'error' => 0,
                          'username' => $dt["username"],
                          'mensaje' => 'Error al insertar la nueva posición'
                      ));
                    }

                  }
                  if($dt["unidad"]){
                    $campo=$DB->get_record('user_info_data', array('fieldid' =>"1",'userid' =>$user->id));
                      if($campo){
                        $campo->data=$dt["unidad"];
                        $actualizar=$DB->update_record('user_info_data', $campo);
                        if( !$actualizar)
                        return json_encode(array(
                            'error' => 1,
                            'username' => $dt["username"],
                            'mensaje' => 'Error al actualizar la unidad'
                        ));
                      }else{
                        $campo = new stdClass;
                        $campo->userid=$user->id;
                        $campo->fieldid='1';
                        $campo->data=$dt["unidad"];
                        $campo->dataformat='0';
                        $id = $DB->insert_record('user_info_data', $campo);
                        if( !$id )
                        return json_encode(array(
                            'error' => 0,
                            'username' => $dt["username"],
                            'mensaje' => 'Error al insertar la nueva unidad'
                        ));
                      }

                    }
                    if($dt["centrocosto"]){
                      $campo=$DB->get_record('user_info_data', array('fieldid' =>"2",'userid' =>$user->id));
                        if($campo){
                          $campo->data=$dt["centrocosto"];
                          $actualizar=$DB->update_record('user_info_data', $campo);
                          if( !$actualizar)
                          return json_encode(array(
                              'error' => 1,
                              'username' => $dt["username"],
                              'mensaje' => 'Error al actualizar el centro costo'
                          ));
                        }else{
                          $campo = new stdClass;
                          $campo->userid=$user->id;
                          $campo->fieldid='2';
                          $campo->data=$dt["centrocosto"];
                          $campo->dataformat='0';
                          $id = $DB->insert_record('user_info_data', $campo);
                          if( !$id )
                          return json_encode(array(
                              'error' => 0,
                              'username' => $dt["username"],
                              'mensaje' => 'Error al insertar el nuevo centro costo'
                          ));
                        }

                      }
                      if($dt["jefeinmediato"]){
                        $campo=$DB->get_record('user_info_data', array('fieldid' =>"3",'userid' =>$user->id));
                          if($campo){
                            $campo->data=$dt["jefeinmediato"];
                            $actualizar=$DB->update_record('user_info_data', $campo);
                            if( !$actualizar)
                            return json_encode(array(
                                'error' => 1,
                                'username' => $dt["username"],
                                'mensaje' => 'Error al actualizar el jefe inmediato'
                            ));
                          }else{
                            $campo = new stdClass;
                            $campo->userid=$user->id;
                            $campo->fieldid='3';
                            $campo->data=$dt["jefeinmediato"];
                            $campo->dataformat='0';
                            $id = $DB->insert_record('user_info_data', $campo);
                            if( !$id )
                            return json_encode(array(
                                'error' => 0,
                                'username' => $dt["username"],
                                'mensaje' => 'Error al insertar el jefe inmediato'
                            ));
                          }

                        }
                        if($dt["fecha"]){
                          $campo=$DB->get_record('user_info_data', array('fieldid' =>"6",'userid' =>$user->id));
                            if($campo){
                              $campo->data=$dt["fecha"];
                              $actualizar=$DB->update_record('user_info_data', $campo);
                              if( !$actualizar)
                              return json_encode(array(
                                  'error' => 1,
                                  'username' => $dt["username"],
                                  'mensaje' => 'Error al actualizar la fecha'
                              ));
                            }else{
                              $campo = new stdClass;
                              $campo->userid=$user->id;
                              $campo->fieldid='6';
                              $campo->data=$dt["fecha"];
                              $campo->dataformat='0';
                              $id = $DB->insert_record('user_info_data', $campo);
                              if( !$id )
                              return json_encode(array(
                                  'error' => 0,
                                  'username' => $dt["username"],
                                  'mensaje' => 'Error al insertar la fecha'
                              ));
                            }

                          }


                $actualizar=$DB->update_record('user', $user);
                if( !$actualizar)
                return json_encode(array(
                    'error' => 1,
                    'username' => $dt["username"],
                    'mensaje' => 'Error al actualizar el usuario'
                ));
    }
    header('Content-Type: application/json');
    return json_encode(array(
        'error' => 0,
        'mensaje' => 'Tarea realizada satisfactoriamente'
    ));
  }
  public static function set_roles_returns()
  {
      return new external_value(PARAM_RAW, "Boolean value if has an error");
  }

  public static function get_curso_estatus_parameters()
  {
    return new external_function_parameters(
            array('date' => new external_value(PARAM_INT, 'Fecha de inicio o modificación de curso'))
    );
  }

  /****
   ** Campos que se deben retornar
      Nombre del curso finalizado
      Codigo Curso
      Nota obtenida
      Fecha de inicio y fecha fin del curso
      Estado del curso
  *****/
  public static function get_curso_estatus($data = null)
  {
    global $DB, $CFG;
    require_once($CFG->libdir.'/gradelib.php');
    require_once("$CFG->dirroot/grade/querylib.php");
    //$params = self::validate_parameters(self::set_roles_parameters(), array('enrolments'=>$data));
    $params = self::validate_parameters(self::get_curso_estatus_parameters(),
      array('date' => $data));
    $date = "";
    if( $data )
    {

      $date = "WHERE id IN ( SELECT courseid FROM {grade_items} gi INNER JOIN {grade_grades} gg WHERE gg.timemodified >= $data )
        OR id IN ( SELECT courseid FROM {enrol}  e INNER JOIN {user_enrolments} ue ON e.id = ue.enrolid WHERE ue.timecreated >= $data )
      ";
    }

    $query = "SELECT * from {course} $date";
    $courselist = $DB->get_records_sql($query);
    $cursos = array();
    foreach($courselist as $key => $curso)
    {
      $context = get_context_instance(CONTEXT_COURSE, $key);

      $stQuery = "SELECT u.*, ue.status, ue.timestart, ue.timeend, e.status as 'estatus', cc.timecompleted
        FROM {user} u
        INNER JOIN {user_enrolments} ue ON u.id = ue.userid
        INNER JOIN {enrol} e ON ue.enrolid = e.id
        LEFT JOIN {grade_grades} gg ON u.id = gg.userid
        LEFT JOIN {grade_items} gi ON gg.itemid = gi.id AND gi.courseid = $key
        LEFT join {course_completions} cc ON u.id = cc.userid and e.courseid=cc.course
        WHERE e.courseid = $key AND ( gg.timemodified >= $data OR ue.timecreated >= $data ) ";

      $students = $DB->get_records_sql($stQuery);

      if( $students )
      {
        $cursos[$key] = array(
          'id' => $key,
          'fullname' => $curso->fullname,
          'shortname' => $curso->idnumber,
          "startdate" => $curso->startdate,
          "enddate" => $curso->enddate,
          "students" => array()
        );
        foreach($students as $user)
        {
          $grade = grade_get_course_grade($user->id);

          $status = "En Proceso";
          // tc = tareas curso
          $tc = $DB->get_record_sql("Select count(id)as num,course from {course_completion_criteria} where course = $key group by course");
          // tu = tareas usuario
          $tu = $DB->get_record_sql("Select userid,course,count(id)as num from {course_completion_crit_compl} where course = $key AND userid = $user->id  group by course, userid");

          if( $tu->num == 0) $status = "Asignado";
          if( $tu->num == $tc->num ) $status = "Finalizado";

          $cursos[$key]["students"][] = array(
            'id' => $user->id,
            'username' => $user->username,
            'grade' => $grade[$key]->grade,
            'status' => $status,
            'timestart' => $user->timestart,
            'timecompleted' => $user->timecompleted
          );
        }
      }
    }
    $dataCurso = array( "cursos" => array_values($cursos));
    $json = json_encode($dataCurso,JSON_UNESCAPED_UNICODE);
    echo stripslashes($json);
    die();
  }

  public static function get_curso_estatus_returns()
  {
      return new external_value(PARAM_RAW, "Boolean value if has an error", VALUE_OPTIONAL);
  }
}
