Warning. Bundle in development state.

# SmsBundle

This bundle will help you to implement an sms messages to your project

# Installation 

You can install this bundle by the following command: 

``` bash
$ composer require yamilovs/sms-bundle ^1.0
```

# Configuration

You can define as many provider configurations as you want. Available providers are:
 
 * [Sms Ru](src/Resources/docs/providers/sms_ru.md) [sms.ru]
 * [Sms Aero](src/Resources/docs/providers/sms_aero.md) [smsaero.ru]
 * [Sms Discount](src/Resources/docs/providers/sms_discount.md) [iqsms.ru]
 * [Sms Center](src/Resources/docs/providers/sms_discount.md) [smsc.ru]

# Usage

#### In your controller

```php
<?php
// src/Controller/FooController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yamilovs\Bundle\SmsBundle\Service\ProviderManager;
use Yamilovs\Bundle\SmsBundle\Sms\Sms;

class FooController extends Controller
{
    public function barAction(ProviderManager $providerManager)
    {
        $sms = new Sms('+12345678900', 'The cake is a lie');
        $provider = $providerManager->getProvider('your_provider_name');
        
        $provider->send($sms);
    }
}
```

# Tips

You can check sms delivery by the following command:
``` bash
$ php bin/console yamilovs:sms:delivery:test [your_provider_name] [your_phone_number] [your_message_text]
```