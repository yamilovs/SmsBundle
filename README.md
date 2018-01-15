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

If you want to schedule an sms delivery

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
        // Your selected sms provider
        $provider = $providerManager->getProvider('your_provider_name');
        
        // Date of sms delivery
        $worldCupStartDate = (new \DateTime("2018:06:30 00:00:00"))->setTimezone(new \DateTimeZone('Europe/London'));
        $remindDate = (new \DateTime())->add(new \DateInterval('PT5M'));
        
        // Create new delayed sms
        $worldCupStartSms = new Sms('+12345678900', '2018 FIFA World Cup started!', $worldCupStartDate);
        $remindSms = new Sms('+12345678900', 'I will remind you of football', $remindDate);
        
        // Send delayed delivery to provider
        $provider->send($worldCupStartSms); // will be sent at 2018:06:30 00:00:00
        $provider->send($remindSms); // will be sent after 5 minutes
    }
}



```

# Tips

You can check sms delivery by the following command:
``` bash
$ php bin/console yamilovs:sms:delivery:test [your_provider_name] [your_phone_number] [your_message_text]
```