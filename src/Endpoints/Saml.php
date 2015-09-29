<?php

namespace Graze\Gigya\Endpoints;

use Graze\Gigya\Model\ModelInterface;

/**
 * Class Saml
 *
 * @package Graze\Gigya\Endpoints
 *
 * @link     http://developers.gigya.com/display/GD/FIdM+SAML+REST
 *
 * @method ModelInterface delIdP(array $params) @link http://developers.gigya.com/display/GD/fidm.saml.delIdP+REST
 * @method ModelInterface getConfig(array $params) @link
 *         http://developers.gigya.com/display/GD/fidm.saml.getConfig+REST
 * @method ModelInterface getRegisteredIdPs(array $params) @link
 *         http://developers.gigya.com/display/GD/fidm.saml.getRegisteredIdPs+REST
 * @method ModelInterface importIdPMetadata(array $params) @link
 *         http://developers.gigya.com/display/GD/fidm.saml.importIdPMetadata+REST
 * @method ModelInterface registerIdP(array $params) @link
 *         http://developers.gigya.com/display/GD/fidm.saml.registerIdP+REST
 * @method ModelInterface setConfig(array $params) @link
 *         http://developers.gigya.com/display/GD/fidm.saml.setConfig+REST
 */
class Saml extends NamespaceClient
{
    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return static::NAMESPACE_FIDM;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethodNamespace()
    {
        return static::NAMESPACE_FIDM_SAML;
    }

    /**
     * @return SamlIdp
     */
    public function idp()
    {
        return new SamlIdp($this->options, $this->dataCenter);
    }
}
