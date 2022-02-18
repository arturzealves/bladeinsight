up:
	docker-compose up --remove-orphans
dev:
	docker-compose run --service-ports --rm php bash
down:
	docker-compose down --volumes

test:
	./vendor/phpunit/phpunit/phpunit -c phpunit.xml
