<?php
declare(strict_types=1);

namespace Jigius\Tokenizer\Preprocessor\Vanilla;

use Acc\Core\PrinterInterface;
use LogicException;

/**
 * Class VanillaTkn
 * @package Jigius\Tokenizer\Preprocessor\Vanilla
 */
final class VanillaTkn implements VanillaTknInterface
{
    /**
     * @var array
     */
    private array $i;

    /**
     * VanillaTkn constructor.
     * @param bool $isSeparator
     */
    public function __construct(bool $isSeparator = false, string $escapeChr = "\\")
    {
        $this->i = [
            'input' => null,
            'startedAt' => null,
            'finishedAt' => null,
            'separator' => $isSeparator,
            'escChr' => $escapeChr
        ];
    }

    /**
     * @inheritDoc
     */
    public function printed(PrinterInterface $printer)
    {
        array_walk(
            $this->i,
            function ($val, string $key) use (&$printer): void {
                $printer = $printer->with($key, $val);
            }
        );
        return $printer->finished();
    }

    /**
     * @inheritDoc
     * @throws LogicException
     */
    public function token(): string
    {
        if (
            !isset($this->i['input']) ||
            !isset($this->i['startedAt']) ||
            !isset($this->i['finishedAt'])
        ) {
            throw new LogicException("all mandatory params are not defined");
        }
        return
            stripslashes(
                mb_substr(
                    $this->i['input'],
                    $this->i['startedAt'],
                    ($this->i['finishedAt'] - $this->i['startedAt']) + 1
                )
            );
    }

    /**
     * @inheritDoc
     */
    public function withInput(string &$txt): self
    {
        $that = $this->blueprinted();
        $that->i['input'] = &$txt;
        return $that;
    }

    /**
     * @inheritDoc
     */
    public function withStartedAt(int $pos): self
    {
        $that = $this->blueprinted();
        $that->i['startedAt'] = $pos;
        return $that;
    }

    /**
     * @inheritDoc
     */
    public function withFinishedAt(int $pos): self
    {
        $that = $this->blueprinted();
        $that->i['finishedAt'] = $pos;
        return $that;
    }

    /**
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = new self();
        $that->i = $this->i;
        return $that;
    }
}
