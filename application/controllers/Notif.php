<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Notif extends CI_Controller {

    public function index()
    {
        $this->load->view('notif_view');
    }

    public function getsubs()
    {
        $this->load->library('PHPWebPush');
        $client = json_decode($this->input->raw_input_stream, true);
        $notif = json_encode(["title" => "Success", "message" => "Success subscribe notification", "url" => base_url()]);
        $this->phpwebpush->send($client, $notif);
    }

}

/* End of file Notif.php */
