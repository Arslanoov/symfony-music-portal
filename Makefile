start: clean build up
test: api-tests-run

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

api-tests-run:
	docker-compose run --rm api-php-cli php bin/phpunit