
<section id="submit_pdf" style="overflow: auto">
      <div class="preview_pdf">
  			<div id="image-holder">
  				<img src="<?=assets("images/pdf_box.png") ?>" >
          <canvas id="pdfViewer" style="display: none"></canvas>
  			</div>
        <div class="file-info"></div>
      </div>
      <div>
      <form enctype="multipart/form-data" class="data_pdf" method="post" id="upload_pdf">  
      <!-- <form method="POST"  enctype="multipart/form-data"> -->
      <input type="file" id="my_file" name="new-pdf" class="hilang new-image" accept="application/pdf"> 
      <input class="hilang img_default" data-href="458"> 
      <table style="padding:10px;width: 100%">
        <tbody><tr class="hilang">
          <td>
            <b>User ID</b><br> 
            <input type="text" name="uid" id="uid" required="" value="<?= $session["uid"]; ?>">
          </td>
        </tr>
      	<tr>
      		<td>
      		<b>Category</b><br>
      		<select name="pdf_category" id="pdf_category" required="">
              <option value="">Choose your category</option>
              <option value='1'>Art</option>
              <option value='2'>Automotive</option>
              <option value='3'>Entertainment</option>
              <option value='4'>Home</option>
              <option value='5'>Lifestyle</option>
              <option value='6'>Men</option>
              <option value='7'>News</option>
              <option value='8'>Science &amp; Tech</option>
              <option value='9'>Sport</option>
              <option value='10'>Travel</option>
              <option value='11'>Women</option>
              <option value='12'>Fashion &amp; Style</option>			
            </select>
      		</td>
      	</tr>
      	<tr>
      		<td>
      			<b>Title</b><br>	
      			<input type="text" name="pdf_title" id="pdf_title" placeholder="Your Magazine Title" required="" autocomplete="off">
      		</td>
      	</tr>
      		<td>
      			<b>Description</b><br>
      			<textarea name="pdf_desc" id="pdf_desc" placeholder="Brief explanation of your pdf in minimum 140 characters" required=""></textarea>
      		</td>
      	</tr>
      	<tr>
      		<td>
      			<input type="button" name="pdf_submit" id="pdf_submit" class="button2 nbg ver-bg4 ver-clr1" value="UPLOAD">
      		</td>
      	</tr>
      </tbody>
      </table>
       <div class="alert alert-info alert-danger txc nmp message-info">info</div>
      </form>
      </div>
    </section>