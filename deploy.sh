#!/bin/bash
#usage example:  ./deploy.sh 'a test'
if [ $# -ne 1 ];then
    echo 'This command needs the message for git commit as the only parameter.'
else
    #grunt build
    git add .
    git commit -m "$1"
    git push
    echo 'The deployment is done!'
fi
