# Sms Center

Provider to connect with [Sms Center](https://smsc.ru/) service.

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
        sms_center_provider_doc:
            sms_center:
                login: 'your_login'
                password: '12345'
                sender: 'YourSenderName'
                flash: false
```