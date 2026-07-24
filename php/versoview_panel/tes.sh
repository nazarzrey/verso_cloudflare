#!/bin/bash

echo "Nama File : "
read xfile

if [ "$xfile" == "" ]; then
        echo  "nama file ga boleh kosong"
else
nxfile=$(date '+%y%d%m%H%M')$xfile".zip"
	cd /var/www/html/
	zip -r backup/$nxfile assets/js/ assets/css/ application/controllers/ application/views/ application/helpers/ application/models/ application/config/
    #    echo $(date '+%y%d%m%H%M')$xfile".zip"
	#echo $nxfile;
fi


