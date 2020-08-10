<?php
class Caja extends CI_Controller
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
        $this->load->model('caja/Querys');
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
        /*
        cajaIdAdvance: U-03fb5ca7539c770b6b
        cajaNuevoFecha: 2020-07-01
        cajaResult: C-zr8h0iji96crde4
        cajaConcepto: concepto 1
        cajaNotas: nota 1
        cajaTipo: inicial
        cajaMonto: 1000
        cajaNoCompra: 000
        cajaTotalMBData: 0|0|0|0|0|0|0|0|0|0|1
        */
        if (
            is_null($_POST['cajaIdAdvance'])  or
            is_null($_POST['cajaNuevaFecha']) or
            is_null($_POST['cajaResult'])     or
            is_null($_POST['cajaConcepto'])   or
            is_null($_POST['cajaNotas'])      or
            is_null($_POST['cajaTipo'])       or
            is_null($_POST['cajaMonto'])      or
            is_null($_POST['cajaNoCompra'])   or
            is_null($_POST['cajaTotalMBData'])
        ) {
        //----->
            $xr8_data   = "Error: 1001";
        //----->
        } else {
        //----->
            if($_POST['cajaSave'] == 'true'){
            //----->
                $xr8_data   = $this->Querys->cajaCreate();
            //----->
            }else{
            //----->
                $xr8_data  = [
                    "category"    => "Demo",
                    "http_code"   => 404,
                    "code"        => 1005,
                    "request"     => true
                ];
            //----->
            }

        //----->    
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));
    }
    //--->

    //--->
    /*
    /caja/readerdata?
    id_advance=&
    a181a603769c1f98ad927e7367c7aa51=b326b5062b2f0e69046810717534cb09&
    date=2020-07
    */
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
        
        if (empty($_GET['id_advance'])){
            $date = date("Y-m");
        }else{
            $date = $_GET['id_advance'];
        }

        if (empty($_GET['id_advance']) && $_GET['a181a603769c1f98ad927e7367c7aa51'] == 'b326b5062b2f0e69046810717534cb09') {

            /*
            all
            id_advance                       =
            a181a603769c1f98ad927e7367c7aa51 = b326b5062b2f0e69046810717534cb09
            */
            $id_advance = null;
            $all        = true;
            $xr8_data   = $this->Querys->cajaRead($id_advance, $all, $date);
        } else if (!empty($_GET['id_advance']) && $_GET['a181a603769c1f98ad927e7367c7aa51'] == '68934a3e9455fa72420237eb05902327') {

            /*
            one
            id_advance                       = ec66331706175538efd5
            a181a603769c1f98ad927e7367c7aa51 = 68934a3e9455fa72420237eb05902327
            */

            $id_advance = $_GET['id_advance'];
            $all        = false;
            $xr8_data   = $this->Querys->cajaRead($id_advance, $all, $date);
        } else {
            $xr8_data  = array("Error"  => 101);
        }


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

    //--->
    public function utilitydata()
    {

        if (!empty($_GET['type'])) {

            if($_GET['type'] == 'total') {

                $xr8_data = $this->Querys->utilityTotal();

            }else if ($_GET['type'] == 'buscar') {
                //-----> Begin: Buscar
                
                //--->
                /*
                A) Model buscar user si existe alguna coicidencia imprime un json
                B)si no existe ninguna coicidencia ejecuta Model buscar clientes
                C) Model buscar clientes si existe alguna coicidencia imprime un json
                D) si no existe ninguna coicidencia Model buscar proveedor
                E)si no existe ninguna coicidencia ejecuta Model buscar clientes
                f) si no existe ninguna coicidencia IMPRIME error 104

                */
                $dataUser = $this->Querys->utilityBuscarUser();
                
                    if(!array_key_exists("Error",$dataUser[0])){
                        
                        //A)
                        $this->output->set_content_type('application/json')->set_output(json_encode($dataUser));

                    }else if(array_key_exists("Error",$dataUser[0]) && $dataUser[0]['Error'] == 101){
                        
                        //B)
                        $dataClientes = $this->Querys->utilityBuscarClientes();

                        if(!array_key_exists("Error",$dataClientes[0])){

                            //C)
                            $this->output->set_content_type('application/json')->set_output(json_encode($dataClientes));

                        }else if(array_key_exists("Error",$dataClientes[0]) && $dataClientes[0]['Error'] == 101){
                            
                            //D)
                            $dataProveedor = $this->Querys->utilityBuscarProveedor();

                            if(!array_key_exists("Error",$dataProveedor[0])){
                                
                                //E)
                                $this->output->set_content_type('application/json')->set_output(json_encode($dataProveedor));

                            }else if(array_key_exists("Error",$dataProveedor[0]) && $dataProveedor[0]['Error'] == 101){
                                
                                //F)
                                $dataError = array("Error" => 104,"Buscador" =>"Error");
                                $this->output->set_content_type('application/json')->set_output(json_encode($dataError));

                            }

                        }

                    }
                
                //--->



                //-----> End: Buscar
            }else if ($_GET['type'] == 'ultimafecha') {

                $xr8_data = $this->Querys->utilityUltimafecha();
                $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));

            }else{

                $xr8_data  = array("Error"  => 103);
                $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));
                
            }

        } else {
            $xr8_data  = array("Error"  => 102);
            $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));
        }

        
    }
    //--->    

    //----->
}