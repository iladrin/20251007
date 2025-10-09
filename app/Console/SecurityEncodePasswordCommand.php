<?php

namespace App\Console;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:security:encode-password')]
class SecurityEncodePasswordCommand extends Command
{
    public function __invoke(
        InputInterface $input,
        OutputInterface $output,
        #[Argument(description: 'Password to encode')] ?string $password = null,
    ): int {
        $io = new SymfonyStyle($input, $output);

        if ($password === null) {
            $password = $io->ask('Enter the password to encode');
        }

        $encodedPassword = password_hash($password, PASSWORD_BCRYPT);

        $io->success('Password encoded: ' . $encodedPassword);

        return Command::SUCCESS;
    }
}
