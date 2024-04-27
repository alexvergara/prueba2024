#!/bin/bash
#sudo rm -rf database/data
docker-compose up --force-recreate || docker compose up --force-recreate
