#!/usr/bin/env bash
set -e

PHP=$(which php)

${PHP} bin/migratons migrations:migrate --no-interaction

${PHP} vendor/bin/openapi src/Application/ --output public/openapi.yml

exec "$@"