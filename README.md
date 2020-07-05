# Panda - Password Manager

**Documentation is limited.**

## About

This is a very basic password manager - whilst all passwords are encrypted using the OpenSSL encryption library with secret keys, I am not an encryption expert and cannot guarantee this software is 100% safe. It is the end user's responsibility to frequently back up the database and secret key in a secure off-server location.

## Setup

Import the `database.sql` file to your database.

Duplicate the `.env.example` file as `.env` and fill in the fields required. Set a `SECRET_KEY` as a secret password encryption key. If you wish to use API access, set `API_PUBLIC_KEY`, and `API_RETRIEVE_KEY` respectively. Ensure the `BASE_URL` has no trailing slashes.

In the `globals.php` file set the `ROOT` definition with no trailing slashes. For most it would just be a blank string.

Run `npm run build` to build the SCSS files.

## The account

Accounts are created with an SECRET KEY individual to each account. This is used to encrypt any password that is retrieved through the API.

The SECRET KEY can be requested via the `api/get-api-secret.php` endpoint, however it is delivered encrypted with the PANDA SECRET KEY stored within the `.env` file. Any device that is used to decrypt the SECRET KEY into plain text must have this PANDA SECRET KEY.

## The passwords

Passwords are encrypted using a different SECRET KEY which is generic across Panda, however a unique IV and Tag is generated for each password - this data is stored in the database. 