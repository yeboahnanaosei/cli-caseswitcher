<?php
class App
{
    public function __construct()
    {
        $args = $this->parseArgs(getopt('d:rhluv'));

        if ($args['help']) {
            $this->showHelp();
            exit(0);
        }

        if ($this->validateArgs($args)) {
            try {
                $switcher = new CaseSwitcher();
                $switcher->setCase($args['case']);
                $switcher->setDirectory($args['directory']);
                $switcher->setRecursion($args['recursion']);
                $switcher->setVerboseness($args['verboseness']);

                if ($switcher->run()) {
                    $this->sendFeedback('Your files were successfully renamed', 'success');
                    exit(0);
                } else {
                    $this->sendFeedback($switcher->getErrorMsg(), 'info');
                }
            } catch (\Throwable $exception) {
                $this->sendFeedback($exception->getMessage(), 'error');
            }
        }
    }


    /**
     * Processes and gets the options supplied via the command line as well
     * as their values
     *
     * @param array $cliOptions An array of command line options supplied to the script
     * @return array $arguments An array of the options and their values
     */
    private function parseArgs(array $cliOptions) : array
    {
        $arguments['help'] = isset($cliOptions['h']) ? : false;
        $arguments['recursion'] = isset($cliOptions['r']) ? : false;
        $arguments['directory'] = isset($cliOptions['d']) ? realpath($cliOptions['d']) : null;
        $arguments['verboseness'] = isset($cliOptions['v']) ? : false;
        $arguments['lowercase'] = isset($cliOptions['l']) ? : false;
        $arguments['uppercase'] = isset($cliOptions['u']) ? : false;
        $arguments['case'] = $this->determineCase($arguments['lowercase'], $arguments['uppercase']);
        return $arguments;
    }

    /**
     * Validates and ensures that the options or arguments supplied via
     * the command line are valid and can be used.
     *
     * @param array $arguments An associative array of arguments from the command line
     * @return bool Returns true if all arguments are found to be valid.
     * False if any one of them is not valid
     */
    private function validateArgs(array $args) : bool
    {
        if ($this->validateDirectory($args['directory']) &&
            $this->validateCase($args['case'])) {
            return true;
        } else {
            return false;
        }

    }

    private function validateDirectory(string $dir = null) : bool
    {
        if (is_null($dir)) {
            $this->sendFeedback('Expected a directory. None supplied', 'error');
            $this->showTip();
            exit(1);
        } elseif ($dir === false) {
            $this->sendFeedback(
                'You either supplied a non-existent directory or an invalid path. Please check',
                'error'
            );
            exit(1);
        }
        return true;
    }

    private function validateCase($case) : bool
    {
        if (is_null($case)) {
            $this->sendFeedback('You did not specify any case', 'error');
            $this->showTip();
            exit(1);
        } elseif ($case === false) {
            $this->sendFeedback("You can't use both '-l' and '-u'. It does not make sense", 'error');
            $this->showTip();
            exit(1);
        }

        return true;
    }

    /**
     * Determines the case to be used in renameing files
     *
     * @param bool $lowercase True if lowercase was specified at the command prompt
     * @param bool $uppercase True if uppercase was specified at the command prompt
     * @return string|null|false Returns 'lower' if lowercase was determined, 'upper' if upperca
     * was determined. False or null represents an error situation
     */
    private function determineCase($lowercase, $uppercase)
    {
        switch (true) {
            case $lowercase === true && $uppercase === false:
                return 'lower';
                break;

            case $lowercase === false && $uppercase === true:
                return 'upper';
                break;

            case $lowercase === true && $uppercase === true:
                return false;
                break;

            case $lowercase === false && $uppercase === false:
                return null;
                break;
        }
    }


    /**
     * Sends feedback to output
     *
     * @param string $msg The feedback message
     * @param string $type The type of feedback (error, success, info)
     * @param bool $newLine Whether to append a newline at end of feedback. True by default
     */
    private function sendFeedback($msg, $type = null, $newLine = true)
    {
        $styles = [
            'success' => "\e[1;32m%s\e[m",
            'error' => "\e[1;31;31m%s\e[m",
            'info' => "\e[1;33;33m%s\e[m"
        ];

        $format = '%s';

        if (isset($styles[$type])) {
            $format = $styles[$type];
        }

        if ($newLine) {
            $format .= PHP_EOL;
        }

        printf($format, $msg);
    }

    /**
     * Prints a tip to output showing how help can be obtained
     *
     * @return void
     */
    private function showTip()
    {
        echo <<<TIP
Type caseswitcher -h for help

TIP;
    }

    /**
     * Prints a help message to output
     *
     * @return void
     */
    private function showHelp()
    {
        echo <<<HELP

Caseswitcher help
-----------------

\e[4;1;37mOption\e[m              \e[4;1;37mUsage\e[m
-h                  Show this help
-d [DIRECTORY]      Specify the directory to rename. Must be a valid path and writable
-r                  Instruct caseswitcher to rename recursively
-l                  Instruct caseswitcher to change filenames to lowercase
-u                  Instruct caseswitcher to change filenames to uppercase


\e[4;1;37mExample:\e[m
    \e[1;32meg1: caseswitcher -d path/to/directory -l -r\e[m
    This means change the filenames inside the directory
    to lowercase recursively.

    You can also join options together. The first example
    can be written as:
    \e[1;32meg2: caseswitcher -lrd path/to/directory\e[m


\e[4;1;37mNB:\e[m
You must specify the case you want to switch to. Either -l for
lowercase or -u for uppercase. However, you can't use both -l and -u
together. It won't make sense.
\n
HELP;
    }
}


