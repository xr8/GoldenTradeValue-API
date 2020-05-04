<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /**
    *Create
    *Read
    *Update
    *Delete
    **/

    class Querys extends CI_Model {

      //--->
      function clientesCreate(){
          $data = array(
              'id_advance' => random_string('sha1', 20),
              'time'       => date("Y-m-d H:m:s"),
              'activo'     => "true",
              'email'      => $_POST['email'],
              'firstname'  => $_POST['first'],
              'secondname' => $_POST['second'],
              'telefono'   => $_POST['tel']
          );
          $this->db->insert('clientes', $data);
            //return $status;
            $status = "[OK: 1]";
            return    $status;
          }
      //--->
      //--->

        //--->
        function clientesRead($id_advance,$all){

            //---A)
            $this->db->select('
            `clientes`.id_advance,
            `clientes`.time,
            `clientes`.email,
            `clientes`.firstname,
            `clientes`.secondname,
            `clientes`.telefono,
                ');
            $this->db->from('clientes');

            /*all o single*/
            if ($all == true) {

                $this->db->where('clientes.`activo`','true');

                }else{

                    $this->db->where('clientes.`id_advance`',$id_advance);
                    $this->db->where('clientes.`activo`','true');

                    }

                $query = $this->db->get();
                $row = $query->row_array();
            //---A)

                if ($query->num_rows() > 0) {
                    foreach ($query->result() as $row) {
                        $row->Message = "Datasuccessful";
                        $data[] = $row;
                        }
                        return $data;
                    }

        }
        //--->

        //--->
        function clientesUpdate(){

          $data = array(
            'email'      => $_POST['email'],
            'firstname'  => $_POST['first'],
            'secondname' => $_POST['second'],
            'telefono'   => $_POST['tel'],
              );

                    $this->db->where('id_advance',$_POST['id_advance']);
                    $this->db->update('clientes', $data);

                      //return $status;
                      $status = "[OK: 1]";
                      return    $status;
          }
          //--->

        function clientesDelete(){

              $data = array('activo'=> 'false');

                $this->db->where('id_advance',$_POST['id_advance']);
                $this->db->update('clientes', $data);

                    //return $status;
                    $status = "[OK: 1]";
                    return    $status;
            }
        //--->

        }
/* End of file database.php */
