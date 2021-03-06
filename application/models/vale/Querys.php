<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Querys extends CI_Model
{

    function ValeCreate()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        $metales_pagos_data = array(
            'id_advance'            => random_string('sha1', 20),
            'detail_id_advance'     => $_POST['save_id_advance'],
            'detail_time_update'    => $_POST['generar_fecha_saldo'],
            'detail_saldo'          => $_POST['generar_saldo_saldo'],
            'detail_saldo_actual'   => $_POST['generar_saldo_saldo']
        );

        $this->db->insert('saldo',$metales_pagos_data);
        
        $status[] = array(
            "Time"       => $date,
            "Message"    => "Ok Create",
            "Code"       => 101,
            "Contorller" => "Saldo",
            "class"      => "saldo",
            "fuction"    => "createdata",
            "id"         => " "
        );
        
        return    $status;
    }

    function ValeRead()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);
      
        $status[] = array(
            "Time"       => $date,
            "Message"    => "Ok Reade",
            "Code"       => 101,
            "Contorller" => "readedata",
            "class"      => "Ok",
            "fuction"    => "Ok",
            "id"         => "Ok"
        );

        return  $data;
    }

    function ValeUpdate()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);


        $status[] = array(
            "Time"       => $date,
            "Message"    => "Ok Update",
            "Code"       => 101,
            "Contorller" => "Saldo",
            "class"      => "updatedata",
            "fuction"    => "Ok",
            "id"         => "Ok"
        );
        
        return    $status;
    }

    function ValeDelete()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);


        $status[] = array(
            "Time"       => $date,
            "Message"    => "Ok Update",
            "Code"       => 101,
            "Contorller" => "Saldo",
            "class"      => "updatedata",
            "fuction"    => "Ok",
            "id"         => "Ok"
        );
        
        return    $status;
    }

    function ValeActual()
    {
        $this->db->select('*');
        $this->db->from('vale');
        $this->db->limit(1); 
        //$this->db->order_by('id', 'ASC');
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        $row = $query->row_array();

        //---A)
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }

        } else {
            $data[] = array("Error"  => 104,"Caja" => "Error");
        }

        return  $data;
    }    
}
/* End of file database.php */