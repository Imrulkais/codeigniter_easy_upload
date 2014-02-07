<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Codeigniter Easy Upload</title>
</head>
<body>
	<h1>Please upload your file</h1>
	<?php echo form_open_multipart('example/upload_file', array('id' => 'FormUpload')); ?>

	<p>
	<label for="the_image">Choose image file to be uploaded :</label>
	<?php echo form_upload("the_image"); ?>
	</p>

	<p>
	<label for="the_doc">Choose document file to be uploaded :</label>
	<?php echo form_upload("the_doc"); ?>
	</p>

	<?php echo form_submit('upload', "Upload Now") ?>

	<?php echo form_close(); ?>
</body>
</html>