#!/bin/bash

mkdir -m 777 ../../docker_data
mkdir -m 777 ../../docker_data/db
mkdir -m 777 ../../docker_data/dump
mkdir -m 777 ../../docker_data/tmp
mkdir -m 777 ../../docker_data/logs
mkdir -m 777 ../../docker_data/logs/nginx
mkdir -m 777 ../../docker_data/logs/php
chmod -R 777 ../web/assets

docker-compose up -d --build
sleep 5
docker exec wwp_db mysql -uroot -prootpwd --init-command="CREATE DATABASE IF NOT EXISTS wwp"
docker exec wwp_php composer install
docker exec wwp_php php yii cron/initdb
docker exec wwp_php php yii migrate