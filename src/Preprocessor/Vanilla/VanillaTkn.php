<?php
declare(strict_types=1);

namespace Tokenizer\Preprocessor\Vanilla;

use Acc\Core\PrinterInterface;
use LogicException;

/**
 * Class VanillaTkn
 * @package Tokenizer\Preprocessor\Vanilla
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
    public function __construct(bool $isSeparator = false)
    {
        $this->i = [
            'input' => null,
            'startedAt' => null,
            'finishedAt' => null,
            'separator' => $isSeparator
        ];
    }

    /**
     * @inheritDoc
     */
    public function printed(PrinterInterface $printer)
    {
        array_walk(
            $printer,
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
            !isset($this->input['input']) ||
            !isset($this->input['startedAt']) ||
            !isset($this->input['finishedAt'])
        ) {
            throw new LogicException("all mandatory params are not defined");
        }
        return mb_substr($this->i['input'], $this->i['startedAt'], $this->i['finishedAt']);
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
    public function withStartedAt(string $pos): self
    {
        $that = $this->blueprinted();
        $that->i['startedAt'] = $pos;
        return $that;
    }

    /**
     * @inheritDoc
     */
    public function withFinishedAt(string $pos): self
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
