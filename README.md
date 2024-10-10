# Website-jasamarga 

# Project Setup Guide

## Prerequisites

Before running the program, ensure the following configurations and installations are completed.

### 1. PHP Configuration

Uncomment the following lines in your `php.ini` file:

extension=gd
extension=zip


### 2. Install Yajra DataTable

Run the following command to install Yajra DataTable:

composer require yajra/laravel-datatables-oracle


### 3. Install Intervention Image

Run the following command to install Intervention Image:

composer require intervention/image:2.7.0


## Additional Information

For more detailed instructions, please refer to the official documentation of each package:
- [Yajra DataTable Documentation](https://yajrabox.com/docs/laravel-datatables)
- [Intervention Image Documentation](http://image.intervention.io/)