Codeigniter Easy Upload is small library which can used to upload, Reatrive and remove file to and from server. It's possible to create thumbnail when file uploaded is image.

## Required files:
- application/config/easy_upload.php
- application/libraries/Easy_upload.php

## Configuration:
- open application/config/easy_upload.php and specify where to upload, is file uploaded name would be encrypted, etc.

```php
$config["default"]['file_upload']['upload_path'] = "./uploads/images"; 
$config["default"]['file_upload']['encrypt_name'] = false;
$config["default"]['file_upload']['allowed_types'] = "jpg|jpeg|png|bmp|gif|pdf|doc|docx|xls|xlsx|rtf";
$config["default"]['image_lib']['image_library'] = 'gd2';
$config["default"]['image_lib']['create_thumb'] = true;
$config["default"]['image_lib']['maintain_ratio'] = false;
$config["default"]['image_lib']['width'] = 287;
$config["default"]['image_lib']['height'] = 50;
```

- if you want to make multiple configuration, just copy and paste from default configuration and give it uniqe name, for example custom

```php
$config["cutsom"]['file_upload']['upload_path'] = "./uploads/docs"; 
$config["cutsom"]['file_upload']['encrypt_name'] = false;
$config["cutsom"]['file_upload']['allowed_types'] = "pdf|doc|docx|xls|xlsx|rtf";
```

- make sure you create directory which defined in upload_path configuration

## Upload the file:
- make sure you use form_open_multipart in view file
- in controller you can use this code:
```php
$this->load->library('easy_upload');
$this->easy_upload->upload_file('the_image'); // the_image is name of HTML input elemen
```