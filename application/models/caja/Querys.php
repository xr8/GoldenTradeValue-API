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

        if($_POST['cajaTipo'] == 'inicial'){

            $data0 = array(
                'id_advance'        => random_string('sha1', 20),
                'time'              => $date,
                'cajaIdAdvance'     => $_POST['cajaIdAdvance'],
                'cajaNuevaFecha'    => $_POST['cajaNuevaFecha'],
                'cajaResult'        => $_POST['cajaResult'],
                'cajaConcepto'      => $_POST['cajaConcepto'],
                'cajaNotas'         => $_POST['cajaNotas'],
                'cajaTipo'          => $_POST['cajaTipo'],
                'cajaEntrada'       => '0',
                'cajaSalida'        => '0',
                'cajaSaldo'         => $_POST['cajaMonto'],
                'cajaMonto'         => $_POST['cajaMonto'],
                'cajaNoCompra'      => $_POST['cajaNoCompra'],
                'cajaTotalMBData'   => $_POST['cajaTotalMBData']
            );

        }else if($_POST['cajaTipo'] == 'entrada'){

            $data0 = array(
                'id_advance'        => random_string('sha1', 20),
                'time'              => $date,
                'cajaIdAdvance'     => $_POST['cajaIdAdvance'],
                'cajaNuevaFecha'    => $_POST['cajaNuevaFecha'],
                'cajaResult'        => $_POST['cajaResult'],
                'cajaConcepto'      => $_POST['cajaConcepto'],
                'cajaNotas'         => $_POST['cajaNotas'],
                'cajaTipo'          => $_POST['cajaTipo'],
                'cajaEntrada'       => $_POST['cajaMonto'],
                'cajaSalida'        => '0',
                'cajaSaldo'         => '0',
                'cajaMonto'         => $_POST['cajaMonto'],
                'cajaNoCompra'      => $_POST['cajaNoCompra'],
                'cajaTotalMBData'   => $_POST['cajaTotalMBData']
            );

        }else if($_POST['cajaTipo'] == 'salida'){

            $data0 = array(
                'id_advance'        => random_string('sha1', 20),
                'time'              => $date,
                'cajaIdAdvance'     => $_POST['cajaIdAdvance'],
                'cajaNuevaFecha'    => $_POST['cajaNuevaFecha'],
                'cajaResult'        => $_POST['cajaResult'],
                'cajaConcepto'      => $_POST['cajaConcepto'],
                'cajaNotas'         => $_POST['cajaNotas'],
                'cajaTipo'          => $_POST['cajaTipo'],
                'cajaEntrada'       => '0',
                'cajaSalida'        => $_POST['cajaMonto'],
                'cajaSaldo'         => '0',
                'cajaMonto'         => $_POST['cajaMonto'],
                'cajaNoCompra'      => $_POST['cajaNoCompra'],
                'cajaTotalMBData'   => $_POST['cajaTotalMBData']
            );

        }else{
        }

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
            `CajaEntradaSalida`.cajaIdAdvance,
            `CajaEntradaSalida`.cajaNuevaFecha,
            `CajaEntradaSalida`.cajaResult,
            `CajaEntradaSalida`.cajaConcepto,
            `CajaEntradaSalida`.cajaNotas,
            `CajaEntradaSalida`.cajaTipo,
            `CajaEntradaSalida`.cajaEntrada,
            `CajaEntradaSalida`.cajaSalida,
            `CajaEntradaSalida`.cajaSaldo,
            `CajaEntradaSalida`.cajaNoCompra,
            `CajaEntradaSalida`.cajaTotalMBData,
            `user`.user,
            `user`.email,
            `user`.firstname,
            `user`.secondname
        ');
        $this->db->from('CajaEntradaSalida');
        $this->db->join('user', 'CajaEntradaSalida.cajaIdAdvance = user.id_advance');
        $this->db->like('cajaNuevaFecha',$_GET['date']);
        $this->db->group_by('CajaEntradaSalida.time'); 

        /*all o single*/
        if ($all == true) {
        } elseif ($all == false) {
            //$this->db->where('caja.`id_advance`', $id_advance);
        }
        $this->db->order_by('`CajaEntradaSalida`.id', 'ASC');
        $this->db->order_by('`CajaEntradaSalida`.time', 'ASC');

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
    function utilityBuscarUser()
    {
        /*
            SELECT
            `user`.id,
            `user`.id_advance,
            `user`.activo,
            `user`.`user`,
            `user`.permissions,
            `user`.email,
            `user`.firstname,
            `user`.secondname
            FROM
            `user`
            WHERE
            `user`.`user` LIKE '%ad%' OR
            `user`.email LIKE '%XXX%' OR
            `user`.firstname LIKE '%xxx%' OR
            `user`.secondname LIKE '%xxx%'
            ORDER BY
            `user`.id ASC        
        */
        //----> user
        $this->db->select('
        `user`.id,
        `user`.id_advance,
        `user`.activo,
        `user`.`user`,
        `user`.permissions,
        `user`.email,
        `user`.firstname,
        `user`.secondname        
        ');

        $this->db->from('user');

        $this->db->or_like('user', $_GET['term']);
        $this->db->or_like('email', $_GET['term']);
        $this->db->or_like('firstname', $_GET['term']);
        $this->db->or_like('secondname', $_GET['term']);

        $this->db->order_by("id", "DESC");
        //----> user

        $query = $this->db->get();
        $row = $query->row_array();

        //---A)
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        } else {
            $data[] = array(
                    "Error"    => 101,
                    "Buscador" => "Error User"
                );
        }

        return $data;
    }
    //--->

    //--->
    function utilityBuscarClientes()
    {
        /*
            SELECT
            clientes.id,
            clientes.id_advance,
            clientes.email,
            clientes.firstname,
            clientes.secondname
            FROM
            clientes
            WHERE
            clientes.email LIKE '%@%'    
        */
        //----> user
        $this->db->select('
        `clientes`.id,
        `clientes`.id_advance,
        `clientes`.email,
        `clientes`.firstname,
        `clientes`.secondname     
        ');

        $this->db->from('clientes');

        $this->db->or_like('email', $_GET['term']);
        $this->db->or_like('firstname', $_GET['term']);
        $this->db->or_like('secondname', $_GET['term']);

        $this->db->order_by("id", "DESC");
        //----> user

        $query = $this->db->get();
        $row = $query->row_array();

        //---A)
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        } else {
            $data[] = array(
                    "Error"    => 101,
                    "Buscador" => "Error Clientes"
                );
        }

        return $data;
    }
    //--->

    //--->
    function utilityBuscarProveedor()
    {
        /*
            SELECT
            proveedores.id,
            proveedores.id_advance,
            proveedores.email,
            proveedores.firstname,
            proveedores.secondname
            FROM
            proveedores
            WHERE
            proveedores.email LIKE '%@%'    
        */
        //----> user
        $this->db->select('
        `proveedores`.id,
        `proveedores`.id_advance,
        `proveedores`.email,
        `proveedores`.firstname,
        `proveedores`.secondname     
        ');

        $this->db->from('proveedores');

        $this->db->or_like('email', $_GET['term']);
        $this->db->or_like('firstname', $_GET['term']);
        $this->db->or_like('secondname', $_GET['term']);

        $this->db->order_by("id", "DESC");
        //----> user

        $query = $this->db->get();
        $row = $query->row_array();

        //---A)
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        } else {
            $data[] = array(
                    "Error"    => 101,
                    "Buscador" => "Error Proveedor"
                );
        }

        return $data;
    }
    //--->  

    //--->
    function utilityUltimafecha()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        $this->db->select('
        `CajaEntradaSalida`.id,
        `CajaEntradaSalida`.id_advance,
        `CajaEntradaSalida`.time,
        `CajaEntradaSalida`.cajaNuevaFecha,
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
            $data = [
                "category"    => "Request",
                "description" => "Caja Utility Data",
                "id advance"  => $random,
                "date"        => $date,
                "http_code"   => 404,
                "code"        => 1001,
                "request"     => true,
                "request_id"  => $r_id
            ];            
        }

        return $data;
        
        
    }
    //--->    
    
}
/* End of file database.php */