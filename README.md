# Web-Push Library for Codeigniter 3
### Installation

Just clone or fork this repository and copy into your Codeigniter 3 project and configure the configuration at `./application/config/webpush_config.php` file.

Before using you need to install phpwebpush-lib `composer require minishlink/web-push` using composer at : 
```bash
./application/third-party
```

and set composer autoload at `config.php` to
```bash
APPPATH.'third_party/vendor/autoload.php';
```

You need to generate your own public and private key based on [PHP Web-Push documentation](https://github.com/web-push-libs/web-push-php#authentication-vapid)

### Config You Need To Configure
If you change model name or model function you need to change this code : 
```php
$config['webpush']['publickey'] = 'YOUR-OWN-PUBLIC-KEY';
$config['webpush']['privatekey'] = 'YOUR-OWN-PRIVATE-KEY';
$config['webpush']['contact'] = 'YOUR-CONTACT';
```

### How to Use
Load the library : 
```php
$this->load->library('PHPWebPush');
```

Send Notification For Single Receiver :
```php
$this->phpwebpush->send(array $client, mixed $notif_data);
```

Send Notification For Multiple Receiver :
```php
$this->phpwebpush->send(array of array $client, mixed $notif_data, false);
```
