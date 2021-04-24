![forge-cli](https://cloud.githubusercontent.com/assets/11269635/24330714/fdfddfaa-1224-11e7-8f84-f1b4efa7a8b7.jpg)

# Forge CLI

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-tests]][link-tests]
[![StyleCI][ico-styleci]][link-styleci]

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

Then, execute the following command on the command line:

```bash
$ forge authorize
```

When prompted for it, paste in your API key. You may optionally pass in the key directly as an argument to the command:

```bash
$ forge authorize <your_key_here>
```

If the API key on your Forge account changed, you'll need to run the same command again. A hidden configuration file 
will be saved to your home directory (`~/.forge.json` on macOS / Linux, `%USERPROFILE%/.forge.json` on Windows).

## Usage
A list of commands with their explanation can be found below. You can also find a list of commands and their arguments by installing the package
and running `forge list` or `forge help {command}`.

---

### Servers

#### server:list
Show all servers associated with your account.

```bash
$ forge server:list

+----------------+--------+----------------+-------------+-------+
| Name           | Id     | IP Address     | Region      | Ready |
+----------------+--------+----------------+-------------+-------+
| sparkling-reef | 124833 | 95.85.60.157   | Amsterdam 2 | Yes   |
+----------------+--------+----------------+-------------+-------+
```

#### server:show
Show information about one of your servers.

```bash
$ forge server:show {serverId}

Name:        sparkling-reef
IP Address:  95.85.60.157
Size:        512MB
Region:      Amsterdam 2
PHP version: php71
Created:     2017-03-13 20:59:16
```
    
#### server:make
Create a new server.

```bash
$ forge server:make
    --provider=ocean2
    --credentials={credentialId}
    --region=ams2
    --ip=127.0.0.1
    --private-ip=192.168.1.1
    --php=php71
    --database=some_database
    --install-maria
    --load-balancer
    --network={otherServerId}
    --network={anotherServerId}
```

#### server:update
Update the metadata on one of your servers. This will only update the data in Forge, it won't make any actual
changes to your server.

```bash
$ forge server:update {serverId} 
    --name=sluggish-cheetah
    --size=1GB
    --ip=127.0.0.1
    --private-ip=192.168.1.1
    --max-upload-size=256
    --network={otherServerId}
    --network={anotherServerId}    
```

#### server:reboot
Reboot one of your servers. You will need to confirm your action.

```bash
$ forge server:reboot {serverId}
```

#### server:delete
Delete an existing server. You will need to confirm your action.

```bash
$ forge server:delete {serverId}
```

---

### Sites

#### site:list
Show all sites installed on a server.

```bash
$ forge site:list {serverId}

+--------+-----------------+------+-----------------------------+--------+
| Id     | Name            | Type | Repository                  | Branch |
+--------+-----------------+------+-----------------------------+--------+
| 303243 | default         | php  | -                           | -      |
| 303246 | svenluijten.com | html | svenluijten/svenluijten.com | master |
| 303247 | pkgst.co        | php  | svenluijten/slack-packagist | master |
+--------+-----------------+------+-----------------------------+--------+
```

#### site:show
Show information about a site on a specified server.

```bash
$ forge site:show {serverId} {siteId}

Name:            svenluijten.com
Repository info: svenluijten/svenluijten.com @ master
Directory:       /build_production
Quick deploy:    Off
Status:          installed
Project type:    html
Created:         2017-03-13 21:14:19
```

#### site:make
Create a new site on one of your servers. Use `--alias` to include one or more additional domains.

```bash
$ forge site:make {serverId} 
    --domain=example.com
    --alias=example.org
    --alias=another-site.net
    --type=php
    --directory=/public
```

#### site:update
Update a site on a specified server.

```bash
$ forge site:update {serverId} {siteId}
    --directory=/html
```

#### site:deploy
Deploy the given site.

```bash
$ forge site:deploy {serverId} {siteId}
```

#### site:delete
Delete a site. You will need to confirm your action.

```bash
$ forge site:delete {serverId} {siteId}
```

---

### Services

#### service:reboot
Reboot a service on the given server. Supported services are `nginx`, `mysql`, and `postgres`.

```bash
$ forge service:reboot {serverId} {service}
```

#### service:stop
Stop a service on the given server. Supported services are `nginx`, `mysql`, and `postgres`.

```bash
$ forge service:stop {serverId} {service}
```

#### service:install
Install a service on the given server. Supported services are `blackfire` and `papertrail`. The `--host` option
is only required when installing Papertrail, `--server-id` and `--server-token` are only required when installing
Blackfire.

```bash
$ forge service:install {serverId} {service}
    --host=192.168.1.1
    --server-id=12345
    --server-token=YOUR_SERVER_TOKEN
```

#### service:uninstall
Uninstall a service from the given server. Supported services are `blackfire` and `papertrail`.

```bash
$ forge service:uninstall {serverId} {service}
```

---

### Daemons

#### daemon:list
List all active daemons on the given server.

```bash
$ forge daemon:list {serverId}

+-------+------------+---------------------------------+---------------------+
| Id    | Status     | Command                         | Created             |
+-------+------------+---------------------------------+---------------------+
| 12345 | installing | echo 'hello world' >> /dev/null | 2017-03-13 21:14:19 |
+-------+------------+---------------------------------+---------------------+
```

#### daemon:show
Show information about the given daemon.

```bash
$ forge show:daemon {serverId} {daemonId}

Status:  installing
Command: echo 'hello world' >> /dev/null
Created: 2017-03-21 18:26:33
```

#### daemon:make
Create a new daemon to run on the given server. If no user is supplied, it defaults to `forge`.

```bash
$ forge make:daemon {serverId}
    --command="command to run"
    --user=root
```

#### daemon:reboot
Reboot the given daemon. You will need to confirm your action.

```bash
$ forge reboot:daemon {serverId} {daemonId}
```

#### daemon:delete
Delete the given daemon from the given server. You will need to confirm your action.

```bash
$ forge delete:daemon {serverId} {daemonId}
```

---

### MySQL Users

#### mysql-user:make
Create a new MySQL user with access to the given databases.

```bash
$ forge mysql-user:make {serverId}
    --username="your_username"
    --password="password"
    --database=456
    --database=789
```

#### mysql-user:list
List all MySQL users on the given server.

```bash
$ forge mysql-user:list {serverId}

+-------+---------------+------------+---------------------+
| Id    | Name          | Status     | Created             |
+-------+---------------+------------+---------------------+
| 67890 | your_username | installing | 2017-03-13 21:14:19 |
+-------+---------------+------------+---------------------+
```

#### mysql-user:show
Show information about the given MySQL user.

```bash
$ forge mysql-user:show {serverId} {userId}

Status:  installing
Name:    your_username
Created: 2017-03-21 18:26:33
```

#### mysql-user:update
Update the databases a MySQL user has access to.

```bash
$ forge mysql-user:update {serverId} {userId}
    --database=987
    --database=654
```

#### mysql-user:delete
Delete the given MySQL user from your server. You will need to confirm your action.

```bash
$ forge mysql-user:delete {serverId} {userId}
```

### Firewall Rules

#### rule:make
Create a new firewall rule.

```bash
$ forge rule:make {serverId}
    --name="firewall rule"
    --port=88
```

#### rule:list
Show all firewall rules.

```bash
$ forge rule:list {serverId}
```

#### rule:show
Show information about one of your firewall rules.

```bash
$ forge rule:show {serverId} {ruleId}
```

#### rule:delete
Delete a given firewall rule from one of your servers. You will need to confirm your action.

```bash
$ forge rule:delete {serverId} {ruleId}
```

---

### Scheduled Jobs

#### job:make
Create a new scheduled job.

```bash
$ forge job:make {serverId}
    --user="forge"
    --command="echo 'hello world' > /dev/null"
    --frequency="hourly"
```

#### job:list
Show all scheduled jobs.

```bash
$ forge job:list {serverId}
```

#### job:show
Show information about one of your scheduled jobs.

```bash
$ forge job:show {serverId} {jobId}
```

#### job:delete
Delete a given scheduled job from one of your servers. You will need to confirm your action.

```bash
$ forge job:delete {serverId} {jobId}
```

---

### Databases

#### database:make
Create a new database. The flags `--user` and `--password` must either both be present or both
be absent.

```bash
$ forge database:make {serverId}
    --user="sven"
    --password="My_P45sw0rD"
```

#### database:list
Show all databases on a server.

```bash
$ forge database:list {serverId}
```

#### database:show
Show information about one of your databases.

```bash
$ forge database:show {serverId} {databaseId}
```

#### database:delete
Delete a given database from one of your servers. You will need to confirm your action.

```bash
$ forge database:delete {serverId} {databaseId}
```

---

### SSL Certificates

#### certificate:list
Show all certificates installed on the given site.

```bash
$ forge certificate:list {serverId} {siteId}
```

#### certificate:show
Show information about the specified certificate.

```bash
$ forge certificate:show {serverId} {siteId} {certificateId}
```

#### certificate:make
Create a new certificate for one of your sites.

```bash
$ forge certificate:make {serverId} {siteId}
    --domain="www.example.com"
    --country="US"
    --state="NY"
    --city="New York"
    --organization="Acme, Inc."
    --department="Development"
```

#### certificate:activate
Activate a currently installed SSL certificate.

```bash
$ forge certificate:activate {serverId} {siteId} {certificateId}
```

#### certificate:install
Install a certificate on the given site.

```bash
$ forge certificate:install {serverId} {siteId} {certificateId}
```

#### certificate:delete
Revoke and remove a certificate from the given site. You will need to confirm you action.

```bash
$ forge certificate:delete {serverId} {siteId} {certificateId}
```

---

### SSH Keys

#### key:make
Create a new SSH key and add it to a server.

```bash
$ forge key:make {serverId}
    --name="Macbook"
    --file="~/.ssh/id_rsa.pub"
```

If you do not supply the `--file` option, the command will look in `STDIN` for any input:

```bash
$ forge key:make {serverId} --name="Macbook" < ~/.ssh/id_rsa.pub
```

#### key:list
Show all SSH keys installed on a server.

```bash
$ forge key:list {serverId}
```

#### key:show
Show information about one of your SSH keys.

```bash
$ forge key:show {serverId} {keyId}
```

#### key:delete
Delete a given SSH key from one of your servers. You will need to confirm your action.

```bash
$ forge key:delete {serverId} {keyId}
```

---

### Workers

#### worker:make
Create a new worker.

```bash
$ forge worker:make {serverId} {siteId}
    --connection=sqs
    --timeout=90
    --sleep=10
    --tries=1
    --daemon
```

#### worker:list
Show all workers installed on a site.

```bash
$ forge worker:list {serverId} {siteId}
```

#### worker:show
Show information about one of your workers.

```bash
$ forge worker:show {serverId} {siteId} {workerId}
```

#### worker:delete
Delete a given worker from one of your sites. You will need to confirm your action.

```bash
$ forge worker:delete {serverId} {siteId} {workerId}
```

#### worker:reboot
Reboot one of your workers. You will need to confirm your action.

```bash
$ forge worker:reboot {serverId} {siteId} {workerId}
```

---

#### quickdeploy:enable
Enable quick deployment for the given site.

```bash
$ forge quickdeploy:enable {serverId} {siteId}
```

#### quickdeploy:disable
Disable quick deployment for the given site.

```bash
$ forge quickdeploy:disable {serverId} {siteId}
```

#### deploy-script:get
Get the deployment script of the given site.

```bash
$ forge deploy-script:get {serverId} {siteId}
```

The output will be written to `STDOUT`, so you can save it to a file directly:

```bash
$ forge deploy-script:get {serverId} {siteId} > file.txt
```

#### deploy-script:set
Update the deployment script of the given site.

```bash
$ forge deploy-script:set {serverId} {siteId}
    --file=file.txt
```

If you do not supply the `--file` option, the command will look in `STDIN` for any input:

```bash
$ forge deploy-script:set {serverId} {siteId} < file.txt
```

#### deploy-log
Show the latest deployment log.

```bash
$ forge deploy-log {serverId} {siteId}
```

The output will be written to `STDOUT`, so you can save it to a file directly:

```bash
$ forge deploy-log {serverId} {siteId} > file.log
```

#### reset-deploy-state
Reset the state of the deployment.

```bash
$ forge reset-deploy-state {serverId} {siteId}
```

---

### Configuration

#### env:get
Get the environment file of one of your sites.

```bash
$ forge env:get {serverId} {siteId}
```

The output will be written to `STDOUT`, so you can save it to a file directly:

```bash
$ forge env:get {serverId} {siteId} > env-file.txt
```

#### env:set
Update the environment file for one of your sites.

```bash
$ forge env:set {serverId} {siteId}
    --file=new-env.txt
```

If you do not supply the `--file` option, the command will look in `STDIN` for any input:

```bash
$ forge env:set {serverId} {siteId} < new-env.txt
```

#### nginx-config:get
Get the nginx config file of one of your sites.

```bash
$ forge nginx-config:get {serverId} {siteId}
```

The output will be written to `STDOUT`, so you can save it to a file directly:

```bash
$ forge nginx-config:get {serverId} {siteId} > nginx.conf
```

#### nginx-config:set
Update the nginx config file for one of your sites.

```bash
$ forge nginx-config:set {serverId} {siteId}
    --file=new.conf
```

If you do not supply the `--file` option, the command will look in `STDIN` for any input:

```bash
$ forge nginx-config:set {serverId} {siteId} < new.conf
```

---

### Projects

#### git:install
Install a git project on the given site.

```bash
$ forge git:install {serverId} {siteId}
    --provider="github"
    --repository="username/repository"
```

The `provider` option can be either `github` (default) or `custom`.

#### git:delete
Remove a git project from the given site. You will need to confirm your action.

```bash
$ forge git:delete {serverId} {siteId}
```

#### wordpress:install
Install WordPress on the given site.

```bash
$ forge wordpress:install {serverId} {siteId}
    --database="name_of_database"
    --user="your_username"
```

#### wordpress:delete
Remove a WordPress project from the given site. You will need to confirm your action.

```bash
$ forge wordpress:delete {serverId} {siteId}
```

---

### Recipes

#### recipe:make
Create a new recipe.

```bash
$ forge recipe:make
    --name="My Recipe"
    --user=forge
    --script="echo 'hi' >> /dev/null"
```

If you do not supply the `--script` option, the command will look in `STDIN` for any input:

```bash
$ forge recipe:make --name="My Recipe" --user=forge < file.txt
```

#### recipe:list
Show all recipes in your Forge account.

```bash
$ forge recipe:list
```

#### recipe:show
Show information about one of your recipes.

```bash
$ forge recipe:show {recipeId}
```

#### recipe:run
Run the given recipe on the specified server(s).

```bash
$ forge recipe:run {recipeId}
    --server=1234
    --server=5678
```

#### recipe:delete
Delete the given recipe. You will need to confirm your action.

```bash
$ forge recipe:delete {recipeId}
```

---

### Credentials
Show all credentials associated with your account.

```bash
$ forge credentials

+-------+----------+--------+
| Id    | Name     | Type   |
+-------+----------+--------+
| 15071 | Personal | ocean2 |
+-------+----------+--------+
```

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
[ico-tests]: https://github.com/svenluijten/forge-cli/workflows/Tests%20(PHP)/badge.svg
[ico-styleci]: https://styleci.io/repos/85804300/shield

[link-packagist]: https://packagist.org/packages/sven/forge-cli
[link-downloads]: https://packagist.org/packages/sven/forge-cli
[link-tests]: https://github.com/svenluijten/forge-cli/actions?query=workflow%3ATests%20(PHP)
[link-styleci]: https://styleci.io/repos/85804300
