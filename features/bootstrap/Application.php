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

class Application
{
    /**
     * The user logged in.
     *
     * @var string
     */
    private $loggedIn;

    /**
     * The user repository.
     *
     * @var array
     */
    private $userRepository = [];

    /**
     * The user roles.
     *
     * @var array
     */
    private $userRoles = [];
    
    /**
     * Adds the user.
     *
     * @param array $user
     *        - @b username
     *          The username.
     *        - @b email
     *          The email address.
     *        - @b password
     *          The password (this will be hashed).
     *        .
     * @return void
     */
    public function addUser($user = [])
    {
        $username = $user['username'];
        $email    = $user['email'];
        $password = hash('sha256', $user['password']);

        if ($this->userExists($username) === true) {
            return;
        }

        $this->userRepository[$username] = [
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ];

        return;
    }

    /**
     * Gets the user.
     *
     * @param string $username
     * @return array The user.
     * @throws \Exception if not found.
     */
    public function getUser($username = null)
    {
        if (! isset($username)) {
            throw new \IllegalArgumentException('Username is unset.');
        }

        if ($this->userExists($username) === true) {
            return $this->userRepository[$username];
        }

        throw new \Exception("User '$username' not found.");
    }

    /**
     * Determines if user exists.
     *
     * @param string $username
     * @return bool
     */
    public function userExists($username = null)
    {
        if (! isset($username)) {
            throw new \IllegalArgumentException('Username is unset.');
        }

        if (array_key_exists($username, $this->userRepository)) {
            return true;
        }

        return false;
    }

    /**
     * Gives the user the specified role.
     *
     * @param string $username
     * @param string $role
     * @return void
     */
    public function giveUserRole($username, $role)
    {
        if (! isset($username)) {
            throw new \IllegalArgumentException('Username is unset.');
        }

        if (! isset($role)) {
            throw new \IllegalArgumentException('Role is unset.');
        }

        $user = $this->getUser($username);

        if (! array_key_exists($username, $this->userRoles)) {
            $this->userRoles[$username] = [
                $role => true,
            ];
        }  else {
            $this->userRoles[$username][$role] = true;
        }

        return;
    }

    /**
     * Determines if the user has the role.
     *
     * @param string $username
     * @param string $role
     * @return bool
     * @throws \Exception if user not found.
     */
    public function userHasRole($username, $role)
    {
        if (! isset($username)) {
            throw new \IllegalArgumentException('Username is unset.');
        }

        if (! isset($role)) {
            throw new \IllegalArgumentException('Role is unset.');
        }

        $user = $this->getUser($username);

        if (! array_key_exists($username, $this->userRoles) ||
            ! isset($this->userRoles[$username][$role]) ||
            $this->userRoles[$username][$role] !== true) {
            return false;
        }

        return true;
    }

    /**
     * Logs in the specified user.
     *
     * @param string $username
     * @return void
     * @throws \Exception if the user not found.
     */
    public function login($username)
    {
        if (! isset($username)) {
            throw new \IllegalArgumentException('Username is unset.');
        }

        $user = $this->getUser($username);

        $this->loggedIn = $username;

        return;
    }

    /**
     * Determines if the logged in user can perform the passed in role.
     *
     * @param string $role
     * @return bool
     * @throws \Exception if not logged in (or the logged in user cannot be
     *         found).
     */
    public function can($role)
    {
        if (! isset($role)) {
            throw new \IllegalArgumentException('Role is unset.');
        }

        if (! isset($this->loggedIn)) {
            throw new \Exception('Not logged in.');
        }

        $user = $this->getUser($this->loggedIn);

        return $this->userHasRole($this->loggedIn, $role);
    }
}