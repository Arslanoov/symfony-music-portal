start: clean build up
test: test-unit test-functional

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