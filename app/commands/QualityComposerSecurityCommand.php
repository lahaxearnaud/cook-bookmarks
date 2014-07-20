<?php

use Illuminate\Console\Command;
use SensioLabs\Security\SecurityChecker;

class QualityComposerSecurityCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'qa:composer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test composer.lock with security.sensiolabs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $checker = new SecurityChecker();
        $alerts = $checker->check('composer.lock');

        $this->displayResults($this->getOutput(), 'composer.log', $alerts);

    }

    private function displayResults(\Symfony\Component\Console\Output\OutputInterface $output, $lockFilePath, array $vulnerabilities)
    {
        $output->writeln("\n<fg=blue>Security Check Report\n~~~~~~~~~~~~~~~~~~~~~</>\n");
        $output->writeln(sprintf('Checked file: <comment>%s</>', realpath($lockFilePath)));
        $output->write("\n");

        if ($count = count($vulnerabilities)) {
            $status = 'CRITICAL';
            $style = 'error';
        } else {
            $status = 'OK';
            $style = 'bg=green;fg=white';
        }

        $output->writeln($this->getHelper('formatter')->formatBlock(array('['.$status.']', $count.' packages have known vulnerabilities'), $style, true));
        $output->write("\n");

        if (0 !== $count) {
            foreach ($vulnerabilities as $dependency => $issues) {
                $dependencyFullName = $dependency.' ('.$issues['version'].')';
                $output->writeln('<info>'.$dependencyFullName."\n".str_repeat('-', strlen($dependencyFullName))."</>\n");

                foreach ($issues['advisories'] as $issue => $details) {
                    $output->write(' * ');
                    if ($details['cve']) {
                        $output->write('<comment>'.$details['cve'].': </comment>');
                    }
                    $output->writeln($details['title']);

                    if ('' !== $details['link']) {
                        $output->writeln('   '.$details['link']);
                    }

                    $output->writeln('');
                }
            }
        }

        $output->writeln("<bg=yellow;fg=white>            </> This checker can only detect vulnerabilities that are referenced");
        $output->writeln("<bg=yellow;fg=white> Disclaimer </> in the SensioLabs security advisories database. Execute this");
        $output->writeln("<bg=yellow;fg=white>            </> command regularly to check the newly discovered vulnerabilities.\n");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }
}
