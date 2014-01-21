Phpro_RemoteMedia
=================

Magento development tool to automatically fetch catalog product images from a production environment for a development or staging environment.

The purpose of this module is to prevent being forced to download all media files to your local development/staging environment (sometimes this can be a huge amount of data). Each catalog product image is fetched and stored on the fly if it is missing at page load.

Note: This is a tool simplify your development/staging setup, and definitely not meant to be used on a production environment!

How it works
=================
Files are fetched on the fly from a configured production media URL if the media/catalog/product file is not found in the media folder of your local Magento installation.

Usage / installation
=================
- Install the module using modman or Composer
- Configure the module in the System > Configuration > Development > PHPro - Remote Media Fetch Settings
- Enable the module and configure the URL to the production media URL
- Refresh a page and wait until all the images are downloaded (this only adds a small one-time overhead)

Supported Magento version
=================

Considered to work on most recent versions of Magento Community / Enterprise
Actually tested on :
- Magento Community Edition 1.7.1 & 1.8.1
- Magento Enterprise Edition 1.13.1.0

Todo
=================
- Prevent usage of file_get_contents in helper/Data.php
- Write unit tests
- Run unit tests on Travis
