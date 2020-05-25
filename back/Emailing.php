<?php

namespace SymplBundle\Emailing;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymplBundle\Emailing\DependencyInjection\Compiler\EmailingCompilerPass;
use SymplBundle\Emailing\DependencyInjection\EmailingExtension;

class Emailing extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new EmailingCompilerPass());
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EmailingExtension();
        }

        return $this->extension;
    }
}
