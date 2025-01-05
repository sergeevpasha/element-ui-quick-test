.PHONY: up
up:
	@docker compose up -d

.PHONY: down
down:
	@docker compose down

.PHONY: rebuild
rebuild:
	@docker compose build --no-cache

.PHONY: api
api:
	@docker exec -it element_api bash

.PHONY: client
client:
	@docker exec -it element_client sh