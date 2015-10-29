#!/bin/bash
#Description: Images downloader
# Run at terminal 
# "chmod +x ./img_downloader.sh"
# "./img_downloader.sh <URL-LINK>"
#Filename: img_downloader.sh

wget -nd -r -l1 -p -np -A jpg -e robots=off $1

rsync -a --remove-source-files --include='*.jpg' --exclude='*.sh' ./ backup
