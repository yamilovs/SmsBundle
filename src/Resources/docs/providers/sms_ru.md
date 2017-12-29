# Sms Ru

Provider to connect with [Sms Ru](https://sms.ru) service.

## Parameters

 * `api_id` Your API key *(required)*
 * `from` Sender name *(required)*
 * `test` Simulates sending a message to test your programs for the correct handling of server responses. In this case, the message itself is not sent and the balance is not spent. *(default false)*

## Example

``` yaml
# config/yamilovs_sms.yaml
yamilovs_sms:
    providers:
        sms_ru_provider_doc: # your custom provider name
            sms_ru:
                api_id: '1234567890abcdefg'
                from: 'YourSenderName'
                test: true
```