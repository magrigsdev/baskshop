# mvp_basketshop
Install PHPBrew (PHP version manager):

Follow installation guide at: https://github.com/phpbrew/phpbrew
Install phpbrew with variants
phpbrew install php-8.2.27 +default+sqlite+openssl # builds out php with some dependent variants
phpbrew switch php-8.2.27 # sets php version
Install required PHP extensions:
phpbrew ext install iconv
phpbrew ext install ctype
Install Composer (PHP dependency manager):

Follow installation steps at: https://getcomposer.org/download/
Run composer install to install dependencies
Set up local development server:

Install Symfony CLI from: https://symfony.com/download
Start the server: symfony server:start
Access the application:

Open your browser and navigate to: http://localhost:8000/

# requirements:
##The symfony binary also provides a tool to check if your computer meets all requirements. Open your console terminal and run this command:
symfony check:requirements

#Creating Symfony Applications
Open your console terminal and run any of these commands to create a new Symfony application:

symfony new my_project_directory --version="7.2.x" --webapp
console app or api
symfony new my_project_directory --version="7.2.x"

Installing Doctrines
First, install Doctrine support via the orm Symfony pack, as well as the MakerBundle, which will help generate some code:
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle

The PHPUnit Testing Framework
Symfony integrates with an independent library called PHPUnit to give you a rich testing framework. This article won't cover PHPUnit itself, which has its own excellent documentation.

Before creating your first test, install symfony/test-pack, which installs some other packages needed for testing (such as phpunit/phpunit):
composer require --dev symfony/test-pack
After the library is installed, try running PHPUnit:

php bin/phpunit

After that, you can create the test database and all tables using:
php bin/console --env=test doctrine:database:create

o be able to test the comment list, the pagination, and the form submission, we need to populate the database with some data. And we want the data to be the same between test runs to make the tests pass. Fixtures are exactly what we need.

Install the Doctrine Fixtures bundle:
symfony composer req orm-fixtures --dev

PHP CS Fixer is a very useful tool for automatically formatting code according to coding standards (like PSR-12). Here's how to use it with a Symfony project.
composer require --dev friendsofphp/php-cs-fixer

#### git begining command 
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/magrigsdev/Projet_php_b2_Hotel.git
git push -u origin main


…or push an existing repository from the command line
git remote add origin https://github.com/magrigsdev/Projet_php_b2_Hotel.git
git branch -M main
git push -u origin main

# creation database ... for dev and test
php bin/console doctrine:database:create
php bin/console doctrine:database:create env=test

##entity
$ php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:migrate

## make test


on: [pull_request]
name: Main
jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - name: Configure Git to trust the repository directory
        run: git config --global --add safe.directory /app
      - uses: actions/checkout@v3

      - name: Install Composer
        uses: php-actions/composer@v6
        with:
          php_version: 8.2

      # Fix permissions before composer operations
      # If not some composer operations that need to update autoloader files will fail
      - name: Fix directory permissions
        run: sudo chown -R $USER:$USER .

      - name: Install Dependencies
        run: composer install

      - name: Cache composer store
        uses: actions/cache@v3
        with:
          path: ~/vendor
          key: ${{ runner.OS }}-composer-${{ hashFiles('**/composer.lock') }}
          restore-keys: |
            ${{ runner.OS }}-composer-

      - name: Lint PHP
        run: find . -name "*.php" -type f -not -path "./vendor/*" -not -path "./var/*" -exec php -l {} \;

      - name: Lint Style
        run: vendor/bin/php-cs-fixer fix --diff --dry-run

      - name: Setup test db
        run: php bin/console doctrine:database:create --env=test

      - name: Run migrations
        run: php bin/console doctrine:migrations:migrate --env=test -n

      - name: Run tests
        run: vendor/bin/phpunit


