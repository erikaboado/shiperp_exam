## Description
This Laravel-based project enables users to manage data provider modules by adding, editing, and deleting providers. The program consumes a data provider module and displays the response image on the web interface.

## Requirements
- Laravel 8.x
- PHP 7.4 or higher
- Composer
- MySQL or any supported database
- Node.js (for frontend assets)

## Setup
1. Clone the repository: git clone <repository_url>
2. Navigate to the project directory: cd shiperp_exam
3. Install PHP dependencies: composer install
4. Copy the .env.example file to .env: cp .env.example .env
5. Configure the database settings in the .env file.
6. Generate an application key: php artisan key:generate
7. Run database migrations: php artisan migrate
8. Install frontend dependencies: npm install && npm run dev (or npm run watch for development)

## Usage
1. Launch the application: php artisan serve
2. Open your browser and go to the URL displayed by the serve command (e.g., http://127.0.0.1:8000)
3. Use the interface to add, edit, and delete data provider modules.
4. Click "Show" under Action column
5. Input the key of the image url from the API respone
6. Click the "Trigger API" button to call the API and display the image response on the web page.
    - [sample API: (https://dog.ceo/api/breeds/image/random) key of the image url of this API:message]
