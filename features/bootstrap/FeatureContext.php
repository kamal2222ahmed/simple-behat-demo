<?php

/**
 *  Copyright 2017 David S. Lloyd
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $application;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->application = new Application();

        // Add the admin user.
        $this->application->addUser([
            'username' => 'test',
            'email'    => 'test@localhost.com',
            'password' => 'password123',
        ]);

        $this->application->addUser([
            'username' => 'admin',
            'email'    => 'admin@localhost.com',
            'password' => 'password123',
        ]);

        $this->application->giveUserRole('admin', 'admin');

        $this->application->login('admin');
    }

    /**
     * @Given user :user exists
     */
    public function userExists($user)
    {
       $this->application->getUser($user);
    }

    /**
     * @Given I am logged in as :role
     */
    public function loggedInAs($role)
    {
        if ($this->application->can($role) !== true) {
            throw new \Exception("Not logged in as a '$role'");
        }
    }

    /**
     * @When I register a user :username with email :email and password :password
     */
    public function iRegisterAUserWithEmailAndPassword(
            $username,
            $email,
            $password)
    {
        $this->application->addUser([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ]);
    }

    /**
     * @Then a user :username with email :email should exist
     */
    public function aUserWithEmailShouldExist($username, $email)
    {
        $user = $this->application->getUser($username);

        if ($user['email'] !== $email) {
            throw new \Exception("Email '$email' retrieved for user ".
                "'$username' was not same, got '" . $user['email'] ."'.");
        }
    }

    /**
     * @Given user :username is a :role
     */
    public function userIsA($username, $role)
    {
        if ($this->application->userHasRole($username, $role) !== true) {
            throw new \Exception("User '$username' does not have role ".
                "'$role'.");
        }
    }
}
