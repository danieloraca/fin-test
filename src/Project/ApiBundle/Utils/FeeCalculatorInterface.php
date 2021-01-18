<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Utils;

use App\Project\ApiBundle\Model\LoanApplicationInterface;

interface FeeCalculatorInterface
{
    public function calculate(LoanApplicationInterface $loanApplication): float;
}
