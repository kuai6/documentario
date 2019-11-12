#!/usr/bin/env bash
set -ex

# Link dynamic configurations of www.conf to nginx
ln -rsf conf/www.d/ /etc/nginx/

# Process template file and replace default.conf of nginx
envsubst \
    '$PORT $FPM_URL' \
    < conf/www.tpl.nginx \
    > /etc/nginx/conf.d/default.conf

exec "$@"