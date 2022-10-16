<?php

namespace App\Helpers;

class MatcherHelper
{
    public function employeeMatcher(array $employee1, array $employee2) : int{
        $matchers = $this->getMatchCases();

        $score = 0;
        foreach($employee1 as $key => $value) {
            $matcher = "match$key";

            if (in_array($matcher, $matchers)) {
                $score += $this->{$matcher}($value, $employee2[$key]);
            }
        }

        return $score;
    }

    private function getMatchCases()
    {
        // get validation methods of class
        return preg_grep('~^match~', get_class_methods($this));
    }

    protected function matchDivision(string $division1, string $division2) : int {
        // dump('matchDivision');
        return $division1 === $division2 ? 30 : 0;
    }

    protected function matchAge(int $age1, int $age2) : int {
        // dump('matchAge');
        return abs($age1 - $age2) <= 5 ? 30 : 0;
    }

    protected function matchTimezone(int $timezone1, int $timezone2) : int {
        // dump('matchzone');
        return $timezone1 === $timezone2 ? 40 : 0;
    }
}
