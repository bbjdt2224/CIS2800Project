# CIS2800Project
Our CIS 2800 semester project

##Setup
This project uses laravel https://laravel.com/docs/5.8/installation

Laravel uses the Model View Controller style.
Models hold the outline of the datatypes.
Controllers handel all the database calls and routing
Views hold all the html 

All of our database tables are generated using migrations
The database can be filled with test data using the seeder

Your .env file should be filled with the correct information and look something like this:

```DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=dbname
DB_USERNAME=uname
DB_PASSWORD=password```

##Running
Make sure your apache server and mysql are running

Open this file in your localhost and open the public folder

##Database

To generate the database structure run ```php artisan migrate```
To get test data run ```php artisan db:seed```

All users are generated with the password: "secret"