<?php
declare(strict_types=1);

namespace Jigius\Tokenizer\Preprocessor\Vanilla;

use Jigius\Tokenizer\Preprocessor\TokenInterface;
use Jigius\Tokenizer\Preprocessor\TokenizableInterface;
use LogicException;

/**
 * Class VanillaTknzr
 * @package Jigius\Tokenizer\Preprocessor\Vanilla
 */
final class VanillaTknzr implements VanillaTkzrInterface
{
    /**
     * @var array
     */
    private array $i;
    /**
     * @var TokenInterface
     */
    private TokenInterface $regularTkn;
    /**
     * @var TokenInterface
     */
    private TokenInterface $separatorTkn;

    /**
     * VanillaTknzr constructor.
     * @param TokenInterface $regular
     * @param TokenInterface $separator
     */
    public function __construct(TokenInterface $regular, TokenInterface $separator)
    {
        $this->regularTkn = $regular;
        $this->separatorTkn = $separator;
        $this->i = [
            'input' => null,
            'sep' => []
        ];
    }

    /**
     * @inheritDoc
     */
    public function tokens(): array
    {
        if ($this->i['input'] === null) {
            throw new LogicException("input text is not defined");
        }
        $res = [];
        $s = 0;
        $l = mb_strlen($this->i['input']);
        $escaped = false;
        for ($i = 0; $i < $l; $i++) {
            $chr = mb_substr($this->i['input'], $i, 1);
            if ($chr === "\\" && !$escaped) {
                $escaped = true;
                continue;
            }
            if (!$escaped && in_array($chr, $this->i['sep'])) {
                if ($s < $i) {
                    $res[] =
                        $this
                            ->regularTkn
                            ->withInput($this->i['input'])
                            ->withStartedAt($s)
                            ->withFinishedAt($i - 1);
                }
                $res[] =
                    $this
                        ->separatorTkn
                        ->withInput($this->i['input'])
                        ->withStartedAt($i)
                        ->withFinishedAt($i);
                $s = $i + 1;
            }
            $escaped = false;
        }
        if ($s < $l) {
            $res[] =
                $this->regularTkn
                    ->withInput($this->i['input'])
                    ->withStartedAt($s)
                    ->withFinishedAt($l - 1);
        }
        return $res;
    }

    /**
     * @inheritDoc
     */
    public function withInput(string $txt): TokenizableInterface
    {
        $that = $this->blueprinted();
        $that->i['input'] = $txt;
        return $that;
    }

    /**
     * @inheritDoc
     */
    public function withSeparator(string $chr): VanillaTkzrInterface
    {
        $that = $this->blueprinted();
        $that->i['sep'][] = $chr;
        return $that;
    }

    /**
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = new self($this->regularTkn, $this->separatorTkn);
        $that->i = $this->i;
        return $that;
    }
}
