<?php

namespace Merci\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Finder\Finder;


/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MerciUserExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $this->loadValidation($container);
    }

    /**
     * Load all validation files from bundle path.
     *
     * @param ContainerBuilder $container
     */
    public function loadValidation(ContainerBuilder $container)
    {
        $validatorFiles = $container->getParameter('validator.mapping.loader.yaml_files_loader.mapping_files');
        $finder = new Finder();
        foreach ($finder->files()->in(__DIR__ . '/../Resources/config/validation') as $file) {
            $validatorFiles[] = $file->getRealPath();
        }
        $container->setParameter('validator.mapping.loader.yaml_files_loader.mapping_files', $validatorFiles);
    }




}
