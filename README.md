# dueDateCalculator
## Requirements
- PHP 7.4 or higher
- PHPUnit 9.x for running tests (optional)

## Installation
1. Clone this repository:


    git clone https://github.com/QbHead/dueDateCalculator.git


2. If you want to run tests, you'll need to install PHPUnit. Navigate to the project directory and run:


    composer require --dev phpunit/phpunit ^9


## Usage
Include 'dueDateCalculator.php' in your project and use the DueDateCalculator::CalculateDueDate method.

Here's a simple example:


    require 'dueDateCalculator.php';
    try {
        $submitDateTime = new DateTime("2023-09-04 16:12:59");
        $turnaroundTimeInHours = 1;
        $dueDate = DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTimeInHours);
        echo "Due Date: " . $dueDate->format("Y-m-d H:i:s");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

## Running Tests
To run tests, navigate to the project directory and execute:


    ./vendor/bin/phpunit DueDateCalculatorTest.php
## Rules

- Working hours are from 9AM to 5PM on every working day (Monday to Friday).
- Holidays are ignored.
- The turnaround time is defined in working hours.
- Problems can only be reported during working hours.