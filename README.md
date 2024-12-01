# Symfony and Domain-Driven Design in practice

This repository contains the base code for the [Symfony and Domain-Driven Design in practice](https://ingewikkeld-trainingen.nl/trainingen/symfony-en-domain-driven-design-in-de-praktijk/)
training. 

## Requirements

Your computer should have Docker installed. An IDE or code editor such as PHPStorm or VSCode is recommended.

## Get your environment up and running

Start the code by opening a console, going to the directory where the code is, and entering:

`docker compose up -d`

This should build your whole environment. Once it's done building, you should be able to open [http://localhost](http://localhost/)
in your browser.

## Open a shell inside the container

Opening a shell in the container should be as easy as typing

`docker exec -ti symfony-ddd-php-1 sh`