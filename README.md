# Doctrine Extra Skeleton

Advanced Nette and Doctrine project skeleton with Nettrine and Contributte integrations.

## Requirements

- PHP 8.4 or newer
- [Composer](https://getcomposer.org/)
- `make` for the provided development commands
- Docker Compose for the container stack

## Native quick start

Start PostgreSQL 15 with the credentials tracked in `config/local.neon.dist`: host `localhost`, database `doctrine`, user `doctrine`, and password `doctrine`.

```bash
composer create-project contributte/doctrine-extra-skeleton acme
cd acme
make setup
NETTE_DEBUG=1 bin/console migrations:migrate --no-interaction
NETTE_DEBUG=1 bin/console doctrine:fixtures:load --no-interaction --append
make dev
```

`composer create-project` installs the dependencies, and its post-install script creates `config/local.neon` from `config/local.neon.dist`. Keep that generated file for local overrides; it is not committed. `make setup` only creates the writable runtime directories, avoiding a second Composer install.

The commands above apply pending migrations and append fixtures without first dropping the database. To intentionally reset a disposable development database, run `make build`; it drops the complete schema before migrating and appending fixtures.

The development server listens on <http://localhost:8000>. The default route renders the Basic presenter, including the books, categories, and tags loaded by the fixtures.

## Docker Compose

Start the stack with:

```bash
docker compose up
```

Compose uses a separate database configuration. Before starting it, set `config/local.neon` to:

```neon
parameters:
	database:
		host: database
		dbname: contributte
		user: contributte
		password: contributte
```

The application is available at <http://localhost> and <https://localhost>; Adminer is available at <http://localhost:8081>. The PostgreSQL 15 service is internal to the Compose network. The PHP container installs dependencies, runs migrations, and loads fixtures at startup, so use the full stack with a fresh disposable database volume.

The `make docker-postgres` target starts an older PostgreSQL image with different database defaults and is not compatible with the native quick-start configuration above.

## Development

```bash
make qa       # coding standard and static analysis
make tests    # Nette Tester suite
make cs       # coding standard check
make csf      # fix coding standard issues
make phpstan  # static analysis
make coverage # generate coverage.xml
```
