<p align="center"><img src="https://cdn.rawgit.com/santigarcor/laratrust/135aa15fecd22a512c444389d1f8cb94e72d0fa7/docs/img/laratrust.svg"></p>

# Why This Fork
This fork is meant to be used on AceLords projects, and thus contain other functionalities not requred in the official package by Santigarcor.

### Installation
`composer require acelords/laratrust`

### Changelog
#### 6.3.1.1
- Added config `display_roles_permissions_being_checked` that appends the roles/permissions being checked and display in abort message

>NB: now read on the rest of the docs.


# Laratrust (Laravel Package)

[![tests](https://github.com/santigarcor/laratrust/workflows/tests/badge.svg)](https://github.com/santigarcor/laratrust/actions?query=workflow%3Atests)
[![Latest Stable Version](https://poser.pugx.org/acelords/laratrust/v)](//packagist.org/packages/acelords/laratrust)
[![Total Downloads](https://poser.pugx.org/acelords/laratrust/downloads)](//packagist.org/packages/acelords/laratrust)
[![License](https://poser.pugx.org/acelords/laratrust/license)](//packagist.org/packages/acelords/laratrust)

## Version Compatibility

 Laravel  | Laratrust
:---------|:----------
 9.x    | [7.x](https://laratrust.santigarcor.me/docs/7.x/)
 8.x    | [6.x](https://laratrust.santigarcor.me/docs/6.x/)
 7.x    | [6.x](https://laratrust.santigarcor.me/docs/6.x/)
 6.x    | [6.x](https://laratrust.santigarcor.me/docs/6.x/)
 5.6.x - 5.8.x    | [5.2](https://laratrust.santigarcor.me/docs/5.2/)
 5.3.x - 5.5.x    | [5.1](https://laratrust.santigarcor.me/docs/5.1/)
 5.0.x - 5.2.x    | [4.0](https://github.com/santigarcor/laratrust/tree/4.0).

## Installation, Configuration and Usage
To install, configure and learn how to use Laratrust please go to the [Documentation](https://laratrust.santigarcor.me/).

## What does Laratrust support?

- Multiple user models.
- Multiple roles and permissions can be attached to users.
- Multiple permissions can be attached to roles.
- Roles and permissions verification.
- Roles and permissions caching.
- Events when roles and permissions are attached, detached or synced.
- Multiple roles and permissions can be attached to users within teams.
- Objects ownership verification.
- Multiple guards for the middleware.
- A simple administration panel for roles and permissions.
- Laravel gates and policies.

## License

Laratrust is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Contributing

Please report any issue you find in the issues page. Pull requests are more than welcome.
