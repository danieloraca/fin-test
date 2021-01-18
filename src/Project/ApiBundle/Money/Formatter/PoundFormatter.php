<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Money\Formatter;

use App\Project\ApiBundle\Money\MoneyAmount;

class PoundFormatter implements MoneyFormatterInterface
{
    public function format(MoneyAmount $money, array $options = []): string
    {
        $amount = $money->getValue();

        if (isset($options['show_hundredths']) && $options['show_hundredths']) {
            $amount = number_format($amount, 2);
        }

        return sprintf('%s%s', $money->getCurrency(), $amount);
    }
}
