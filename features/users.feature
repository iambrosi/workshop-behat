#noinspection CucumberUndefinedStep
Feature:
  Para poder gestionar usuarios
  como cualquier usuario web
  debo ser capaz de listar y agregar usuarios

  Background:
    Given there are no users in the database

  Scenario: Listar usuarios
    Given I am on "/"
    Then I should see "Listado de usuarios"

  Scenario: Crear usuarios
    Given I am on "/"
    When I follow "Crear Usuario"
    Then I should see "Nombre"
    And should see "Email"
    And should see "Submit"
    When I fill in "form[name]" with "John Doe"
    And fill in "form[email]" with "john@doe.com"
    And press "Submit"
    Then the response status code should be 200
    And I should see "Listado de usuarios"
    And I should see the users:
      | name     | email        |
      | John Doe | john@doe.com |
