<?php

namespace App\Entity\calendar;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\calendar\MonthRepository")
 */
class Month
{

    public $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    private $months = ['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October','November', 'December'];
    public $month;
    public $year;
    
    /**
     * Month constructor
     *
     * @param integer|null $month The month between 1 and 12
     * @param integer|null $year The year
     * @throws \Exception
     * 
     * @return Response
     */
    public function __construct(?int $month = null, ?int $year = null)
    {

        if($month === null)
        {

            $month = intval(date('m'));

        }

        if($year === null)
        {

            $year = intval(date('Y'));

        }
        
        if($month < 1 || $month > 12)
        {

            throw new \Exception("The month " . $month . " isn't valid");

        }

        if($year < 1970)
        {

            throw new \Exception("The year " . $year . " is less than 1970");

        }

        $this->month = $month;
        $this->year = $year;

    }

    /**
     * Get the month in letters
     *
     * @return string
     */
    public function toString(): string
    {

        return $this->months[$this->month - 1] . " " . $this->year;

    }

    /**
     * Get the month weeks number
     *
     * @return integer
     */
    public function getWeeks(): int
    {

        $start = $this->getStartingDate();
        $end = (clone $start)->modify('+1 month - 1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;

        // For December when the last day is in the first week of the next year
        if ($weeks < 0) 
        {

            $weeksNumber = $end->setISODate($this->year, 53);

            if($weeksNumber)
            {

                $weeksNumber = 53;

            }
            else
            {

                $weeksNumber = 52;

            }
            
            $weeks = $weeksNumber - intval($start->format('W')) + 1;

        }

        return $weeks;

    }

    /**
     * Get the first month day
     *
     * @return \DateTime
     */
    public function getStartingDate(): \DateTime
    {

        return new \DateTime($this->year . "-" . $this->month . "-01");

    }

    /**
     * Get if the given date is in the month
     *
     * @param \DateTime $date
     * 
     * @return boolean
     */
    public function getIfIsInMonth(\DateTime $date): bool
    {

        return $this->getStartingDate()->format('Y-m') === $date->format('Y-m');

    }

    /**
     * Get the next month
     *
     * @return Month
     */
    public function nextMonth(): Month
    {

        $month = $this->month + 1;
        $year = $this->year;

        if($month > 12)
        {

            $month = 1;
            $year += 1;

        }

        return new Month($month, $year);

    }

    /**
     * Get the previous month
     *
     * @return Month
     */
    public function previousMonth(): Month
    {

        $month = $this->month - 1;
        $year = $this->year;

        if($month < 1)
        {

            $month = 12;
            $year -= 1;

        }

        return new Month($month, $year);

    }

}
