<?php

declare(strict_types=1);

namespace OpenEuropa\EnsureBehatBatching\Tests\Commands;

use Composer\Autoload\ClassLoader;
use OpenEuropa\TaskRunner\TaskRunner;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Test project symlink command.
 */
class BehatBatchingCommandsTest extends TestCase
{
    /**
     * Test "behat:ensure-batching" command.
     */
    public function testBehatBatchingCommands()
    {
        $output = new BufferedOutput();

        // Run command on the path with correct Behat features.
        $this->runCommand(__DIR__ . "/../fixtures/correct", $output);
        $text = $output->fetch();
        $this->assertStringContainsString('[OK] All scenarios have been assigned to a test batch.', $text);

        // Run command on the path with wrong Behat features.
        $this->runCommand(__DIR__ . "/../fixtures/wrong", $output);
        $text = $output->fetch();
        $this->assertStringContainsString('[ERROR] The following scenarios have not been assigned to a test batch:', $text);
        $this->assertStringContainsString('Tag is absent', $text);
        $this->assertStringContainsString('Incomplete tag', $text);
        $this->assertStringContainsString('Typo in the tag', $text);
        $this->assertStringContainsString('Special characters aren\'t allowed in the tag', $text);
    }

    /**
     * Run "behat:ensure-batching" command.
     *
     * @param string $path
     *   Path to test.
     * @param \Symfony\Component\Console\Output\BufferedOutput $output
     *   Console output.
     */
    protected function runCommand(string $path, BufferedOutput $output): void
    {
        $input = new StringInput("behat:ensure-batching --path={$path}");
        $runner = new TaskRunner($input, $output, $this->getClassLoader());
        $runner->run();
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
