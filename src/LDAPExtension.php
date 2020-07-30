<?php

namespace cyllenea\ldap;

use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;
use Nette\Reflection\Extension;

class LDAPExtension extends CompilerExtension
{

    private array $defaults = [
        'attributes' => [
            "employeeNumber",
            "employeeID",
            "mail",
            "cn",
        ],
        'controllers' => [],
    ];

    public function loadConfiguration()
    {

        $this->validateConfig($this->defaults);
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('main'))
            ->setFactory(LDAP::class, [
                $this->config['controllers'],
                $this->config['attributes'],
            ]);
    }

    /**
     * @param Configurator $configurator
     */
    public static function register(Configurator $configurator)
    {
        $configurator->onCompile[] = function ($config, Compiler $compiler) {
            $compiler->addExtension('MultiLDAP', new Extension());
        };
    }

}