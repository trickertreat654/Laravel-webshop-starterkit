# Vue Webshop Starter Kit

This project is a Laravel 12 starter kit integrated with Vue 3 and Inertia 2, designed to provide a solid foundation for building a simple webshop.

## Features

- **Laravel 12 Backend:** Modern PHP framework with all the benefits of Laravel.
- **Vue 3 & Inertia 2 Frontend:** A reactive, component-driven UI using Vue’s Composition API.
- **Dummy Product Seeding:** A migration is provided that seeds dummy products.
- **Themeable Design:** Easily swap out the default styling by choosing a new theme.

## Setup Instructions

When creating a new Laravel application using the Laravel installer, you can use any community maintained starter kit available on Packagist with the `--using` flag:

```bash
laravel new my-app --using=trickertreat654/laravel-webshop-starterkit
```

**Install Frontend Dependencies and Build Assets:**

    ```bash
    cd my-app
    npm install && npm run build
    composer run dev
    ```


- Add your Stripe keys in the `.env` file for payment integration.
- **WorkOS Setup:** Follow [this video](https://www.youtube.com/watch?v=xFL4MPp2RX0) for setting up WorkOS.

### 4. Run Migrations

Run the migrations if not already done to create your database schema and seed dummy products (there is a migration to seed dummy data. seed is not required):

```bash
php artisan migrate
```

### 5. Theme Customization

This shop is themeable. To customize the design:

1. Visit [shadcn-vue themes](https://www.shadcn-vue.com/themes) to pick a theme.
2. Replace the `@layer base` section in the `app.css` file with the selected theme’s base styles.


Then open your browser at `http://localhost:8000`.

## Additional Information

This starter kit includes everything you’d expect from a simple webshop. It provides a base for common web shop functionalities, allowing you to further customize or extend as needed.

## Contributing

Contributions are welcome! If you have suggestions or improvements, please open an issue or submit a pull request.

## License

This project is open-sourced under the [MIT license](LICENSE).
