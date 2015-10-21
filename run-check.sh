#!/usr/bin/env bash
phpcs_param="--standard=PSR2 ./src/"

echo "use php code beautifier and fixer"
./vendor/bin/phpcbf ${phpcs_param}

echo "check style"
./vendor/bin/phpcs ${phpcs_param}

echo "run phpunit"
./vendor/bin/phpunit
