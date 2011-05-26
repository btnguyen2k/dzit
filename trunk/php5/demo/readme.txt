* Last update: $Id$

* Guideline:
- Checkout/Update from SVN
- Run the builddemo.php

* Demos:
(Feel free to use demos as starting point of your Dzit Framework application)

- helloworld: a *super simple* Dzit-based application
    + Only to demonstrate Dzit's request routing (request -> controller)
    + No database, template or multiple languages!

- pwdencrypt:
This application asks user to input a string and encrypt it
Demo:
    + dphp-mls as language engine (2 languages: ENglish and VietNamese)

- cookieviewer: a simple Dzit-based application.
This application allows users to view the current value of http cookie.
Demo:
    + dphp-template as template engine (only 1 template: php)

- sessionviewer: a simple Dzit-based application.
This application allows users to view the current value of http session.
Demo:
    + dphp-template as template engine (only 1 template: smarty)

- simpleblog: a *very* simple blog system
This demo uses:
    + MySql as storage engine.
    + dphp-dao as database access layer.
    + dphp-commons-logging as logging system.
This demo does not demonstrate:
    + Multi-languages support.
    + Multi-templates support.
