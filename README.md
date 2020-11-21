# laravel-twilio-helper
Laravel helper class for twilio sdk

How to use:
```
TwilioSmsServiceHelper::init()->sms($to, $content);
\\ $to: User model instanse with phone_number field, or phone number string
\\ sms sender will get from config('services.twilio.number')
```
