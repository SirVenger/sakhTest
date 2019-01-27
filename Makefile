prepare-project:
	docker-compose exec php bash -c 'composer install'
migrate:
	docker-compose exec php bash -c 'php bin/console doctrine:database:drop --force'
	docker-compose exec php bash -c 'php bin/console doctrine:database:create'
	docker-compose exec php bash -c 'php bin/console doctrine:migration:migrate'
	docker-compose exec php bash -c 'php bin/console doctrine:fixtures:load'
