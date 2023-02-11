build:
	docker compose build --no-cache --force-rm --pull
start:
	docker compose run --rm node yarn
	docker compose --env-file=".env.local" up -d
stop:
	docker compose stop
restart:
	docker compose restart
logs:
	docker compose logs -f
down:
	docker compose down
npm:
	docker compose exec node npm $(filter-out $@,$(MAKECMDGOALS))