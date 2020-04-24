Zetetic Elench - Seeking Proof
---

[![Dependabot Status](https://api.dependabot.com/badges/status?host=github&repo=elvispt/zeteticelench)](https://dependabot.com)

## Stack:
- PHP 7.2
- Laravel 6.*
- MySQL 5.7
- Vue.js 2.x

## Milestones:

1. A simple note taking app ✔️
2. Add authentication layer ✔️
3. Use Docker compose to prepare ✔️
4. Add hacker news best/top lists ✔️
5. User management ✔️
6. Add homepage with common personal common links
7. Styling
8. Add (Svelte || Vue || React) to transform to a SPA echo ✔️

## Installation

Requirements: Docker

1. Checkout the repo
2. Update .env values according to you environment
3. then enter the docker folder and edit the docker-composer.yml file:
  - Set the volume path for the mysql service/container.
  - Change the passwords for the mysql server.

Then run the following command inside the docker folder:
`docker-compose up`
