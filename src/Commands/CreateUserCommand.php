<?php
/**
 * Created by PhpStorm.
 * User: Thomas Merlin
 * Email: contact.thomasmerlin@gmail.com
 * Date: 12/06/2018
 * Time: 23:47
 */

namespace App\Commands;


use App\Commands\Utilities\CommandUtilities;
use App\Entity\User;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateUserCommand
 * @package App\Commands
 */
class CreateUserCommand extends CommandUtilities
{
    /**
     *
     */
    public function configure()
    {
        $this
            ->setName('app:create:user')
            ->setDescription('Créé un utilisateur')
        ;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->launchIntroductionMessages($output);

            $questions = array(
                array(
                    'key' => 'username',
                    'answer' => null
                ),
                array(
                    'key' => 'email',
                    'answer' => null
                ),
                array(
                    'key' => 'password',
                    'answer' => null
                ),
            );

            $answers = $this->getAnswersFromQuestions(
                $output,
                $input,
                $questions
            );

            $this->generateEntityFromAnswers(
                $answers,
                User::class,
                true
            );

            $this->writeOutputMessage(
                $output,
                "Le compte utilisateur a bien été créé."
            );
        } catch (\Exception $exception) {
            $this->writeOutputMessage(
                $output,
                $exception->getMessage()
            );
            $this->writeOutputMessage(
                $output,
                "La création de l'utilisateur n'a pu aller à terme. Fin de la commande."
            );
        }
    }
}