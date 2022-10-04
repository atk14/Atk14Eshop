ATK14 Eshop
============

[![Build Status](https://travis-ci.com/atk14/Atk14Eshop.svg?branch=master)](https://travis-ci.com/atk14/Atk14Eshop)

_ATK14 Eshop_ is an skeleton suitable for eshops. It is built on top of _ATK14 Catalog_.

Check out <http://eshop.atk14.net/> to see the eshop running.

The Eshop contains mainly
--------------------------

* List of categories
* List of brands
* List of collections
* Pages with a hierarchical structure
* Contact page with fast contact form
* News section
* User registration (with strong blowfish passwords hashing)
* Basic administration
* RESTful API
* Sitemap (HTML, XML)
* Localization (English, Czech)
* Front-end tooling including [Gulp](https://github.com/gulpjs/gulp) and [BrowserSync](https://github.com/BrowserSync/browser-sync)

Installation
------------

3rd party libraries are being installed using the Composer. If you don't have the Composer installed, visit http://www.getcomposer.org/

    git clone https://github.com/atk14/Atk14Eshop.git
    cd Atk14Eshop
    git submodule init
    git submodule update
    composer update
    ./scripts/create_database
    ./scripts/migrate

If you are experiencing a trouble make sure that all requirements are met: <http://book.atk14.net/czech/installation%3Arequirements/>

Front-end assets
----------------

With [Node.js](http://nodejs.org) and npm installed, run following commands to install
all the tools you will need to serve and build your front-end assets.

    npm install -g gulp
    npm install

Run initial Gulp build process for the main presentation and the admininstration.

    gulp
    gulp admin

In order to serve the eshop & watch for file changes run the following command:

    gulp serve

This outputs an IP address you can use to locally test and another that can be used on devices connected to your network.

Starting the eshop
---------------------

If you are not happy with *gulp serve*, you can start the development server this way:

    ./scripts/server

and you should find the running eshop on http://localhost:8000/

Installing the eshop as a virtual host on Apache web server
--------------------------------------------------------------

This is an optional step. If you have Apache installed, you may want to install the eshop as a virtual server.

    ./scripts/virtual_host_configuration -f
    sudo service apache2 reload
    chmod 777 tmp log

Visit <http://atk14eshop.localhost/>. Is it running? Great!

If you have a trouble run the following command and follow instructions.

    ./scripts/virtual_host_configuration

You're done! Happy coding!
------------------------------

Don't forget to list your new project on http://www.atk14sites.net/

[//]: # ( vim: set ts=2 et: )
