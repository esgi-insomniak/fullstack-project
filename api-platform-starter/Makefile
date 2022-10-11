build:
	docker compose build --no-cache --force-rm --pull
	docker compose run --rm php composer install
	make jwt
	make start
	make migration
jwt:
	docker compose run --rm php sh 'set -e && apk add openssl && php bin/console lexik:jwt:generate-keypair && setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt && setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt'
start:
	docker compose up -d
stop:
	docker compose stop
restart:
	docker compose restart
logs:
	docker compose logs -f
down:
	docker compose down
fixtures:
	docker compose exec php bin/console doctrine:fixtures:load --no-interaction
migration:
	docker compose exec php bin/console make:migration
	make migrate
migrate:
	docker compose exec php bin/console doctrine:migrations:migrate --no-interaction
bash:
	docker compose exec php sh
composer:
	docker compose exec php composer $(filter-out $@,$(MAKECMDGOALS))
entity:
	docker compose exec php bin/console make:entity $(filter-out $@,$(MAKECMDGOALS))
test:
	docker compose exec php php bin/console doctrine:database:drop --force --if-exists --env=test
	docker compose exec php php bin/console doctrine:database:create --env=test
	docker compose exec -T php php bin/console -e test doctrine:migrations:migrate --no-interaction
	docker compose exec -T php php bin/console doctrine:fixtures:load --no-interaction --env=test
	docker compose exec php bin/phpunit

