# FoodShare - Food Donation Platform

A platform that connects donors with receivers, organizations, and volunteers to fight food waste and support those in need. Built with Laravel, Vue.js, and Inertia.js.

## Overview

FoodShare provides a comprehensive solution for managing food donations, connecting communities, and reducing food waste. The platform enables individuals and organizations to post available food donations, browse nearby offerings, and coordinate pickups through an intuitive interface with real-time notifications and interactive mapping.

## Features

### Core Functionality
- Food donation management system with create, browse, and claim capabilities
- Interactive map view using Leaflet with geolocation support
- Real-time email notifications for donation requests and status updates
- Multi-role user system supporting donors, receivers, organizations, partners, and volunteers
- Privacy controls including anonymous donation options

### Places System
- Community location sharing for food pickup points
- Interactive map with click-to-select functionality
- Reverse geocoding for automatic address lookup
- Multiple photo uploads using ImgBB CDN
- Automated email notifications with Google Maps and Calendar integration

### Analytics and Reporting
- Complete donation history tracking
- Impact metrics including total donations, meals served, and urgent pickups
- Monthly trend visualization

### Organization Features
- Partner and organization management
- Food request creation and management
- Contribution and funding tracking
- Support for multiple organizational roles

## Technical Stack

### Backend
- Laravel 11 as the core framework
- MySQL for data persistence
- Laravel Sanctum for API authentication
- Laravel Breeze for authentication scaffolding

### Frontend
- Vue.js 3 for reactive user interfaces
- Inertia.js for seamless SPA experience
- Tailwind CSS for styling
- Chart.js for data visualization
- Leaflet for interactive maps

### External Services
- ImgBB API for image hosting and CDN
- OpenStreetMap for map tiles
- Nominatim for geocoding services
- SMTP for email delivery

## Requirements

- PHP 8.2 or higher
- Composer 2.0 or higher
- Node.js 18.x or higher
- NPM 9.x or higher
- MySQL 8.0 or higher

## Installation

Clone the repository:

```bash
git clone https://github.com/yourusername/foodshare.git
cd foodshare
```

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Create and configure your environment file:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database and external services in the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodshare
DB_USERNAME=root
DB_PASSWORD=

IMGBB_API_KEY=your_imgbb_api_key

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@foodshare.com"
```

Run database migrations:

```bash
php artisan migrate
```

Create the storage symlink:

```bash
php artisan storage:link
```

Build frontend assets:

```bash
npm run dev
```

Start the development server:

```bash
php artisan serve
```

The application will be available at http://localhost:8000

## Project Structure

```
foodshare/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Mail/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── build/
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   └── Pages/
│   └── views/
├── routes/
│   ├── web.php
│   └── auth.php
└── README.md
```

## Configuration

### ImgBB Setup

Register for an API key at https://imgbb.com and add it to your `.env` file:

```env
IMGBB_API_KEY=your_api_key_here
```

### Email Configuration

For development, use Mailtrap:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

For production with Gmail:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

## Deployment

### Production Build

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### Laravel Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### cPanel Deployment Notes

1. Upload all files to `/public_html/`
2. Configure production environment variables in `.env`
3. Set appropriate permissions for storage and cache directories:
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```
4. Run migrations: `php artisan migrate --force`
5. Create storage symlink: `php artisan storage:link`
6. Clear and optimize caches

Important: Set your document root to `/public_html/public/` in your hosting control panel.

## Contributing

Contributions are welcome. Please follow these guidelines:

1. Fork the repository
2. Create a feature branch
3. Make your changes with clear commit messages
4. Ensure tests pass
5. Submit a pull request

Please follow PSR-12 coding standards for PHP and use ESLint for JavaScript.


## Author

Ismael Abba Diakite

## Contact

For questions or support, please email isadiak98us@gmail.com or open an issue on GitHub.

## Acknowledgments

Built with Laravel, Vue.js, Inertia.js, and Tailwind CSS. Map data provided by OpenStreetMap contributors. Image hosting by ImgBB.
