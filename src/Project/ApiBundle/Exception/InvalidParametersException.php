<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Exception;

class InvalidParametersException extends \Exception
{
    /** @var string */
    protected $message = 'API Parameters not acceptable.';
}
