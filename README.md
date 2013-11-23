workshop-behat
==============

Codigo de ejemplo para la demostración sobre Behat en el workshop PHP de [#techMeetup](http://tech.meetup.uy)


Instalación
-----------

Primero se debe obtener el código del repositorio:

```
git clone https://github.com/iambrosi/workshop-behat.git
```

Luego se deben instalar las dependencias con composer:

```
cd workshop-behat
composer.phar install
```

Inciar el servidor
------------------

Este ejemplo contiene un comando para iniciar un servidor web desde nuestra terminal. Para esto se debe ejecutar lo siguiente:

```
./console server:run
```

Ejecutar el test suite
----------------------

La idea de este workshop es dar una breve introducción a **BDD** y una muy buena herramienta para este modelo de testing es *Behat*. Para ejecutar todos los tests se debe ejecutar el comando proporcionado por Behat:

```
./vendor/bin/behat
```

A continuación un ejemplo de la salida en pantalla:

```
Feature:
  Para poder gestionar usuarios
  como cualquier usuario web
  debo ser capaz de listar y agregar usuarios

  Scenario: Listar usuarios                 # features/users.feature:7
    Given I am on "/"                       # FeatureContext::visit()
    Then I should see "Listado de usuarios" # FeatureContext::assertPageContainsText()

  Scenario: Crear usuarios                  # features/users.feature:11
    Given I am on "/"                       # FeatureContext::visit()
    When I follow "Crear Usuario"           # FeatureContext::clickLink()
    Then I should see "Nombre"              # FeatureContext::assertPageContainsText()
    And should see "Email"                  # FeatureContext::assertPageContainsText()

2 scenarios (2 passed)
6 steps (6 passed)
0m0.276s
```

Por más información sobre Behat dirigirse a http://behat.org/
