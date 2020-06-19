Zetetic Elench - Seeking Proof
---

[![Dependabot Status](https://api.dependabot.com/badges/status?host=github&repo=elvispt/zeteticelench)](https://dependabot.com) ![Laravel](https://github.com/elvispt/zeteticelench/workflows/Laravel/badge.svg?branch=develop)

## Stack:
- PHP 7.4.*
- Laravel 7.*
- MySQL 5.7
- Vue.js 2.x

## Features:

1. A dashboard with:
  - System Info
  - Current Weather
  - Next (National) Holidays
  - Inspirational quote
2. A simple note taking app
3. Hacker News application
  - Uses Firebase as backend to obtain all the hacker posts
  - Ability to bookmark posts
4. User management

## Installation

Requirements: Docker

1. Checkout the repo
2. Update .env values according to you environment
3. Enter the docker folder and edit the docker-composer.yml file:
  - Set the volume path for the mysql service/container.
  - Change the passwords for the mysql server.

Then run the following command inside the docker folder:
`docker-compose up`
