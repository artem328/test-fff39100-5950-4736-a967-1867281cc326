# Test Assignment

## Setup
1. Copy `.env.dist` file to `.env` and modify configs by your needs
2. Run `docker-compose up -d`
3. Open http://localhost:<EXTERNAL_HTTP_PORT>/api/doc ([http://localhost/api/doc](http://localhost/api/doc) by default) in the browser

## Data Fixtures

In order to populate database with sample data, run `docker-compose exec php bin/console doctrine:fixtures:load`

## Notes

The following was done intentionally, and production should or even must be improved for production:

- API endpoints that return collections of data will return all records (instead of paged chunks)
- Validation response are not explicit (should display where exactly validation constraints were violated)
- \App\Transfer\TransferProcessor depends on Doctrine's EntityManager. Could be an abstraction over doctrine
- \App\Transfer\TransferProcessor does not lock wallet balance when updating it. Possible data corruption if simultaneous requests update one wallet's balance.
- I'm not a fan of forms for mapping request to DTO, but it is a simple approach.
- Tests, codestyle tools and static analysis tools should be added