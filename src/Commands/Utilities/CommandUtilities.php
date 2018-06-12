<?php
/**
 * Created by PhpStorm.
 * User: Thomas Merlin
 * Email: contact.thomasmerlin@gmail.com
 * Date: 12/06/2018
 * Time: 23:52
 */

namespace App\Commands\Utilities;


use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CommandUtilities
 * @package App\Commands\Utilities
 */
abstract class CommandUtilities extends Command
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    private $container;

    /**
     * @var \Symfony\Bridge\Doctrine\RegistryInterface $doctrine
     */
    private $doctrine;

    /**
     * CommandUtilities constructor.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param \Symfony\Bridge\Doctrine\RegistryInterface                $registry
     */
    public function __construct(
        ContainerInterface $container,
        RegistryInterface $registry
    ) {
        $this->container = $container;
        $this->doctrine = $registry;
        parent::__construct();
    }

    /**
     * Write an output message
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param string                                            $message
     *
     * @return string
     */
    public function writeOutputMessage(
        OutputInterface $output,
        string $message
    ) {
        return $output->writeln($message);
    }

    /**
     * Ask each question and return the array of answers for the given fields.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param array                                             $questions
     *
     * @return array
     */
    public function getAnswersFromQuestions(
        OutputInterface $output,
        InputInterface $input,
        array $questions = []
    ) : array {
        $asker = $this->getHelper('question');
        $answers = array();

        foreach ($questions as $question) {
            $question['answer'] = $asker->ask(
                $input,
                $output,
                new Question('Valeur pour le champ "' .$question['key'] . '" : ')
            );

            $answers[$question['key']] = $question['answer'];
        }

        return $answers;
    }

    /**
     * Command's introduction messages.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function launchIntroductionMessages(OutputInterface $output)
    {
        $this->writeOutputMessage(
            $output,
            "Lancement de la commande " . $this->getName()
        );

        $this->writeOutputMessage(
            $output,
            "---------------------------"
        );
    }

    /**
     * Generate a new entity dynamically and insert it in the database if needed.
     *
     * @param array  $answers
     * @param string $entityName
     * @param bool   $insertIntoDatabase
     */
    public function generateEntityFromAnswers(
        array $answers,
        string $entityName,
        bool $insertIntoDatabase = false
    ) {
        $entity = new $entityName();

        foreach ($answers as $field => $answer) {
            $functionName = 'set' . ucfirst($field);

            if ($functionName === 'setPassword') {
                $passwordEncoder = $this->container->get('security.password_encoder');

                $answer = $passwordEncoder->encodePassword(
                    $entity,
                    $answer
                );
            }

            $entity->$functionName($answer);
        }

        if ($insertIntoDatabase === true) {
            $em = $this->doctrine->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }
}