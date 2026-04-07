<?php

declare(strict_types=1);

namespace BestIt\Sniffs;

use PHP_CodeSniffer\Files\File;

/**
 * Provides testErrors() for sniff test classes that have a with_errors/ fixture directory.
 *
 * @author Bjoern Lange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs
 */
trait SniffErrorFilesTrait
{
    /**
     * Asserts all errors in a given file.
     *
     * @param string $file Filename of the fixture
     * @param string $error Error code
     * @param int[] $lines Array of lines where the error code occurs
     * @param array $sniffProperties Array of sniff properties
     *
     * @return File The php cs file
     */
    abstract protected function assertErrorsInFile(
        string $file,
        string $error,
        array $lines,
        array $sniffProperties = [],
    ): File;

    /**
     * Returns data for errors.
     *
     * @return array List of error data (Filepath, error code, error lines, fixable)
     */
    public function getErrorAsserts(): array
    {
        return $this->loadAssertData();
    }

    /**
     * Loads the assertion data out of the file names.
     *
     * @param bool $forErrors Load data for errors?
     *
     * @return array The assert data as data providers.
     */
    abstract protected function loadAssertData(bool $forErrors = true): array;

    /**
     * Tests errors.
     *
     * @return void
     */
    public function testErrors(): void
    {
        $asserts = $this->getErrorAsserts();

        if (!$asserts) {
            $this->markTestSkipped('No error fixtures found.');
        }

        foreach ($asserts as $assert) {
            [$file, $error, $lines] = $assert;
            $withFixable = $assert[3] ?? false;
            $report = $this->assertErrorsInFile($file, $error, $lines);

            if ($withFixable) {
                $this->assertAllFixedInFile($report);
            }
        }
    }
}
