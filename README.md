# QRQ - Real-Time Queue Management System

QRQ is a modern, premium queue management solution built with **Laravel 12**, **Livewire 4**, and **Reverb**. It allows businesses to manage customer flows in real-time with beautiful interfaces and instant updates.

## ✨ Key Features

- **Real-Time Dashboard**: Admin panel for calling, serving, and canceling tickets with instant feedback.
- **Public Display**: High-contract, glassmorphism-styled display for waiting areas.
- **Customer Join Page**: Easy-to-use mobile interface for customers to join lines via QR code.
- **Real-Time Broadcasting**: Powered by Laravel Reverb for zero-latency updates across all screens.
- **Push Notifications**: WebPush integration to notify customers when it's their turn.
- **Modern UI**: Built with a sleek, dark-mode focused design system using Tailwind CSS and Alpine.js.

## � Available Routes

### Public Routes
- `/` : Welcome landing page.
- `/join/{queue:slug}` : Customer page to join a specific queue.
- `/display/{queue:slug}` : TV/Monitor display page for public areas.

### Admin Routes (Protected)
- `/admin/login` : Administrator login page.
- `/admin` : Admin overview and business selection.
- `/business/{business:slug}/queues` : Manage queues for a specific business.
- `/business/{business:slug}/queues/create` : Create a new queue.
- `/dashboard/{queue:slug}` : The interactive queue management dashboard.
- `/profile` : Manage administrator account settings.

## 📱 Getting the QR Codes

Customers join your queue by scanning a unique QR code. You can find these in two places:
1. **Admin Panel**: Go to the **Queues** section for your business (`/business/{slug}/queues`). Each queue card now shows a mini QR code preview. Clicking the "Join Link" will take you to the page customers see.
2. **Public Display**: The public display page (`/display/{slug}`) automatically shows a large QR code in the bottom-right corner for customers to scan while they wait.

## 🚀 Tech Stack

- **Framework**: [Laravel 12+](https://laravel.com)
- **Frontend**: [Livewire 4](https://livewire.laravel.com), [Alpine.js](https://alpinejs.dev)
- **Styling**: Tailwind CSS
- **Real-Time**: [Laravel Reverb](https://reverb.laravel.com)
- **Database**: MySQL / SQLite
- **Notifications**: WebPush PHP

## 🛠️ Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/chaminduodithya/qrq-clone.git
   cd qrq-clone
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Configure Broadcasting**:
   Update your `.env` with Reverb credentials:
   ```env
   BROADCAST_CONNECTION=reverb
   REVERB_APP_ID=your_id
   REVERB_APP_KEY=your_key
   REVERB_APP_SECRET=your_secret
   ```

5. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

6. **Build Assets**:
   ```bash
   npm run build
   ```

## 🏃 Running Globally

To run the full system in development mode:

1. **Start the Laravel Server**:
   ```bash
   php artisan serve
   ```

2. **Start the Reverb Server** (for real-time):
   ```bash
   php artisan reverb:start --debug
   ```

3. **Start the Vite Dev Server**:
   ```bash
   npm run dev
   ```

## 🔔 Push Notifications (Optional)

To enable push notifications, generate VAPID keys and add them to your `.env`:
```env
VAPID_PUBLIC_KEY=your_public_key
VAPID_PRIVATE_KEY=your_private_key
```

## 📄 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
