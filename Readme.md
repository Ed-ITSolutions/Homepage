# Homepage

This page can be easily setup to provide a clean home page for your domain.

## Features

* Google Search
* Configurable Quick Links
* Server/Service monitoring by opening a socket (see config.ini)
* AUP/Stay Safe rules display

# Install

Just place all the files into the same folder on a web server and then open up config.ini and configure away.

## Installing on IIS

This works no problem on IIS you just need to install PHP which can be done through the Microsoft Web Platform installer (See [http://php.iis.net/])

Once PHP is installed just point your browser at your install location and your done!

## Other Servers

This will work on any web server with PHP installed on it, just upload and go. (Obviously it would need to be on your internal network to be able to check the status of servers)

# Configuring

Config.ini contains all the configuration values, you should never need to go into index.php.

All the variables are documented in config.ini and all contain some values already to make the example page so it should be pretty straight forward to change.

# Upadting

To update just re download and upload over your current install (Backing up config.ini first), then check that there are no new config variables you need to define and then upload your config.ini back over the sample one.
