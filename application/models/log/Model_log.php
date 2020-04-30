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
            SQL
            INSERT INTO `log` (`id_advance`) VALUES ('134365578098ouikgtdf')
            */

            $response = file_get_contents('http://worldtimeapi.org/api/timezone/America/Mexico_City');      
            $obj = json_decode($response);

            $data['id_advance'] = random_string('alpha', 20);
            $data['time']       = $obj->{'datetime'};
            
                $this->db->insert('log', $data);

                    $status = "[OK: new record log]";
                    return    $status;
              }
        //--->

        }
/* End of file database.php */
