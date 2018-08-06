# Message Bird

Provider to connect with [Message Bird](https://www.messagebird.com/) service.

## Parameters

 * `originator` The sender of the message. This can be a telephone number (including country code) or an alphanumeric string. In case of an alphanumeric string, the maximum length is 11 characters. *(required)*
 * `access_key` Your API key *(required)*
 * `type` The type of message. Values can be: `sms`, `binary`, or `flash`. Default: sms

## Example

``` yaml
# config/yamilovs_sms.yaml
yamilovs_sms:
    providers:
        message_bird_provider_doc: # your custom provider name
            message_bird:
                access_key: '1234567890abcdefg'
                originator: 'your_sample_originator'
                type: sms
```