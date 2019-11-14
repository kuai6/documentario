#!/usr/bin/env bash
set -e

PHP=$(which php)

${PHP} bin/migratons migrations:migrate --no-interaction

exec "$@"