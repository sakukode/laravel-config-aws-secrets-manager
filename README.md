# Laravel Config with AWS Secret Managers

How to use AWS Secret Managers for Laravel Config

## Usage

### Setting AWS Credentials

Make sure you already setup AWS Credentials with two files on home folder:

- ~/.aws/config
```
[default]
region=
```

- ~/.aws/credentials
```
[default]
aws_access_key_id=
aws_secret_access_key=
```

### Setup the project

Clone this repository
```
git clone https://github.com/sakukode/laravel-config-aws-secrets-manager.git
```

and run `composer install`

### Load the config

Update the config with AWS Secret Managers values using artisan command

```
php artisan config:cache
```

I added config test file in `config/test.php`, so we can check the update config value using artisan command

```
php artisan config:show test
```


