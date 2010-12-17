# LDAP driver for Kohana Auth

## Description

This is an LDAP driver for the Kohana Auth module. The only method implemented
is `login`, which attempts to bind the given username and password to LDAP.

## Installation

This module is dependent on Zend_LDAP. You can install Zend as a Kohana module
using `https://github.com/kolanos/kohana-zend`. After installing, create your
own `ldap.php` in `application/config`, and configure as needed. The Auth
`driver` parameter should be set to `ldap`.
