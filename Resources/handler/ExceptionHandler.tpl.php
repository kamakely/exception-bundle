<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

<?= $use_statements; ?>

class <?= $class_name."\n" ?> implements ExceptionHandlerInterface
{
    public function handleException(\Throwable $throwable): Response
    {
        // your logic
        return new Response("Customize this render in " . __DIR__ . "/<?= $class_name; ?>.php");
    }

    public function supportsException(\Throwable $throwable): bool
    {
        return $throwable instanceof <?= $exception_class; ?>;
    }
}
