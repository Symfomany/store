Feature: suscribe
  Suscribe an user
  & Confirm & Login


  Scenario: I am a visitor
    Given I am on homepage
    When I fill in "#title" with "Pe"
    And I press .btn-primary
    Then I should see "Le nom de votre boutique doit être valide"

