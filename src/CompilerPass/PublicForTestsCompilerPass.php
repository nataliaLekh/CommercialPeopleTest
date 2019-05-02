<?php
namespace App\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class PublicForTestsCompilerPass
 */
final class PublicForTestsCompilerPass implements CompilerPassInterface
{
    /**
     * Make services public for tests only.
     *
     * @param ContainerBuilder $containerBuilder
     */
    public function process(ContainerBuilder $containerBuilder): void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            $definition->setPublic(true);
        }
        foreach ($containerBuilder->getAliases() as $definition) {
            $definition->setPublic(true);
        }
    }
}