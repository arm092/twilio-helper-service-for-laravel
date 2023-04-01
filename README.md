# twilio-helper-service-for-laravel
Helper class for working with twilio sdk in Laravel

How to use:
```
TwilioSmsServiceHelper::init()->sms($to, $content);
\\ $to: User model instanse with phone_number field, or phone number string
\\ sms sender will get from config('services.twilio.number')
```
