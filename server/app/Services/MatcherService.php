<?php

namespace App\Services;

use App\Exceptions\InvalidCountException;
use App\Interfaces\IMatcherService;
use App\Helpers\MatcherHelper;
use App\Helpers\ArrayHelper;

class MatcherService implements IMatcherService
{
    public function getBestMatches(array $employees) : array {
        $this->validateList($employees);

        $employee_pair_list = $this->pair($employees);

        $score_list = $this->composeScoreList($employee_pair_list);

        return $this->getTopMatches($score_list);
    }

    protected function validateList($employees) : void {
        if (count($employees) <=1 ) {
            throw new InvalidCountException();
        }
    }

    public function pair(array $employees) : array {
        $collected_pair_list = [];

        if (count($employees) == 2) {
            array_push($collected_pair_list, [[$employees[0], $employees[1]]]);

        } else if (count($employees) == 3) {
            array_push($collected_pair_list, [$employees[0], $employees[1]]);
            array_push($collected_pair_list, [$employees[0], $employees[2]]);
            array_push($collected_pair_list, [$employees[1], $employees[2]]);

        } else {
            for ($i = 0; $i < count($employees) - 1; $i++) {
                $employee_mutable_list = $employees;

                $employee1 = $this->unsetEmployee($employee_mutable_list, 0);
                $employee2 = $this->unsetEmployee($employee_mutable_list, $i);

                $possible_pair_list = $this->pair($employee_mutable_list);

                for ($j = 0; $j < count($possible_pair_list); $j++) {
                    array_push($possible_pair_list[$j], [$employee1, $employee2]);
                    array_push($collected_pair_list, $possible_pair_list[$j]);
                }
            }
        }

        return $collected_pair_list;
    }

    protected function unsetEmployee(array &$employee_mutable_list, $index) : array {
        $employee = $employee_mutable_list[$index];
        unset($employee_mutable_list[$index]);
        $employee_mutable_list = array_values($employee_mutable_list);

        return $employee;
    }

    protected function composeScoreList(array $employee_pair_list) : array {
        $matcher_helper = new MatcherHelper();

        return array_reduce($employee_pair_list, function($accumulator, $employee_pairs) use ($matcher_helper) {
            $total_score = 0;
            $scores = [];

            foreach($employee_pairs as $employees) {
                $score = $matcher_helper->employeeMatcher($employees[0], $employees[1]);
                $total_score += $score;

                array_push($scores, [
                    'employee1' => $employees[0]['Name'] ?? '',
                    'employee2' => $employees[1]['Name'] ?? '',
                    'score' => $score,
                ]);
            }

            $scores_average = array_merge($scores, ['average' => round($total_score / count($employee_pairs))]);
            $accumulator === [] ? $accumulator[] = $scores_average : array_push($accumulator, $scores_average);

            return $accumulator;
        } , []);
    }

    protected function getTopMatches($score_list) : array {
        $score_list = ArrayHelper::sortByKey($score_list, 'average');

        $top_scores[] = $score_list[0];
        for($i = 1; $i < count($score_list); ++$i) {
            if($top_scores[0]['average'] === $score_list[$i]['average']) {
                array_push($top_scores, $score_list[$i]);
                continue;
            }

            break;
        }

        return $top_scores;
    }
}
