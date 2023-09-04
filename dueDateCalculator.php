<?php

class DueDateCalculator {
    
    public static function CalculateDueDate(DateTime $submitDateTime, int $turnaroundTimeInHours): DateTime {
        
        $startOfWorkDay = 9;  // 9 AM
        $endOfWorkDay = 17;   // 5 PM

        if ($submitDateTime->format('H') < $startOfWorkDay || $submitDateTime->format('H') >= $endOfWorkDay || $submitDateTime->format('N') >= 6) {
            throw new Exception("Invalid submit date/time.");
        }
        
        $remainingTime = $turnaroundTimeInHours;
        
        while ($remainingTime > 0) {
            // Calculate end of current working day
            $endOfWorkDayDateTime = clone $submitDateTime;
            $endOfWorkDayDateTime->setTime($endOfWorkDay, 0, 0);
            
            $timeLeftToday = ($endOfWorkDayDateTime->getTimestamp() - $submitDateTime->getTimestamp()) / 3600;
            
            // If remaining time can be completed today
            if ($timeLeftToday >= $remainingTime) {
                $timeToAdd = $remainingTime * 3600; // convert hours to seconds
                $submitDateTime->modify("+$timeToAdd seconds");
                return $submitDateTime;
            }
            
            // Move to next working day and reduce remaining time
            $remainingTime -= $timeLeftToday;
            $submitDateTime->modify('+1 day')->setTime($startOfWorkDay, 0, 0);
            
            // Skip to Monday if it's the weekend
            if ($submitDateTime->format('N') >= 6) {
                $submitDateTime->modify('next Monday')->setTime($startOfWorkDay, 0, 0);
            }
        }
        
        return $submitDateTime;
    }
}

// Testing
try {
    $submitDateTime = new DateTime("2023-09-08 16:12:59"); // Monday
    $turnaroundTimeInHours = 1;
    $dueDate = DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTimeInHours);
    echo "Due Date: " . $dueDate->format("Y-m-d H:i:s") . "\n"; // Should return Tuesday 09:12:59
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
