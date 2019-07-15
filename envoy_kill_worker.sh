#!/usr/bin/env bash

# find pid of queue worker
worker_pid=$(ps aux | grep 'nohup php artisan queue:work' | grep -v 'grep' | awk '{print $2}')

if [[ -z "$worker_pid" ]]
then
  echo "[INFO] Queue worker is not running."
else
  kill ${worker_pid};
fi
