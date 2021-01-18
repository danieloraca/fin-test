<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Money;

class MoneyAmount
{
    /** @var float */
    private $value;

    /** @var string */
    private $currency;

    public function __construct(float $value, string $currency)
    {
        $this->value = (float)$value;
        $this->currency = $currency;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getValueAsString(): string
    {
        return (string)$this->value;
    }
}
