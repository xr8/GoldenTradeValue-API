<?php
class A999 extends CI_Controller {
//----->
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->default= $this->load->database('default', TRUE);
    }

    public function index(){
        /*
        {
        "abbreviation": "CST",
        "client_ip": "187.190.153.78",
        "datetime": "2021-03-11T03:40:45.099622-06:00",
        "day_of_week": 4,
        "day_of_year": 70,
        "dst": false,
        "dst_from": null,
        "dst_offset": 0,
        "dst_until": null,
        "raw_offset": -21600,
        "timezone": "America/Mexico_City",
        "unixtime": 1615455645,
        "utc_datetime": "2021-03-11T09:40:45.099622+00:00",
        "utc_offset": "-06:00",
        "week_number": 10
        }
        vz 5554145703
        */

        $myTime = new DateTime(null, new DateTimeZone('America/Mexico_City'));
        
        $fecha = date_create();

        $xr8_data['abbreviation'] = "";
        $xr8_data['client_ip']    = $_SERVER['REMOTE_ADDR'];
        $xr8_data['datetime']     = $myTime->format('Y-m-d\TH:i:s.u');
        $xr8_data['day_of_week']  = strftime("%u");
        $xr8_data['day_of_year']  = strftime("%j");

        $xr8_data['dst']          = "";
        $xr8_data['dst_from']     = "";
        $xr8_data['dst_offset']   = "";
        $xr8_data['dst_until']    = "";
        $xr8_data['raw_offset']   = "";

        $xr8_data['timezone']     = date("e");
        $xr8_data['unixtime']     = date_timestamp_get($fecha);
        $xr8_data['utc_datetime'] = "";
        $xr8_data['utc_offset']   = "";
        $xr8_data['week_number']  = strftime("%V");
        
        $array = array($xr8_data);

        $this->output->set_content_type('application/json')->set_output(json_encode($array));
    }

//----->
}
