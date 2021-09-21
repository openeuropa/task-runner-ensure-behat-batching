<?php

declare(strict_types=1);

namespace OpenEuropa\EnsureBehatBatching\TaskRunner\Commands;

use Behat\Gherkin\Keywords\ArrayKeywords;
use Behat\Gherkin\Lexer;
use Behat\Gherkin\Parser;
use OpenEuropa\TaskRunner\Commands\AbstractCommands;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

/**
 * TaskRunner commands related to Behat tests setup.
 */
class BehatBatchingCommands extends AbstractCommands
{
    /**
     * Ensure that all scenarios have been tagged with a batch tag "@batch*".
     *
     * @command behat:ensure-batching
     *
     * @option path Folder where Behat tests have to be reviewed.
     */
    public function ensureBehatBatching(array $options = ['path' => InputOption::VALUE_REQUIRED]): int
    {
        // Setup Gherkin parser.
        $keywords = new ArrayKeywords([
            'en' => [
                'feature' => 'Feature',
                'background' => 'Background',
                'scenario' => 'Scenario',
                'scenario_outline' => 'Scenario Outline|Scenario Template',
                'examples' => 'Examples|Scenarios',
                'given' => 'Given',
                'when' => 'When',
                'then' => 'Then',
                'and' => 'And',
                'but' => 'But',
            ],
        ]);
        $lexer = new Lexer($keywords);
        $parser = new Parser($lexer);
        $finder = new Finder();
        $finder->files()->in($options['path']);

        // Collect all scenarios that are not tagged with '@batch*'.
        $not_tagged = [];
        foreach ($finder as $file) {
            $feature = $parser->parse($file->getContents());
            foreach ($feature->getScenarios() as $scenario) {
                $tags = $scenario->getTags();
                if (empty(preg_grep('/^batch(\d+)$/', $tags))) {
                    $not_tagged[] = $scenario->getTitle();
                }
            }
        }

        $io = new SymfonyStyle($this->input(), $this->output());
        // If no tagged scenarios found exit with status 1, so that builds can fail.
        if (!empty($not_tagged)) {
            $error_messages = array_merge(['The following scenarios have not been assigned to a test batch:'], $not_tagged);
            $io->error($error_messages);
            return 1;
        }

        $io->success('All scenarios have been assigned to a test batch.');
        return 0;
    }
}
