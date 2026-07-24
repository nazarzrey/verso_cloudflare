#!/bin/bash

nxfile=$(date '+%y%d%m%H%M')"versoview.zip"
dbfront=$(date '+%y%d%m%H%M')"front.sql"
dbback=$(date '+%y%d%m%H%M')"back.sql"
cd /var/www/panel/
sudo msyqldump -u root -p2r3yAppV13WL0k verso_front >backup/$dbfront
sudo mysqldump -u root -pNazarApp versoview >backup/$dbback
zip -r backup/$nxfile assets/js/ assets/css/ application/controllers/ application/views/ application/helpers/ application/models/ application/config/config.php application/config/routes.php backup/$dbfront backup/$dbback
#    echo $(date '+%y%d%m%H%M')$xfile".zip"
#echo $nxfile;



