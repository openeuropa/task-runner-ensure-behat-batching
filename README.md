# OpenEuropa Task Runner: Ensure Behat batching

The "Ensure Behat batching" is [Task Runner](https://github.com/openeuropa/task-runner) command that ensures Behat 
features are properly tagged for batched execution by special batch tag "@batch[BATCH_NUMBER]". This tag is used
to divide tests execution on few parallel processes.

## Installation

Require the command as a dev dependency:

    composer require --dev openeuropa/task-runner-ensure-behat-batching

## Usage

Make sure to always run the following command, after adding files and scenarios into Behat tests:

    ./vendor/bin/run behat:ensure-batching --path=FOLDER_WITH_TESTS

## Step debugging

To enable step debugging from the command line, pass the `XDEBUG_SESSION` environment variable with any value to
the Docker container:

```bash
docker-compose exec -e XDEBUG_SESSION=1 web <your command>
```

Please note that, starting from XDebug 3, a connection error message will be outputted in the console if the variable is
set but your client is not listening for debugging connections. The error message will cause false negatives for PHPUnit
tests.

To initiate step debugging from the browser, set the correct cookie using a browser extension or a bookmarklet
like the ones generated at https://www.jetbrains.com/phpstorm/marklets/.
