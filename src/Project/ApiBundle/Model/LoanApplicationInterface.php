<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Model;

interface LoanApplicationInterface
{
    public function getTerm(): int;

    public function getAmount(): float;
}
