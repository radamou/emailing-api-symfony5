.PHONY: composer test-security

RUN_COMPOSER_SECURITY_CHECKER=docker run --rm -t -v $(CURRENT_DIR):/src adamculp/php-security-checker:latest

composer:
	$(PHP_EXEC_WWW) sh -c "composer self-update"
	$(PHP_EXEC_WWW) sh -c "composer validate"

test-security:
	$(RUN_COMPOSER_SECURITY_CHECKER) php /usr/local/lib/php-security-checker/vendor/bin/security-checker security:check ./composer.lock > ./security_check_results.txt
