# RIN2 Notification System

A Laravel-based notification system that allows users to see special posts as one-time notifications.

## Features

### Core Functionality
- **User Management**: Basic user authentication with notification preferences
- **Notification System**: Create, manage, and track notifications with expiration dates
- **User Impersonation**: Admin can impersonate users to see their notification experience
- **Phone Number Validation**: Basic format validation for international phone numbers
- **Real-time Notifications**: AJAX-powered notification bell with unread counters

### Notification Types
- **Marketing**: Promotional content and offers
- **Invoices**: Billing and payment-related notifications
- **System**: System updates and maintenance notifications

### User Features
- **Notification Settings**: Toggle notifications on/off, update email and phone
- **Dashboard**: Personal dashboard with notification bell and unread counter
- **Notification History**: View all notifications with read status

### Admin Features
- **User Listing**: View all users with unread notification counts
- **Notification Management**: Create, edit, delete, and filter notifications
- **User Impersonation**: Test user experience by impersonating any user
- **Analytics**: Track notification read rates and user engagement

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd rin2-notify
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Phone Number Validation**
   Phone numbers are validated using basic format checking. They must:
   - Start with a country code (e.g., +1, +44, +91)
   - Contain only digits after the country code
   - Be in international format (e.g., +1234567890)

6. **Start the development server**
   ```bash
   php artisan serve
   npm run dev
   ```

## Usage

### Test Users
The seeder creates several test users:
- **John Doe** (john@example.com) - Password: `password`
- **Jane Smith** (jane@example.com) - Password: `password`
- **Bob Johnson** (bob@example.com) - Password: `password`
- **Alice Brown** (alice@example.com) - Password: `password`
- **Charlie Wilson** (charlie@example.com) - Password: `password`

### Navigation
- **Dashboard**: Main dashboard with notification bell
- **Users**: List all users and impersonate them
- **Notifications**: Manage notifications (create, edit, delete, filter)
- **Settings**: Update notification preferences

### Creating Notifications
1. Go to **Notifications** → **Create New Notification**
2. Select notification type (Marketing, Invoices, System)
3. Enter notification text
4. Set expiration date
5. Choose destination (All Users or Specific User)
6. Save the notification

### User Impersonation
1. Go to **Users** page
2. Click **Impersonate** next to any user
3. You'll be logged in as that user
4. Use the notification bell to see their notifications
5. Click **Stop Impersonating** to return to admin view

## Database Schema

### Users Table
- `id`: Primary key
- `name`: User's full name
- `email`: User's email address
- `password`: Hashed password
- `notification_switch`: Boolean for notification preferences
- `phone_number`: Optional phone number (validated via MessageBird)
- `email_verified_at`: Email verification timestamp
- `created_at`, `updated_at`: Timestamps

### Notifications Table
- `id`: Primary key
- `type`: Notification type (marketing, invoices, system)
- `text`: Notification message content
- `expires_at`: Expiration timestamp
- `user_id`: Target user ID (nullable for all-users notifications)
- `is_for_all`: Boolean indicating if notification is for all users
- `created_at`, `updated_at`: Timestamps

### Notification Reads Table
- `id`: Primary key
- `user_id`: Foreign key to users table
- `notification_id`: Foreign key to notifications table
- `read_at`: Timestamp when notification was read
- `created_at`, `updated_at`: Timestamps

## API Endpoints

### Notifications
- `GET /notifications` - List all notifications with filters
- `GET /notifications/create` - Show create form
- `POST /notifications` - Store new notification
- `GET /notifications/{id}` - Show notification details
- `GET /notifications/{id}/edit` - Show edit form
- `PUT /notifications/{id}` - Update notification
- `DELETE /notifications/{id}` - Delete notification
- `GET /notifications/user/list` - Get user's unread notifications (AJAX)
- `POST /notifications/{id}/mark-read` - Mark notification as read (AJAX)

### Users
- `GET /users` - List all users with unread counts
- `POST /users/{id}/impersonate` - Impersonate user
- `POST /users/stop-impersonating` - Stop impersonation

### User Settings
- `GET /user-settings` - Show settings form
- `PATCH /user-settings` - Update user settings

## Technologies Used

- **Laravel 12**: PHP framework
- **Tailwind CSS**: Styling framework
- **Alpine.js**: JavaScript framework for interactions
- **Phone Validation**: Basic format validation for international phone numbers
- **SQLite**: Database (configurable)

## Security Features

- CSRF protection on all forms
- User authentication and authorization
- Phone number format validation
- Secure password hashing
- Input validation and sanitization

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).