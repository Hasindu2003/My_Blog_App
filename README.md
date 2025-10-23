# My Blog App
A full-featured blog application built with HTML, CSS, JavaScript, PHP, and MySQL.

## Features

### User Authentication & Authorization
- User registration with validation
- User login/logout functionality
- Session management
- Secure password hashing

### Blog Management
- Create new blog posts with a rich editor
- Read/view blog posts
- Update your own blog posts
- Delete your own blog posts
- Only blog owners can edit/delete their blogs

### Frontend Features
- Home page displaying all blog posts
- Single blog view page
- Blog editor page for creating and updating blogs
- Responsive and clean UI design
- Real-time user feedback with messages

## Setup Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server

### Installation

1. Clone the repository:
```bash
git clone https://github.com/Hasindu2003/My_Blog_App.git
cd My_Blog_App
```

2. Create the database:
```bash
mysql -u root -p < setup.sql
```

Or manually create the database using phpMyAdmin or MySQL client:
- Create a database named `blog_app`
- Import the `setup.sql` file

3. Configure database connection:
```bash
cp config.sample.php config.php
```

Edit `config.php` with your database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'blog_app');
```

4. Start the web server:

Using PHP built-in server:
```bash
php -S localhost:8000
```

Or configure Apache/Nginx to serve from the project directory.

5. Access the application:
```
http://localhost:8000/index.html
```

## Usage

### Register a New Account
1. Click on "Register" in the navigation
2. Fill in username, email, and password
3. Click "Register" button

### Login
1. Click on "Login" in the navigation
2. Enter your username and password
3. Click "Login" button

### Create a Blog Post
1. After logging in, click "Create New Blog" on the home page
2. Enter a title and content for your blog
3. Click "Publish"

### View a Blog Post
1. Click "Read More" on any blog card on the home page
2. View the full blog content

### Edit a Blog Post
1. View your own blog post
2. Click the "Edit" button
3. Make changes and click "Update"

### Delete a Blog Post
1. View your own blog post
2. Click the "Delete" button
3. Confirm the deletion

## File Structure

```
My_Blog_App/
├── index.html          # Home page
├── auth.html           # Login/Register page
├── editor.html         # Blog editor page
├── view.html           # Single blog view page
├── style.css           # Stylesheet
├── app.js              # Frontend JavaScript
├── db.php              # Database connection
├── register.php        # Registration API
├── login.php           # Login API
├── logout.php          # Logout API
├── check_auth.php      # Authentication check API
├── api_blogs.php       # Blog CRUD API
├── setup.sql           # Database schema
├── config.sample.php   # Sample configuration
└── README.md           # This file
```

## Security Features

- Password hashing using PHP's `password_hash()`
- Prepared statements to prevent SQL injection
- Session-based authentication
- Input validation and sanitization
- CSRF protection through session validation
- Authorization checks (users can only edit/delete their own blogs)

## Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Architecture**: RESTful API design

## License

This project is open source and available under the MIT License.
