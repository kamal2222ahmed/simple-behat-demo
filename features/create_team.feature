# Copyright 2017 David S. Lloyd
#
#   Licensed under the Apache License, Version 2.0 (the "License");
#   you may not use this file except in compliance with the License.
#   You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
#   Unless required by applicable law or agreed to in writing, software
#   distributed under the License is distributed on an "AS IS" BASIS,
#   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#   See the License for the specific language governing permissions and
#   limitations under the License.

Feature: Teams
    In order to manage teams
    As a staff member
    I need to be able to create teams

Background:
    Given user "admin" exists
    Given user "admin" is a "admin"
    Given user "test" exists
    
Scenario Outline: Team Creating
    Given I am logged in as "admin"
    When I register a user "<username>" with email "<email>" and password "<password>"
    Then a user "<username>" with email "<email>" should exist

    Examples:
        | username | email | password |
        | test_user | test_user@test.com | test_user |
        | test_user2 | test_user2@test.com | test_user 2|

