<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /**
    *
    *
    *
    *
    *
    **/

    class Model_log extends CI_Model {

        //--->
        function logNew(){
          /*
          $response = file_get_contents('http://worldtimeapi.org/api/timezone/America/Mexico_City');

            $obj = json_decode($response);

              $data['time']       = $obj->{'datetime'};
              */
              $data['time']       = date('Y-m-d H:m:s');
              $data['id_advance'] = random_string('alpha', 20);

                $this->db->insert('log', $data);

                //$status['message'] = "worldtimeapi";
                $status['message'] = "date php";
                  return    $status;
              }
        //--->

        }
/* End of file database.php */
