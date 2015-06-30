Feature: suscribe
  Suscribe an user
  & Confirm & Login


  Scenario: I am a visitor
    Given I am on "/"
    When I fill in "title" with "Behavior Driven Development"
    And I fill in "description" with "Blablabla"
    And I fill in "username" with "djscrave"
    And I fill in "email" with "toto@gmil.com"
    And I fill in "password_mdp" with "toto123456"
    And I fill in "password_mdp_conf" with "toto123456"
    And I press "#btnsend"