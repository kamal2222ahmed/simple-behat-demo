# Simple Behat Demonstration

## Purpose

The purpose of this project is to provide a very simple example of using BDD
with [Behat](http://behat.org/).

## Installation

1. Checkout this repository;
2. Install its dependency using `composer install --prefer-dist`
3. Run behat using `./vendor/bin/behat`

## Sample Run

```
Feature: Teams
    In order to manage teams
    As a staff member
    I need to be able to create teams

  Background:                       # features\create_team.feature:20
    Given user "admin" exists       # FeatureContext::userExists()
    Given user "admin" is a "admin" # FeatureContext::userIsA()
    Given user "test" exists        # FeatureContext::userExists()

  Scenario Outline: Team Creating                                                      # features\create_team.feature:25
    Given I am logged in as "admin"                                                    # FeatureContext::loggedInAs()
    When I register a user "<username>" with email "<email>" and password "<password>" # FeatureContext::iRegisterAUserWithEmailAndPassword()
    Then a user "<username>" with email "<email>" should exist                         # FeatureContext::aUserWithEmailShouldExist()

    Examples:
      | username   | email               | password    |
      | test_user  | test_user@test.com  | test_user   |
      | test_user2 | test_user2@test.com | test_user 2 |

2 scenarios (2 passed)
12 steps (12 passed)
0m0.10s (7.80Mb)
```

## License

```
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
 ```