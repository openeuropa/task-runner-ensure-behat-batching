Feature: Some terse yet descriptive text of what is desired
  In order to realize a named business value
  As an explicit system actor
  I want to gain some beneficial outcome which furthers the goal

  @batch1
  Scenario: Correct tag exists
    Given some precondition
    And some other precondition
    When some action by the actor
    And some other action
    And yet another action
    Then some testable outcome is achieved
    And something else we can check happens too

  Scenario: Tag is absent
    Given some precondition
    And some other precondition
    When some action by the actor
    And some other action
    And yet another action
    Then some testable outcome is achieved
    And something else we can check happens too

  @batch
  Scenario: Incomplete tag
    Given some precondition
    And some other precondition
    When some action by the actor
    And some other action
    And yet another action
    Then some testable outcome is achieved
    And something else we can check happens too

  @batchs1
  Scenario: Typo in the tag
    Given some precondition
    And some other precondition
    When some action by the actor
    And some other action
    And yet another action
    Then some testable outcome is achieved
    And something else we can check happens too

  @batch-1 @batch.1 @batch/1 @batch_1
  Scenario Outline: Special characters aren't allowed in the tag
    Given some <start>
    When <number> is taken
    Then some <left> is left

    Examples:
      | start | number | left |
      |    12 |   5    |    7 |
      |    20 |   5    |   15 |
