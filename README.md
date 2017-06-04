# tictock



## Features
- Attendace Signup Form
- Attendace Check-in Form
- Admin Panel
- Listing by department or username
- Filters on listing
- AVG time by user
- AVG time for department's users
- config.json
- ip based validation has done for check-in using http://ipinfo.io/10.93.229.188/json

## Site
https://tictock.herokuapp.com/

## Admin Panel
https://tictock.herokuapp.com/admin.php

`Username: admin`
`Password: BATMAN`


Admin need to login to the site using above credentials and need to do needful changes to the configuration file, in order to update a location.

User can check-in only from specific location and location has been computed using IP address.

So don't forget about updating the configuration file.
https://tictock.herokuapp.com/admin.php?landing_page=config


## Technologies and credits
- ashleydawson/simple-pagination
- JQuery
- Select2
- BoilerTemplate
- Heroku
- Bootstrap
- Custome MVC - Self Developed 
	- Service Class represents both (Controller and model)
	- index.php and admin.php used as routers


# Database
sampleData.sql

# PHPUnit 4.8.0
```
Bhushans-MacBook-Pro-2:Downloads bhushanvaiude$ phpunit /Users/bhushanvaiude/Documents/MAMP/tictock/tests/PageTest.php
PHPUnit 4.8.0 by Sebastian Bergmann and contributors.

..

Time: 3.09 seconds, Memory: 11.75Mb

OK (2 tests, 2 assertions)
Bhushans-MacBook-Pro-2:Downloads bhushanvaiude$ git status
```
