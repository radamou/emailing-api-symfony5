DOCKER_COMPOSE=docker-compose
PHP_EXEC=$(DOCKER_COMPOSE) exec sympl-server-php
PHP_EXEC_WWW=$(DOCKER_COMPOSE) exec -u www-data sympl-server-php

.PHONY: cs phpstan

cs:
	$(PHP_EXEC_WWW) sh -c "cd src/SymplBundle/Emailing && php-cs-fixer fix --config=.php_cs --allow-risky=yes --diff --verbose"

phpstan:
	$(PHP_EXEC_WWW) sh -c "bin/phpstan analyse ./src/SymplBundle/Emailing  -l 0 -c ./src/SymplBundle/Emailing/phpstan.neon"