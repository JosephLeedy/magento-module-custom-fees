# Custom Fees for Magento 1
_by Joseph Leedy_

Custom Fees allows merchants to configure additional fees to be charged to 
customers when orders are placed.

## Features

- Allows fees to be configured with a label and amount to be added to an order
- Custom fees are displayed for orders, invoices and credit memos in both the 
frontend and backend
- Custom fees can be refunded via Magento's credit memo functionality

## Requirements

- PHP 5.6 or greater
- Magento Community 1.9.4.5 _or_ Magento Enterprise 1.9.4.5

## Installation

This extension can be installed by downloading the latest code archive from the 
[releases] page of the GitHub [repository] and running these commands from a 
terminal on a Web server or in the desired installation location:

    cd /path/to/your/store
    mkdir -p tmp/custom-fees
    tar -xf [filename] -C tmp/custom-fees # OR unzip -d tmp/custom-fees [filename]
    mkdir -p app/code/community/JosephLeedy/CustomFees
    cp tmp/custom-fees/src/* app/code/community/JosephLeedy/CustomFees
    cp tmp/custom-fees/design/frontend/base/default/layout/custom_fees.xml app/design/frontend/base/default/layout
    cp tmp/custom-fees/design/adminhtml/default/default/layout/custom_fees.xml app/design/adminhtml/default/default/layout
    cp tmp/custom-fees/JosephLeedy_CustomFees.xml app/etc/modules
    rm -rf tmp/custom-fees
    rm -rf var/cache/*

**\* Note:** Be sure to replace `[filename]` with the actual name of the file 
that you downloaded.  

After copying the files, please visit the Home page of your store. Doing so 
will trigger Magento's automated installation process in the background. 

## Updating

This extension can be updated by following the same instructions listed above 
for installing the extension. It is recommended, however, that you delete all 
previously installed code files to ensure that no outdated files are left 
behind in your filesystem.

## Usage

### Configuration

Custom Fees can be added from the Magento Admin panel by going to `System > 
Configuration > Sales > Sales > Custom Order Fees`. The overall display order 
of the Custom Fees block in relation to other totals shown in the cart, 
checkout and elsewhere can be configured at `System > Configuration > 
Sales > Sales > Checkout Totals Sort Order`. All settings for this extension 
can be configured in the Global (Default), Website or Store scope.

## Support

This extension is provided as-is without warranty or support.

## License

The source code contained in this extension is licensed under the Open Software
License version 3.0 (OSL-3.0) license. A copy of this license can be found in
the [LICENSE] file included with the source code or online at
https://opensource.org/licenses/OSL-3.0.

Copyright for the included source code is exclusively held by Joseph Leedy,
all rights reserved.

## History

- 1.0.0
  - Initial release

[releases]: https://github.com/JosephLeedy/magento-module-custom-fees/releases
[repository]: https://github.com/JosephLeedy/magento-module-custom-fees
[LICENSE]: ./LICENSE
