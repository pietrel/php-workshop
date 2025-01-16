.PHONY: test coverage install update clean help

PHPUNIT=vendor/bin/phpunit
TEST_DIR=tests

test:
	@$(PHPUNIT) --testdox $(TEST_DIR)

coverage:
	@$(PHPUNIT) --coverage-html coverage $(TEST_DIR)
	@echo "Coverage report generated in the 'coverage' directory."

install:
	@composer install
	@echo "Dependencies installed."

update:
	@composer update
	@echo "Dependencies updated."

clean:
	@rm -rf coverage
	@echo "Cleaned up generated files."

