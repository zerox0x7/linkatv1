# Installation Instructions

1. Copy all files to the new directory
2. Install Composer dependencies:
   `
   composer install
   `
3. Install NPM dependencies:
   `
   npm install
   `
4. Create .env file from .env.example and update database settings
5. Create storage symbolic link:
   `
   php artisan storage:link
   `
6. Run migrations:
   `
   php artisan migrate
   `
7. Make sure these directories are writable:
   - /storage
   - /bootstrap/cache
