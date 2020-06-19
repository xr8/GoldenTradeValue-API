<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *Create
 *Read
 *Update
 *Delete
 **/

class Querys extends CI_Model
{

    //--->
    function cajaCreate()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        $data0 = array(
            'id_advance'        => random_string('sha1', 20),
            'time'              => $date,
            'fecha'             => date("Y-m-d", strtotime($_POST['fecha'])),
            'origen_id_advance' => $_POST['origen_id_advance'],
            'saldo'             => $_POST['saldo'],
            'entrada'           => $_POST['entrada'],
            'salida'            => $_POST['salida'],
            'nocompra'          => $_POST['nocompra'],
            'concepto'          => $_POST['concepto'],
            'totalbilletes'     => $_POST['totalbilletes'],
            'notas'             => $_POST['notas'],
            'tipo'              => $_POST['tipo']
        );

        $this->db->insert('CajaEntradaSalida', $data0);

        //return $status;
        $status = [
            "category"    => "Request",
            "description" => "Create Caja New",
            "id advance"  => $random,
            "date"        => $date,
            "http_code"   => 404,
            "code"        => 1001,
            "request"     => true,
            "request_id"  => $r_id
        ];

        return    $status;
        
    }
    //--->

    //--->
    function cajaRead($id_advance, $all, $date)
    {
        //print $date;
        //---A)
        /*
        {
        "id": "1",
        "id_advance": "acc679a1caa70a1e8dda",
        "time": "2020-06-08 12:00:00",
        "fecha": "2020-01-08",
        "origen_id_advance": "rwzr8h0iji96crde4",
        "saldo": "777971.01",
        "entrada": "0.00",
        "salida": "0.00",
        "nocompra": "0",
        "concepto": "CORTE AL DIA\n",
        "totalbilletes": "0",
        "notas": "0",
        "rs_fecha": "2020-01-08",
        "Message": "Datasuccessful"
        }
        */
        $this->db->select('
        `CajaEntradaSalida`.id_advance,
        `CajaEntradaSalida`.origen_id_advance,
        `CajaEntradaSalida`.fecha,
        `CajaEntradaSalida`.entrada,
        `CajaEntradaSalida`.salida,
        `CajaEntradaSalida`.saldo,
        `CajaEntradaSalida`.nocompra,
        `CajaEntradaSalida`.concepto,
        `CajaEntradaSalida`.totalbilletes,
        `CajaEntradaSalida`.notas,
        `CajaEntradaSalida`.tipo,
        ');
        $this->db->from('CajaEntradaSalida');
        $this->db->like('fecha',$_GET['date']);

        /*all o single*/
        if ($all == true) {
        } elseif ($all == false) {
            //$this->db->where('caja.`id_advance`', $id_advance);
        }
        $this->db->order_by("id", "ASC");
        $this->db->order_by("fecha", "ASC");

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

        return $data;
    }
    //--->

    //--->
    function proveedoresUpdate()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        /*
        Array ( 
            [id_advance] => 0f9385c23d1d5825d266 

            [rfc1] => 3 
            [pais1] => 3 
            [giro1] => 3 

            [first] => viernes3 
            [second] => gomez3 
            [email] => viernes@gomez.com3 
            [tel] => 55111122223 
            [rfc] => SAOK790530QZ23 
            [curp] => BEML920313HMCLNS093 
            [direccion] => Av. Paseo de la Reforma No 347, Cuauhtémoc, CP 06500 Ciudad de México, CDMX3 )        

        */
        $data0 = array(
            'firstname'  => $_POST['first'],
            'secondname' => $_POST['second'],
            'email'      => $_POST['email'],
            'telefono'   => $_POST['tel'],
            'rfc'        => $_POST['rfc'],
            'curp'       => $_POST['curp'],
            'direccion'  => $_POST['direccion']
        );

        $this->db->where('id_advance', $_POST['id_advance']);
        $this->db->update('proveedores', $data0);

        $data1 = array(
            'rfc'         => $_POST['rfc1'],
            'pais'        => $_POST['pais1'],
            'giro'        => $_POST['giro1'],
            'fechaconsti' => $_POST['fecha1']
        );
        $this->db->where('id_advance_origen', $_POST['id_advance']);
        $this->db->update('razonsocial', $data1);

        //return $status;
        $status = [
            "category"    => "Request",
            "description" => "Update Proveedores New",
            "id advance"  => $random,
            "date"        => $date,
            "http_code"   => 404,
            "code"        => 1001,
            "request"     => true,
            "request_id"  => $r_id
        ];

        return    $status;
    }
    //--->

    function proveedoresDelete()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        $data = array('activo' => 'false');

        $this->db->where('id_advance', $_POST['id_advance']);
        $this->db->update('proveedores', $data);

        //return $status;
        $status = [
            "category"    => "Request",
            "description" => "Delete Proveedores",
            "id advance"  => $random,
            "date"        => $date,
            "http_code"   => 404,
            "code"        => 1001,
            "request"     => true,
            "request_id"  => $r_id
        ];
        return    $status;
    }
    //--->

    //--->
    function utilityTotal()
    {

        $this->db->select('`CajaEntradaSalida`.id_advance,`CajaEntradaSalida`.saldo');
        $this->db->from('CajaEntradaSalida');
        $this->db->order_by("id", "desc");
        $this->db->limit("1");

        $query = $this->db->get();
        $row = $query->row_array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        } else {
            $data[] = array("Error"  => 104);
        }

        return $data;
    }
    //--->

    //--->
    function utilityBuscar()
    {

        $this->db->select('
        `clientes`.id_advance,
        `clientes`.firstname,
        `clientes`.secondname,
        ');
        $this->db->from('clientes');
        $this->db->like('firstname', $_GET['term']);

        $query = $this->db->get();
        $row = $query->row_array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->nombre = "Datasuccessful";
                $data[] = $row;
            }
        } else {
            $data[] = null;
        }

        return $data;
    }
    //--->
    
    //--->
    function utilityUltimafecha()
    {


        $this->db->select('
        `CajaEntradaSalida`.id,
        `CajaEntradaSalida`.id_advance,
        `CajaEntradaSalida`.time,
        `CajaEntradaSalida`.fecha,
        ');
        $this->db->from('CajaEntradaSalida');
        $this->db->order_by("id", "DESC");
        $this->db->limit(1); 

        $query = $this->db->get();
        $row = $query->row_array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        } else {
            $data[] = null;
        }

        return $data;
        
        
    }
    //--->    
    
}
/* End of file database.php */