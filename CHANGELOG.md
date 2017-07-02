# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Added
- `install:git` command
- `delete:git` command
- `install:wordpress` command
- `delete:wordpress` command
- Ability to inline file contents to `make:recipe`, `env:update`, etc.

## [0.2.0] - 2017-06-23
### Added
- `get:env` command
- `update:env` command
- `get:nginx-config` command
- `update:nginx-config` command
- `make:key` command
- `show:key` command
- `list:keys` command
- `delete:key` command

### Changed
- Remove need for custom `->execute()` method on commands
- Loads of the commands' namespaces
- Folder structure in `/src/Commands`

### Fixed
- Minor typos in documentation

## [0.1.5] - 2017-06-12
### Added
- `make:worker` command
- `show:worker` command
- `list:workers` command
- `delete:worker` command
- `reboot:worker` command
- `make:recipe` command
- `show:recipe` command
- `list:recipes` command
- `delete:recipe` command
- `run:recipe` command
- `update:recipe` command

## [0.1.4] - 2017-06-11
### Changed
- Renamed `create:*` commands to `make:*` ([#5](https://github.com/svenluijten/forge-cli/issues/5))

### Added
- `create:rule` command
- `show:rule` command
- `list:rules` command
- `delete:rule` command
- `create:job` command
- `show:job` command
- `list:jobs` command
- `delete:job` command
- `create:database` command
- `show:database` command
- `list:databases` command
- `delete:database` command

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

[Unreleased]: https://github.com/svenluijten/forge-cli/compare/0.2.0...HEAD
[0.2.0]: https://github.com/svenluijten/forge-cli/compare/0.1.5...0.2.0
[0.1.5]: https://github.com/svenluijten/forge-cli/compare/0.1.4...0.1.5
[0.1.4]: https://github.com/svenluijten/forge-cli/compare/0.1.3...0.1.4
[0.1.3]: https://github.com/svenluijten/forge-cli/compare/0.1.2...0.1.3 
[0.1.2]: https://github.com/svenluijten/forge-cli/compare/0.1.1...0.1.2
[0.1.1]: https://github.com/svenluijten/forge-cli/compare/0.1.0...0.1.1
[0.1.0]: https://github.com/svenluijten/forge-cli/releases/0.1.0
