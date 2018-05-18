# IAB Global Vendor List
Display a table-ified version of the IAB Global Vendor List.  To use this:
1. Clone the repository to a machine that can run Laravel.  The Laravel dependencies are listed at https://laravel.com/docs/5.6#installation.
2. Install Composer from https://getcomposer.org/download/.
3. Run `/path/to/composer install` from within the cloned repository.  Note that your Composer executable may be named `composer.phar`.
4. Run `php artisan serve` from within the cloned repository.
5. Visit http://localhost:8000

By default, the table is sorted by the vendor ID.  The table can be sorted by vendor name by adding `sort=name` to the query parameters.  The sort can be reversed by adding `rev=1` to the query parameters.