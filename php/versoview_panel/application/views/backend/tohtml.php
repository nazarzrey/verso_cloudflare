
<?php 
 echo form_open_multipart('backend/do_upload');
 echo form_input(array('type' => 'file','name' => 'userfile'));
 echo form_submit('submit','upload'); 
 echo form_close(); 
 ?>