Feature: Teams
    In order to manage teams
    As a staff member
    I need to be able to create teams

Background:
    Given user "test" exists
    
Scenario Outline: Team Creating
    Given I am logged in as "admin"
    When I register a user "<username>" with email "<email>" and password "<password>"
    Then a user "<username>" with email "<email>" should exist

    Examples:
        | username | email | password |
        | test_user | test_user@test.com | test_user |
        | test_user2 | test_user2@test.com | test_user 2|