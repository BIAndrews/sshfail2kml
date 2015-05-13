#!/bin/bash

if [ -f sshfail2kml ];then

  php -l sshfail2kml

  if [ $? -ne 0 ];then
    echo "Failed PHP validation"
    exit 1
  fi

else

  echo "run this from the root of the repo, like: ./contrib/qa.sh"
  exit 1

fi
