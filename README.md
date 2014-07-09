# Create your own reactionface collection!

You want to setup a page like [ponyfac.es](http://ponyfaces) or [lauerfac.es](http://lauerfac.es)? Well, you've come to the right place!

## How to get started:

1. Download or clone this repo to your local harddrive and unpack it if necessary.
2. Create an empty MySQL database.
    `CREATE DATABASE reactionfaces DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;`
3. Import the file **install/db.sql** into the database.

### Configuration
1. Duplicate **/config/localhost.php** and name it like your host name, e.g. **/config/an.example.com.php**
2. Open the config file with a text editor and change it according to your site.
3. Secure the admin area of your installation with a password:
    1. Generate a .htpasswd file online, for example at [htaccesstools.com](http://www.htaccesstools.com/htpasswd-generator/)
    2. Save the file to **admin/.htpasswd**
    3. Open the file **admin/.htaccess**
    4. Change line 3 to point to the .htpasswd file
4. If you install into a subfolder of your webspace, you'll also have to edit the RewriteBase in the .htaccess file. Set it to match your folder, e.g. if you installed to http://example.com/reactions change the line to `RewriteBase /reactions/`

Finally, upload all the files to your webserver.

## A new outfit

### CSS

The stylesheets are written in [LESS](http://lesscss.org), so you'll need to compile them to CSS if you change anything. To make this easier I've provided a Gruntfile to automate the process (same goes for the JS files, the Gruntfile covers these, too).

To get started, install the necessary npm modules:
    `npm install`

To build everything just type
    `grunt`

### Templates
Templates in **/core/templates** can be overridden by creating a file with the same name in **/content/templates**.

For example, if you want to override the navigation, copy **/core/templates/partials/nav.php** to **/content/templates/partials/nav.php** and change it as you like.

