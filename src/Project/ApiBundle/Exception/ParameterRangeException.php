<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Exception;

class ParameterRangeException extends \Exception
{
    /** @var string */
    protected $message = '';
}
