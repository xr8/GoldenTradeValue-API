<?php
class Clientes extends CI_Controller
{
    //----->

    //--->
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->default = $this->load->database('default', TRUE);

        $this->load->model('log/Model_log');
        $this->load->model('clientes/Querys');
        $xr8_data = $this->Model_log->logNew();
    }
    //--->

    //--->
    public function index()
    {
        $xr8_data = $this->Model_log->logNew();
        $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));
    }
    //--->

    //--->
    public function createdata()
    {

        if (
            empty($_POST['fecha1']) ||
            empty($_POST['rfc1'])   ||
            empty($_POST['pais1'])  ||
            empty($_POST['giro1'])  ||
            empty($_POST['first'])  ||
            empty($_POST['second']) ||
            empty($_POST['email'])  ||
            empty($_POST['tel'])    ||
            empty($_POST['rfc'])    ||
            empty($_POST['curp'])   ||
            empty($_POST['direccion'])
        ) {

            echo "algo post vacio";

        } else {

            $xr8_data   = $this->Querys->clientesCreate();
            $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));

        }
        
    }
    //--->

    //--->
    public function readerdata()
    {
        //$xr8_data                        = $this->Model_log->logNew();
        //$id_advance                      = 'CLjFxfEC16HE9AZ948Ws';    
        //a181a603769c1f98ad927e7367c7aa51 = all    
        //b326b5062b2f0e69046810717534cb09 = true
        //68934a3e9455fa72420237eb05902327 = false
        /*
            id_advance                      = ec66331706175538efd5
            a18a603769c1f98ad927e7367c7aa51 = b326b5062b2f0e69046810717534cb09
        */
        
        if(empty($_GET['id_advance']) && $_GET['a181a603769c1f98ad927e7367c7aa51'] == 'b326b5062b2f0e69046810717534cb09'){

            /*
            all
            id_advance                       =
            a181a603769c1f98ad927e7367c7aa51 = b326b5062b2f0e69046810717534cb09
            */
            $xr8_data   = array('all' => "all");
            $id_advance = null;
            $all        = true;
            $xr8_data   = $this->Querys->clientesRead($id_advance, $all);


        }else if(!empty($_GET['id_advance']) && $_GET['a181a603769c1f98ad927e7367c7aa51'] == '68934a3e9455fa72420237eb05902327'){
            
            /*
            one
            id_advance                       = ec66331706175538efd5
            a181a603769c1f98ad927e7367c7aa51 = 68934a3e9455fa72420237eb05902327
            */

            $id_advance = $_GET['id_advance'];
            $all        = false;
            $xr8_data   = $this->Querys->clientesRead($id_advance, $all);

        }else{ $xr8_data  = array("Error"  => 101); }

        $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));

    }
    //--->

    //--->
    public function updatedata()
    {
        
        //print_r($_POST);

        $id_advance = $_POST['id_advance'];
        $xr8_data = $this->Querys->clientesUpdate($id_advance);

        //----->json
        $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));
        
    }
    //--->

    //--->
    public function deletedata()
    {
        $xr8_data = $this->Querys->clientesDelete();
        //----->json
        $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));
    }
    //--->

    //----->
}
