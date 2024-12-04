<?php

namespace App\Management\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'blog:create-user',
    description: 'Create the initial user for the blog',
)]
class BlogCreateUserCommand extends Command
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User();
        $user->setEmail('test@example.org');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'test123'));
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln(sprintf('Created user <%s>', $user->getEmail()));

        return Command::SUCCESS;
    }
}
