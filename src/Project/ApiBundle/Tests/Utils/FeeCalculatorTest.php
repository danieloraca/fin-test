<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Tests\Utils;

use App\Project\ApiBundle\Exception\ParameterRangeException;
use App\Project\ApiBundle\Model\LoanApplication;
use App\Project\ApiBundle\Utils\FeeCalculator;
use PHPUnit\Framework\TestCase;

class FeeCalculatorTest extends TestCase
{
    /** @var FeeCalculator */
    private $feeCalculator;

    /** @var LoanApplication */
    private $loanApplication;

    protected function doSetUp(): void
    {
        $this->loanApplication = $this->createMock(LoanApplication::class);

        $this->feeCalculator = new FeeCalculator($this->loanApplication);
    }

    public function testWhenAmountNotInRange(): void
    {
        $term = 12;
        $amount = 100;
        $loanApplication = new LoanApplication($term, $amount);

        $this->feeCalculator = new FeeCalculator($loanApplication);

        $this->expectException(ParameterRangeException::class);

        $this->feeCalculator->calculate($loanApplication);
    }

    public function testWhenTermAndAmountValid(): void
    {
        $options = [
            [
                'term' => 12,
                'amount' => 1000,
                'expected' => 50
            ],
            [
                'term' => 12,
                'amount' => 1200,
                'expected' => 55
            ],
            [
                'term' => 12,
                'amount' => 3200,
                'expected' => 95
            ],
            [
                'term' => 12,
                'amount' => 4400,
                'expected' => 105
            ],
            [
                'term' => 12,
                'amount' => 5200,
                'expected' => 100
            ],
            [
                'term' => 24,
                'amount' => 1167,
                'expected' => 75
            ],
            [
                'term' => 24,
                'amount' => 1166.67,
                'expected' => 75
            ],
            [
                'term' => 24,
                'amount' => 1166.65,
                'expected' => 70
            ],
        ];

        foreach ($options as $option) {
            $loanApplication = new LoanApplication($option['term'], $option['amount']);
            $this->feeCalculator = new FeeCalculator($loanApplication);
            $response = $this->feeCalculator->calculate($loanApplication);
            $this->assertEquals($option['expected'], $response);
        }
    }
}
