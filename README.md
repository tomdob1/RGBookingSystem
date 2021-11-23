# RGBookingSystem
Booking System

**To run please make sure you have the following installed:**

-PHP 8
-Composer
-Symfony 5
-Git

Once you have cloned the repository please do the following steps:

1. Go to the file directory in Git
2. Run the command 'symfony serve -d'
3. Once the Symfony web server is running enter in the command 'composer install' and wait for every package to install.
4. Migrate the database with the following command 'php bin/console doctrine:migrations:migrate' 
5. Enter 'yes' to download the correct database tables.
6. If you receive any driver errors when downloading the db tables - please check your php.ini file to ensure 'extension=pdo_sqlite' is not commented out (contains a semicolon at the start). Restart the server if this is the case 'symfony server:stop' and then 'symfony serve -d'
7. Go to localhost:8000 in your browser. 

**Unit tests are located in the folder tests**


Any issues let me know at tomasz.dob@hotmail.com

**Future changes I would like to make:**

1. Add a dynamic booking form which removes the time input if the 'Whole Day' radio button has been selected.
2. Logging and error handling.
3. Make booking portal display a timetable based on the current date, with the option to book a month in advance.
4. Login portal for employees to make booking on their individual account.
5. Admin account to add offices and configure booking times.
