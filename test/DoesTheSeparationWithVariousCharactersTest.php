<?php
declare(strict_types=1);

namespace Jigius\Tokenizer\Test;

use Jigius\Tokenizer\Preprocessor\Vanilla\VanillaTkn;
use Jigius\Tokenizer\Preprocessor\Vanilla\VanillaTknInterface;
use Jigius\Tokenizer\Preprocessor\Vanilla\VanillaTknzr;
use Jigius\Tokenizer\Preprocessor\Vanilla\VanillaTkzrInterface;
use PHPUnit\Framework\TestCase;

final class DoesTheSeparationWithVariousCharactersTest extends TestCase
{
    public function sampleData(): array
    {
        return [
            [
                "foo bar/b\"az\",q(a)z",
                [
                    " ", "/", ",", "(", ")", "\""
                ],
                [
                    "foo", " ", "bar", "/", "b", "\"", "az", "\"", ",", "q", "(", "a", ")", "z"
                ],
                "various characters are used as a separator #1"
            ],
            [
                "foo bar/b\"az\",q(a)z",
                [
                    " ", "/", ","
                ],
                [
                    "foo", " ", "bar", "/", "b\"az\"", ",", "q(a)z"
                ],
                "various characters are used as a separator #2"
            ],
            [
                "foo\\ bar/b\\\"az\"",
                [
                    " ", "/", "\""
                ],
                [
                    "foo bar", "/", "b\"az", "\""
                ],
                "escapes some characters are used as a separator"
            ]
        ];
    }

    /**
     * @dataProvider sampleData
     */
    public function testCreationWithVariousParams(string $input, array $separators, array $tokens, string $message): void
    {
        $tknzr =
            array_reduce(
                $separators,
                function (VanillaTkzrInterface $carry, string $sep): VanillaTkzrInterface {
                    return $carry->withSeparator($sep);
                },
                new VanillaTknzr(new VanillaTkn(), new VanillaTkn())
            );
        $this->assertTrue(
            array_map(
                function (VanillaTknInterface $t): string {
                    return $t->token();
                },
                $tknzr->withInput($input)->tokens()
            ) === $tokens,
            $message
        );
    }
}
