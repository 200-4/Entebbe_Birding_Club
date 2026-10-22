# Post admin setup on cPanel

This post manager uses the PostgreSQL service shown in cPanel. It does not need WordPress or a MySQL database. The cPanel account must have PostgreSQL enabled and the active PHP version must have `PDO`, `pdo_pgsql`, and `fileinfo` enabled.

## 1. Create the database

1. In cPanel, open **PostgreSQL Database Wizard** (or **PostgreSQL Databases**).
2. Create a database and database user, then grant the user access to the database.
3. Record the full database name and username exactly as cPanel displays them. cPanel may prepend your account name.
4. Open **phpPgAdmin**, select the new database, and import `private/schema.sql`. The import creates the tables and inserts the three sample stories from the current site.

If you do not see the PostgreSQL database wizard or databases interface, ask the hosting provider to enable PostgreSQL for your cPanel account. Seeing a PHP extension alone does not create a database service.

## 2. Configure the application

1. In cPanel File Manager, copy `private/config.example.php` to `private/config.php`.
2. Edit `private/config.php` with the database name, username, password, host, and port from your hosting account. `localhost` and `5432` are common defaults; use the values your host provides.
3. Replace `setup_key` with a unique random secret at least 32 characters long. Keep this file private and do not commit it to Git. The `private` directory is blocked from direct web access and `config.php` is excluded from Git.
4. In cPanel's PHP selector/settings, confirm `PDO`, `pdo_pgsql`, and `fileinfo` are enabled for the domain's selected PHP version. Ask the host to enable `pdo_pgsql` if it is unavailable.
5. Enable HTTPS for the domain before creating the admin account or signing in.

## 3. Create the first admin

Visit `https://your-domain.example/admin/setup.php`, enter the setup key, choose a username and a strong password of at least 12 characters. The setup form locks after the first admin is created. Sign in later at `https://your-domain.example/admin/`.

The admin can create, edit, and delete posts. Each post has a title, category, short summary, story body, and exactly three JPG, PNG, or WebP photos. New photos are saved in `uploads/posts/` with generated filenames; the folder blocks PHP execution. Each photo can be up to 5 MB. If the host uses lower PHP upload limits, raise `upload_max_filesize` and `post_max_size` in the cPanel PHP settings or keep images within those limits.

## Backups

Back up both the PostgreSQL database and `uploads/posts/`. The database stores the post text and the image paths; the image files themselves live in the uploads folder.
