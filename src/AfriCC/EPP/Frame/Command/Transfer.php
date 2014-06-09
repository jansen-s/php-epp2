<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

abstract class Transfer extends Command
{
    protected $command_name = 'transfer';
    protected $mapping_name;

    function setObject($object)
    {
        $type = strtolower(str_replace(__CLASS__.'_', '', get_class($this)));
        foreach ($this->payload->childNodes as $child) $this->payload->removeChild($child);
        $this->payload->appendChild($this->createElementNS(
            Net_EPP_ObjectSpec::xmlns($type),
            $type.':'.Net_EPP_ObjectSpec::id($type),
            $object
        ));
    }

    function setOp($op)
    {
        $this->command->setAttribute('op', $op);
    }

    function setAuthInfo($authInfo)
    {
        $el = $this->createObjectPropertyElement('authInfo');
        $el->appendChild($this->createObjectPropertyElement('pw'));
        $el->firstChild->appendChild($this->createTextNode($authInfo));
        $this->payload->appendChild($el);
    }
}