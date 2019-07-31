# census CMS

census is a free open source CMS under the license GPL-2.0+

### Requirements

#### Software
* PHP >= 7.3
* Webserver running Apache2 or IIS
* Composer

#### Hardware
* RAM >= 4GB
* CPU >= dual core
* HDD >= 5GB

## For developers
This project uses Twig 2.x for the tempplate rendering. Please visit
https://twig.symfony.com/doc/2.x/ for more information.


census CMS is a flat file based application which does not need any database 
from scratch. But maybe some 3rd party plugins can use a database, please 
read the docs of 3rd party plugins to match the requirements.


# Installing census CMS
```
composer require census/cms
```

This will install the latest version which might be unstable. You can specify 
a version e.g. `composer require census/cms ^1.0` to install a stable version.

# Configuration
In your webroot open the `config.php` and edit your settings as needed. There 
are a couple of settings you can change like

* Template path
* Domain
* Page tree path
* Meta information

# Templating
Create a directory in your webroot `templates` (if you want to change the directory 
name, you also have to set this name in the `config.php`.

# Backend
Go to `https://your-host.dev/backend` to login into the backend and manage pages or
content.