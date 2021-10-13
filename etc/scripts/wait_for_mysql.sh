#!/bin/bash

set -e

host="$1"
port=$2
user="$3"
pass="$4"

shift 4

if ! command -v mysql &> /dev/null
then
    echo "Error: \"mysql\" CLI could not be found"
    exit
fi

echo "Waiting for $host:$port"
until mysql -h "$host" -P $port -u"$user" -p"$pass" -e "SELECT 1;" &> /dev/null
do
  printf "."
  sleep 1
done

echo -e "\n$host:$port ready"

