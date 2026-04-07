<?php

declare(strict_types=1);

namespace BestIt\Sniffs;

/**
 * Provides testCorrect() for sniff test classes that have a correct/ fixture directory.
 *
 * @author Bjoern Lange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs
 */
trait SniffCorrectFilesTrait
{
    /**
     * Tests files which have to be without errors.
     *
     * @param string $file File to test
     *
     * @return void
     */
    abstract protected function assertFileCorrect(string $file): void;

    /**
     * Returns a list of correct fixture files as a data provider.
     *
     * @return array With the path to a file as the first parameter.
     */
    abstract public function getCorrectFileListAsDataProvider(): array;

    /**
     * Tests that correct files produce no errors or warnings.
     *
     * @return void
     */
    public function testCorrect(): void
    {
        $files = $this->getCorrectFileListAsDataProvider();

        if (!$files) {
            $this->markTestSkipped('No correct fixtures found.');
        }

        foreach ($files as [$file]) {
            $this->assertFileCorrect($file);
        }
    }
}
