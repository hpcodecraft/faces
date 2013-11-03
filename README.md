# OHAI!

You want to setup a page like [ponyfac.es](http://ponyfaces) or [lauerfac.es](http://lauerfac.es)? Well, you've come to the right place!

Here you'll find the piece of web software I have made for running these sites.

For the Github version, I've tried to simplify some things to make the setup relatively easy, but there's no installer script yet. Sorry about that. It's high priority on my todo-list.

So be warned, it's still a bit tinkerish.

## How to get started:

### Le download:
1. Download or clone this repo to your local harddrive and unpack it if necessary.

### Le database:
1. Create an empty MySQL database.
    `CREATE DATABASE reactionfaces DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;`
2. Import the file **install/db.sql** into the database.

### Le files:
1. Go to the **sites** folder and duplicate the folder **squid**. Rename the copy according to your site. Let's say you're about to make robotfac.es: Name it **robot**. If you want to setup homersimpsonfac.es, name it **homersimpson** and so on.
2. Rename **sites/yourname/config-squid.php** to **sites/yourname/config-yourname.php**
3. Open the config file with a text editor and change it according to your site.

Now you may want to secure the admin area of your installation with a password. If you are about to install directly to a public server, DO THIS NOW!

1. Generate a .htpasswd file online, for example at [htaccesstools.com](http://www.htaccesstools.com/htpasswd-generator/)
2. Save the file to **admin/.htpasswd**
3. Open the file **admin/.htaccess**
4. Change line 3 to point to the .htpasswd file

Finally, upload all the files to your webserver.

## A new outfit

### CSS
To change the appearance of your site, you will have to edit the file **sites/yourname/css/theme.less**

The first change you'll want to make is to edit the three main color variables **@dark**, **@medium** and **@light**.

The rest of the file defines the used fonts, navigation bullets and the styling of the popup that appears when you click on a face.

You can also use this file to override the default styles if you really want to do this.

When you're happy with your changes, compile

**sites/yourname/css/app-min.less** and **sites/yourname/css/admin-min.less**

to

**sites/yourname/css/min/app-min.css** and **sites/yourname/css/min/admin-min.css**

*Hint:* You can switch on developer mode in the admin frontend. This will enable live preview of your style changes without having to recompile every time. Styling will be a lot easier and you'll only have to compile once after you're finished. However, you should not do this on a live system!

### Templates
Templates in the **views** folder can be overridden by creating a file with the same name in **sites/yourname/views**.

For example, if you want to override the navigation, copy **views/global/nav.php** to **sites/yourname/views/global/nav.php** and change it as you like.

