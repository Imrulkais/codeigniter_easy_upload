<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form', 'url');
	}

	public function index()
	{
		$this->load->view("example/form");
	}

	public function upload_file()
	{
		$this->load->library('easy_upload');
		$result[] = $this->easy_upload->upload_file('the_image');
		$result[] = $this->easy_upload->upload_file('the_doc', 'cutsom');
		echo "File " . implode(", ", $result) . " has been uploaded";
	}

}