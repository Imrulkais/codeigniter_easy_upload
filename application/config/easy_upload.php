<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['current'] = 'default';

// Default upload configuration
$config["default"]['file_upload']['path_upload'] = "./uploads"; 
$config["default"]['file_upload']['encrypt_name'] = false;
$config["default"]['file_upload']['allowed_types'] = "jpg|jpeg|png|bmp|gif|pdf|doc|docx|xls|xlsx|rtf";
$config["default"]['image_lib']['image_library'] = 'gd2';
$config["default"]['image_lib']['create_thumb'] = true;
$config["default"]['image_lib']['maintain_ratio'] = false;
$config["default"]['image_lib']['width'] = 287;
$config["default"]['image_lib']['height'] = 50;

// Custom upload configuration