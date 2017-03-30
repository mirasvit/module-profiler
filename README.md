# Magento 2 Profiler Module #

## Installation

Log in to the Magento server, go to your Magento install dir and run these commands:
```
composer require mirasvit/module-profiler

php -f bin/magento module:enable Mirasvit_Profiler
php -f bin/magento setup:upgrade
php -f bin/magento mirasvit:profiler:enable

rm -rf pub/static/*; rm -rf var/view_preprocessed/*;
php -f bin/magento setup:static-content:deploy
```

## Usage

```
php -f bin/magento mirasvit:profiler:enable # Enable profiler
php -f bin/magento mirasvit:profiler:disable # Disable profiler
php -f bin/magento mirasvit:profiler:status # Current status
php -f bin/magento mirasvit:profiler:allow-ips 127.0.0.1 192.268.22.11 # Allow only specified IPs
php -f bin/magento mirasvit:profiler:allow-ips --none # Remove IP restriction
```

## Demo
[http://profiler.m2.mirasvit.com/](http://profiler.m2.mirasvit.com/)

## Screenshots
### Magento2 Profiler
![](http://mirasvit.com/media/profiler/profiler.png)

### Magento2 Database Profiler
![](http://mirasvit.com/media/profiler/db.png)

## Licence
[Open Software License (OSL 3.0)](http://opensource.org/licenses/osl-3.0.php)
