<?php
declare(strict_types=1);

namespace Jigius\Tokenizer\Preprocessor\Vanilla;

use Jigius\Tokenizer\Preprocessor\TokenizableInterface;

/**
 * Interface VanillaTkzrInterface
 * @package Jigius\Tokenizer\Preprocessor\Vanilla
 */
interface VanillaTkzrInterface extends TokenizableInterface
{
    /**
     * Injects a character that corresponds to the separators class characters
     * @param string $chr
     * @return VanillaTkzrInterface
     */
    public function withSeparator(string $chr): VanillaTkzrInterface;
}
