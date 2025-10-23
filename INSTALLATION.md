# Installation and Deployment Guide

## Local Development Setup

### Step 1: Install Prerequisites

#### Install PHP
- **Windows**: Download from [php.net](https://www.php.net/downloads.php)
- **macOS**: `brew install php`
- **Linux**: `sudo apt-get install php php-mysql`

#### Install MySQL
- **Windows**: Download from [mysql.com](https://dev.mysql.com/downloads/installer/)
- **macOS**: `brew install mysql`
- **Linux**: `sudo apt-get install mysql-server`

### Step 2: Clone Repository

```bash
git clone https://github.com/Hasindu2003/My_Blog_App.git
cd My_Blog_App
```

### Step 3: Set Up Database

#### Option A: Using MySQL Command Line

```bash
# Login to MySQL
mysql -u root -p

# Create database and tables
source setup.sql

# Or run commands directly
CREATE DATABASE IF NOT EXISTS blog_app;
USE blog_app;
# Copy and paste the SQL from setup.sql
```

#### Option B: Using phpMyAdmin

1. Open phpMyAdmin in your browser
2. Create a new database named `blog_app`
3. Select the database
4. Click "Import" tab
5. Choose `setup.sql` file
6. Click "Go"

### Step 4: Configure Application

```bash
# Copy the sample configuration
cp config.sample.php config.php

# Edit config.php with your database credentials
nano config.php  # or use any text editor
```

Update these values in `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_mysql_username');
define('DB_PASS', 'your_mysql_password');
define('DB_NAME', 'blog_app');
define('SITE_URL', 'http://localhost:8000');
```

### Step 5: Start the Server

#### Using PHP Built-in Server (Recommended for Development)

```bash
php -S localhost:8000
```

#### Using XAMPP

1. Copy the project folder to `C:\xampp\htdocs\My_Blog_App` (Windows) or `/Applications/XAMPP/htdocs/My_Blog_App` (macOS)
2. Start Apache and MySQL from XAMPP Control Panel
3. Access `http://localhost/My_Blog_App/index.html`

#### Using WAMP

1. Copy the project folder to `C:\wamp64\www\My_Blog_App`
2. Start WAMP services
3. Access `http://localhost/My_Blog_App/index.html`

### Step 6: Access the Application

Open your browser and navigate to:
```
http://localhost:8000/index.html
```

## Production Deployment

### Deploy to Shared Hosting (cPanel)

1. **Upload Files**
   - Compress all files into a ZIP
   - Login to cPanel
   - Go to File Manager
   - Upload and extract in `public_html`

2. **Create Database**
   - Go to MySQL Databases in cPanel
   - Create database `blog_app`
   - Create MySQL user
   - Add user to database with all privileges
   - Import `setup.sql` using phpMyAdmin

3. **Configure Application**
   - Edit `config.php` with your database credentials
   - Update `SITE_URL` to your domain

4. **Set Permissions**
   - Ensure files are readable (644)
   - Ensure directories are executable (755)

### Deploy to VPS (Ubuntu/Debian)

1. **Install LAMP Stack**
```bash
sudo apt update
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql
```

2. **Clone Repository**
```bash
cd /var/www/html
sudo git clone https://github.com/Hasindu2003/My_Blog_App.git
cd My_Blog_App
```

3. **Set Up Database**
```bash
sudo mysql -u root -p < setup.sql
```

4. **Configure Application**
```bash
sudo cp config.sample.php config.php
sudo nano config.php
```

5. **Set Permissions**
```bash
sudo chown -R www-data:www-data /var/www/html/My_Blog_App
sudo chmod -R 755 /var/www/html/My_Blog_App
```

6. **Configure Apache**
```bash
sudo nano /etc/apache2/sites-available/blog.conf
```

Add:
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/html/My_Blog_App
    
    <Directory /var/www/html/My_Blog_App>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/blog_error.log
    CustomLog ${APACHE_LOG_DIR}/blog_access.log combined
</VirtualHost>
```

Enable site:
```bash
sudo a2ensite blog.conf
sudo systemctl reload apache2
```

## Troubleshooting

### Database Connection Issues

**Error: "Connection failed"**
- Verify MySQL is running: `sudo systemctl status mysql`
- Check credentials in `config.php`
- Ensure database exists: `mysql -u root -p -e "SHOW DATABASES;"`

### PHP Errors

**Error: "Call to undefined function"**
- Install required PHP extensions: `sudo apt install php-mysql php-json`

### Permission Errors

**Error: "Permission denied"**
- Fix ownership: `sudo chown -R www-data:www-data /var/www/html/My_Blog_App`
- Fix permissions: `sudo chmod -R 755 /var/www/html/My_Blog_App`

### Session Errors

**Error: "Failed to start session"**
- Check PHP session directory permissions
- Ensure `session.save_path` is writable in `php.ini`

## Security Recommendations

1. **Change Default Credentials**
   - Use strong MySQL passwords
   - Use strong user passwords

2. **Enable HTTPS**
   - Install SSL certificate (Let's Encrypt)
   - Force HTTPS in Apache/Nginx config

3. **Protect config.php**
   - Ensure it's not publicly accessible
   - Add to `.htaccess`: `<Files config.php>deny from all</Files>`

4. **Regular Backups**
   - Backup database regularly
   - Backup uploaded files

5. **Update Software**
   - Keep PHP, MySQL, and Apache updated
   - Monitor security advisories

## Maintenance

### Backup Database

```bash
mysqldump -u root -p blog_app > backup_$(date +%Y%m%d).sql
```

### Restore Database

```bash
mysql -u root -p blog_app < backup_20250101.sql
```

### Monitor Logs

```bash
# Apache error log
tail -f /var/log/apache2/error.log

# Apache access log
tail -f /var/log/apache2/access.log

# MySQL log
sudo tail -f /var/log/mysql/error.log
```
