<?php
declare(strict_types=1);

namespace Jigius\Tokenizer\Preprocessor\Vanilla;

use Jigius\Tokenizer\Preprocessor\TokenInterface;

/**
 * Interface VanillaTknInterface
 * @package Jigius\Tokenizer\Preprocessor\Vanilla
 */
interface VanillaTknInterface extends  TokenInterface
{
    /**
     * @param string $txt
     * @return VanillaTknInterface
     */
    public function withInput(string &$txt): VanillaTknInterface;

    /**
     * @param int $pos
     * @return VanillaTknInterface
     */
    public function withStartedAt(int $pos): VanillaTknInterface;

    /**
     * @param int $pos
     * @return VanillaTknInterface
     */
    public function withFinishedAt(int $pos): VanillaTknInterface;
}
