<?php
// DueDateCalculatorTest.php
use PHPUnit\Framework\TestCase;

require 'dueDateCalculator.php'; // Adjust the path as needed

//This is my first time trying to create a unit test
final class DueDateCalculatorTest extends TestCase
{
    public function testCalculateDueDate(): void
    {
        $submitDateTime = new DateTime("2023-09-04 16:12:59"); // Monday
        $turnaroundTimeInHours = 1;
        $dueDate = DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTimeInHours);
        $this->assertEquals('2023-09-05 09:12:59', $dueDate->format('Y-m-d H:i:s'));
    }

    public function testCalculateDueDateWithWeekend(): void
    {
        $submitDateTime = new DateTime("2023-09-01 16:12:59"); // Friday
        $turnaroundTimeInHours = 3;
        $dueDate = DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTimeInHours);
        $this->assertEquals('2023-09-04 11:12:59', $dueDate->format('Y-m-d H:i:s'));
    }

    public function testInvalidSubmitTime(): void
    {
        $this->expectException(Exception::class);

        $submitDateTime = new DateTime("2023-09-04 18:12:59"); // Time out of work hours
        $turnaroundTimeInHours = 1;
        DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTimeInHours);
    }

    public function testInvalidSubmitDay(): void
    {
        $this->expectException(Exception::class);

        $submitDateTime = new DateTime("2023-09-03 10:12:59"); // Sunday
        $turnaroundTimeInHours = 1;
        DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTimeInHours);
    }
}
