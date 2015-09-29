<?php

namespace Graze\Gigya\Endpoints;

use Graze\Gigya\Model\ModelInterface;

/**
 * Class Audit
 *
 * @package Graze\Gigya\Endpoints
 *
 * @link     http://developers.gigya.com/display/GD/Audit+REST
 *
 * @method ModelInterface search(array $params) @link http://developers.gigya.com/display/GD/audit.search
 */
class Audit extends NamespaceClient
{
    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return static::NAMESPACE_AUDIT;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethodNamespace()
    {
        return static::NAMESPACE_AUDIT;
    }
}
