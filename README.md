# eticaret - E-commerce Platform

This repository contains the codebase for a basic e-commerce platform built using PHP. It features user authentication, product listings, cart management, and an admin panel for managing products and users.

## Features and Functionality

*   **User Authentication:** Users can register and log in to access personalized features like cart management and order placement.
*   **Product Listing:** Browse a catalog of products with details like name, price, description, and stock availability. Product images are also displayed.
*   **Cart Management:** Add products to the cart, update quantities, and remove items.
*   **Admin Panel:** A secure admin panel enables authorized users to manage products (add, edit, delete) and users (edit, delete).
*   **Image Upload:**  Admins can upload images for products. Uploaded images are stored in the `public/assets/upload/` directory.
*   **AJAX Functionality:**  Uses AJAX for asynchronous operations like adding items to the cart, updating cart totals, deleting products/users, and submitting forms without page reloads.
*   **DataTables Integration:**  The admin dashboard uses DataTables for enhanced table display, sorting, searching, and pagination.
*   **SweetAlert2 & Toastr:**  Provides user-friendly notifications using SweetAlert2 for confirmation dialogs and Toastr for less intrusive messages.
*   **Dark Mode:** Includes a toggle for switching between light and dark themes, enhancing user experience.
*   **CSRF Protection:** The registration form includes CSRF protection to prevent cross-site request forgery attacks.
*   **Bulk Order Handling:** The cart implementation supports placing orders for multiple products at once.

## Technology Stack

*   **PHP:**  The core programming language.
*   **HTML/CSS/JavaScript:**  For front-end structure, styling, and interactivity.
*   **Bootstrap:**  CSS framework for responsive design.
*   **jQuery:**  JavaScript library for DOM manipulation and AJAX.
*   **DataTables:**  jQuery plugin for advanced table features.
*   **SweetAlert2:**  JavaScript library for enhanced alert dialogs.
*   **Toastr:** JavaScript library for notifications.
*   **Composer:**  Dependency management.
*   **iconv:**  For character encoding conversion.
*   **PDO:** PHP Data Objects for database interaction.
*   **.env (vlucas/phpdotenv):** For managing environment variables.

## Prerequisites

Before setting up the project, ensure you have the following installed:

*   **PHP:** Version 7.2.5 or higher.
*   **Composer:** Dependency manager for PHP.
*   **MySQL:** Database server.
*   **Web Server (Apache or Nginx):** To serve the application.
*   **iconv extension:** Required by symfony/polyfill-mbstring.

## Installation Instructions

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/Altay-Akyurek/eticaret.git
    cd eticaret
    ```

2.  **Install Composer dependencies:**

    ```bash
    composer install
    ```

3.  **Configure the database:**

    *   Create a MySQL database for the project.
    *   Rename `.env.example` to `.env`.
    *   Update the `.env` file with your database credentials:

        ```
        DB_HOST=localhost
        DB_NAME=your_database_name
        DB_USER=your_database_user
        DB_PASS=your_database_password
        ```

4.  **Set up the web server:**

    *   Configure your web server (Apache or Nginx) to point the document root to the `public` directory within the project.
    *   **Apache Example (.htaccess):** The `public` directory includes a `.htaccess` file for basic routing. Ensure that `mod_rewrite` is enabled.

        ```apache
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteBase /php/php_calısmaları/eticaret-main/public

            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
        </IfModule>
        ```

    *   **Nginx Example (Virtual Host Configuration):**

        ```nginx
        server {
            listen 80;
            server_name yourdomain.com;
            root /path/to/eticaret/public;

            index index.php index.html index.htm;

            location / {
                try_files $uri $uri/ /index.php?$query_string;
            }

            location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.4-fpm.sock; # Adjust to your PHP version
            }

            location ~ /\.ht {
                deny all;
            }
        }
        ```
        (Adjust the `fastcgi_pass` according to your php version and sock location.)

5.  **Database migrations and seeders (if applicable):**

    *   This project doesn't include migrations, you need to manually create tables or import SQL dumps.
    *   SQL dump is not provided, so you need to create tables manually.

6.  **Admin User creation:**

    *   The code includes an `AdminModel`. You'll likely need to manually create an admin user in the database. Example SQL:

    ```sql
    INSERT INTO admins (username, password) VALUES ('admin', 'password123');
    -- Or, with password hashing (recommended):
    INSERT INTO admins (username, password) VALUES ('admin', '$2y$10$YOUR_HASHED_PASSWORD_HERE');
    ```

    **Important:** Replace `'password123'` with a more secure password, and preferably use `password_hash()` in PHP to generate a secure hash and store that in the database.  For example: `$hashedPassword = password_hash('your_secure_password', PASSWORD_DEFAULT);`

## Usage Guide

1.  **Access the application:**

    *   Open your web browser and navigate to the configured domain name (e.g., `http://yourdomain.com`).

2.  **User Registration and Login:**

    *   Click the "Register" link to create a new user account.
    *   Click the "Login" link to log in with an existing account.

3.  **Browsing Products:**

    *   The homepage (`/home`) displays a list of available products.
    *   Click on a product image or name to view detailed information on the product page (`/product/detail/{id}`).

4.  **Cart Management:**

    *   Add products to your cart from the homepage or product detail pages.
    *   Access the cart by clicking the cart icon in the header (`/cart`).
    *   Update product quantities or remove items from the cart.
    *   Select the products you want to order and proceed to checkout.

5.  **Admin Panel:**

    *   Access the admin panel by navigating to `/admin/login`.
    *   Log in with valid admin credentials.
    *   The dashboard (`/admin/dashboard`) provides access to manage products and users.
    *   Products can be added, edited, and deleted. Product images are stored in `public/assets/upload/`.
    *   Users can be edited and deleted.

## API Documentation (if applicable)

This project does not explicitly define an external API. However, the following AJAX endpoints are used internally:

*   `/auth/login` (POST): Handles user login. Returns a JSON response indicating success or failure, and a redirect URL on success.
*   `/admin/login` (POST): Handles admin login. Returns a JSON response with similar structure to user login.
*   `/cart/add/{id}` (GET): Adds a product to the cart. Returns a JSON response indicating success and the updated cart count.
*   `/admin/deleteProduct/delete/{id}` (POST): Deletes a product from the database. Returns a JSON response with success status.
*   `/cart/update` (POST): Updates product quantity in cart. Accepts `id` and `adet` (quantity) in POST data.
*   `/cart/remove` (POST): Removes item from cart. Accepts `id` in POST data.
*   `/cart/bulkOrder` (POST): Handles bulk ordering, taking an array of `products` with `id`, `adet` and `price` information.
*   `/admin/addProduct` (POST): Adds a new product. Accepts `name`, `price`, `description`, `stock`, and `img` (file upload) data.
*   `/admin/editOrUpdateProduct/edit/{id}` (POST): Edits a product.  Accepts `name`, `price`, `description`, `stock`, and `img` data.
*   `/admin/editOrUpdateUser/edit/{id}` (POST): Edits a user. Accepts `username`, and `email` data.
*    `/admin/deleteUser/delete/{id}` (POST): Deletes a user.

**Note:**  These AJAX endpoints are primarily used internally by the application and are subject to change.  For a public API, consider implementing proper authentication, request validation, and response formatting.

## Contributing Guidelines

Contributions are welcome! To contribute:

1.  Fork the repository.
2.  Create a new branch for your feature or bug fix.
3.  Implement your changes and thoroughly test them.
4.  Submit a pull request with a clear description of your changes.

## License Information

This project is licensed under the [Apache License 2.0](LICENSE).

## Contact/Support Information

For questions or support, please contact: [altay.akyurek@example.com].
(Replace with actual contact information.)
