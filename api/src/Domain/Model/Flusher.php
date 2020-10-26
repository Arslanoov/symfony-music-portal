<?php

declare(strict_types=1);

namespace Domain\Model;

interface Flusher
{
    public function flush(): void;
}
