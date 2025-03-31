# Vue Webshop Starter Kit

This project is a Laravel 12 starter kit integrated with Vue 3 and Inertia 2, designed to provide a solid foundation for building a simple webshop.

## Features

- **Laravel 12 Backend:** Modern PHP framework with all the benefits of Laravel.
- **Vue 3 & Inertia 2 Frontend:** A reactive, component-driven UI using Vue’s Composition API.
- **Dummy Product Seeding:** A migration is provided that seeds dummy products.
- **Themeable Design:** Easily swap out the default styling by choosing a new theme.

## Setup Instructions

### 1. Clone the Repository

```bash
git clone <repository-url>
cd vue-webshop-starter-kit
```

### 2. Install Dependencies

Install the PHP and Node dependencies:

```bash
composer install
npm install
```

### 3. Environment Configuration

- Copy the example environment file:

    ```bash
    cp .env.example .env
    ```

- Set up your database credentials.
- Add your Stripe keys in the `.env` file for payment integration.
- **WorkOS Setup:** Follow [this video](https://www.youtube.com/watch?v=xFL4MPp2RX0) for setting up WorkOS.

### 4. Run Migrations

Run the migrations to create your database schema and seed dummy products:

```bash
php artisan migrate
```

### 5. Theme Customization

This shop is themeable. To customize the design:

1. Visit [shadcn-vue themes](https://www.shadcn-vue.com/themes) to pick a theme.
2. Replace the `@layer base` section in the `app.css` file with the selected theme’s base styles.

### 6. Run the Application

Start the development server:

```bash
npm run dev
php artisan serve
```

Then open your browser at `http://localhost:8000`.

## Additional Information

This starter kit includes everything you’d expect from a simple webshop. It provides a base for common web shop functionalities, allowing you to further customize or extend as needed.

## Contributing

Contributions are welcome! If you have suggestions or improvements, please open an issue or submit a pull request.

## License

This project is open-sourced under the [MIT license](LICENSE).
