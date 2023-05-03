
B2B -
===============================================

#### POWERED BY Medica Scope.


`b2b` is a theme based on starter theme called 'underscores', Requires PHP version 8.1+

Installation
---------------

To start using this project you need to follow the steps below:

- Clone the `b2b` repo to your apache directory.
- Create an empty database.
- Go to your project directory and copy `config-sample.php` file then change its name to `config.php`.
- Change the MYSQL connection settings and `WP_HOME`, `WP_SITEURL` constants to your site url.
- Go to your project url `www.example.com` and complete the WordPress installation.
- Login to your WordPress site and go to the `Plugins -> Installed plugins` section and search for `UpdraftPlus - Backup/Restore` plugin then activate it.
- From the toolbar select `UpdraftPlus -> Backup/Restore` then go to `Existing backups` section and restore the latest backup.
- Follow the wizard steps.
- Check theme instructure to compile the `style.css` & `style-rtl.css`.

Now you're ready to go to the next step. :)


### Login

`b2b` platform is designed to log admins in with a different path.
To access the dashboard you have to replace `/wp-admin` in the last of the URL to `/backoffice`..

Username: `admin`  
Password: `mds@12345`

> **_NOTE:_**  These credentials are working only in the dev mode, should be changed after publishing the website.

### Requirements

`b2b` requires the following dependencies:

- [Node.js](https://nodejs.org/)
- [Composer](https://getcomposer.org/)

### Quick Start


### Setup

To start using all the tools that come with `b2b`  you need to install the necessary Node.js and Composer dependencies :

```sh
$ composer install
$ npm install
```

### Available CLI commands

`b2b` comes packed with CLI commands tailored for WordPress theme development :

- `npm run start` : Start watching all files [SASS, JS, PHP] and compile them all.
- `npm run publicStyles` : Compile the sass files included in the public path.
- `npm run publicStylesRtl` : Convert the css files to rtl version.
- `npm run publicScripts` : Compile all scripts included in the public path.
- `npm run publicImages` : Minify all images included in the public path and convert them to webp extension.
- `npm run adminStyles` : Compile the sass files included in the admin path.
- `npm run adminStylesRtl` : Convert the css files to rtl version.
- `npm run adminScripts` : Compile all scripts included in the admin path.
- `npm run adminImages` : Minify all images included in the admin path and convert them to webp extension.
- `npm run translate` : Crawl the php files searching for strings added to _() function to be added to the .pot file to make it ready to be translated.
- `npm run all` : Compile all files [SASS, JS, PHP] for just one time - Production purpose.
- `npm run bundle` : generates a .zip archive for distribution, excluding development and system files.

Now you're ready.

Good luck!

### Development Team

- Mustafa Shaaban - SR. PHP Developer
- Khaled Fathy - SR. Fullstack Developer
