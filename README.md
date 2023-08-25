# PG-Life Web Application
The `PG-Life` Web Application is a platform designed to facilitate the management and search for Paying Guest (PG) accommodations. It allows users to explore available PG options, view details, and connect with potential landlords or tenants.

## Installation
To set up the PG-Life Web Application on your local system, follow these steps:

1. Clone the repository:
``` 
git clone https://github.com/mohitrajput2002/PG_Life.git 
```

2. Database Connectivity:

Create a database with `phpMyAdmin` using the same name as the provided SQL file name.
Import the given SQL file into the created database.

3. Update database connectivity:
In the file `includes/database_connect.php`, modify the following line:

php
```
$conn = mysqli_connect("localhost", "username_of_phpmyadmin", "password_of_phpmyadmin", "Database_name(PGLife)");
```
Replace "username_of_phpmyadmin", "password_of_phpmyadmin", and "Database_name(PGLife)" with your phpMyAdmin credentials and the database name you created.

## Usage
1. After completing the installation steps, open the PG-Life Web Application on your local server.
2. Explore the available PG accommodations by browsing through the listings.
3. View details of each listing, such as location, amenities, pricing, and contact information.
4. Connect with landlords or potential tenants by using the provided contact information.
5. Use the search functionality to filter PG accommodations based on specific criteria.

## Technologies Used
The PG-Life Web Application utilizes the following technologies:
1. HTML
2. CSS
3. JavaScript
4. PHP
5. MySQL (phpMyAdmin)

**Thank you for using PGLife!**
