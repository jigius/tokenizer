<?php
declare(strict_types=1);

namespace Jigius\Tokenizer\Preprocessor;

use Acc\Core\MediaInterface;

/**
 * Interface TokenInterface
 * @package Jigius\Tokenizer\Preprocessor
 */
interface TokenInterface extends MediaInterface
{
    /**
     * @return string
     */
    public function token(): string;
}
