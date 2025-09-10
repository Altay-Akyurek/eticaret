🛒 eticaret – E-Commerce Platform






A lightweight yet powerful E-Commerce Platform built with PHP.
Provides user authentication, product catalog, shopping cart, and an admin dashboard for managing users & products.
🚀 Optimized with AJAX, DataTables, SweetAlert2, and Toastr for a modern shopping experience.

✨ Features

🔐 User Authentication – Register & log in securely

🛍️ Product Catalog – Browse products with images, stock, and pricing

🛒 Shopping Cart – Add, update, and remove items

🛠️ Admin Panel – Manage products and users with CRUD operations

🖼️ Image Upload – Store product images in public/assets/upload/

⚡ AJAX Support – Smooth interactions without page reloads

📊 DataTables Integration – Search, sort, and paginate product lists

🎨 Dark Mode – Switch between light & dark themes

🛡️ CSRF Protection – Secure forms against CSRF attacks

📦 Bulk Orders – Place multiple product orders at once

🛠️ Tech Stack
Technology	Purpose
PHP	Core backend logic
HTML / CSS / JS	UI & interactivity
Bootstrap	Responsive design
jQuery + AJAX	Dynamic operations
DataTables	Advanced tables
SweetAlert2 & Toastr	Alerts & notifications
Composer	Dependency management
PDO	Database interaction
dotenv	Environment variables
⚙️ Installation
1️⃣ Clone the repository
git clone https://github.com/Altay-Akyurek/eticaret.git
cd eticaret

2️⃣ Install dependencies
composer install

3️⃣ Configure database

Create a MySQL database

Copy .env.example → .env

Update credentials:

DB_HOST=localhost
DB_NAME=your_database_name
DB_USER=your_database_user
DB_PASS=your_database_password

4️⃣ Set up web server

Apache → Ensure mod_rewrite is enabled (uses .htaccess)

Nginx → Point the root to /public and configure PHP-FPM

🚀 Usage

Open the app in your browser → http://localhost/

Register/Login as a user

Browse products → add items to your cart

Manage cart → update quantities or remove items

Checkout → place single or bulk orders

Admin Panel → /admin/login for managing products & users

🔗 Internal AJAX Endpoints
Endpoint	Method	Description
/auth/login	POST	User login
/admin/login	POST	Admin login
/cart/add/{id}	GET	Add product to cart
/cart/update	POST	Update product quantity
/cart/remove	POST	Remove item from cart
/cart/bulkOrder	POST	Place bulk order
/admin/addProduct	POST	Add product
/admin/editOrUpdateProduct/edit/{id}	POST	Update product
/admin/deleteProduct/delete/{id}	POST	Delete product
/admin/editOrUpdateUser/edit/{id}	POST	Update user
/admin/deleteUser/delete/{id}	POST	Delete user
🤝 Contributing

Contributions are welcome!

Fork this repository

Create a new branch (feature/your-feature)

Commit your changes

Push and open a Pull Request 🚀

📜 License

This project is licensed under the Apache 2.0 License – see LICENSE
 for details.

📧 Contact

For support or questions: altay.akyurek@example.com

(replace with your actual email)
