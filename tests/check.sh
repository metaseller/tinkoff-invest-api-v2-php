#!/bin/sh
set -eu

php --version
php --ri grpc
composer validate --strict
composer install --prefer-dist --no-interaction
composer check-platform-reqs
composer audit --locked

# Check every file without printing hundreds of successful lint results.
if ! find src examples tests -name '*.php' -print0 | xargs -0 -n1 php -d error_reporting=E_ALL -l > /tmp/sdk-php-lint.log 2>&1; then
    cat /tmp/sdk-php-lint.log >&2
    exit 1
fi
if grep -v '^No syntax errors detected in ' /tmp/sdk-php-lint.log; then
    echo 'PHP lint failed; see /tmp/sdk-php-lint.log' >&2
    exit 1
fi
printf 'PHP lint passed: %s files\n' "$(wc -l < /tmp/sdk-php-lint.log)"
composer test
