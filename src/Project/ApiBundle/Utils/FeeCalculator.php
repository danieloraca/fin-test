<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Utils;

use App\Project\ApiBundle\Exception\ParameterRangeException;
use App\Project\ApiBundle\Model\LoanApplicationInterface;

class FeeCalculator implements FeeCalculatorInterface
{
    private const TERMS = [12, 24];
    private const MIN_LOAN = 1000;
    private const MAX_LOAN = 20000;
    private const FEE_STEP = 5;
    private const LOAN_STEP = 1000;
    private const FEES_GRID = [
        '12' => [
            1000 => 50,
            2000 => 90,
            3000 => 90,
            4000 => 115,
            5000 => 100,
            6000 => 120,
            7000 => 140,
            8000 => 160,
            9000 => 180,
            10000 => 200,
            11000 => 220,
            12000 => 240,
            13000 => 260,
            14000 => 280,
            15000 => 300,
            16000 => 320,
            17000 => 340,
            18000 => 360,
            19000 => 380,
            20000 => 400,
        ],
        '24' => [
            1000 => 70,
            2000 => 100,
            3000 => 120,
            4000 => 160,
            5000 => 200,
            6000 => 240,
            7000 => 280,
            8000 => 320,
            9000 => 360,
            10000 => 400,
            11000 => 440,
            12000 => 480,
            13000 => 520,
            14000 => 560,
            15000 => 600,
            16000 => 640,
            17000 => 680,
            18000 => 720,
            19000 => 760,
            20000 => 800,
        ],
    ];

    public function calculate(LoanApplicationInterface $loanApplication): float
    {
        $term = $loanApplication->getTerm();
        $amount = $loanApplication->getAmount();

        if (!in_array($term, self::TERMS)) {
            throw new ParameterRangeException('Term must be 12 or 24');
        }

        if ($amount < self::MIN_LOAN || $amount > self::MAX_LOAN) {
            throw new ParameterRangeException('Loan amount must be between £1000 and £20000.');
        }

        $grid = self::FEES_GRID;
        if ($amount % self::LOAN_STEP === 0) {
            return $grid[$term][$amount];
        }

        $lowAmountRange = floor($amount / self::LOAN_STEP) * self::LOAN_STEP;
        $highAmountRange = ceil($amount / self::LOAN_STEP) * self::LOAN_STEP;

        $differenceSteps = ($grid[$term][$highAmountRange] - $grid[$term][$lowAmountRange]) / self::FEE_STEP;

        $amountStep = $lowAmountRange;
        if ($grid[$term][$lowAmountRange] !== $grid[$term][$highAmountRange]) {
            $amountStep = ($highAmountRange - $lowAmountRange) / $differenceSteps;
        }

        $stepsToIncrease = 1;
        if ($lowAmountRange !== $highAmountRange) {
            $stepsToIncrease = floor(($amount - $lowAmountRange) / $amountStep);
        }

        return $grid[$term][$lowAmountRange] + $stepsToIncrease * self::FEE_STEP;
    }
}
