## Quick implementation of a social graph feature

### Prerequisites/Dev machine
Build on a Windows machine using:
- PHP 5.3.13
- MySQL 5.5.24
- Apache server 2.2.22 (mod_rewrite)

3rd party libraries (via Composer):
- Propel ORM 1.6.9 (with Craftyshadow's <strong>Equal Nest</strong> behaviour)
- Silex
- Twig

### Installation
- Clone this repo. This will create a project folder 'HwTest' with all the source code.
- Run <strong>composer install --prefer-dist</strong> to get the dependencies.
- Create a MySQL <em>hwtest_iplesca</em> database on any given server. 
- Update the <strong>config.inc.php</strong> with proper db credentials
  NOTE: I intended to have configurable database name but there was not enough time to sort Propel Generator.
- Execute www.example.com/path/to/<strong>HwTest/install_db.php</strong> to create the appropriate tables

### Usage
Just access the main URL, www.example.com/path/to/HwTest to see all the available users in the social graph.
Clicking any user will show a user info page with direct friends, friends of friends, suggested friends and suggested cities.

### Dev notes
I've used Silex as controller skeleton and micro-framework and Propel ORM.

Initially I've designed the db in phpMyAdmin, exported to file, fine tuned it, created the Propel XML schema, generated Propel's models.
Because Propel Generator (through Composer) on a Windows machine has some glitches (that I've fixed locally), I had to hardcode the db name to <em>hwtest_iplesca</em> so please keep it this way, if possible. Otherwise you have to change few files :P

There are 2 important page controllers, Main and Users. Both of them make use of Propel's User object.
All the magic happens in /src/models/build/classes/hwtest_iplesca/User.php

### Final note
I had fun building this and I tried making it proper, with documentation and installation. If anything doesn't work and you can't fix it, please give me a shout :D
Thanks!
