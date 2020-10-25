<?php

namespace Domain\Model\User\Service;

use Domain\Model\User\ConfirmToken;
use Exception;

interface Tokenizer
{
    /**
     * @return ConfirmToken
     * @throws Exception
     */
    public function generate(): ConfirmToken;
}