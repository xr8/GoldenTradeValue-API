<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *Create
 *Read
 *Update
 *Delete
 **/

class Querys extends CI_Model
{

//------------------------------------------------------------------------------------------>    
/********************************************************************************************
*                                            CRUD                                           *
********************************************************************************************/
    //--->
    function metalesCreate()
    {

        //--->
        /*
        ENTREGAS
        */        
            /*
                metales_id_advance: xxx
                entregas_fecha: 2021-03-19
                entregas_no_vale: 11
                entregas_no_ext: 22
                entregas_grs_af: 33
                entregas_barra: 44
                entregas_ley: 55
                entregas_fino: 66
            */

            $data = array(
                'id_advance'         => random_string('sha1', 20),
                'time'               => date("Y-m-d H:m:s"),
                'metales_id_advance' => $_POST['metales_id_advance'],
                'entregas_fecha'     => $_POST['entregas_fecha'],
                'entregas_no_vale'   => $_POST['entregas_no_vale'],
                'entregas_no_ext'    => $_POST['entregas_no_ext'],
                'entregas_grs_af'    => $_POST['entregas_grs_af'],
                'entregas_barra'     => $_POST['entregas_barra'],
                'entregas_ley'       => $_POST['entregas_ley'],
                'entregas_fino'      => $_POST['entregas_fino']
            );
            $this->db->insert('metales_entregas', $data);

        //--->
        /*
        ENTREGAS
        */        

        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        $data_cierres = array(
            'id_advance'         => random_string('sha1', 20),
            'time'               => $date,
            'metales_id_advance' => $_POST['metales_id_advance'],
            'cierres_fino'       => $_POST['entregas_fino'],
            'cierres_precio'     => $_POST['metalesPrecioInput'],
            'cierres_importe'    => $_POST['entregas_fino'] * $_POST['metalesPrecioInput']
        );
        $this->db->insert('metales_cierres', $data_cierres);

        //--->
        /*
        PAGOS
        */      
        
        $random3 = random_string('sha1', 20);
        $date3   = date("Y-m-d H:m:s");
        $r_id3   = random_string('md5', 4);

        $data_pagos = array(
            'id_advance'         => random_string('sha1', 20),
            'time'               => $date,
            'metales_id_advance' => $_POST['metales_id_advance'],
            'pagos_total'        =>  $_POST['entregas_fino'] * $_POST['metalesPrecioInput']
        );
        $this->db->insert('metales_pagos', $data_pagos);
            //return $status;
            $status = [
                "category"    => "Request",
                "description" => "Create Metales Entregas",
                "id advance"  => $random3,
                "date"        => $date3,
                "http_code"   => 404,
                "code"        => 1001,
                "request"     => true,
                "request_id"  => $r_id3
            ];

        return    $status;
        
    }
    //--->

    //--->
    function metalesRead()
    {
        /*
        SELECT
        metales.id,
        metales.id_advance,
        metales.time,
        metales.detail_type,
        metales.detail_id_advance,
        clientes.firstname,
        clientes.secondname,
        metales.detail_fecha,
        metales.detail_status,
        metales.detail_tipo,
        metales.detail_metal,
        metales.detail_grs,
        metales.detail_precio,
        metales.detail_saldo
        FROM
        metales
        JOIN clientes ON metales.detail_id_advance = clientes.id_advance
        WHERE
        metales.detail_id_advance = "C-zr8h0iji96crde4" AND
        metales.detail_fecha LIKE "%2021-03-%"
        ORDER BY
        metales.id DESC
        */        
 
        $this->db->select('
            `metales`.id,
            `metales`.id_advance,
            `metales`.time,
            `metales`.detail_type,
            `metales`.detail_id_advance,
            `clientes`.firstname,
            `clientes`.secondname,
            `metales`.detail_fecha,
            `metales`.detail_status,
            `metales`.detail_tipo,
            `metales`.detail_metal,
            `metales`.detail_grs,
            `metales`.detail_precio,
            `metales`.detail_saldo            
        ');
        $this->db->from('metales');
        $this->db->join('clientes', 'metales.detail_id_advance = clientes.id_advance');
        $this->db->where('metales.`detail_id_advance`', "C-zr8h0iji96crde4");
        $this->db->like('metales.`detail_fecha`',"2021-03-");
        $this->db->order_by('`metales`.id', 'DESC');

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
    //--->

    //--->
    function metalesReadOne()
    {
        /*
        SELECT
        metales.id,
        metales.id_advance,
        metales.time,
        metales.detail_type,
        metales.detail_id_advance,
        clientes.firstname,
        clientes.secondname,
        metales.detail_fecha,
        metales.detail_status,
        metales.detail_tipo,
        metales.detail_metal,
        metales.detail_grs,
        metales.detail_precio,
        metales.detail_saldo
        FROM
        metales
        JOIN clientes ON metales.detail_id_advance = clientes.id_advance
        WHERE
        metales.detail_id_advance = "C-zr8h0iji96crde4" AND
        metales.detail_fecha LIKE "%2021-03-%"
        ORDER BY
        metales.id DESC
        */        
 
        $this->db->select('
            `metales`.id,
            `metales`.id_advance,
            `metales`.time,
            `metales`.detail_type,
            `metales`.detail_id_advance,
            `clientes`.firstname,
            `clientes`.secondname,
            `metales`.detail_fecha,
            `metales`.detail_status,
            `metales`.detail_tipo,
            `metales`.detail_metal,
            `metales`.detail_grs,
            `metales`.detail_precio,
            `metales`.detail_saldo            
        ');
        $this->db->from('metales');
        $this->db->join('clientes', 'metales.detail_id_advance = clientes.id_advance');
        $this->db->where('metales.`id`',$_GET['id']);

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
    //--->

   //--->
   function metalesReadEntregas()
   {

       $this->db->select('*');
       $this->db->from('metales_entregas');
        $this->db->where('metales_entregas.`metales_id_advance',$_GET['id']);

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
   //--->

    //--->
    function cajaUpdate()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        /*
        Array ( 
            [id_advance] => 0f9385c23d1d5825d266 
        */
        
        if($_POST['cajaTipo'] == 'inicial'){

            $data0 = array(
                'cajaConcepto'      => $_POST['cajaConcepto'],
                'cajaNotas'         => $_POST['cajaNotas'],
                'cajaTipo'          => $_POST['cajaTipo'],
                'cajaEntrada'       => '0',
                'cajaSalida'        => '0',
                'cajaSaldo'         => $_POST['cajaMonto']
            );

        }else if($_POST['cajaTipo'] == 'entrada'){

            $data0 = array(
                'cajaConcepto'      => $_POST['cajaConcepto'],
                'cajaNotas'         => $_POST['cajaNotas'],
                'cajaTipo'          => $_POST['cajaTipo'],
                'cajaEntrada'       => $_POST['cajaMonto'],
                'cajaSalida'        => '0',
                'cajaSaldo'         => '0'
            );

        }else if($_POST['cajaTipo'] == 'salida'){

            $data0 = array(
                'cajaConcepto'      => $_POST['cajaConcepto'],
                'cajaNotas'         => $_POST['cajaNotas'],
                'cajaTipo'          => $_POST['cajaTipo'],
                'cajaEntrada'       => '0',
                'cajaSalida'        => $_POST['cajaMonto'],
                'cajaSaldo'         => '0'
            );

        }else{}


        $this->db->where('id_advance', $_POST['id_advance']);
        $this->db->update('CajaEntradaSalida', $data0);


        //return $status;
        $status = [
            "category"    => "Request",
            "description" => "Update Caja",
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
//------------------------------------------------------------------------------------------>

    //--->
    function utilityTotal()
    {

        $this->db->select('*');
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

        $this->db->select('`CajaEntradaSalida`.id,`CajaEntradaSalida`.id_advance,`CajaEntradaSalida`.time,`CajaEntradaSalida`.idoperacion');
        $this->db->where('idoperacion', $_POST['idOperacion']);
        $this->db->from('CajaEntradaSalida');

        $query = $this->db->get();
        $row = $query->row_array();

        if ($query->num_rows() > 0) {
                $data = [
                    "category"    => "Request",
                    "description" => "Caja Utility Id Operacion - yes",
                    "id advance"  => $random,
                    "date"        => $date,
                    "http_code"   => 404,
                    "request"     => true,
                    "request_id"  => $r_id,
                    "code"        => 1001
                ];     
            $data[] = $row;
        } else {
                $data = [
                    "category"    => "Request",
                    "description" => "Caja Utility Id Operacion - no",
                    "id advance"  => $random,
                    "date"        => $date,
                    "http_code"   => 404,
                    "request"     => true,
                    "request_id"  => $r_id,
                    "code"        => 1002
                ];    
            $data[] = $row;                
        }

        return $data;
    }
    //--->      
}
/* End of file database.php */
