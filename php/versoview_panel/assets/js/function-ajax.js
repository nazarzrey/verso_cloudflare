
function crud($frm_id,$exec){
	//if($($frm_id).length){msg1($frm_id)};
	loader("s");
	$.ajax({
		type : 'POST',
		url  : base_url('xhr/crud/')+$exec,
		//dataType : 'json',
		data : $($frm_id).serialize(),
		success: function(data, status, xhr){
			$dl = data.length;
			if($dl>10){
				if(data.substring(0,10)=="cetak_data"){
					msg1(data.substring(13,$dl));
					return false;
				}else if(data.substring(0,5)=="error"){
					msg1(data.substring(6,$dl));
					return false;
				}else if(data.substring(0,6)=="sukses"){
					msg1(data.substring(7,$dl));
					refresh("",100);
				}else if($frm_id=="#dataplasma"){		
					$("#transaksi-controller .btn-cancel").click();
					showtrans1("result-dataplasma","0");
					showtrans2("result-dataplasma2");
				}else if($frm_id=="#lap-barang" || $frm_id=="#lap-plasma"){		
					$(".data-laporan").html(data).show();
				}else{
					$id_class = "result-"+$frm_id.replace("#","").replace(".","");
					 if($("."+$id_class).length){
						$("."+$id_class).html(data);
					}else if($("#"+$id_class).length){
						$("#"+$id_class).html(data);
					}
				}
			loader("h");
			}else{
				if(data=="1"){
					msg1("sukses ");
					refresh("",100);
				}else if(data=="reload"){
					$("#transaksi-controller .btn-cancel").click();
					showtrans1("result-dataplasma","0");
					showtrans2("result-dataplasma2");
				}else if(data=="refresh"){
					refresh("",100);
				}else if(data=="x"){
					msg1("nama tersebut sudah ada pada database silahkan ulangi");
				}else if(data=="e"){
					msg1("sukses di edit");
					refresh("",100);
				}else if(data=="ex"){
					msg1("gagal di edit");
				}else if(data=="d"){
					msg1("sukses di hapus");
					refresh("",100);
				}else if(data=="dx"){
					msg1("gagal di hapus");
				}else if(data=="pls-no"){
					msg1("gagal save data, silahkan ulangi");
					refresh("",100);
				}else if(data=="gacukup"){
					msg1("total qty melebihi dari hitungan sisa");
					return false;
				}else if(data=="del-gagal"){
					msg1("gagal hapus transaksi");
					return false;
				}else{
					msg1("data belum ada yang dipilih..!");
				}
			loader("h");
			}
		},
		error: function(xhr, status, error) {
			loader("h");
			msg1(error)
		}
	})
}
function proses_trans($struk){
	loader("s");
	$.get(base_url('xhr/transplasm/proses:')+uid()+$struk,function(data,status){
		if(status=="success"){
			if(data=="1"){
				msg1("sukses di proses");
			}else if(data=="0"){
				msg1("gagal proses")
			}else{
				cetak(data);
			}
		}else{
			msg1("error parse");
		}
		loader("h");
		refresh("",100);
	});
};
function cetak(xdata){
	$.get(base_url('xhr/transplasm/struk/')+xdata,function(data,status){
		if(status=="success"){
			msg1("sukses diproses dan dicetak");
		}else{
			msg1("gagal dicetak");
		}
		loader("h");
		refresh("",100);
	});
}
function save(){
	$id = "#frm-plasma";
	$.ajax({
		type : 'POST',
		url  : base_url('xhr/transplasm'),
		// dataType : 'json',
		data : $($id).serialize(),
		success: function(data, status, xhr){
			if(data=="x"){
				msg1("data belum ada yang dipilih");
			}else{
				$("#result-trans").html(data);
				$(".data-barang input").val("0");
				$(".data-barang select").val($(".data-barang select option:first").val());
				$("#payment").removeClass("hilang");
			}
		},
		error: function(xhr, status, error) {
			msg1(error)
		}
	})
}
function result($exec,$id,$result){	
	loader("s");
	$.get(base_url('xhr/result/'+$exec+"/"+$id),function(data,status){
		if(status=="success"){
			loader("h");
			if($("#"+$result).length){
				$("#"+$result).html(data);
			}else{
				$("."+$result).html(data);
			}
			if($exec=="plasma"){
				$harga = $(".plasma-select").attr("data-price");
				$("#hargabarang").val($harga);
			}
		}else{
			loader("h");
			msg1("error parse");
		}
	});
}
function showtrans1($frm_id,$id){
	$.get(base_url('xhr/showtrans/'+$id),function(data,status){
		if(status=="success"){
			$id_class = $frm_id.replace("#","").replace(".","");
			 if($("."+$id_class).length){
				$("."+$id_class).html(data);
			}else if($("#"+$id_class).length){
				$("#"+$id_class).html(data);
			}
			btntambah();
		}
	});
}
function showtrans2($frm_id){
	$.get(base_url('xhr/showtrans2'),function(data,status){
		if(status=="success"){
			$id_class = $frm_id.replace("#","").replace(".","");
			 if($("."+$id_class).length){
				$("."+$id_class).html(data);
			}else if($("#"+$id_class).length){
				$("#"+$id_class).html(data);
			}
		}
	});
}
function btntambah(){
	$id = $("#barang_id").val();
	if(sisa($id)==0){
		hilang("tambah-plasma")
	}else{
		muncul("tambah-plasma")
	}
}

function sisa($id){
	var jqXHR = $.ajax({
		url   : base_url('xhr/result/sisa/'+$id),
		async : false
	});
	return jqXHR.responseText;	
}

function booking_plasma($tipe,$id){
	var jqXHR = $.ajax({
		url   : base_url('xhr/booking/'+$tipe+'/'+$id),
		async : false
	});
	return jqXHR.responseText;	
}