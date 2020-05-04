<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /**
    *Create
    *Read
    *Update
    *Delete
    **/

    class Querys extends CI_Model {

      //--->
      function proveedoresCreate(){
          $data = array(
              'id_advance' => random_string('sha1', 20),
              'time'       => date("Y-m-d H:m:s"),
              'activo'     => "true",
              'email'      => $_POST['email'],
              'firstname'  => $_POST['first'],
              'secondname' => $_POST['second'],
              'telefono'   => $_POST['tel']
          );
          $this->db->insert('proveedores', $data);
            //return $status;
            $status = "[OK: 1]";
            return    $status;
          }
      //--->
      //--->

        //--->
        function proveedoresRead($id_advance,$all){

            //---A)
            $this->db->select('
            `proveedores`.id_advance,
            `proveedores`.time,
            `proveedores`.email,
            `proveedores`.firstname,
            `proveedores`.secondname,
            `proveedores`.telefono,
                ');
            $this->db->from('proveedores');

            /*all o single*/
            if ($all == true) {

                $this->db->where('proveedores.`activo`','true');

                }else{

                    $this->db->where('proveedores.`id_advance`',$id_advance);
                    $this->db->where('proveedores.`activo`','true');

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
        function proveedoresUpdate(){

          $data = array(
            'email'      => $_POST['email'],
            'firstname'  => $_POST['first'],
            'secondname' => $_POST['second'],
            'telefono'   => $_POST['tel'],
              );

                    $this->db->where('id_advance',$_POST['id_advance']);
                    $this->db->update('proveedores', $data);

                      //return $status;
                      $status = "[OK: 1]";
                      return    $status;
          }
          //--->

        function proveedoresDelete(){

              $data = array('activo'=> 'false');

                $this->db->where('id_advance',$_POST['id_advance']);
                $this->db->update('proveedores', $data);

                    //return $status;
                    $status = "[OK: 1]";
                    return    $status;
            }
        //--->

        }
/* End of file database.php */
