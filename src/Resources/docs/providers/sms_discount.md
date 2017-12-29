# Sms Discount

Provider to connect with [Sms Discount](https://iqsms.ru) service.

## Parameters

 * `login` Your system login *(required)*
 * `password` Your system password *(required)*
 * `sender` Your sender name *(default null)*
 * `flash` Flash SMS is a message that is immediately displayed on the screen and is not stored in the phone's memory *(default false)*

## Example

``` yaml
# config/yamilovs_sms.yaml
yamilovs_sms:
    providers:
        sms_discount_provider_doc:
            sms_discount:
                login: 'z1234567890'
                password: '12345'
                sender: 'YourSenderName'
                flash: false
```