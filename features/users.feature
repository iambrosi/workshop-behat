Feature:
  Para poder gestionar usuarios
  como cualquier usuario web
  debo ser capaz de listar y agregar usuarios


  Scenario: Listar usuarios
    Given I am on "/"
    Then I should see "Listado de usuarios"

  Scenario: Crear usuarios
    Given I am on "/"
    When I follow "Crear Usuario"
    Then I should see "Nombre"
    And should see "Email"

