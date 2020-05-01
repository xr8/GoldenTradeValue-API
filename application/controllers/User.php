<?php
class User extends CI_Controller {
//----->

    //--->
    public function __construct(){
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->default= $this->load->database('default', TRUE);

            $this->load->model('log/Model_log');
            $this->load->model('user/Querys');
            $xr8_data = $this->Model_log->logNew();
        }
    //--->

    //--->
    public function index(){
        $xr8_data = $this->Model_log->logNew();
        $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));
        }
    //--->

        //--->
        public function createdata(){
            $xr8_data = $this->Querys->logNew();
                /*
                'id_advance' => random_string('sha1', 20),
                'time'       => date("Y-m-d H:m:s"),
                'user'       => $_POST['user'],
                'permissions'=> $_POST['permissions'],
                'email'      => $_POST['email'],
                'password'   => password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost']),
                'firstname'  => $_POST['first'],
                'secondname' => $_POST['second'],
                'telefono'   => $_POST['tel'],
                'puesto'     => $_POST['puesto']
                */
                if (
                    empty($_POST['user'])        ||
                    empty($_POST['permissions']) ||
                    empty($_POST['email'])       ||
                    empty($_POST['password'])    ||
                    empty($_POST['first'])       ||
                    empty($_POST['second'])      ||
                    empty($_POST['tel'])         ||
                    empty($_POST['puesto'])
                    ){

                        echo "algo post vacio";
                    }else{

                        $xr8_data   = $this->Querys->usuarioNew();
                        $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));
                    }

            }
        //--->

        //--->
        public function readerdata(){
            /* Rec Log*/
            $xr8_data = $this->Model_log->logNew();

            //$id_advance = 'CLjFxfEC16HE9AZ948Ws';
            //a181a603769c1f98ad927e7367c7aa51 = all
            //b326b5062b2f0e69046810717534cb09 = true
            //68934a3e9455fa72420237eb05902327 = false

            if ((empty($_GET['id_advance'])) && ($_GET['a181a603769c1f98ad927e7367c7aa51'] == 'b326b5062b2f0e69046810717534cb09')){
                /*All*/
                $id_advance = null;
                $all        = True;
                }else{
                    /*id advance*/
                    $id_advance = $_GET['id_advance'];
                    $all        = False;
                    }

                $xr8_data   = $this->Querys->userRead($id_advance,$all);
                $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));

            }
        //--->

        //--->
        public function update(){

            $id_advance = $_POST['id_advance'];
            $xr8_data = $this->Querys->socios_actualizar($id_advance);

            //----->json
            $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));

            }
        //--->

        //--->
        public function delete(){
            $xr8_data = $this->Querys->socios_borrar();
            //----->json
            $this->output->set_content_type('application/json')->set_output(json_encode($xr8_data));
            }
        //--->

//----->
}
