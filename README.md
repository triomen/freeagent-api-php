freeagent-api-php - v0.1
========================

## Description

This is an *unofficial* FreeAgent PHP Client Library provides a simple PHP interface for the FreeAgent API 2.0 (https://dev.freeagent.com/docs).
It is a fork from [nickheppleston repository](https://github.com/nickheppleston/freeagent-api-php "nickheppleston repository") 

Basic OAuth support is provided, however this API assumes you have already exchanges tokens and have a 'Refresh Token'. 
For more information, see https://dev.freeagent.com/docs/oauth/.

## Limitation

This API is a **read only** one.

The API currently supports the following functionality of the FreeAgent API v2:

* Invoices
* Contacts
* Projects
* Category
* Bank Accounts & explanations 

## Usage

1. Do the quickstart for FreeAgent API 2.0 to obtain access token : https://dev.freeagent.com/docs/quick_start
2. Copy paste the access token into "config.inc.php"
3. Use the api ! 

Example 1 : Get one element
```php
$invoice = new Invoice('https://api.freeagent.com/v2/invoices/4');
echo $invoice->net_value;
```

Example 2 : Get all elements 

```php
$cats = new Categories();
$categories = $cats->getAll();
```

## Next steps

- Unit testing
- Manage all objects (tasks, ...)
- Automatic Date casting when it is a date + getters / setters
- Attachment management