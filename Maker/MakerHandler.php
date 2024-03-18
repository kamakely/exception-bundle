<?php

namespace Tounaf\ExceptionBundle\Maker;

use Exception;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Util\UseStatementGenerator;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpFoundation\Response;
use Tounaf\Exception\Exception\ExceptionHandlerInterface;

final class MakerHandler extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return "make:handler-exception";
    }
    public static function getCommandDescription()
    {
        return "Cretae new handler exception class";
    }

    public function interact(InputInterface $input, ConsoleStyle $consoleStyle, Command $command)
    {
        $handlerClassName = $input->getArgument('handler');
        if (null === $handlerClassName) {
            $handlerArgument = $command->getDefinition()->getArgument('handler');
            $question = new Question($handlerArgument->getDescription(), $handlerArgument->getDefault());
            $handlerClassName = $consoleStyle->askQuestion($question);
            $input->setArgument('handler', $handlerClassName);
        }

        $exception = $input->getArgument('exception');
        if (null === $exception) {
            $exceptionArgument = $command->getDefinition()->getArgument('exception');
            $exceptionQuestion = new Question(
                sprintf("%s: [%s]", $exceptionArgument->getDescription(), $handlerClassName), 
                $handlerClassName.'Exception'
            );
            $exceptionQuestion->setAutocompleterValues([$handlerClassName]);
            $exceptionClassName = $consoleStyle->askQuestion($exceptionQuestion);
            $input->setArgument('exception', $exceptionClassName);
        }
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfiguration)
    {
        $defaultHandlerName = Str::asClassName(Str::getRandomTerm());
        $command
            ->addArgument(
                'handler',
                InputArgument::OPTIONAL,
                sprintf('Choose a name for your exception handler class  (e.g. <fg=yellow>%sHandlerException</>)', $defaultHandlerName),
            )
            ->addArgument(
                'exception',
                InputArgument::OPTIONAL,
                'Choose a name for your exception class to handle by the handler',
            )
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeService.txt'))
            ;
            $inputConfiguration->setArgumentAsNonInteractive('handler');
        $inputConfiguration->setArgumentAsNonInteractive('exception');
    }

    public function generate(InputInterface $input, ConsoleStyle $consoleStyle, Generator $generator)
    {
        $exceptionClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('exception'),
            'Handler\\Exception\\',
            'Exception'
        );
        
        $generator->generateClass(
            $exceptionClassNameDetails->getFullName(), 
            __DIR__.'/../Resources/handler/Exception.tpl.php',
            [
                'use_statements' => new UseStatementGenerator([Exception::class])
            ]
        );
        
        $handlerClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('handler'),
            'Handler\\',
            'ExceptionHandler'
        );

        $useStatementGenerator = new UseStatementGenerator([
            ExceptionHandlerInterface::class,
            Response::class,
            $exceptionClassNameDetails->getFullName()
        ]);
        
        $generator->generateClass(
            $handlerClassNameDetails->getFullName(),
            __DIR__.'/../Resources/handler/ExceptionHandler.tpl.php',
            [
                'use_statements' => $useStatementGenerator,
                'exception_class' => $exceptionClassNameDetails->getShortName(),
                'full_handler_path' => Str::asRoutePath($handlerClassNameDetails->getRelativeNameWithoutSuffix())
            ]
        );

        $generator->writeChanges();
        $this->writeSuccessMessage($consoleStyle);
        $consoleStyle->text('Next: Open your new exception handler class and add some logic!');
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        
    }

}