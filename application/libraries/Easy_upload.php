<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Library for upload, retrieve and remove file to and from server
 *
 * @author		Edo masaru <masaruedogawa@gmail.com>
 * @copyright	Copyright (c) 2013, Jogjamedicom.
 * @since		Version 1.0
 */
 
class Easy_upload {	
	
	private $errors = null;
	
	function __construct($params = array()) {
		$this->CI = & get_instance();
        // $this->CI->config->load("easy_upload");
	}
	
	/**
	 * get path for uploaded file
	 * @param string $file file name
	 * @param boolean $clean
	 * @return string
	 */
    function get_file_path($file = "", $clean = true, $ccfg = null) {
        // get current configuration
		$current = $ccfg ? $ccfg : $this->CI->config->item('current');
		$cur_config = $this->CI->config->item($current);
		$cur_config = $cur_config['file_upload'];
		
		// get path upload
        $path = $cur_config["path_upload"];
        
        if ($clean) {
            $path = str_replace("./", "", $path);
        }
        
        return rtrim($path, "/") . "/" . ( $file ? $file : "" );
    }
	
	
	/**
	 * remove file from server
	 *
	 * @param string $file file name would be removed
	 * @param mix $path aditional path	 
	 * @param mix $ccfg current configuration
	 */
    function remove_file($file, $path = false, $ccfg = null) {
        // get current configuration
		$current = $ccfg ? $ccfg : $this->CI->config->item('current');
		$cur_config = $this->CI->config->item($current);
		$cur_config = $cur_config['file_upload'];

		// get path upload from config
		// and concat with additional path if specified
        $path = rtrim($cur_config["path_upload"], "/") . ($path ? ("/" . $path) : "");
        $status = false;
		
		// make sure file defined
        if (!empty($file)) {
            $image = "{$path}/{$file}";
			
			// remove file
			if (file_exists($image)) {
                $status = unlink($image);
            } 
			
			// check if there is thumbnail created            
			$thumb = str_replace('.', '_thumb.', $file);
			$thumb = "$path/$thumb";
			
			if (file_exists($thumb)) {
				$status = unlink($thumb);
			}         
        }

        return $status;
    }
	
	/**
	 * upload file to server
	 * it possible to create thumbnail if uploaded file is image type
	 *
	 * @param string $input_name HTML input file name
	 * @param string $path Additional path
	 * @param boolean $create_thumb option creating image thumbnail or not
	 */
    function upload_file($input_name, $path = null, $create_thumb = false, $ccfg = null) {        
        $this->CI->load->library('upload');   

		// get current configuration
		$current = $ccfg ? $ccfg : $this->CI->config->item('current');
		$cur_config = $this->CI->config->item($current);
		$upload_config = $cur_config['file_upload'];

		// initialize 
        $this->CI->upload->initialize($upload_config);

        $ret_filename = "";
        if ($this->CI->upload->do_upload($input_name)) {
            // get file uploaded atributes
            $file_uploaded = $this->CI->upload->data();
			
			// get file uploaded name
            $ret_filename = $file_uploaded['raw_name'] . $file_uploaded['file_ext'];
            
            // if file uploaded is image, would it be created image thumbnail
            if (in_array($file_uploaded['file_type'], array('image/bmp', 'image/x-windows-bmp', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png',  'image/x-png')) ) {
                
				//create thumb if needed
                if ($create_thumb) {
					// get current image lib configuration
                    $imagelib_config = $cur_config['image_lib'];

                    $new_width = $thumb['width'];
                    $new_height = $thumb['height'];

                    // get proportional image dimansion                  
                    list($width, $height) = getimagesize($file_uploaded['full_path']);                    

                    if ($width == $height) {
                        $new_width = $new_width;
                        $new_height = $new_width;
                    } 
					else if ($width > $height && $new_height < $height) {
                        $new_height = $height / ($width / $new_width);
                    } 
					else if ($width < $height && $new_width < $width) {
                        $new_width = $width / ($height / $new_height);
                    } 
					else {
                        $new_width = $width;
                        $new_height = $height;
                    }

					// Additional image lib configuration
					$imagelib_config['source_image'] = $file_uploaded['full_path'];
					$imagelib_config['width'] = $new_width;
					$imagelib_config['height'] = $new_height;
                    
                    $this->CI->load->library('image_lib');
                    $this->CI->image_lib->initialize($imagelib_config);
                    $this->CI->image_lib->resize();
                }
            }                        
        } else {
            $this->errors =  $this->CI->upload->display_errors();			
            return null;
        }

        return $ret_filename;
    }
	
	function display_errors() {
		return $this->errors;
	}

}