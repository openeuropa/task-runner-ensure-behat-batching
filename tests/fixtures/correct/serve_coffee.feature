Feature: Serve coffee
  In order to earn money
  Customers should be able to
  buy coffee at all times

  @batch1
  Scenario: Buy last coffee
    Given there are 1 coffees left in the machine
    And I have deposited 1 dollar
    When I press the coffee button
    Then I should be served a coffee

  @batch2000
  Scenario Outline: Coffee ordering
    Given there are <start> coffee
    When I order <cup> coffee
    Then I should have <left> coffee

    Examples:
      | start | cup | left |
      |    12 |   5 |    7 |
      |    20 |   5 |   15 |
