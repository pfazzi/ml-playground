psalm:
	./vendor/bin/psalm

phpunit:
	 ./vendor/bin/phpunit test

qa: psalm phpunit