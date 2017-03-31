![forge-cli](https://cloud.githubusercontent.com/assets/11269635/24330714/fdfddfaa-1224-11e7-8f84-f1b4efa7a8b7.jpg)

# Forge CLI

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Code Climate][ico-codeclimate]][link-codeclimate]
[![Code Quality][ico-quality]][link-quality]
[![SensioLabs Insight][ico-insight]][link-insight]

Interact with your [Laravel Forge](https://forge.laravel.com) servers and sites via the command line with this package. Create and list
servers, add sites, and install repositories all without leaving the comfort of your command line. An overview of all available commands
can be found [here](#usage).

## Installation
Via [composer](http://getcomposer.org):

```bash
$ composer global require sven/forge-cli
```

## Setup
Ensure Composer's global `bin` directory is included in your path. This directory is located at `~/.composer/vendor/bin` on macOS / Linux, and at
`%APPDATA%/Composer/vendor/bin` on Windows.

Before using the commands, you have to provide an API token. To generate a new token, visit [this page](https://forge.laravel.com/user/profile#/api),
give the token a name (like `ForgeCLI`) and click "Create new token". 

Then, execute the following command on the command line, replacing `{key}` with your own API key:

```bash
$ forge authorize {key}
```

If the API key on your Forge account changed, you'll need to run the same command again. The configuration file will be saved to your home
directory (`~/forge.json` on macOS / Linux, `%USERPROFILE%/forge.json` on Windows).

## Usage
A list of commands with their explanation can be found below.

### Servers
```bash
# Show all servers associated with your account.
$ forge list:servers

# Show information about one of your servers.
$ forge show:server {id}

# Update the metadata on one of your servers.
$ forge update:server {id} --name=sluggish-cheetah --size=1GB --ip=127.0.0.1 --private-ip=192.168.1.1 --max-upload-size=256 --network=123,456,789
```

### Sites
Sites documentation...

### Services
Services documentation...

### Daemons
Daemons documentation...

### Firewalls
Firewalls documentation...

### Scheduled jobs
Scheduled jobs documentation...

### Databases
Databases documentation...

### SSL certificates
SSL certificates documentation...

### SSH keys
SSH keys documentation...

### Workers
Workers documentation...

### Deployment
Deployment documentation...

### Configuration
Configuration documentation...

### Projects
Projects documentation...

### Recipes
Recipes documentation...

### Credentials
Credentials documentataion...

## Contributing
All contributions (pull requests, issues and feature requests) are
welcome. Make sure to read through the [CONTRIBUTING.md](CONTRIBUTING.md) first,
though. See the [contributors page](../../graphs/contributors) for all contributors.

## License
`sven/forge-cli` is licensed under the MIT License (MIT). Please see the
[license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/forge-cli.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/forge-cli.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/svenluijten/forge-cli.svg?style=flat-square
[ico-codeclimate]: https://img.shields.io/codeclimate/github/svenluijten/forge-cli.svg?style=flat-square
[ico-quality]: https://img.shields.io/scrutinizer/g/svenluijten/forge-cli.svg?style=flat-square
[ico-insight]: https://img.shields.io/sensiolabs/i/:insight.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sven/forge-cli
[link-downloads]: https://packagist.org/packages/sven/forge-cli
[link-travis]: https://travis-ci.org/svenluijten/forge-cli
[link-codeclimate]: https://codeclimate.com/github/svenluijten/forge-cli
[link-quality]: https://scrutinizer-ci.com/g/svenluijten/forge-cli/?branch=master
[link-insight]: https://insight.sensiolabs.com/projects/:insight
