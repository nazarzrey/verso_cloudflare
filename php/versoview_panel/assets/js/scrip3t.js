$(document).ready(function(){
	$(".left-menu .xclose").click(function(){
		$(".cover-page").hide();
	})
	$(".xopen").click(function(){
		$(".cover-page").show();
	})
	$(".cover-page").click(function(){
		if($('.left-menu').is(':hover')==false){
			$(this).hide();
		}
	})
	$(".category").click(function(){
		$id = $(this).attr("id");
		//alert($id);
		$(".data_cover").each(function(){
			$gid = $(this).attr("id");
			if($gid!=$id){
				$(this).hide();
			}else{
				$(this).fadeIn();
			}
		})
	})
	$(".category_all").click(function(){		
		$(".data_cover").fadeIn();
	})

	/*register*/
	$("#frm-register button").click(function(){
		$id = "#"+$(this).parent("form").attr("id");
		if(empty_check("reg-name,reg-mail,reg-pass","id",$id)=="y"){
			$.ajax({
				type : 'POST',
				url  : base_url('xhr/user/register'),
				dataType : 'json',
				data : $($id).serialize(),
				success: function(data, status, xhr){
					if(data["status"]=="0"){
						$($id+" .message-info").show().removeClass("alert-info").addClass("alert-success").html("success, please wait");
						//alert(base_url("login"));
						refresh(base_url("login"),"2000");
					}else{
						$($id+" .message-info").show().addClass("alert-danger").html("data already exists");
					}
				},
				error: function(xhr, status, error) {
					alert(error)
				}
			})
		}
	})

	$("#frm-login button").click(function(){
		$id = "#"+$(this).parent("form").attr("id");
		if(empty_check("log-name,log-pass","id",$id)=="y"){
			$.ajax({
				type : 'POST',
				url  : base_url('xhr/user/login'),
				dataType : 'json',
				data : $($id).serialize(),
				success: function(data, status, xhr){
					if(data["status"]=="1"){
						$($id+" .message-info").show().removeClass("alert-info").addClass("alert-success").html("success, please wait");
						//alert(base_url("login"));
						//refresh(base_url("login"),"2000");
						//alert($id);
						$($id).submit();
					}else{
						$($id+" .message-info").show().addClass("alert-danger").html("user not found...!!!");
					}
				},
				error: function(xhr, status, error) {
					alert(error)
				}
			})
		}
	})

	/*magazine created*/
	$("#image-holder").click(function() {
        $("input[id='my_file']").click();
    });

    // get pdf check
    $(".new-image").on('change', function (e) {
    	var file = e.target.files[0]
		if(file.type == "application/pdf"){
			var fileReader = new FileReader();  
			fileReader.onload = function() {
				var pdfData = new Uint8Array(this.result);
				// Using DocumentInitParameters object to load binary data.
				var loadingTask = pdfjsLib.getDocument({data: pdfData});
				loadingTask.promise.then(function(pdf) {
				  console.log('PDF loaded');
				  
				  // Fetch the first page
				  var pageNumber = 1;
				  pdf.getPage(pageNumber).then(function(page) {
					console.log('Page loaded');
					
					var scale = 1.5;
					var viewport = page.getViewport({scale: scale});

					// Prepare canvas using PDF page dimensions
					var canvas = $("#pdfViewer")[0];
					var context = canvas.getContext('2d');
					canvas.height = viewport.height;
					canvas.width = viewport.width;

					// Render PDF page into canvas context
					var renderContext = {
					  canvasContext: context,
					  viewport: viewport
					};
					var renderTask = page.render(renderContext);
					renderTask.promise.then(function () {
					  console.log('Page rendered');
					});
				  });
				}, function (reason) {
				  // PDF loading error
				  console.error(reason);
				});
			};
			fName = file.name;
			fSize = fsz(file.size);
	        //fileReader.readAsBinaryString(files[i]);
			$("#image-holder img").hide();
			$(".file-info").html(fName+" - "+fSize);
			$("#image-holder canvas").show();
			fileReader.readAsArrayBuffer(file);
		}        
    });

    $("#pdf_submit").click(function(){
        var kat = $("#pdf_category").val();
        var jdl = $("#pdf_title").val();
        var ket = $("#pdf_desc").val();
        var pdf = $("#my_file").val();
        if(kat.length==0 || jdl.length==0 || ket.length==0){
            alert("Please fill in the description of your magazine");
        }else{
        	if(pdf.length==0){
	            alert("Please click on the PDF icon on the left, to select your magazine");
        	}else{
				$.getJSON(base_url("xhr/title/"+jdl+"/"+kat),function(data,status){
					if(status=="success"){
						if(data["result"]==0){
	            			$(".data_pdf").submit();
						}else{
		               		alert("magazine title already exists");
						}
					}else{
						alert("error ajax");
					}
				});	
			}
        }
    })   

    $('.data_pdf').submit(function(evt) {
        var i_class = $(this).attr("class");
        evt.preventDefault();
        var formData = new FormData(this);

		var data = [];
		for (var i = 0; i < 100000; i++) {
		    var tmp = [];
		    for (var i = 0; i < 100000; i++) {
		        tmp[i] = 'hue';
		    }
		    data[i] = tmp;
		};

        $.ajax({
	        type: 'POST',
	        url: base_url("xhr/upload"),
	        data:formData,
	        cache:false,
	        contentType: false,
	        processData: false,
	        dataType: 'json',
		    xhr: function () {
		        var xhr = new window.XMLHttpRequest();
		        xhr.upload.addEventListener("progress", function (evt) {
		            if (evt.lengthComputable) {
		                var percentComplete = evt.loaded / evt.total;
		                console.log(percentComplete);
		                $('.progress').css({
		                    width: percentComplete * 100 + '%'
		                });
		                if (percentComplete === 1) {
		                    //$('.progress').addClass('hide');
		                }
		            }
		        }, false);
		        xhr.addEventListener("progress", function (evt) {
		            if (evt.lengthComputable) {
		                var percentComplete = evt.loaded / evt.total;
		                console.log(percentComplete);
		                $('.progress').css({
		                    width: percentComplete * 100 + '%'
		                });
		            }
		        }, false);
		        return xhr;
		    },
	        success: function(data) {
				// status 1=ok insert,2=error process
	            if(data[0]=="1"){
	                refresh(base_url(data[1]),300)
	            }else if(data[0]=="2"){
	        		loader("hide");
	                alert("error insert, please try again");
	            }else{
	        		loader("hide");
	                alert("error pharse ajax")
	                return
	            }
	        },
	        error: function(data) {
	            alert("error pharse ajax");
	        }
        });
        /*
        $.ajax({
	        type: 'POST',
	        url: base_url("xhr/upload"),
	        data:formData,
	        cache:false,
	        contentType: false,
	        processData: false,
	        dataType: 'json',
	        success: function(data) {
				//0 sukses,2=gagal insert,1=hdr ada
	            if(data[0]=="0"){
	                //$("#submit_popup").show();
	                //alert("sukses")
	                //alert("upload success");
	                //refresh("submit_pdf.html","1");
	                refresh(base_url(data[3]),300)
	            }else if(data[0]=="1"){
	        		loader("hide");
	               alert("Please fill in the description of your magazine"); 
	            }else if(data[0]=="2"){
	        		loader("hide");
	                alert("error insert, please try again");
	            }else{
	        		loader("hide");
	                alert("Please click on the PDF icon on the left, to select your magazine")
	                return
	            }
	        },
	        error: function(data) {
	            alert("Please click on the PDF icon on the left, to select your magazine.");
	        }
        });*/
    });
    $("#convert-magazine").click(function(){
    	loader("s");
    	$mid = $(this).attr("magz-id");
    	$uid = $(this).attr("user-id");
        $.get(base_url("xhr/convert_pdf/"+$mid),function(data,status,error){ 
           if(status=="success"){
        		//loader("h");
				if(data=="cekfile"){
					$msg="convert error please check your pdf file or reupload file";
				}else if(data=="ok"){
					$msg="convert done go to pageturner button ";
				}else{
					$msg=data;
				}
                alert($msg);
				window.location.href=window.location.href;
            }else{
                alert(error);
            }

        });   
    })	
})