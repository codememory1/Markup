<?php

namespace Codememory\Components\Markup\Exceptions;

use ErrorException;
use JetBrains\PhpStorm\Pure;

/**
 * Class IncorrectNestingIniException
 *
 * @package Codememory\Components\Markup\Exceptions
 *
 * @author  Codememory
 */
class IncorrectNestingIniException extends ErrorException
{

    /**
     * IncorrectNestingIniException constructor.
     */
    #[Pure]
    public function __construct()
    {

        parent::__construct('The ini config file cannot contain infinite nesting');

    }

}