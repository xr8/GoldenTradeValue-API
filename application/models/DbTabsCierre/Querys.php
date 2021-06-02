<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Querys extends CI_Model
{

    //--->
    function cierreCreate()
    {   
        /*
          d_advance: U-03fb5ca7539c770b6b
          save_id_advance: C-zr8h0iji96crde4
          generar_c_fecha: 2021-04-01
          generar_c_tipo: compra
          generar_c_metal: oro
          generar_c_grs: 100
          generar_c_precio: 1129.21
        */
          $random = random_string('alnum', 20);
          $date   = date("Y-m-d H:m:s");
          $r_id   = random_string('md5', 4);
          
          $grs    = floatval($_POST['generar_c_grs']);
          $precio = floatval($_POST['generar_c_precio']);
  
          $saldo  = $grs * $precio;
  
          $x      = $_POST['save_id_advance'];
          $x_type = explode("-", $x);
          if($x_type[0] == "C"){
            $x_type_value = "clientes";
          }
          
  
          $data = array(
            'id_advance'           => $random,
            'user_id_advance'      => $_POST['save_id_advance'],
            'user_type'            => $x_type_value,
            'detail_fecha'         => $_POST['generar_c_fecha'],
            'detail_status'        => 'abierto',
            'detail_tipo'          => $_POST['generar_c_tipo'],
            'detail_grs_original'  => $_POST['generar_c_grs'],
            'detail_grs'           => $_POST['generar_c_grs'],
            'detail_precio'        => $_POST['generar_c_precio']
          );
  
          $this->db->insert('tabscierre', $data);
        /*
          id
          id_advance
          time
          detail_id_advance
          detail_time_update
          detail_saldo
          detail_saldo_actual
        */
  
      /*
      $this->db->set('detail_time_update',$_POST['generar_c_fecha'], FALSE);
      $x = $_POST['generar_c_precio'];
      $this->db->set('detail_saldo_actual',"detail_saldo_actual+$x", FALSE);
      $this->db->where('detail_id_advance', $_POST['save_id_advance']);
      $this->db->update('saldo');
          */
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
    function cierreRead()
    {
        $this->db->select('
            `tabscierre`.id,
            `tabscierre`.id_advance,
            `tabscierre`.time,
            `tabscierre`.user_type,
            `tabscierre`.user_id_advance,
            `tabscierre`.detail_fecha,
            `tabscierre`.detail_status,
            `tabscierre`.detail_tipo,
            `tabscierre`.detail_metal,
            `tabscierre`.detail_grs_original,
            `tabscierre`.detail_grs,
            `tabscierre`.detail_precio,
            saldo.detail_saldo AS saldo_saldo,
            saldo.detail_saldo_actual AS saldo_saldo_actual,
            clientes.email,
            clientes.firstname,
            clientes.secondname            
        ');        
        $this->db->from('tabscierre');
        $this->db->where('tabscierre.user_id_advance', $_GET['id']);

        $this->db->join('clientes', 'clientes.id_advance     = tabscierre.user_id_advance');
        $this->db->join('saldo'   , 'saldo.detail_id_advance = tabscierre.user_id_advance');

        $this->db->order_by('`tabscierre`.id', 'DESC');

        $query = $this->db->get();
        $row = $query->row_array();

        //---A)
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        } else {
            $date   = date("Y-m-d H:m:s");
            $data[] = array(
                "Time"       => $date,
                "Message"    => "Error Tabs Cierre",
                "Code"       => 104,
                "Contorller" => "DbTabsCierre",
                "class"      => "DbTabsCierre",
                "fuction"    => "DbTabsCierreRead",
                "id"         => "user"
            );
        }

        return  $data;
    }
    //--->
        
}    