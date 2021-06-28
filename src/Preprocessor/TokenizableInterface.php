<?php
declare(strict_types=1);

namespace Jigius\Tokenizer\Preprocessor;

/**
 * Translates an injected text string into tokens
 *
 * Interface Jigius\TokenizableInterface
 * @package Jigius\Tokenizer\Preprocessor
 */
interface TokenizableInterface
{
    /**
     * Returns tokens
     * @return array
     */
    public function tokens(): array;

    /**
     * Injects a text string into the instance
     * @param string $txt
     * @return TokenizableInterface
     */
    public function withInput(string $txt): TokenizableInterface;
}
