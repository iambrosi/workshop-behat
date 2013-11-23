<?php

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @var Doctrine\DBAL\Connection
     */
    private $connection;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $config           = new \Doctrine\DBAL\Configuration();
        $connectionParams = array(
            'dbname'   => 'test',
            'user'     => 'root',
            'password' => '',
            'host'     => 'localhost',
            'driver'   => 'pdo_mysql',
        );
        $this->connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    }

    /**
     * @Given /^there are no users in the database$/
     */
    public function thereAreNoUsersInTheDatabase()
    {
        $this->connection->exec('DELETE FROM users');
    }

    /**
     * @Given /^I should see the users:$/
     */
    public function iShouldSeeTheUsers(TableNode $table)
    {
        $hash = $table->getHash();
        foreach ($hash as $row) {
            $this->assertElementContains('.table', $row['name']);
            $this->assertElementContains('.table', $row['email']);
        }
    }

    /**
     * @Then /^I should see the user form$/
     */
    public function iShouldSeeTheUserForm()
    {
        return array(
            new \Behat\Behat\Context\Step\Then('I should see "Nombre"'),
            new \Behat\Behat\Context\Step\Then('I should see "Email"'),
            new \Behat\Behat\Context\Step\Then('I should see "Submit"'),
        );
    }
}
