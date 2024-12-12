
## Prerequisites

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM
- Git

## Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/nanno619/phpword.git
   cd <project-folder>
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database in .env file**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Build assets**
   ```bash
   npm run dev
   ```

## Installing PHPWord

1. **Install PHPWord via Composer**
   ```bash
   composer require phpoffice/phpword

## Template Setup

1. Template already in this folder
   ```
   storage/app/public/templates/Lisan/
   ```

## Running the Application

1. **Start the development server**
   ```bash
   php artisan serve
   ```

2. **Start Vite development server**
   ```bash
   npm run dev
   ```

3. Access the application at `http://localhost:8000`

## Key Features Usage

### Creating a New Question
1. Navigate to Questions page
2. Click "Add New Question"
3. Select a user
4. Fill in question and answer using the Froala editor
5. Submit the form

### Generating Documents
1. Go to the questions list
2. Click the download button for the desired question
3. The system will generate a Word document based on the template

## Libraries Used

- PHPWord for document generation
- Froala Editor for rich text editing
- Laravel Framework 11.x
