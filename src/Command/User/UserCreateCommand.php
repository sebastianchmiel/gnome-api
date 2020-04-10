<?php

namespace App\Command\User;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{InputArgument, InputInterface};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\{ChoiceQuestion, Question};
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\UserRepository;

/**
 * command to create user
 * 
 * @author Sebastian Chmiel <s.chmiel2@gmail.com>
 */
final class UserCreateCommand extends Command
{
    /**
     * command name
     *
     * @var string
     */
    protected static $defaultName = 'user:create';

    /**
     * @var PasswordEncoder
     */
    private $passwordEncoder;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * user available roles
     *
     * @var array
     */
    private $availableRoles = [
        1 => 'ROLE_API'
    ];

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        parent::__construct();
        
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

    /**
     * configure command 
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.')
            ->addArgument('roles', InputArgument::REQUIRED, 'The roles of the user. You can enter more separated by commas.')
        ;
    }

    /**
     * execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * 
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $roles = [];
        foreach (array_map('trim', explode(',', $input->getArgument('roles'))) as $roleId) {
            if (isset($this->availableRoles[$roleId])) {
                $roles[] = $this->availableRoles[$roleId];
            }
        }
        
        try {
            $user = (new User())
                ->setUsername($username)
                ->setRoles($roles)
                ;

            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $password
                )
            );

            $this->userRepository->save($user);
        } catch (\Exception $ex) {
            $output->writeln('Something goes wrong');
            return -1;
        }

        $output->writeln('User was successfuly created!');
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = [];

        if (!$input->getArgument('username')) {
            $question = new Question('Please choose a username: ');
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Username can not be empty');
                }

                return $username;
            });
            $questions['username'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('Please choose a password: ');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }

                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }

        if (!$input->getArgument('roles')) {
            $question = new Question('Please write roles: ');
            $question = new ChoiceQuestion(
                'Please write roles:',
                $this->availableRoles,
                $this->availableRoles[1]
            );
            $question->setValidator(function ($roles) {
                if (empty($roles)) {
                    throw new \Exception('Roles can not be empty');
                }

                return $roles;
            });
            $questions['roles'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}