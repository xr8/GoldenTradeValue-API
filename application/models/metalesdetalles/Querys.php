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
    function metalesCreate()
    {
        /*
            save_id_advance: ce35a5da236708d702a9
            save_preio: 1129.21
            metales_saldo_actual: 8230.25
            save_nolext: 
            save_grsaf: 
            save_barra: 10
            save_ley: 24
            save_fino: 10.00
            save_finopza: 20
            save_pagos: 10000
            save_total: 22584.20
            save_saldo: 20814.45
            save_id_advance_user: C-zr8h0iji96crde4

            saldo actual + total    - pago =
            6566.21      + 62540.53 - 60966 = 8140.74
        */
        //print_r($_POST);
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d");
        $r_id   = random_string('md5', 4);

        if($_POST['save_finopza'] > 0){
            $fino_x = $_POST['save_finopza'];
        }else{
            $fino_x = $_POST['save_fino'];
        }

        //-------------------------------------------------------------------------> Begin: Pagos
            /*  
                $random -> entregas - cierres dos - pagos = id_advance

                save_id_advance: 5036c41a0a1aec721aac    -> metales_id_advance
                save_id_advance_user: C-zr8h0iji96crde4  -> metales_detail_id_advance   
               
                save_id_advance: 5036c41a0a1aec721aac    -> id_advance metales
                save_preio: 1255.00
                metales_saldo_actual: 1138.40
                save_nolext: 1983
                save_grsaf: 0
                save_barra: 100
                save_ley: 24
                save_fino: 100.00
                save_finopza: 100.00
                save_pagos: 120000
                save_total: 125500.00
                save_saldo: 6638.40
                save_id_advance_user: C-zr8h0iji96crde4
                save_vale: 101
            */
            /********************************************
            *           tabla: metales                  *
            *   'detail_id_advance'  =>
            ********************************************/         
            //------------------------------------------>              
            $datax = array(
                'id_advance'         => random_string('sha1', 20),
                'detail_id_advance'  => $_POST['save_id_advance']
            );
            $this->db->insert('vale', $datax);  
            //------------------------------------------>

            /********************************************
            *           tabla: metales                  *
            ********************************************/         
            //------------------------------------------>  
            $this->db->set('detail_grs',"detail_grs-$fino_x", FALSE);
                $this->db->where('id_advance', $_POST['save_id_advance']);
                    $this->db->update('metales');
            //------------------------------------------>  
            
            /********************************************
            *           tabla: saldo                 *
            ********************************************/         
            //------------------------------------------>  
            $save_total = $_POST['save_total'];
            $save_pagos = $_POST['save_pagos'];
            
            $x      = $_POST['save_id_advance_user'];
            $x_type = explode("-", $x);
            if($x_type[0] == "C"){$x_type_value = "clientes";}

            $this->db->set('detail_saldo_actual',"detail_saldo_actual+$save_total-$save_pagos", FALSE);
                $this->db->where('detail_id_advance', $_POST['save_id_advance_user']);
                    $this->db->update('saldo');
            //------------------------------------------>  
            
            /********************************************
            *           tabla: entregas                 *
            ********************************************/         
            //------------------------------------------>  
            $metales_entregas_data = array(
                'id_advance'                => $random,
                'metales_id_advance'        => $_POST['save_id_advance_user'],
                'metales_detail_type'       => $x_type_value,
                'metales_detail_id_advance' => $_POST['save_id_advance'],
                'entregas_fecha'            => $date,
                'entregas_no_vale'          => $_POST['save_vale'],
                'entregas_no_ext'           => $_POST['save_nolext'],
                'entregas_grs_af'           => $_POST['save_grsaf'],
                'entregas_barra'            => $_POST['save_barra'],
                'entregas_ley'              => $_POST['save_ley'],
                'entregas_fino'             => $fino_x
            );

            $this->db->insert('metales_entregas',$metales_entregas_data);            
            //------------------------------------------>  
            
            /********************************************
            *           tabla: entregas                 *
            ********************************************/         
            //------------------------------------------>  
            $metales_cierres_data = array(
                'id_advance'                => $random ,
                'metales_id_advance'        => $_POST['save_id_advance'],
                'metales_detail_type'       => $x_type_value,
                'metales_detail_id_advance' => $_POST['save_id_advance_user'],
                'entregas_fecha'            => $date,
                'cierres_fino'              => $fino_x,
                'cierres_precio'            => $_POST['save_preio'],
                'cierres_importe'           => $fino_x*$_POST['save_preio'],
            );

            $this->db->insert('metales_cierres',$metales_cierres_data);
            //------------------------------------------>  
            
            /********************************************
            *           tabla: pagos                 *
            ********************************************/         
            //------------------------------------------>              
            $metales_pagos_data = array(
                'id_advance'                => $random ,
                'metales_id_advance'        => $_POST['save_id_advance'],
                'metales_detail_type'       => $x_type_value,
                'metales_detail_id_advance' => $_POST['save_id_advance_user'],
                'entregas_fecha'            => $date,
                'pagos_total'               => $_POST['save_total'],
                'pagos_pagos'               => $_POST['save_pagos'],
                'pagos_saldos'              => $_POST['save_saldo'],
                'pagos_observaciones'       => 0
            );
            $this->db->insert('metales_pagos',$metales_pagos_data);
            //------------------------------------------>              

        //-------------------------------------------------------------------------> End:   Pagos
        $status[] = array(
            "Ok"      => 101,
            "Cierres" => "Ok",
            "Saldo"   => "Ok",
            "Entregas"=> "Ok",
            "Cierres" => "Ok",
            "Pagos"   => "Ok"
        );
        
        return    $status;
    }
    //--->
    //--->
    function saldoCreate()
    {
        $random = random_string('sha1', 20);
        $date   = date("Y-m-d H:m:s");
        $r_id   = random_string('md5', 4);

        //-------------------------------------------------------------------------> Begin: Pagos

            //id id_advance time detail_id_advance detail_time_update detail_saldo detail_saldo_actual
        /*
            id_advance      : U-03fb5ca7539c770b6b
            save_id_advance : C-zr8h0iji96crde4
            generar_fecha_saldo : 2021-04-01
            generar_saldo_saldo : 1000
        */
            
            $metales_pagos_data = array(
                'id_advance'            => random_string('sha1', 20),
                'detail_id_advance'     => $_POST['save_id_advance'],
                'detail_time_update'    => $_POST['generar_fecha_saldo'],
                'detail_saldo'          => $_POST['generar_saldo_saldo'],
                'detail_saldo_actual'   => $_POST['generar_saldo_saldo']
            );

            $this->db->insert('saldo',$metales_pagos_data);
            
        //-------------------------------------------------------------------------> End:   Pagos
        $status[] = array(
            "Ok"      => 101,
            "Cierres" => "Ok",
            "Saldo"   => "Ok",
            "Entregas"=> "Ok",
            "Cierres" => "Ok",
            "Pagos"   => "Ok"
        );
        
        return    $status;
    }
    //--->
    //--->
    function metalesdetallesRead()
    {

        $this->db->select('
            `metales`.id                  AS m_id,
            `metales`.id_advance          AS m_id_advance,
            `metales`.time                AS m_time,
            `metales`.detail_type         AS m_detail_type,
            `metales`.detail_id_advance   AS m_detail_id_advance,
            `metales`.detail_fecha        AS m_detail_fecha,
            `metales`.detail_status       AS m_detail_status,
            `metales`.detail_tipo         AS m_detail_tipo,
            `metales`.detail_metal        AS m_detail_metal,
            `metales`.detail_grs_original AS m_detail_grs_original,
            `metales`.detail_grs          AS m_detail_grs,
            `metales`.detail_precio       AS m_detail_precio
        ');
        $this->db->from('metales');
        //$this->db->join('saldo', 'saldo.detail_id_advance = metales.detail_id_advance');
        $this->db->where('metales.detail_id_advance', $_GET['id']);
        $this->db->like('metales.`time`',Date("Y-m-"));
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
    function metalesReadEntregas()
    {
        /*
            SELECT
            metales_entregas.id,
            metales_entregas.id_advance,
            metales_entregas.time,
            metales_entregas.metales_id_advance,
            metales_entregas.metales_detail_id_advance,
            metales_entregas.entregas_fecha,
            metales_entregas.entregas_no_vale,
            metales_entregas.entregas_no_ext,
            metales_entregas.entregas_grs_af,
            metales_entregas.entregas_barra,
            metales_entregas.entregas_ley,
            metales_entregas.entregas_fino,
            metales.id AS m_id,
            metales.id_advance AS m_id_advance
            FROM
            metales_entregas
            JOIN metales ON metales.id_advance = metales_entregas.metales_id_advance
            WHERE
            metales_entregas.metales_detail_id_advance = 'C-zr8h0iji96crde4'
            ORDER BY
            metales_entregas.id DESC
        */        
        $this->db->select('        
        `metales_entregas`.id,
        `metales_entregas`.id_advance,
        `metales_entregas`.time,
        `metales_entregas`.metales_detail_type,
        `metales_entregas`.metales_detail_id_advance,
        `metales_entregas`.entregas_fecha,
        `metales_entregas`.entregas_no_vale,
        `metales_entregas`.entregas_no_ext,
        `metales_entregas`.entregas_grs_af,
        `metales_entregas`.entregas_barra,
        `metales_entregas`.entregas_ley,
        `metales_entregas`.entregas_fino
        ');
        $this->db->from('metales_entregas');
        //$this->db->join('metales', 'metales.id_advance = `metales_entregas`.metales_detail_id_advance');
        $this->db->where   ('`metales_entregas.metales_id_advance',$_GET['id']);
        $this->db->order_by("`metales_entregas`.id", "DESC");

        $query = $this->db->get();
        $row = $query->row_array();

        //---A
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        } else {
            $data[] = array("Error"  => 104,"Metales Detalles" => "Error");
        }

        return  $data;
    }
    //--->

    //--->
    function metalesReadCierres()
    {
        /*
        SELECT
        metales_cierres.id,
        metales_cierres.id_advance,
        metales_cierres.time,
        metales_cierres.metales_id_advance,
        metales_cierres.metales_detail_id_advance,
        metales_cierres.cierres_fino,
        metales_cierres.cierres_precio,
        metales_cierres.cierres_importe,
        metales.id         AS m_id,
        metales.id_advance AS m_id_advance
        FROM metales_cierres
        INNER JOIN metales on metales.id_advance = metales_cierres.metales_id_advance
        WHERE metales_cierres.metales_detail_id_advance = 'C-zr8h0iji96crde4'
        ORDER BY metales_cierres.id DESC
        */        

        $this->db->select  ('        
            metales_cierres.id,
            metales_cierres.id_advance,
            metales_cierres.time,
            metales_cierres.metales_id_advance,
            metales_cierres.metales_detail_id_advance,
            metales_cierres.entregas_fecha,
            metales_cierres.cierres_fino,
            metales_cierres.cierres_precio,
            metales_cierres.cierres_importe,
            metales.id         AS m_id,
            metales.id_advance AS m_id_advance');
        $this->db->from    ('metales_cierres');
        $this->db->join    ('metales', 'metales.id_advance = metales_cierres.metales_id_advance');
        $this->db->where   ('`metales_cierres.metales_detail_id_advance',$_GET['id']);
        $this->db->order_by('`metales_cierres`.id','DESC');
        
        //----->
        $query = $this->db->get();
        $row = $query->row_array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){$data[] = $row;}
            }else{
                $data[] = array("Error"  => 104,"Metales Detalles" => "Error");
                }
        //----->

        return  $data;
    }
    //---> 

    //--->
    function metalesReadPagos()
    {
        /*
        SELECT
            metales_pagos.id,
            metales_pagos.id_advance,
            metales_pagos.time,
            metales_pagos.metales_id_advance,
            metales_pagos.metales_detail_id_advance,
            metales_pagos.pagos_total,
            metales_pagos.pagos_pagos,
            metales_pagos.pagos_saldos,
            metales_pagos.pagos_observaciones,
            metales.id AS m_id,
            metales.id_advance AS m_id_advance
        FROM
        metales_pagos
        INNER JOIN metales ON metales.id_advance = metales_pagos.metales_id_advance
        WHERE
        metales_pagos.metales_detail_id_advance = 'C-zr8h0iji96crde4'
        ORDER BY
        metales_pagos.id DESC
        */        

        $this->db->select  ('        
            metales_pagos.id,
            metales_pagos.id_advance,
            metales_pagos.time,
            metales_pagos.metales_id_advance,
            metales_pagos.metales_detail_id_advance,
            metales_pagos.entregas_fecha,
            metales_pagos.pagos_total,
            metales_pagos.pagos_pagos,
            metales_pagos.pagos_saldos,
            metales_pagos.pagos_observaciones,
            metales.id AS m_id,
            metales.id_advance AS m_id_advance');
        $this->db->from    ('metales_pagos');
        $this->db->join    ('metales', 'metales.id_advance = metales_pagos.metales_id_advance');
        $this->db->where   ('`metales_pagos.metales_detail_id_advance',$_GET['id']);
        $this->db->order_by('`metales_pagos`.id','DESC');
        
        //----->
        $query = $this->db->get();
        $row = $query->row_array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){$data[] = $row;}
            }else{
                $data[] = array("Error"  => 104,"Metales Detalles" => "Error");
                }
        //----->

        return  $data;
    }
    //---> 

    //--->
    function metalesReadOne()
    {
        /*
            // 20210329172648
            // http://localhost/server/DevOps/GoldenTradeValue/GoldenTradeValue-API/index.php/metalesdetalles/readerdata/?type=one&id=Un6jmxDklzUwyJBGbw9r

            [
            {
                "id": "2",
                "id_advance": "Un6jmxDklzUwyJBGbw9r",
                "time": "2021-03-24 01:01:31",
                "detail_type": "clientes",
                "detail_id_advance": "C-zr8h0iji96crde4",
                "firstname": "jorge",
                "secondname": "garibaldo",
                "detail_fecha": "2021-03-24 01:01:31",
                "detail_status": "abierto",
                "detail_tipo": "compra",
                "detail_metal": "oro",
                "detail_grs": "96.65",
                "detail_precio": "1255.00",
                "detail_saldo": "0.00"
            }
            ]
        */        
 
        $this->db->select('
        metales.id,
        metales.id_advance,
        metales.time,
        metales.detail_type,
        metales.detail_id_advance,
        metales.detail_fecha,
        metales.detail_status,
        metales.detail_tipo,
        metales.detail_metal,
        metales.detail_grs_original,
        metales.detail_grs,
        metales.detail_precio,
        saldo.detail_saldo AS saldo_saldo,
        saldo.detail_saldo_actual AS saldo_saldo_actual,
        clientes.email,
        clientes.firstname,
        clientes.secondname,
        ');
        $this->db->from('metales');
        $this->db->join('clientes', 'clientes.id_advance     = metales.detail_id_advance');
        $this->db->join('saldo'   , 'saldo.detail_id_advance = metales.detail_id_advance');


        $this->db->where('metales.`id_advance`',$_GET['id']);

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
    function metaleSaldoBase()
    {
        /*
            SELECT
            Count(saldo.id)
            FROM
            saldo
            WHERE
            saldo.detail_id_advance = '30063c359cd725358a5a'
            GROUP BY
            saldo.id_advance
        */        
 
        $this->db->select('Count(saldo.id) AS saldo');
        $this->db->from('saldo');
        $this->db->where('saldo.`detail_id_advance`',$_GET['id']);

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
  function metaleSaldoActual()
  {
      $this->db->select("
        `metales_pagos`.id,
        `metales_pagos`.id_advance,
        `metales_pagos`.time,
        `metales_pagos`.pagos_saldos AS saldo
      ");
      
      $this->db->from("metales_pagos");
      $this->db->order_by("`metales_pagos`.id","DESC");
      $this->db->limit(1); 

      $query = $this->db->get();
      $row = $query->row_array();

      //---A)
      if ($query->num_rows() > 0) {
          foreach ($query->result() as $row) {
              $data[] = $row;
          }
      } else {
          $data[] = array("Error"  => 104,"Saldo Actual" => "Error");
      }

      return  $data;
  }    
    //--->


    //--->
    function metalesCreateUnico()
    {
        /*
id_advance: 00000000000000000000
save_id_advance: C-zr8h0iji96crde4
save_nolext: 1983
save_grsaf: 0
save_ley: 13.68
save_fino: 174.53
save_finopza: 14.18
save_importe: 19102.59
save_pagos: 10000
save_total: 19102.59
save_saldo: 9102.59
        */
        //print_r($_POST);
        $random_x = random_string('sha1', 20);
        $date   = date("Y-m-d");
        $r_id   = random_string('md5', 4);

        if($_POST['save_finopza'] > 0){
            $fino_x = $_POST['save_finopza'];
        }else{
            $fino_x = $_POST['save_fino'];
        }
        $save_total = $_POST['save_total'];
        $save_pagos = $_POST['save_pagos'];
        //-------------------------------------------------------------------------> Begin: Pagos

            //#	ID Cierre	Fecha	Total	Pagos	Saldo	Observaciones
    
            /********************************************
            *           tabla: metales                  *
            ********************************************/         
            //------------------------------------------>  
            $metales_entregas_data = array(
                /*
                'id_advance'                => $random,
                'metales_id_advance'        => $_POST['id_advance'],
                'metales_detail_id_advance' => $_POST['save_id_advance'],
                'entregas_fecha'            => $date,

                */
                'id_advance'          => $random_x,
                'detail_id_advance'   => $_POST['save_id_advance'],
                'detail_fecha'        => $date,
                'detail_type'         => "clientes",
                'detail_status'       => "cerrado",
                'detail_tipo'         => "compra",
                'detail_metal'        => "oro",
                'detail_grs_original' => $_POST['save_barra'],
                'detail_grs'          => $_POST['save_barra'],
                'detail_precio'       => $_POST['save_precio']
            );
            $this->db->insert('metales',$metales_entregas_data );     
            //------------------------------------------>  
            
            /********************************************
            *           tabla: saldo                 *
            ********************************************/         
            //------------------------------------------>  
            //saldo+total-pago
            //$this->db->set('detail_time_update',"date('Y-m-d H:i:s')", FALSE);
            $this->db->set('detail_saldo_actual',"detail_saldo_actual+$save_total-$save_pagos", FALSE);
                $this->db->where('detail_id_advance', $_POST['save_id_advance']);
                    $this->db->update('saldo');
                                
                

            //------------------------------------------>  
            
            /********************************************
            *           tabla: entregas                 *
            ********************************************/         
            //------------------------------------------>  
            $metales_entregas_data = array(
                'id_advance'                => random_string('sha1', 20),
                'metales_id_advance'        => $random_x,
                'metales_detail_id_advance' => $_POST['save_id_advance'],
                'entregas_fecha'            => $date,
                'entregas_no_ext'           => $_POST['save_nolext'],
                'entregas_grs_af'           => $_POST['save_grsaf'],
                'entregas_barra'            => $_POST['save_barra'],
                'entregas_ley'              => $_POST['save_ley'],
                'entregas_fino'             => $fino_x
            );
            $this->db->insert('metales_entregas',$metales_entregas_data);            
            //------------------------------------------>  
            
            /********************************************
            *           tabla: entregas                 *
            ********************************************/         
            //------------------------------------------>  
            $metales_cierres_data = array(
                'id_advance'                => random_string('sha1', 20),
                'metales_id_advance'        => $random_x,
                'metales_detail_id_advance' => $_POST['save_id_advance'],
                'entregas_fecha'            => $date,
                'cierres_fino'              => $fino_x,
                'cierres_precio'            => $_POST['save_precio'],
                'cierres_importe'           => $fino_x*$_POST['save_precio'],
            );
            $this->db->insert('metales_cierres',$metales_cierres_data);
            //------------------------------------------>  

            /********************************************
            *           tabla: pagos                 *
            ********************************************/         
            //------------------------------------------>             
            $metales_pagos_data = array(
                'id_advance'                => random_string('sha1', 20),
                'metales_id_advance'        => $random_x,
                'metales_detail_id_advance' => $_POST['save_id_advance'],
                'entregas_fecha'            => $date,
                'pagos_total'               => $_POST['save_total'],
                'pagos_pagos'               => $_POST['save_pagos'],
                'pagos_saldos'              => $_POST['save_saldo'],
                'pagos_observaciones'       => 0
            );
            $this->db->insert('metales_pagos',$metales_pagos_data);
            //------------------------------------------>              

        //-------------------------------------------------------------------------> End:   Pagos
        $status[] = array(
            "Ok"      => 101,
            "Cierres" => "Ok",
            "Saldo"   => "Ok",
            "Entregas"=> "Ok",
            "Cierres" => "Ok",
            "Pagos"   => "Ok"
        );
        
        return    $status;
    }
    //--->   

    /* End of file database.php */

    //------------------------------------------->
    /********************************************
    *                   CRUD                    *
    *               Metales Detalles            *
    ********************************************/
        //--->
        function metalesCreateMultiple()
        {
            $random20 = random_string('sha1', 20);
            $date     = date("Y-m-d H:m:s");

            $x      = $_POST['id_advance'];
            $x_type = explode("-", $x);
            if($x_type[0] == "C"){$x_type_value = "clientes";}
            
            /*
        id_advance: C-zr8h0iji96crde4
        emfecha: 
        emnvale: 113
        emnoext: 002
        emAntesf[]: 9
        emAntesf[]: 8
        emAntesf[]: 7
        emGrs[]: 9
        emGrs[]: 8
        emGrs[]: 7
        emLey[]: 9
        emLey[]: 8
        emLey[]: 7
        emFinos[]: 9
        emFinos[]: 8
        emFinos[]: 7 
            
            id
            id_advance
            time
            metales_id_advance
            metales_detail_type
            metales_detail_id_advance
            entregas_fecha
            entregas_no_vale
            entregas_no_ext
            entregas_grs_af
            entregas_barra
            entregas_ley
            entregas_fino
            
            */
            $emid_advance = $_POST['id_advance'];
            $emfecha      = $_POST['emfecha'];
            $emnvale      = $_POST['emnvale'];
            $emnoext      = $_POST['emnoext'];
            $emAntesf     = $_POST['emAntesf'];
            $emGrs        = $_POST['emGrs'];
            $emLey        = $_POST['emLey'];
            $emFinos      = $_POST['emFinos'];
            /*
            foreach ($emAntesf as $xxx => $valor) {
                $valy[] = array(
                    'id_advance'                => random_string('sha1', 20),
                    'metales_id_advance'        => $random20,
                    'metales_detail_id_advance' => $emid_advance,
                    'metales_detail_type'       => $x_type_value,
                    'entregas_fecha'            => $emfecha,
                    'entregas_no_vale'          => $emnvale,
                    'entregas_no_ext'           => $emnoext,
                    'entregas_grs_af'           => $emAntesf[$valor],
                    'entregas_barra'            => $emGrs[$valor],
                    'entregas_fino'             => $emFinos[$valor],
                    'entregas_ley'              => $emLey[$valor]
                );
            }
            */
            $ycount = count($emAntesf)-1;
            
            for ($i = 0; $i <= $ycount; $i++) {
                $xyz[] = array(
                    'id_advance'                => random_string('sha1', 20),
                    'metales_id_advance'        => $random20,
                    'metales_detail_id_advance' => $emid_advance,
                    'metales_detail_type'       => $x_type_value,
                    'entregas_fecha'            => $emfecha,
                    'entregas_no_vale'          => $emnvale,
                    'entregas_no_ext'           => $emnoext,
                    'entregas_grs_af'           => $emAntesf[$i],
                    'entregas_barra'            => $emGrs[$i],
                    'entregas_fino'             => $emFinos[$i],
                    'entregas_ley'              => $emLey[$i]
                );
            }

            $this->db->insert_batch('metales_entregas',$xyz);
            
            $datax = array(
                'id_advance'         => random_string('sha1', 20),
                'detail_id_advance'  => $random20
            );
            $this->db->insert('vale', $datax);        
            
            $status[] = array(
                "Ok"              => 101,
                "Metales Detalle" => "Ok",
                "Cierres"         => "Ok",
                "Saldo"           => "Ok",
                "Entregas"        => "Ok",
                "Cierres"         => "Ok",
                "Pagos"           => $xyz
            );
        
            return    $status;
            
        }
        //--->
    //------------------------------------------->
}