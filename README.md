# module-reports

# Report Inventory Reservation for Magento 2

Extension designed exclusively to provide detailed reports on stock reservations. 
Its primary goal is to offer insights and analytics related to inventory management, specifically focusing on reserved stock items. 
This functionality is crucial for Magento 2 store owners and administrators who need to monitor and manage inventory reservations effectively.

Key Feature:
Stock Reservation Reports: Delivers comprehensive analytics and reporting on stock reservations, enabling better inventory management and planning.

Technical Highlights:
Magento 2 Compatibility: Crafted specifically for the Magento 2 platform, ensuring seamless integration.

PSR-4 Autoloading: Utilizes PSR-4 standards for efficient class loading.

Composer Installable: Easily integrated into Magento 2 projects via Composer.

by [NobleCommerce.io](https://noblecommerce.io).

## Installation

1 - Install the module:

```bash
composer require noble-commerce/module-reports
```

2 - Enable the module and clear cache:

```bash
bin/magento module:enable NobleCommerce_Reports
bin/magento setup:upgrade
bin/magento cache:flush
```

Done!

## Configuration

Menu > Report > Inventory Reservation 