# Magento Sucuri

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.0-green)](https://php.net/)
[![Minimum Magento Version](https://img.shields.io/badge/magento-%3E%3D%202.4.4-green)](https://business.adobe.com/products/magento/magento-commerce.html)
[![GitHub release](https://img.shields.io/github/v/release/Pixel-Open/magento-sucuri)](https://github.com/Pixel-Open/magento-sucuri/releases)

## Presentation

The module adds Sucuri API features to Magento: cache management and logs.

![Sucuri Logs](screenshot.png)

## Requirements

- Magento >= 2.4.4
- PHP >= 8.0.0

## Installation

```
composer require pixelopen/magento-sucuri
```

## Configuration

Stores > Configuration > Service > Sucuri

**Multi-Website:** Use the scope config selector to fill API credentials for all websites.

## Clear the Website Firewall cache

### CLI

#### All websites

```shell
bin/magento sucuri:cache:flush
```

#### Specific website

```shell
bin/magento sucuri:cache:flush --website_id=1
```

### Admin UI

System > Cache Management > Additional Cache Management > Flush Sucuri Cache for X

## Display the audit log entries

System > Sucuri > Logs

**Multi-Website:** Use the scope selector to display requests per website.

## Refresh the log entries

### CLI

#### All websites

```shell
bin/magento sucuri:log:refresh
```

#### Specific website

```shell
bin/magento sucuri:log:refresh --website_id=1
```

### Admin UI

System > Sucuri > Logs > Refresh

**Multi-Website:** Use the scope selector before refreshing to a specific website.

### Automatically refresh logs every hour

Stores > Configuration > Service > Sucuri > Cron > Refresh Logs

### Log retention

Stores > Configuration > Service > Sucuri > Cron > Log retention (days)
