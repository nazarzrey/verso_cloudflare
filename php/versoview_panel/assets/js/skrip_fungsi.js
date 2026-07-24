function reset_input(){	
	$('#frm .input_txt0').val("").prop('readonly', false);
	$('#frm .input_txt1').val("").prop('readonly', false);
	$('#frm .input_txt2').val("").prop('readonly', false);
	$(".input_txt0").focus();
}
function reload_pos(){
	if($(".tharga").val()=="grosir"){
		thr = "=grosir";
	}else{
		thr = "";
	}
	$.get('xhr/ajax_request.php?reload_pos'+thr,function(data,status){
		if(status=="success"){
			$("#detail_pos").html(data);
		}else{
			alert("gagal cari data customer");
		}
	});	
	$.get('xhr/ajax_request.php?reload_total'+thr,function(data,status){
		if(status=="success"){
			$("#total_sale").html(data);
			$(".byr_total").val(data);
		}else{
			alert("gagal cari data customer");
		}
	});	
}
function xhr_post(div_id,v_reload,v_url){
	$("#loader").fadeIn();
	$.ajax({
		type : 'POST',
		url  : 'xhr/ajax_post.php?hal='+div_id,
		dataType : 'json',
		data : $("#"+div_id).serialize()
	})
	.done(function(data){
		$("#loader").hide();
		var cek_balikan = data[0];
		var msg_balikan = data[1];
		var id_cetakan  = data[2];
		if(cek_balikan=="N"){
			if(div_id=="data_closing"){
				if(id_cetakan=="0"){
					msg_alert("danger","gagal melakukan closing, karena data sales tidak ada",5000);				
				}else{
					msg_alert("danger","gagal melakukan closing "+ id_cetakan,5000);				
				}
			}else{
				msg_alert("info",msg_balikan,1500);				
			}
		}else{
			if(v_reload=="Y"){
				if(div_id=="data_closing"){
					a("sukses closing sales, dengan varian Rp. "+msg_balikan);
					setTimeout(
						function() {			
							cetak_struk(id_cetakan);							
							setTimeout(
								function() {
									if(data[3]=="Y"){
										cetak_data('cetak_item='+id_cetakan);
									}				
									refresh(v_url,"1");			
								},
							500);
						},
					500);
				}else{
					msg_alert("success",msg_balikan,1500);
					refresh(v_url,"1");					
				}
			}else{			
				reload_pos();
			}
		}
	})
	.fail(function(data,error){
		alert("error ajax "+error);
	});
	return false;	
}
function cetak_struk(cetak){
	$.get('xhr/ajax_request.php?cetak='+cetak,function(data,status){
		if(status=="success"){
			//a("struk sudah di cetak");
		}else{
			alert("gagal cetak data");
		}
	});	
}
function cetak_data(url){
	$.get('xhr/ajax_request.php?'+url,function(data,status){
		if(status=="success"){
			a("data sudah di cetak");
		}else{
			alert("gagal cetak data");
		}
	});	
}
function c_url(){	
	var ip 	      = location.host;
	tringPathName = window.location.pathname;
	x_url	      = "http://"+ip+tringPathName;
	//window.location.href=x_url;
}
function sale(value){
	$('#item_qty').prop('readonly', false);
	$('#item_jual').prop('readonly', false);
	if($(".tharga").val()=="grosir"){
		thr = "&grosir";
	}else{
		thr = "";
	}
	$.getJSON('xhr/ajax_request.php?item='+value+thr,function(data,status){
		if(status=="success"){
			$("#loader").hide();
			if(data[0]=="Y"){
				$("#item_form").show();
				$("#item_kode").val(data[1]);
				$("#item_desc").val(data[2]+' '+data[3]);
				$("#item_harga").val(data[4]);
				$("#item_jual").val(data[5]).select().focus();
				$("#item_ttl_price").val(data[7]);
				$("#item_qty").val(data[6]);
			}else{
				inp_focus("kode_barang");
				msg_alert("info","data tidak ditemukan",0);	
			}
		}else{
			$("#loader").hide();
			if(msg=="Y"){
				alert("gagal syncronize data");
			}
		}
	});
}
function post_item(value){
	$.getJSON('xhr/ajax_request.php?item='+value,function(data,status){
		if(status=="success"){
			$("#loader").hide();
			if(data[0]=="Y"){
				$("#item_form").show();	
				$("#item_kode").val(data[1]);
				$("#item_desc").val(data[2]+' '+data[3]);
				$("#item_harga").val(data[4]);
				$("#item_jual").val(data[5]);
				$("#item_ttl_price").val(data[5]);
				$("#item_qty").val(data[6]);
			}else{
				alert("gagal parse JSON di ajax php");	
			}
		}else{
			$("#loader").hide();
			if(msg=="Y"){
				alert("gagal parse JSON di ajax xhr");	
			}
		}
	});
}
function del_data(data,value,id_fcs,reload){
	$.get('xhr/ajax_request.php?del='+data+'&item='+value,function(data,status){
		if(status=="success"){
			if(reload=="pos"){
				reload_pos();
			}
			setTimeout(
				function() {
					inp_focus(id_fcs);				
				},
			500);
		}else{
			alert("gagal xhr request");
		}
	});	
}
function hide_form(hide_form){
	resetinput(hide_form);
	$("#"+hide_form).hide();
	$("."+hide_form).hide();
}

// clear content div

//Custom Functions that you can call
function resetinput(div_id) {
  $('#'+div_id).find('input:text').val('');
}

function item_order(){
	var harga = angka($("#item_harga").val());
	var jual  = angka($("#item_jual").val());
	var qty   = angka($("#item_qty").val());
	if(jual.length==0 || qty.length==0 || jual==0 || qty==0){
		alert("harga jual / qty tidak boleh kosong / 0");
		return true;			
	}else if(parseInt(jual)<parseInt(harga)){
		alert("harga jual tidak boleh kurang dari harga pokok");
		return true;			
	}else{
		xhr_post("data_item","N","");
		hide_form("item_form");
		inp_focus("kode_barang");
	}
}
function inp_focus(x_id){				 
	setTimeout(
		function() {				
			$("#"+x_id).val("").focus();
			$("."+x_id).val("").focus();
		},
	300);
}
function inp_focus_t(x_id,time){				 
	setTimeout(
		function() {				
			$("#"+x_id).val("").focus();
			$("."+x_id).val("").focus();
		},
	time);
}
function inp_focus_xt(x_id,time){				 
	setTimeout(
		function() {				
			$("#"+x_id).focus();
			$("."+x_id).focus();
		},
	time);
}
function inp_select(x_id){	
	$("#"+x_id).select();
}
function bayar(){
	$("#btn_bayar").click();
}
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
		return false;
	}else{
		return true;		
	}      
}
/* 
function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return val;
  }
$('#elementID').focusout(function(){

  alert(commaSeparateNumber($(this).val()));
});
 */
function refresh(url,dtl){
	$("#loader").fadeIn(); 
	if(dtl.length==0){
		if(url=="home"){
			url = "";
		}else{
			url = url;
		}
		directed = url; 
		window.location.href=directed;	
	}else{	
		window.location.href=url;		
	}
}
function bayar_all(sale,input,rtrn,cetak){
	/* s_total = $("#total_sale").html();
	x_total = s_total.replace(/\./gi,""); */
	$("#kembali").html("");
	if(parseInt(input) < parseInt(sale)){
		alert("total bayar lebih kecil");
	}else{
		if($(".tharga").val()=="grosir"){
			thr = "grosir";
		}else{
			thr = "reguler";
		}
		if(bonus()=="Y"){
			$.get('xhr/ajax_request.php?bayar='+thr+'|'+input+'|'+rtrn+'|'+cetak,function(data,status){
				if(status=="success"){
					if(data=="Y"){
						kembali = $(".byr_return").val();
						$("#totalan").hide();
						$("#kembalian").show()
						var kembali_chr = kembali.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
						$("#kembali").html(kembali_chr);
						add_msg = "";
						if(cetak=="N"){
							add_msg=", struk tidak di cetak";
						}
						msg_alert("success","transaksi sudah di simpan"+add_msg,3500);	
						reload_pos();
						$("#cetakstruk").prop("checked",true);
					}else if(data=="Z"){
						alert("tidak ada data");	
					}else{
						alert("gagal insert transaksi ");	
					}
				}else{
					alert("gagal show data");
				}
			});
		}else{
			alert("gagal simpan bonus sales belum disimpan, silahkan di ulang");
		}
	}	
}
function msg_alert(tipe,txt,time){
	$(".alert-"+tipe).show();
	$(".alert-text").html(txt);
		if(time==0){
			time=1000;
		}else{
			time=time;
		}
		setTimeout(
			function() {
				$(".alert,.alert-"+tipe).fadeOut();				
			},
		time);
}
function hide_form_txt(){
//	alert("ss")
	var counter = 1;
	$('#frm input:text,textarea').each(function(){
		set_id = $(this).attr("id");
		$("#"+set_id).hide();
	})
	$("#input_text").show();
}
function save_data(v_reload,v_url,v_url2,old_kode){
	$("#loader").fadeIn();
	$.ajax({
		type : 'POST',
		url  : 'xhr/ajax_post.php?post='+old_kode,
		dataType : 'json',
		data : $("#frm").serialize(),
		success: function(data, status, xhr){			
			$("#loader").hide();
			var cek_balikan = data[0];
			var msg_balikan = data[1];
			if(cek_balikan=="N"){
				a(msg_balikan);
				$(".input_txt0").focus().select();
			}else{
				if(v_reload=="Y"){
					//refresh(v_url,"1",2000);
					show_hide("xnotif","sh",100,"sukses disimpan");
				}else if(v_reload=="N"){
					reload_form("frm")
					$(".input_txt0").focus();
					show_hide("xnotif","sh",100,"sukses disimpan");
				}else if(v_reload=="L"){
					reload_form("frm")
					show_list("trans-result",v_url2)
					$(".input_txt0").focus();
					show_hide("xnotif","sh",100,"sukses disimpan");
				}else{
					show_hide("xnotif","sh",100,"sukses disimpan");				
				}
			}
		},
		error: function(xhr, status, error) {
			alert(error)
		}
	})	
}
function reload_form(div_id){
	$('#'+div_id).find('input:text,textarea').each(function(){
		if($(this).attr("id")!="input_text"){
			$(this).val("");
		}
	});
}

function cari_data(page,kode,id_class){
	$.getJSON('xhr/ajax_request.php?get='+page+'&val='+kode,function(data,status,error){
		if(status=="success"){
			$("#loader").hide();
		//	alert(page);
			if(page=="add_barang"){
				if(data[0]=="Y"){
					$(".btn_save").attr("disabled",false);
				}else{
					$(".btn_save").attr("disabled",true);
					alert("data "+kode+" "+data[1]+" sudah ada, deskripsi harus lebih spesifik");
					$("#"+id_class).val("").select().focus();
				}
			}else if(page=="cari_barang"){
				if(data[0]=="Y"){
					$(".input_txt1").val(data[1]);
					$(".input_txt2").val(data[2]).select().focus();
					$(".input_txt3").val(data[3]);
					$(".input_txt4").val(data[4]);
				}else{
					a(data[1]);
					$(".input_txt0").select().focus();
					$(".input_txt0,.input_txt1").val("");
				}
			}else if(page=="cari_barang_in" || page=="cari_barang_out" || page=="cari_so"){
				if(data[0]=="Y"){
					$(".input_txt0").prop('readonly', true);
					$(".input_txt1").val(data[1]).prop('readonly', true);
					$(".input_txt2").val(data[2]).select().focus();
					$(".input_txt3").val(data[3]);
					$(".input_txt4").val(data[4]);
				}else{
					a(data[1]);
					$(".input_txt0").select().focus();
					$(".input_txt0,.input_txt1").val("");
				}
			}
		}else{
			$(".btn_save").attr("disabled",false);
		}
	});
}
function cari_desk(kode){
	$.getJSON('xhr/ajax_request.php?get=get_desc&val='+kode,function(data,status,error){
		if(status=="success"){
			if(data[0]=="Y"){
				$(".input_txt1").val(data[1]);
				$(".input_txt2").val(data[2]).select().focus();
				$(".input_txt3").val(data[3]);
				$(".input_txt4").val(data[4]);
			}else{
				alert("data tidak ditemukan");
				$(".input_txt0").select().focus();
				$(".input_txt0,.input_txt1").val("");
			}
		}else{
			$(".btn_save").attr("disabled",false);
		}
	});
}

function show_list_retur(no_sales){
	$.get('xhr/ajax_request.php?list_data_retur='+no_sales,function(data,status){
		if(status=="success"){
			if(data=="x"){
				alert("nomor sales ("+id+") tidak ditemukan...");
				return;
			}
			$("#faktur_data").html(data);			
		}else{
			alert("error ajax "+page+" on data "+id);
		}
	});
}

function data_html(page,id,result){
	$.get('xhr/ajax_request.php?find='+page+'&data='+id,function(data,status){
		if(status=="success"){
			if(data=="x"){
				alert("nomor sales ("+id+") tidak ditemukan...");
				return;
			}
			$("#"+result).html(data);			
 			//$(".ret_sal").click();	
		}else{
			alert("error ajax "+page+" on data "+id);
		}
	});	
}
function faktur(value){
	$.getJSON('xhr/ajax_request.php?retur='+value,function(data,status){
		if(status=="success"){
			$("#loader").hide();
			if(data[0]=="Y"){		
				var ary_ttl = 8;
				for(row = 1;row<=ary_ttl; row++){
					//alert(data[row])
					$("#faktur_dtl_data #fk"+row).val(data[row]);
				}
				$("#faktur_dtl_data #fk7").val(data[8]);
				$("#faktur_dtl_data #fk"+row).val("");
			}else{
				inp_focus("nofak");
				msg_alert("info","data tidak ditemukan",0);	
			}
		}else{
			$("#loader").hide();
			if(msg=="Y"){
				alert("gagal syncronize data");
			}
		}
	});
}
function deleteItem(page,data,modal_click){			
	$.get('xhr/ajax_request.php?delete='+page+'&data='+data,function(data,status){
		if(status=="success"){
			if(modal_click=="N"){
				if(data[0]=="Y"){
					alert("sukses di "+page);
				}else{
					alert("gagal di "+page);
				}
			}else if(modal_click=="A"){
				if(data[0]=="Y"){
					alert("data sudah di hapuskan");					
					window.location.href=window.location.href
				}else if(data[0]=="Z"){
					alert("data hanya di nonaktifkan, karena sudah pernah ada transaksi");					
					window.location.href=window.location.href	
				}else{
					alert("gagal di hapus");
				}
			}else{
				$("."+reload_page).click();
				$("#"+reload_page).click();
			}
		}else{
			alert("gagal cari data customer");
		}
	});	
}
function editItem(page,data,modal_click){			
	$.get('xhr/ajax_request.php?edit='+page+'&data='+data+'&uid='+$uid,function(data,status){
		if(status=="success"){
			if(modal_click!="N"){
				$("."+reload_page).click();
				$("#"+reload_page).click();
			}else{
				if(data=="Y"){
					alert("sukses di edit");
				}else{
					alert("gagal di edit");
				}
			}
		}else{
			alert("gagal cari data customer");
		}
	});	
}
function a(data){
	alert(data)
}
function hapus_data_sales(id,tipe){	
	if(id!="hapus_kasir"){
		total_trans = $(".byr_total").val().replace(/\./g,'');
		if(parseInt(total_trans)==0 || total_trans.length==0 ){
			//alert("data tidak ada");
			return;
		}		
	}
	$.get('xhr/ajax_request.php?del_trans='+id+'&tipe='+tipe,function(data,status){
		if(status=="success" && data!="xx" && data!="xz"){
			if(id=="hapus_kasir"){
				alert("data sales kasir reguler & grosir sudah di hapuskan");			
				refresh("index.php?hal=reclos","1");				
			}else{				
				//07-2018 tambahkan menu pending	
				if(id=="item_pend_all"){
					if(data=="denied"){
						alert("data pending sudah ada 4 tidak bisa pending lagi, silahkan selesaikan dulu data pendingannya");
						return;
					}
				}
				reload_pos()	 
				setTimeout(
					function() {							
						inp_focus("kode_barang");
					},
				500);
				//alert(tipe)
				ttl_pending(tipe);
			}
		}else{
			alert("gagal action form kode "+data);
		}
	});
}
function ttl_pending(kasir){
	$.get('xhr/ajax_request.php?ttl_pending='+kasir,function(data,status){
		if(status=="success"){
			//alert(data);
			// $(".tab-content #2").html(data);

			if(data>0){
				$(".pilihan .pend_reg").html("Pending ("+data+")");
			}else{
				$(".pilihan .pend_reg").html("Pending");
			}			
		}else{
			alert("gagal show list");
		}
	});	
}
function get_pending(kasir,idp){
	$.get('xhr/ajax_request.php?pending='+kasir+"&idp="+idp,function(data,status){
		if(status=="success"){
			if(idp=="0"){
				$(".tab-content #2").html(data);
			}else{
				$("#OPending .modal-body").html(data);
				$("#get_pend_item").attr("data-href",idp);				
				setTimeout(
					function() {
						$("#OPending section").fadeIn()			
					},
				1500);
			}
		}else{
			alert("gagal show list");
		}
	});	
}
function cek_promo(ttl_trans){
	$.getJSON('xhr/ajax_request.php?gratis='+ttl_trans,function(data,status,error){
		if(status=="success"){
			$(".plu_gratis").html("");
			$(".qty_gratis").html("");
			if(data[0]=="Y"){
				$(".bonus").show();
				var array = data[1].split("|");
				$.each(array,function(i){
					$kode_desc = array[i].split("-");
					$(".plu_gratis").append("<option value='"+$kode_desc[0]+"'>"+$kode_desc[0]+" - "+$kode_desc[1]+"</option>");
				});
				$(".plu_gratis").append("<option value='X'>X - tidak dapat bonus</option>");
				qty = parseInt(data[2]);
				/* for(z=qty+1;z--;){
					$(".qty_gratis").append("<option value='"+z+"'>"+z+"</option>");
				} */
				for(z=0;z<=qty;z++){
					$(".qty_gratis").append("<option value='"+z+"'>"+z+"</option>");
				}
			}else{				
				$(".bonus").hide();
				$(".plu_gratis").append("<option value='X'>X - tidak dapat bonus</option>");
				$(".qty_gratis").append("<option value='0'>0</option>");
			}
		}else{
			alert(error);
		}
	});
}
function AddItem(page,kode,qty){
	data = kode+"|"+qty;
	var jqXHR = $.ajax({
		url   : 'xhr/ajax_request.php?add='+page+'&data='+data,
		async : false
	});
	return jqXHR.responseText;	
}
function bonus(){
	$get_kode = $(".plu_gratis").val();
	$get_qty  = $(".qty_gratis").val();
	if($get_kode=="X"){
		$balikan = "Y";
	}else{
		if($get_qty > 0){
			$result = AddItem("diskon",$get_kode,$get_qty);
		}else{
			$result = "Y";
		}
		if($result=="Y"){
			$balikan = "Y";
		}else{
			$balikan = $result;
		}
	}
	return $balikan;
}
function proses_barang(tipe){
	var jqXHR = $.ajax({
		url   : 'xhr/ajax_request.php?proses_brg='+tipe,
		async : false
	});
	return jqXHR.responseText;	
}
function show_list(frm,v_data){	
	$.get('xhr/ajax_request.php?list='+frm+"&data="+v_data,function(data,status){
		if(status=="success"){
			if(frm=="formModalResult"){
				$("#"+frm+",."+frm).addClass("brd-td");
				$("#"+frm+",."+frm).html(data);
			}else{
				if(frm=="stk_result"){
					$("#form_title").attr("plu-kode",v_data);
				}
				$("#"+frm+",."+frm).removeClass("brd-td");
				$("#"+frm+",."+frm).html(data);
			}
		}else{
			alert("gagal show list");
		}
	});	
}
function show_hide(div_class,tipe,waktu,msg){
	$("#modal-footer .xnotif").html(msg);
	if(tipe=="show"){
		$("#modal-footer  ."+div_class).effect("bounce",{ direction: 'left', mode: 'show' },waktu);
	}else if(tipe=="hide"){
		setTimeout(
				function() {	
					$("#modal-footer ."+div_class).effect("bounce",{ direction: 'left', mode: 'hide' },1000);
				},
		waktu);
	}else{
		$("#modal-footer .xnotif").effect("bounce",{ direction: 'left', mode: 'show' },waktu);
		setTimeout(
				function() {	
					$("#modal-footer .xnotif").effect("bounce",{ direction: 'left', mode: 'hide' },1000);
				},
		1500);
	}
}
function remove_currency(str){
	$hasil = str.replace('.','').replace(',','');
	return $hasil;
}
function currency(input) {
    var output = input
    if (parseFloat(input)) {
        input = new String(input); // so you can perform string operations
        var parts = input.split("."); // remove the decimal part
        parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1.").split("").reverse().join("");
        output = parts.join(".");
    }
    return output;
}
function angka(input){
	output = input.replace(/\./g,'').replace(/\,/g,'')
	return output;
}
	
//addThousandsSeparator("1234567890"); // returns 1,234,567,890
//addThousandsSeparator("12345678.90"); // returns 12,345,678.90

function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
//  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
  var targetWin = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
  targetWin.focus();
} 

function popup(datanya){
	$.ajax({
		type : 'POST',
		url  : 'xhr/ajax_request.php?popup='+datanya,
		//dataType : 'json',
		data : $("#data_request").serialize()
	})
	.done(function(data){	
		var w = window.open();
		var html = data;
		$(w.document.body).html(html);
	})
	.fail(function(data,error){
		alert("error ajax "+error);
	});
	return false;
}	

function insert(kode,xform){
	$.get('xhr/ajax_request.php?insert='+kode,function(data,status){
		if(status=="success"){
			if(data=="Y"){
				$(".add_hitul").removeClass("alert-danger").addClass("alert-success");
				$(".add_hitul").fadeIn().html("kode <b>"+kode+"</b>  sudah di tambahkan");
				reload_hitul();
			}else if(data=="R"){
				$(".add_hitul").removeClass("alert-success").addClass("alert-danger");
				$(".add_hitul").fadeIn().html("data hasil hitung ulang yang lama masih ada, silahkan hapus dulu");
				reload_hitul();
			}else if(data=="X"){
				$(".add_hitul").removeClass("alert-success").addClass("alert-danger");
				$(".add_hitul").fadeIn().html(" gagal insert");
			}else if(data=="Z"){
				$(".add_hitul").removeClass("alert-success").addClass("alert-danger");
				$(".add_hitul").fadeIn().html("kode <b>"+kode+"</b> sudah ada didatabase");
			}else if(data=="N"){
				$(".add_hitul").removeClass("alert-success").addClass("alert-danger");
				$(".add_hitul").fadeIn().html("kode <b>"+kode+"</b>  tidak ada di master barang");			
			}
		}else{
			$(".add_hitul").removeClass("alert-success").addClass("alert-danger");
			$(".add_hitul").fadeIn().html("parse error");			
		}
	});
}	
function reload_hitul(){
	$.get('xhr/ajax_request.php?reload_hitul',function(data,status){
		if(status=="success"){
			$(".info_hitul").hide();
			$(".data_hitul").html(data);
		}else{
			alert("error parse");
		}
	});
}
function del_hitul($kode){	
	$.get('xhr/ajax_request.php?del_hitul='+$kode,function(data,status){
		if(status=="success"){
			reload_hitul();
		}else{
			alert("error parse");
		}
	});
}
function retur(get_id){
	$("#fak_rekap").val("No Faktur : "+get_id);
	data_html("faktur",get_id,"faktur_hdr_data");
	$("#faktur_hdra").click();	
}
function data_cat(){	
	data = kode+"|"+qty;
	var jqXHR = $.ajax({
		url   : 'xhr/json.php',
		async : false
	});
	return jqXHR.responseText;	
}
function cek_kasiran(time){	
	setTimeout(
		function() {				
			$.getJSON('xhr/ajax_request.php?cek_kasiran='+$toko,function(data,status){
				if(status=="success"){
					//$("#menu_kasir .")
					$x = data.length;	
					for(row = 0;row<=$x-1; row++){
						//alert(data[row])
						if(data[row][0]=="reguler" && data[row][1]=="1"){
							$("#menu_kasir .r1").text(" ("+data[row][2]+")");
						// }else if(data[row][0]=="reguler" && data[row][1]=="2"){
						// 	$("#menu_kasir .r2").text(" ("+data[row][2]+")");
						// }else if(data[row][0]=="grosir" && data[row][1]=="1"){
							$("#menu_kasir .g1").text(" ("+data[row][2]+")");
						// }else{
						// 	$("#menu_kasir .g2").text(" ("+data[row][2]+")");
						}
					}
				}else{
					alert("error parse");
				}
			});
		},
	time);
}