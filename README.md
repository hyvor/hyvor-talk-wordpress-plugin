All comments should be run from the root of the repository.

## Dependencies

-   PHP
-   MYSQL
-   Composer
-   Bun

## Installation

```bash
./meta/dev/init
```

This command:

-   Deletes the `/wordpress` directory if it exists.
-   Downloads the latest version of WordPress.
-   Connects to your database (the database must already exist).
-   Creates `wp_` tables in the database.
-   Updates the `wp-config.php` file with your database credentials.
-   Installs WordPress.

## Development

```bash
./meta/dev/dev
```

This command:

-   Starts the development server at `http://localhost:9393`.
-   Runs `bun run dev --watch` in the `admin` directory.
-   Syncs `/plugin` to `/wordpress/wp-content/plugins/hyvor-talk`.
-   Syncs `admin.js` changes to `/wordpress/wp-content/plugins/hyvor-talk/admin/admin.js`.
