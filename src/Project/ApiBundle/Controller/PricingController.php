<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Controller;

use App\Project\ApiBundle\Exception\InvalidParametersException;
use App\Project\ApiBundle\Exception\ParameterRangeException;
use App\Project\ApiBundle\Model\LoanApplication;
use App\Project\ApiBundle\Money\Formatter\MoneyFormatterInterface;
use App\Project\ApiBundle\Money\MoneyAmount;
use App\Project\ApiBundle\Utils\FeeCalculatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PricingController extends AbstractController
{
    private const CURRENCY = '£';

    /** @var FeeCalculatorInterface */
    private $feeCalculator;

    /** @var MoneyFormatterInterface */
    private $moneyFormatter;

    public function __construct(
        FeeCalculatorInterface $feeCalculator,
        MoneyFormatterInterface $moneyFormatter
    ) {
        $this->feeCalculator = $feeCalculator;
        $this->moneyFormatter = $moneyFormatter;
    }

    public function getPricing(Request $request): JsonResponse
    {
        try{
            $this->validateParameters($request);
        } catch (InvalidParametersException $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $term = (int) $request->get('term');
        $amount = (float) $request->get('amount');

        $loanApplication = new LoanApplication($term, $amount);

        try {
            $fee = $this->feeCalculator->calculate($loanApplication);
        } catch (ParameterRangeException $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse([
            'term' => $term,
            'amount' => $this->moneyFormatter->format(
                new MoneyAmount($amount, self::CURRENCY),
                [
                    'show_hundredths' => true,
                ]
            ),
            'fee' => $this->moneyFormatter->format(
                new MoneyAmount($fee, self::CURRENCY),
                [
                    'show_hundredths' => true,
                ]
            ),
        ], JsonResponse::HTTP_OK);
    }

    private function validateParameters(Request $request): void
    {
        $term = (int) $request->get('term');
        $amount = (float) $request->get('amount');

        if ((string) $term !== $request->get('term') || (string) $amount !== $request->get('amount')) {
            throw new InvalidParametersException();
        }
    }
}
