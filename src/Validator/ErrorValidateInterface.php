<?php

namespace yohanlaborda\behaviour\Validator;

use yohanlaborda\behaviour\Error\ErrorInterface;

interface ErrorValidateInterface
{
    public function getError(): ErrorInterface;
}
