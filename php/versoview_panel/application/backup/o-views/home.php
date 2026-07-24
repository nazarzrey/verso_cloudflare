<?php  
#    $this->load->view('file/blank_page');
?>
<?php  
   	 	echo '
    <div style="margin-top:20px;">';
    $this->load->view('home/home_slide');
	    echo '
	    	</div>';
	    echo '
	<div class="container">';
    $this->load->view('home/list_category');
    $this->load->view('home/home_content');
  		echo '
  	</div>';  	
?>