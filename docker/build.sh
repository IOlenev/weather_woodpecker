#!/bin/bash

mkdir -m 777 ../../docker_data
mkdir -m 777 ../../docker_data/db
mkdir -m 777 ../../docker_data/dump
mkdir -m 777 ../../docker_data/tmp
mkdir -m 777 ../../docker_data/logs
mkdir -m 777 ../../docker_data/logs/nginx
mkdir -m 777 ../../docker_data/logs/php

docker-compose up -d --build
