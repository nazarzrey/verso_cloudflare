<html>
<style>
	textarea{width:500%;height:100%};margin:0</style>
<?php
// Read 14 characters starting from the 21st character

// Meta tag HTML (probably it's already set): 
$file = '/var/log/mail.log';
$section = file_get_contents($file,true);
echo "<textarea  wrap='soft'>$section</textarea>";
?>
</html>
