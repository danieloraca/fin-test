<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Money\Formatter;

use App\Project\ApiBundle\Money\MoneyAmount;

interface MoneyFormatterInterface
{
    public function format(MoneyAmount $money, array $options = []): string;
}
