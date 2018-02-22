# Create your own reactionface collection!

## What is this?

faces is a PHP web app that allows you to create an online reactionface collection. Live examples:

* [http://ponyfaces.hpcodecraft.me/](http://ponyfaces.hpcodecraft.me/)
* [http://lauerfaces.hpcodecraft.me/](http://lauerfaces.hpcodecraft.me/)

## Manual installation/deployment:

1. Download or clone this repo to your local harddrive and unpack it if necessary.
2. Create an empty MySQL database.
   `CREATE DATABASE faces DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;`
3. Import the file **setup/db.sql** into the database.

### Configuration

1. Duplicate **src/config/localhost.php** and name it like your host name, e.g. **src/config/an.example.com.php**
2. Open the config file with a text editor and change it according to your site.
3. Secure the admin area of your installation with a password:
   1. Generate a .htpasswd file online, for example at [htaccesstools.com](http://www.htaccesstools.com/htpasswd-generator/)
   2. Save the file to **src/admin/.htpasswd**
   3. Open the file **src/admin/.htaccess**
   4. Change line 3 to point to the .htpasswd file
4. If you install into a subfolder of your webspace, you'll also have to edit the RewriteBase in the .htaccess file. Set it to match your folder, e.g. if you installed to http://example.com/faces change the line to `RewriteBase /faces/`

Finally, upload all the files to your webserver.

## A new outfit

### CSS

The stylesheets are written in [LESS](http://lesscss.org), so you'll need to compile them to CSS if you change anything. To make this easier I've provided a Gruntfile to automate the process (same goes for the JS files, the Gruntfile covers these, too).

To get started, install the necessary npm modules:
`npm install`

To build everything just type
`grunt`

### Templates

Templates in **src/core/templates** can be overridden by creating a file with the same name in **src/content/templates**.

For example, if you want to override the navigation, copy **src/core/templates/partials/nav.php** to **src/content/templates/partials/nav.php** and change it as you like.
