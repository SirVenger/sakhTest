prepare-project:
	cp docker-compose.yml.dist docker-compose.yml

migrate:
	docker-compose exec php bash -c 'php bin/console doctrine:database:drop --force'
	docker-compose exec php bash -c 'php bin/console doctrine:database:create'
	docker-compose exec php bash -c 'php bin/console doctrine:migration:migrate'