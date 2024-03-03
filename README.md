
Creation/deletion/editing of products and suppliers using PHP/Laravel, sets of routes for CRUD, and Vue.js for dynamism in the CRUD.

## Requisites

- Docker;
- Node.js;
- PHP;

## Setup

- Clone the repository;
- Install dependencies (`npm install`);
- You can always generate .env file manually by running;
`cp .env.example .env
php artisan key:generate`
- Edit .env db
`DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=greentech
DB_USERNAME=docker
DB_PASSWORD=docker`
- Setup PostgreSQL (`docker compose up -d`);
- Copy `.env.example` file (`cp .env.example .env`);
- Run application (`npm run start`);
- Run migrations (`php artisan migrate`);

