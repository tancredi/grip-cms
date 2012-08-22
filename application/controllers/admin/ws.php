<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ws extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
    }
    


    public function file_upload ()
    {
        $this->load->helper('admin/file_uploader');
        $this->config->load('file_upload');
        $upload_config = $this->config->item('file_upload');

        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array();
        // max file size in bytes
        $sizeLimit = 10 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($upload_config['upload_path']);

        if (isset($result['error']))
        {
            $result['success'] = false;
        } else {
            $result['success'] = true;
        }
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }




}

/* End of file admin/ws.php */
/* Location: ./application/controllers/admin/ws.php */