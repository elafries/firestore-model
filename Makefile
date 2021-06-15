test:
	./vendor/bin/phpunit --do-not-cache-result ./tests

update-vendor:
	rm -rf ./vendor && \
	rm ./composer.lock && \
	rm ./composer.json && \
	docker cp "$$(docker-compose ps -q php)":/app/vendor ./vendor && \
	docker cp "$$(docker-compose ps -q php)":/app/composer.json ./composer.json && \
	docker cp "$$(docker-compose ps -q php)":/app/composer.lock ./composer.lock
