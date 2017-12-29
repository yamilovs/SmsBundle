# Sms Aero

Provider to connect with [Sms Aero](https://smsaero.ru/) service.

## Parameters

 * `user` Your registration email *(required)*
 * `api_key` Your API key *(required)*
 * `sign` Your sign. `biznes` for testing purpose *(required)*
 * `channel` Should be one of the list: 'INFO', 'DIGITAL', 'INTERNATIONAL', 'DIRECT', 'SERVICE' *(required)*

## Example

``` yaml
# config/yamilovs_sms.yaml
yamilovs_sms:
    providers:
        sms_aero_provider_doc: # your custom provider name
            sms_aero:
                user: 'email@domain.com'
                api_key: '1234567890abcdefg'
                sign: 'biznes'
                channel: 'DIGITAL'
```