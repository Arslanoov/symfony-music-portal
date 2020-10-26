start: clean build up
test: test-unit test-functional
clear-cache: api-clear-cache

test-unit: api-unit-tests-run
test-functional: api-load-fixtures api-functional-tests-run

clean: docker-clean
build: docker-build
up: docker-up

docker-clean:
	docker-compose down --remove-orphans

docker-build:
	docker-compose build

docker-up:
	docker-compose up -d

generate-migration:
	docker-compose run --rm api-php-cli php bin/console do:mi:di

migrate:
	docker-compose run --rm api-php-cli php bin/console do:mi:mi

api-load-fixtures:
	docker-compose run --rm api-php-cli php bin/console doctrine:fixtures:load --no-interaction

api-tests-run:
	docker-compose run --rm api-php-cli php bin/phpunit

api-unit-tests-run:
	docker-compose run --rm api-php-cli php bin/phpunit --testsuite=Unit

api-functional-tests-run:
	docker-compose run --rm api-php-cli php bin/phpunit --testsuite=Functional

api-generate-oauth-keys:
	docker-compose run --rm api-php-cli mkdir -p var/oauth
	docker-compose run --rm api-php-cli openssl genrsa -out var/oauth/private.key 2048
	docker-compose run --rm api-php-cli openssl rsa -in var/oauth/private.key -pubout -out var/oauth/public.key
	docker-compose run --rm api-php-cli chmod 644 var/oauth/private.key var/oauth/public.key

api-clear-cache:
	docker-compose run --rm api-php-cli php bin/console cache:clear

api-lint:
	docker-compose run --rm api-php-cli composer lint