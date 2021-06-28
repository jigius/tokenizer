<?php


namespace Tokenizer\Preprocessor\Vanilla;


use Iterator;
use Tokenizer\Preprocessor\TokenizableInterface;

class VanillaTknzr implements VanillaTkzrInterface
{

    /**
     * @inheritDoc
     */
    public function tokens(): Iterator
    {
        // TODO: Implement tokens() method.
    }

    /**
     * @inheritDoc
     */
    public function withInput(string $txt): TokenizableInterface
    {
        // TODO: Implement withInput() method.
    }

    /**
     * @inheritDoc
     */
    public function withSeparator(string $chr): VanillaTkzrInterface
    {
        // TODO: Implement withSeparator() method.
    }
}