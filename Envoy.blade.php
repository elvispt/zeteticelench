@servers(['web' => ['root@159.65.199.206']])

@story('deploy',  ['on' => 'web'])
  init
  changes
  packages
  cache
  migrate
  finish
@endstory

@task('init')
  touch .envoy_zeteticelench_installing
  /snap/bin/docker exec zeteticelench php artisan down
  /snap/bin/docker exec zeteticelench ./envoy_kill_worker.sh
@endtask

@task('changes')
  /snap/bin/docker exec zeteticelench git pull
  /snap/bin/docker exec zeteticelench service apache2 reload
@endtask

@task('packages')
  /snap/bin/docker exec zeteticelench composer install --no-dev
  /snap/bin/docker exec zeteticelench service apache2 reload
@endtask

@task('cache')
  /snap/bin/docker exec zeteticelench php artisan view:cache
  /snap/bin/docker exec zeteticelench php artisan cache:clear
  /snap/bin/docker exec zeteticelench service apache2 reload
@endtask

@task('migrate')
  /snap/bin/docker exec zeteticelench php artisan migrate --force
@endtask

@task('finish')
  /snap/bin/docker exec zeteticelench php artisan up
  /snap/bin/docker exec -d zeteticelench runuser -u www-data nohup php artisan queue:work &
  rm .envoy_zeteticelench_installing
@endtask
