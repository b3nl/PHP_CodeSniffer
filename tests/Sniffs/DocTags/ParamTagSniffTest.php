<?php

declare(strict_types=1);

namespace BestIt\Sniffs\DocTags;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\SniffWarningFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use function array_merge;

use const T_DOC_COMMENT_TAG;

/**
 * Class ParamTagSniffTest
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\DocTags
 */
class ParamTagSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffErrorFilesTrait;
    use SniffWarningFilesTrait;
    use TestRequiredConstantsTrait;
    use TestTokenRegistrationTrait;

    /**
     * Returns the tokens which should be checked.
     *
     * @return array Returns the expected token ids.
     */
    protected function getExpectedTokens(): array
    {
        return [T_DOC_COMMENT_TAG];
    }

    /**
     * Returns the names of the required constants.
     *
     * @return array The required constants of a class. The second value is a possible value which should be checked.
     */
    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_TAG_MISSING_DESC' => ['CODE_TAG_MISSING_DESC', 'MissingDesc'],
            'CODE_TAG_MISSING_VARIABLES' => ['CODE_TAG_MISSING_VARIABLES', 'MissingVariables'],
            'CODE_TAG_MISSING_VARIABLE' => ['CODE_TAG_MISSING_VARIABLE', 'MissingVariable'],
            'CODE_TAG_MISSING_TYPE' => ['CODE_TAG_MISSING_TYPE', 'MissingType'],
            'CODE_TAG_MIXED_TYPE' => ['CODE_TAG_MIXED_TYPE', 'MixedType'],
        ];
    }

    /**
     * Sets up the test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->testedObject = new ParamTagSniff();

        $this->testedObject->descAsWarning = true;
    }

    /**
     * Tests description warnings after config.
     *
     * @return void
     */
    public function testDescriptionWarningsWithConfig(): void
    {
        $files = $this->getCorrectFileListAsDataProvider();

        if (!$files) {
            static::markTestSkipped('No correct fixtures found.');
        }

        foreach ($files as [$file]) {
            $unusedData = [];
            $fileMetadata = $this->getMetadataFromFilenameAsAssertArray($file, $unusedData);

            if (!$fileMetadata) {
                continue;
            }

            $callData = array_merge($fileMetadata, [['descAsWarning' => true]]);

            $this->assertWarningsInFile(...$callData);
        }
    }

    /**
     * Checks the basic type of the sniff.
     *
     * @return void
     */
    public function testType(): void
    {
        static::assertInstanceOf(AbstractTagSniff::class, $this->testedObject);
    }
}
