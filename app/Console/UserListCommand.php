<?php

namespace App\Console;

use Couchbase\UserManager;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

#[AsCommand('app:user:list', description: 'List all users')]
class UserListCommand extends Command
{
    public function __invoke(
        InputInterface $input,
        OutputInterface $output,
        #[Option(description: 'Filter by specific role', shortcut: 'r')] ?string $role = null,
    ): int {
        $io = new SymfonyStyle($input, $output);

        $io->title('Users');

        $users = Yaml::parseFile(dirname(dirname(__DIR__)) . '/config/users.yaml');

        if ($role !== null) {
            $io->text('Filtering by role: ' . $role);
            $users = array_filter($users, function (array $user) use ($role) {
                return in_array($role, $user['roles']);
            });
        }

        $io->table(['username', 'roles'], array_map(function (array $user) {
            return [$user['username'], implode(', ', $user['roles'])];
        }, $users));

        $io->success('En vous souhaitant une bonne journée');

        return Command::SUCCESS;
    }
}
