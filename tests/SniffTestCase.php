<?php

declare(strict_types=1);

namespace BestIt;

use PHP_CodeSniffer\Files\File;
use ReflectionClass;
use ReflectionException;
use SlevomatCodingStandard\Sniffs\TestCase as SlevomatTestCase;
use function array_map;
use function array_merge;
use function array_reverse;
use function basename;
use function dirname;
use function explode;
use function glob;
use function implode;
use function preg_match;
use function range;
use function sprintf;
use function str_replace;
use function strpos;
use const DIRECTORY_SEPARATOR;

/**
 * The basic sniff test case.
 *
 * @author Nick Lubisch <nick.lubisch@bestit-online.de>
 * @package BestIt
 */
abstract class SniffTestCase extends SlevomatTestCase
{
    /**
     * The cached folder path for the fixtures of this class.
     *
     * @var string
     */
    private string $fixturePath = '';

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
    protected function assertErrorsInFile(
        string $file,
        string $error,
        array $lines,
        array $sniffProperties = [],
    ): File {
        if ((!$dirname = dirname($file)) || ($dirname === '.')) {
            $file = $this->getFixtureFilePath($file);
        }

        $report = $this->checkFile($file, $sniffProperties);

        foreach ($lines as $line) {
            $this->assertSniffError(
                $report,
                $line,
                $error,
            );
        }

        return $report;
    }

    /**
     * Tests files which have to be without errors.
     *
     * @param string $file File to test
     *
     * @return void
     */
    protected function assertFileCorrect(string $file): void
    {
        $report = $this->checkFile($file);

        $this->assertNoSniffErrorInFile($report);
        $this->assertNoSniffWarningInFile($report);
    }

    /**
     * Tests files with given error list and fixes them.
     *
     * @param string $file File to test
     * @param string $error Error code
     * @param int[] $lines All lines where the error code occurs
     * @param array $sniffProperties Array of sniff properties
     *
     * @return void
     */
    protected function assertFixableErrorsInFile(
        string $file,
        string $error,
        array $lines,
        array $sniffProperties = [],
    ): void {
        $report = $this->assertErrorsInFile($file, $error, $lines, $sniffProperties);

        $this->assertAllFixedInFile($report);
    }

    /**
     * Copied from slevomat but changed to warnings.
     *
     * @see SlevomatTestCase::assertNoSniffError()
     *
     * @param File $codeSnifferFile
     * @param int $line
     *
     * @return void
     */
    protected static function assertNoSniffWarning(File $codeSnifferFile, int $line): void
    {
        $warnings = $codeSnifferFile->getWarnings();
        self::assertFalse(
            isset($warnings[$line]),
            sprintf(
                'Expected no warning on line %s, but found:%s%s%s',
                $line,
                PHP_EOL . PHP_EOL,
                isset($warnings[$line]) ? self::getFormattedWarnings($warnings[$line]) : '',
                PHP_EOL,
            ),
        );
    }

    /**
     * Checks that there are no warnings for the given file.
     *
     * Copied the following from slevomat but changed to warnings.
     *
     * @param File $file
     * @see SlevomatTestCase::assertNoSniffErrorInFile()
     *
     * @return void
     */
    protected static function assertNoSniffWarningInFile(File $file): void
    {
        $warnings = $file->getWarnings();

        self::assertEmpty($warnings, sprintf('No warnings expected, but %d warnings found.', count($warnings)));
    }

    /**
     * Checks the warnings for the given sniff file.
     *
     * Copied the following from slevomat but changed to warnings.
     *
     * @see SlevomatTestCase::assertSniffError()
     *
     * @param File $codeSnifferFile
     * @param int $line
     * @param string $code
     * @param null|string $message
     *
     * @return void
     */
    protected static function assertSniffWarning(
        File $codeSnifferFile,
        int $line,
        string $code,
        ?string $message = null,
    ): void {
        $warnings = $codeSnifferFile->getWarnings();
        self::assertTrue(isset($warnings[$line]), sprintf('Expected warning on line %s, but none found.', $line));

        $sniffCode = sprintf('%s.%s', static::getSniffName(), $code);

        self::assertTrue(
            self::hasWarning($warnings[$line], $sniffCode, $message),
            sprintf(
                'Expected warning %s%s, but none found on line %d.%sWarnings found on line %d:%s%s%s',
                $sniffCode,
                $message !== null ? sprintf(' with message "%s"', $message) : '',
                $line,
                PHP_EOL . PHP_EOL,
                $line,
                PHP_EOL,
                self::getFormattedWarnings($warnings[$line]),
                PHP_EOL,
            ),
        );
    }

    /**
     * Asserts all warnings in a given file.
     *
     * @throws Exception
     *
     * @param string $file Filename of the fixture
     * @param string $warning Code of the warning
     * @param int[] $lines Array of lines where the error code occurs
     * @param array $sniffProperties Array of sniff properties
     *
     * @return File The php cs file
     */
    protected function assertWarningsInFile(
        string $file,
        string $warning,
        array $lines,
        array $sniffProperties = [],
    ): File {
        $report = $this->checkFile($file, $sniffProperties);

        foreach ($lines as $line) {
            $this->assertSniffWarning(
                $report,
                $line,
                $warning,
            );
        }

        return $report;
    }

    /**
     * Returns a list of files which start with correct*.
     *
     * @return array With the path to a file as the first parameter.
     */
    public function getCorrectFileListAsDataProvider(): array
    {
        $providerFiles = [];

        foreach (glob($this->getFixturePath() . '/correct/*.php') as $file) {
            $providerFiles[basename($file)] = [$file];
        }

        return $providerFiles;
    }

    /**
     * Returns the metadata from the given file name if there is one.
     *
     * @param string $file
     * @param array $errorData This method changes a marker for other files, if there is a file with a fixed marker.
     *
     * @return array<string, string, ...int>
     */
    protected function getMetadataFromFilenameAsAssertArray(string $file, array &$errorData): array
    {
        $fileMetaData = [];
        $fileName = basename($file);
        $matches = [];
        $pattern = '/(?P<code>\w+)(\(\w*\))?\.(?P<errorLines>[\d\-\,]*)(?P<fixedSuffix>\.fixed)?\.php/';

        if (preg_match($pattern, $fileName, $matches)) {
            if (@$matches['fixedSuffix']) {
                @$errorData[str_replace('.fixed', '', $fileName)][] = true;
            } else {
                $errorLines = explode(',', $matches['errorLines']);

                // Check if there is a range.
                foreach ($errorLines as $index => $errorLine) {
                    if (strpos($errorLine, '-') !== false) {
                        unset($errorLines[$index]);

                        $errorLines = array_merge($errorLines, range(...explode('-', $errorLine)));
                    }
                }

                $fileMetaData = [
                    $file,
                    $matches['code'],
                    array_map('intval', $errorLines),
                ];
            }
        }

        return $fileMetaData;
    }

    /**
     * Loads the assertion data out of the file names.
     *
     * @param bool $forErrors Load data for errors?
     *
     * @return array The assert data as data providers.
     */
    protected function loadAssertData(bool $forErrors = true): array
    {
        $errorData = [];

        foreach ($this->getFixtureFiles($forErrors) as $file) {
            if ($fileMetaData = $this->getMetadataFromFilenameAsAssertArray($file, $errorData)) {
                $errorData[basename($file)] = $fileMetaData;
            }
        }

        return $errorData;
    }

    /**
     * Returns a list of files which start with correct*
     *
     * @return array With the path to a file as the first parameter.
     */
    public function getCorrectFileList(): array
    {
        $providerFiles = [];

        foreach (glob($this->getFixturePath() . DIRECTORY_SEPARATOR . 'Correct*.php') as $file) {
            $providerFiles[basename($file)] = [$file];
        }

        return $providerFiles;
    }

    /**
     * Returns fixture file path by given file name.
     *
     * @param string $fixture Filename of fixture
     *
     * @return string Filepath to fixture
     */
    protected function getFixtureFilePath(string $fixture): string
    {
        return $this->getFixturePath() . '/' . $fixture;
    }

    /**
     * Processes the fixture path.
     *
     * @return string Fixture path
     */
    protected function getFixturePath(): string
    {
        if (!$this->fixturePath) {
            $this->fixturePath = $this->loadFixturePath();
        }

        return $this->fixturePath;
    }

    /**
     * Copied from slevomat but changed to warnings.
     *
     * @param array $warnings
     * @see SlevomatTestCase::getFormattedErrors()
     *
     * @return string
     */
    private static function getFormattedWarnings(array $warnings): string
    {
        return implode(PHP_EOL, array_map(function (array $warnings): string {
            return implode(PHP_EOL, array_map(function (array $warning): string {
                return sprintf("\t%s: %s", $warning['source'], $warning['message']);
            }, $warnings));
        }, $warnings));
    }

    protected static function getSniffClassName(): string
    {
        return substr(static::class, 0, -strlen('Test'));
    }

    protected static function getSniffName(): string
    {
        return preg_replace(
            [
                '~\\\~',
                '~\.Sniffs~',
                '~Sniff$~',
            ],
            [
                '.',
                '',
                '',
            ],
            self::getSniffClassName(),
        );
    }

    /**
     * Copied from slevomat but changed to warnings.
     *
     * @see SlevomatTestCase::hasError()
     *
     * @param mixed[][][] $warningsOnLine
     * @param string $sniffCode
     * @param string|null $message
     *
     * @return bool
     */
    private static function hasWarning(array $warningsOnLine, string $sniffCode, ?string $message = null): bool
    {
        foreach ($warningsOnLine as $warningsOnPosition) {
            foreach ($warningsOnPosition as $warning) {
                $isSniffCode = $warning['source'] === $sniffCode;

                if (!($isSniffCode && ($message === null || strpos($warning['message'], $message) !== false))) {
                    continue;
                }

                return true;
            }
        }

        return false;
    }

    /**
     * Returns the test files for errors or warnings.
     *
     * @param bool $forErrors Load data for errors?
     *
     * @return array The testable files.
     */
    private function getFixtureFiles(bool $forErrors = true): array
    {
        return array_reverse(glob(sprintf(
            $this->getFixturePath() . '/with_%s/*.php',
            $forErrors ? 'errors' : 'warnings',
        ))) ?: [];
    }

    /**
     * Returns the path to the fixture folder for this sniff.
     *
     * @return string The path to the fixture folder for this sniff.
     */
    protected function loadFixturePath(): string
    {
        $basePathParts = [];

        try {
            $reflection = new ReflectionClass(static::class);

            $basePathParts = [
                dirname($reflection->getFileName()),
                'Fixtures',
                substr($reflection->getShortName(), 0, -4),
            ];
        } catch (ReflectionException $e) {
            // Do nothing, this class exists!
        }

        return implode(DIRECTORY_SEPARATOR, $basePathParts);
    }
}
