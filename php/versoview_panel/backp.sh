#!/bin/bash

nxfile=$(date '+%y%d%m%H%M')"versoview.zip"
cd /var/www/html/
zip -r backup/$nxfile assets/js/ assets/css/ application/controllers/ application/views/ application/helpers/ application/models/ application/config/
#    echo $(date '+%y%d%m%H%M')$xfile".zip"
#echo $nxfile;