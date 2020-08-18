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
                'idoperacion'       => $_POST['idOperacion'],
                'cajaIdAdvance'     => $_POST['cajaIdAdvance'],
                'cajaResult'        => $_POST['cajaResult'],
                'cajaNuevaFecha'    => $_POST['cajaNuevaFecha'],
                'cajaConcepto'      => $_POST['cajaConcepto'],
                'cajaNotas'         => $_POST['cajaNotas'],
                'cajaTipo'          => $_POST['cajaTipo'],
                'cajaEntrada'       => '0',
                'cajaSalida'        => '0',
                'cajaSaldo'         => $_POST['cajaMonto'],
                'cajaMonto'         => $_POST['cajaMonto']
            );

        }else if($_POST['cajaTipo'] == 'entrada'){

            $data0 = array(
                'id_advance'        => random_string('sha1', 20),
                'time'              => $date,
                'idoperacion'       => $_POST['idOperacion'],
                'cajaIdAdvance'     => $_POST['cajaIdAdvance'],
                'cajaResult'        => $_POST['cajaResult'],
                'cajaNuevaFecha'    => $_POST['cajaNuevaFecha'],
                'cajaConcepto'      => $_POST['cajaConcepto'],
                'cajaNotas'         => $_POST['cajaNotas'],
                'cajaTipo'          => $_POST['cajaTipo'],
                'cajaEntrada'       => $_POST['cajaMonto'],
                'cajaSalida'        => '0',
                'cajaSaldo'         => '0',
                'cajaMonto'         => $_POST['cajaMonto']
            );

        }else if($_POST['cajaTipo'] == 'salida'){

            $data0 = array(
                'id_advance'        => random_string('sha1', 20),
                'time'              => $date,
                'idoperacion'       => $_POST['idOperacion'],
                'cajaIdAdvance'     => $_POST['cajaIdAdvance'],
                'cajaResult'        => $_POST['cajaResult'],
                'cajaNuevaFecha'    => $_POST['cajaNuevaFecha'],
                'cajaConcepto'      => $_POST['cajaConcepto'],
                'cajaNotas'         => $_POST['cajaNotas'],
                'cajaTipo'          => $_POST['cajaTipo'],
                'cajaEntrada'       => '0',
                'cajaSalida'        => $_POST['cajaMonto'],
                'cajaSaldo'         => '0',
                'cajaMonto'         => $_POST['cajaMonto']
            );

        }else{}

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
        
 
        $this->db->select('
            `CajaEntradaSalida`.id,    
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
            `CajaEntradaSalida`.cajaTotalMBData
        ');
        
        $this->db->from('CajaEntradaSalida');
        $this->db->where_not_in('`CajaEntradaSalida`.cajaTipo','cancelado');                   
        //$this->db->select('`user`.user');
        //$this->db->join('user', 'CajaEntradaSalida.cajaResult = user.id_advance');
        
        $this->db->like('cajaNuevaFecha',$_GET['date']);
        //$this->db->group_by('CajaEntradaSalida.time'); 

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
               
                $xxx = explode('-',$row->cajaResult);
                $id_advance_x = $row->cajaResult;

                if($xxx[0]      == "U"){
                    //--------------->
                    $this->db->select('`user`.`firstname`,`user`.`secondname`');
                    $this->db->from('user');
                    $this->db->where('user.`id_advance`',$row->cajaResult);                   
                    $query2 = $this->db->get();
                    $row2 = $query2->row_array();
                    if ($query2->num_rows() > 0) {
                        foreach ($query2->result() as $row2) {
                            $data2 = $row2;
                        }
                    }
                    //--------------->
                }elseif($xxx[0] == "C"){
                    //--------------->
                    $this->db->select('`clientes`.`firstname`,`clientes`.`secondname`');
                    $this->db->from('clientes');
                    $this->db->where('clientes.`id_advance`',$row->cajaResult);                   
                    $query2 = $this->db->get();
                    $row2 = $query2->row_array();
                    if ($query2->num_rows() > 0) {
                        foreach ($query2->result() as $row2) {
                            $data2 = $row2;
                        }
                    }
                    //--------------->
                }elseif($xxx[0] == "P"){
                    //--------------->
                    $this->db->select('`proveedores`.`firstname`,`proveedores`.`secondname`');
                    $this->db->from('proveedores');
                    $this->db->where('proveedores.`id_advance`',$row->cajaResult);                   
                    $query2 = $this->db->get();
                    $row2 = $query2->row_array();
                    if ($query2->num_rows() > 0) {
                        foreach ($query2->result() as $row2) {
                            $data2 = $row2;
                        }
                    }
                    //--------------->
                }
                
                $row->usuarioNombre = $data2;
                $data[] = $row;
            }        
        
        } else {
            $data[] = array("Error"  => 104,"Caja" => "Error");
        }

        return  $data;
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

    function cajaDelete()
    {
        /**
        *   UPDATE CajaEntradaSalida
        *   SET cajaTipo = "cancelado"
        *   WHERE
        *   id_advance = "27786bc5d1e471a691e3"
        */        
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        $data = array('cajaTipo' => 'cancelado');
        $this->db->where('id_advance', $_POST['id_advance']);
        $this->db->update('CajaEntradaSalida', $data);

        //return $status;

        $status = [
            "category"    => "Request",
            "description" => "Delete Caja",
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
 
    //--->
    function utilityCancelados($id_advance, $all,$date )
    {
        $this->db->select('
            `CajaEntradaSalida`.id,    
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
            `CajaEntradaSalida`.cajaTotalMBData
        ');
        
        $this->db->from('CajaEntradaSalida');
        $this->db->where_not_in('`CajaEntradaSalida`.cajaTipo','entrada');
        $this->db->where_not_in('`CajaEntradaSalida`.cajaTipo','salida');
        $this->db->where_not_in('`CajaEntradaSalida`.cajaTipo','inicial');
        //$this->db->select('`user`.user');
        //$this->db->join('user', 'CajaEntradaSalida.cajaResult = user.id_advance');
        
        $this->db->like('cajaNuevaFecha',$_GET['date']);
        //$this->db->group_by('CajaEntradaSalida.time'); 

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
               
                $xxx = explode('-',$row->cajaResult);
                $id_advance_x = $row->cajaResult;

                if($xxx[0]      == "U"){
                    //--------------->
                    $this->db->select('`user`.`firstname`,`user`.`secondname`');
                    $this->db->from('user');
                    $this->db->where('user.`id_advance`',$row->cajaResult);                   
                    $query2 = $this->db->get();
                    $row2 = $query2->row_array();
                    if ($query2->num_rows() > 0) {
                        foreach ($query2->result() as $row2) {
                            $data2 = $row2;
                        }
                    }
                    //--------------->
                }elseif($xxx[0] == "C"){
                    //--------------->
                    $this->db->select('`clientes`.`firstname`,`clientes`.`secondname`');
                    $this->db->from('clientes');
                    $this->db->where('clientes.`id_advance`',$row->cajaResult);                   
                    $query2 = $this->db->get();
                    $row2 = $query2->row_array();
                    if ($query2->num_rows() > 0) {
                        foreach ($query2->result() as $row2) {
                            $data2 = $row2;
                        }
                    }
                    //--------------->
                }elseif($xxx[0] == "P"){
                    //--------------->
                    $this->db->select('`proveedores`.`firstname`,`proveedores`.`secondname`');
                    $this->db->from('proveedores');
                    $this->db->where('proveedores.`id_advance`',$row->cajaResult);                   
                    $query2 = $this->db->get();
                    $row2 = $query2->row_array();
                    if ($query2->num_rows() > 0) {
                        foreach ($query2->result() as $row2) {
                            $data2 = $row2;
                        }
                    }
                    //--------------->
                }
                
                $row->usuarioNombre = $data2;
                $data[] = $row;
            }        
        
        } else {
            $data[] = array("Error"  => 104,"Caja" => "Error");
        }

        return  $data;
    }
    //--->
    //--->
    function idOperacion()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        $this->db->select('
        `CajaEntradaSalida`.id,
        `CajaEntradaSalida`.id_advance,
        `CajaEntradaSalida`.time,
        `CajaEntradaSalida`.idoperacion,
        ');
        $this->db->where('idoperacion', $_POST['idOperacion']);
        $this->db->from('CajaEntradaSalida');

        $query = $this->db->get();
        $row = $query->row_array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        } else {
            $data = [
                "category"    => "Request",
                "description" => "Caja Utility Id Operacion",
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
