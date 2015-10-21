#!/usr/bin/env bash
echo "check style"
./vendor/bin/phpcs --standard=PSR2 ./src/

echo "run phpunit"
./vendor/bin/phpunit
