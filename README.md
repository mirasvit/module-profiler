# Magento 2 Profiler Module #

## Installation

Log in to the Magento server, go to your Magento install dir and run these commands:
```
composer require mirasvit/module-profiler

php -f bin/magento module:enable Mirasvit_Profiler
php -f bin/magento setup:upgrade
php -f bin/magento mirasvit:profiler:enable
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

[http://profiler.m2.mirasvit.com/profiler/profile/index/](http://profiler.m2.mirasvit.com/profiler/profile/index/)

## Screenshots
### Magento 2 Code Profiler and Database Profiler
![](http://mirasvit.com/media/profiler/v2.png)


## Licence
[Open Software License (OSL 3.0)](http://opensource.org/licenses/osl-3.0.php)

## 1.0.5
*(2017-09-07)* 

* PHP 5.6.x

---

## 1.0.3, 1.0.4
*(2017-09-06)* 

* Issues with less compilation

---

## 1.0.2
*(2017-09-05)* 

* Significant changes in UI

---

## 1.0.1
*(2017-03-30)* 

* Improve styles load mechanism

---

## 1.0.0
*(2017-03-30)* 

* Initial release
