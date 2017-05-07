# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Added
- `create:rule` command
- `show:rule` command
- `list:rules` command
- `delete:rule` command
- `create:job` command
- `show:job` command
- `list:jobs` command
- `delete:job` command

## [0.1.3] - 2017-04-04
### Added
- `install:service` command
- `uninstall:service` command
- `list:daemons` command
- `create:daemon` command
- `delete:daemon` command
- `show:daemon` command
- `reboot:daemon` command
- `deploy:site` command
- `site:enable-quickdeploy` command
- `site:disable-quickdeploy` command
- `site:get-deploy-script` command
- `site:update-deploy-script` command
- `site:deploy-log` command
- `site:reset-deployment-status` command
- The `fillData()` method on the `BaseCommand` class now accepts an override array

### Changed
- `reboot:service` and `stop:service` now accept the server ID as first parameter instead of second
- Renamed `Services/Delete.php` to `Services/Uninstall.php`

## [0.1.2] - 2017-04-02
### Added
- `reboot:service` command
- `stop:service` command
- Boilerplate for `install:service` and `remove:service` commands

## [0.1.1] - 2017-04-02
### Fixed
- Issue with path to `autoload.php` in `bin/forge` when installing package globally

### Changed
- Some code style fixes by StyleCI

## [0.1.0] - 2017-04-01
### Added
- `authorize` command
- `credentials` command
- `list:servers` command
- `show:server` command
- `create:server` command
- `update:server` command
- `delete:server` command
- `list:sites` command
- `show:site` command
- `create:site` command
- `update:site` command
- `delete:site` command

[Unreleased]: https://github.com/svenluijten/forge-cli/compare/0.1.3...HEAD
[0.1.3]: https://github.com/svenluijten/forge-cli/compare/0.1.2...0.1.3 
[0.1.2]: https://github.com/svenluijten/forge-cli/compare/0.1.1...0.1.2
[0.1.1]: https://github.com/svenluijten/forge-cli/compare/0.1.0...0.1.1
[0.1.0]: https://github.com/svenluijten/forge-cli/releases/0.1.0
