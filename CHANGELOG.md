# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [0.2.0] - 2016-11-12
### Added
- Added `InstantiatorTrait` that lets you instantiate a class through its constructor.

### Changed
- Changed license to MIT.

## [0.1.6] - 2016-02-26
### Added
- Added unit tests for `Helper` class.

### Fixed
- Renamed `Helper::parse_params` to camelCase `Helper::parseParams`.

## [0.1.5] - 2016-02-26
### Added
- Added `Helper` class that provides a static method to parse parameters.

### Fixed
- Refactored traits to deduplicate code.

## [0.1.4] - 2016-02-26
### Fixed
- Removed unused local variables in tests.

## [0.1.3] - 2016-02-26
### Fixed
- Refactored looping over parameters.

## [0.1.2] - 2016-02-18
### Fixed
- Use `name` property instead of `getName()` method. Fixes issues with APC-enabled PHP versions.

## [0.1.1] - 2016-02-18
### Fixed
- Bumped version requirement for `brightnucleus/exceptions` to v0.2+.

## [0.1.0] - 2016-02-17
### Added
- Initial release to GitHub.

[0.1.7]: https://github.com/brightnucleus/invoker/compare/v0.1.6...v0.2.0
[0.1.6]: https://github.com/brightnucleus/invoker/compare/v0.1.5...v0.1.6
[0.1.5]: https://github.com/brightnucleus/invoker/compare/v0.1.4...v0.1.5
[0.1.4]: https://github.com/brightnucleus/invoker/compare/v0.1.3...v0.1.4
[0.1.3]: https://github.com/brightnucleus/invoker/compare/v0.1.2...v0.1.3
[0.1.2]: https://github.com/brightnucleus/invoker/compare/v0.1.1...v0.1.2
[0.1.1]: https://github.com/brightnucleus/invoker/compare/v0.1.0...v0.1.1
[0.1.0]: https://github.com/brightnucleus/invoker/compare/v0.0.0...v0.1.0
