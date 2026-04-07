<?php

declare(strict_types=1);

namespace BestIt\Sniffs;

use PHP_CodeSniffer\Files\File;

/**
 * Provides testWarnings() for sniff test classes that have a with_warnings/ fixture directory.
 *
 * @author Bjoern Lange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs
 */
trait SniffWarningFilesTrait
{
    /**
     * Asserts all warnings in a given file.
     *
     * @param string $file Filename of the fixture
     * @param string $error Error code
     * @param int[] $lines Array of lines where the error code occurs
     * @param array $sniffProperties Array of sniff properties
     *
     * @return File The php cs file
     */
    abstract protected function assertWarningsInFile(
        string $file,
        string $error,
        array $lines,
        array $sniffProperties = [],
    ): File;

    /**
     * Returns data for warnings.
     *
     * @return array List of warning data (Filepath, warning code, warning lines, fixable)
     */
    public function getWarningAsserts(): array
    {
        return $this->loadAssertData(false);
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
     * Tests warnings.
     *
     * @return void
     */
    public function testWarnings(): void
    {
        $asserts = $this->getWarningAsserts();

        if (!$asserts) {
            $this->markTestSkipped('No warning fixtures found.');
        }

        foreach ($asserts as $assert) {
            [$file, $warning, $lines] = $assert;
            $withFixable = $assert[3] ?? false;
            $report = $this->assertWarningsInFile($file, $warning, $lines);

            if ($withFixable) {
                $this->assertAllFixedInFile($report);
            }
        }
    }
}
