<?php

declare(strict_types=1);

namespace BestIt\CodeSniffer\Helper;

use PHPUnit\Framework\TestCase;

use const T_CLASS;

/**
 * Tests DocTagHelper
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\CodeSniffer\Helper
 */
class DocTagHelperTest extends TestCase
{
    use FileHelperTrait;

    /**
     * The tested object.
     *
     * @var DocTagHelper|null
     */
    private ?DocTagHelper $testedObject = null;

    /**
     * Sets up the test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $file = $this->getFile(__DIR__ . DIRECTORY_SEPARATOR . 'Fixtures/DocTagHelper/ORMJoinsOnMethod.php');

        $this->testedObject = new DocTagHelper($file, 16);
    }

    /**
     * Checks if the comment tags are rendered correctly.
     *
     * @return void
     */
    public function testGetCommentTagTokens(): void
    {
        $expectedArray = [
            29 => [
                'content' => '@ORM\\JoinTable(name="bestit_genius_offering_related_article",',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 9,
                'column' => 8,
                'length' => 61,
                'level' => 1,
                'conditions' => [9 => T_CLASS,],
                'contents' => [
                    35 => [
                        'content' => 'joinColumns={',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 10,
                        'column' => 13,
                        'length' => 13,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    40 => [
                        'content' => '@ORM\\JoinColumn(',
                        'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                        'type' => 'T_DOC_COMMENT_TAG',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 11,
                        'column' => 17,
                        'length' => 16,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    45 => [
                        'content' => 'name="offering",',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 12,
                        'column' => 21,
                        'length' => 16,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    50 => [
                        'content' => 'referencedColumnName="id"',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 13,
                        'column' => 21,
                        'length' => 25,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    55 => [
                        'content' => ')',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 14,
                        'column' => 17,
                        'length' => 1,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    60 => [
                        'content' => '},',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 15,
                        'column' => 13,
                        'length' => 2,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    65 => [
                        'content' => 'inverseJoinColumns={',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 16,
                        'column' => 13,
                        'length' => 20,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    70 => [
                        'content' => '@ORM\\JoinColumn(',
                        'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                        'type' => 'T_DOC_COMMENT_TAG',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 17,
                        'column' => 17,
                        'length' => 16,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    75 => [
                        'content' => 'name="article",',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 18,
                        'column' => 21,
                        'length' => 15,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    80 => [
                        'content' => 'referencedColumnName="id"',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 19,
                        'column' => 21,
                        'length' => 25,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    85 => [
                        'content' => ')',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 20,
                        'column' => 17,
                        'length' => 1,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    90 => [
                        'content' => '}',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 21,
                        'column' => 13,
                        'length' => 1,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    95 => [
                        'content' => ')',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 22,
                        'column' => 8,
                        'length' => 1,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                ],
            ],
            99 => [
                'content' => '@ORM\\ManyToMany(targetEntity="Shopware\\Models\\Article\\Detail")',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 23,
                'column' => 8,
                'length' => 62,
                'level' => 1,
                'conditions' => [9 => T_CLASS],
                'contents' => [],
            ],
            104 => [
                'content' => '@throws',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 24,
                'column' => 8,
                'length' => 7,
                'level' => 1,
                'conditions' => [9 => T_CLASS],
                'contents' => [
                    107 => [
                        'content' => 'RuntimeException',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 24,
                        'column' => 16,
                        'length' => 16,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                ],
            ],
            111 => [
                'content' => '@var',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 25,
                'column' => 8,
                'length' => 4,
                'level' => 1,
                'conditions' => [9 => T_CLASS],
                'contents' => [
                    114 => [
                        'content' => 'Collection Now that we know who you are, I know who I am. I\'m not a mistake! ' .
                            'It all makes sense! In a comic,',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 25,
                        'column' => 13,
                        'length' => 108,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    119 => [
                        'content' => 'you know how you can tell who the arch-villain\'s going to be? He\'s the exact ' .
                            'opposite of the hero. And most',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 26,
                        'column' => 13,
                        'length' => 107,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    124 => [
                        'content' => 'times they\'re friends, like you and me! I should\'ve known way back when... ' .
                            'You know why, David? Because of',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 27,
                        'column' => 13,
                        'length' => 106,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                    129 => [
                        'content' => 'the kids. They called me Mr Glass.',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 28,
                        'column' => 13,
                        'length' => 34,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                ],
            ],
            136 => [
                'content' => '@param',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 30,
                'column' => 8,
                'length' => 6,
                'level' => 1,
                'conditions' => [9 => T_CLASS],
                'contents' => [
                    139 => [
                        'content' => 'string $param1',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 30,
                        'column' => 15,
                        'length' => 14,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                ],
            ],
            143 => [
                'content' => '@param',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 31,
                'column' => 8,
                'length' => 6,
                'level' => 1,
                'conditions' => [9 => T_CLASS],
                'contents' => [
                    146 => [
                        'content' => 'string $param2',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 31,
                        'column' => 15,
                        'length' => 14,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                ],
            ],
            153 => [
                'content' => '@todo',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 33,
                'column' => 8,
                'length' => 5,
                'level' => 1,
                'conditions' => [9 => T_CLASS],
                'contents' => [
                    156 => [
                        'content' => 'Test1',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 33,
                        'column' => 14,
                        'length' => 5,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                ],
            ],
            160 => [
                'content' => '@todo',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 34,
                'column' => 8,
                'length' => 5,
                'level' => 1,
                'conditions' => [9 => T_CLASS],
                'contents' => [
                    163 => [
                        'content' => 'Test2',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 34,
                        'column' => 14,
                        'length' => 5,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                ],
            ],
            167 => [
                'content' => '@todo',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 35,
                'column' => 8,
                'length' => 5,
                'level' => 1,
                'conditions' => [9 => T_CLASS],
                'contents' => [
                    170 => [
                        'content' => 'Test3',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 35,
                        'column' => 14,
                        'length' => 5,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                ],
            ],
            177 => [
                'content' => '@return',
                'code' => 'PHPCS_T_DOC_COMMENT_TAG',
                'type' => 'T_DOC_COMMENT_TAG',
                'comment_opener' => 16,
                'comment_closer' => 182,
                'line' => 37,
                'column' => 8,
                'length' => 7,
                'level' => 1,
                'conditions' => [9 => T_CLASS],
                'contents' => [
                    180 => [
                        'content' => 'void',
                        'code' => 'PHPCS_T_DOC_COMMENT_STRING',
                        'type' => 'T_DOC_COMMENT_STRING',
                        'comment_opener' => 16,
                        'comment_closer' => 182,
                        'line' => 37,
                        'column' => 16,
                        'length' => 4,
                        'level' => 1,
                        'conditions' => [9 => T_CLASS],
                    ],
                ],
            ],
        ];

        static::assertSame($expectedArray, $this->testedObject->getTagTokens());
    }
}
