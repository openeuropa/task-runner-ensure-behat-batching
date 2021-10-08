<?php

declare(strict_types=1);

namespace OpenEuropa\EnsureBehatBatching\Tests\Commands;

use Composer\Autoload\ClassLoader;
use OpenEuropa\TaskRunner\TaskRunner;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Test "Ensure Behat batching" command.
 *
 * Task runner is run in different tests to avoid wrong execution.
 */
class BehatBatchingCommandsTest extends TestCase
{
    /**
     * Test "behat:ensure-batching" command with correct features.
     */
    public function testCorrectPath()
    {
        // Run command on the path with correct Behat features.
        $result = $this->runBehatEnsureBatchingCommand(__DIR__ . "/../fixtures/correct");
        $this->assertStringContainsString('[OK] All scenarios have been assigned to a test batch.', $result);
    }

    /**
     * Test "behat:ensure-batching" command with wrong features.
     */
    public function testWrongPath()
    {
        // Run command on the path with wrong Behat features.
        $result = $this->runBehatEnsureBatchingCommand(__DIR__ . "/../fixtures/wrong");
        $this->assertStringContainsString('[ERROR] The following scenarios have not been assigned to a test batch:', $result);
        $this->assertStringContainsString('Tag is absent', $result);
        $this->assertStringContainsString('Incomplete tag', $result);
        $this->assertStringContainsString('Typo in the tag', $result);
        $this->assertStringContainsString('Special characters aren\'t allowed in the tag', $result);
    }

    /**
     * Run "behat:ensure-batching" command.
     *
     * @param string $path
     *   Path to test.
     *
     * @return string
     *   Console output.
     */
    protected function runBehatEnsureBatchingCommand(string $path): string
    {
        $output = new BufferedOutput();
        $input = new StringInput("behat:ensure-batching --path={$path}");
        $runner = new TaskRunner($input, $output, $this->getClassLoader());
        $runner->run();

        return $output->fetch();
    }

    /**
     * Get project class loader.
     *
     * @return \Composer\Autoload\ClassLoader
     */
    protected function getClassLoader(): ClassLoader
    {
        return require __DIR__.'/../../vendor/autoload.php';
    }
}
