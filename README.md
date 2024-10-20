# Shortened URL Service  

This is a simple URL shortening service built using Laravel as the backend and Vue.js for the frontend. It allows users to shorten long URLs and view the history of shortened URLs.

### Features
* Shorten any valid URL.
* Display the history of shortened URLs.
* Copy shortened URLs to the clipboard.
* View the total clicks and original URL for each shortened link.

### Tech Stack
* Backend: Laravel
* Frontend: Vue.js
* Database: MySQL (or your preferred database)
* Build Tool: Vite

### Steps to Set Up Locally
1. #### Clone the repository:
    `git clone https://github.com/nafischonchol/url-shortener-system`
2. #### Install dependencies:

    ```
    composer install
    npm install
    ```
3. #### Set up the environment variables:
   Copy the .env.example file to .env.

   Update the .env file with your database credentials and other environment variables:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```
4. #### Generate the application key:
   `php artisan key:generate`
   
5. #### Run migrations:
    `php artisan migrate`
6. #### Run development servers:
    `npm run dev`
Now application should run in http://127.0.0.1:8000 
    

