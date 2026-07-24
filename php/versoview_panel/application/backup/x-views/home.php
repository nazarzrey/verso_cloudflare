<?php  
#    $this->load->view('file/blank_page');
?>
<?php  
   	 	echo '
    <div style="margin-top:20px;">';
    $this->load->view('file/home_slide');
	    echo '
	    	</div>';
	    echo '
	<div class="container">';
    $this->load->view('file/list_category');
    $this->load->view('file/home_content');
  		echo '
  	</div>';  	
?>