<?php
/**
 * Created by PhpStorm.
 * User: ETH
 * Date: 2018/10/30
 * Time: 17:09
 */

namespace Janssen\Rpc\Common;


trait OptionsAwareTrail
{
    /**
     * set options
     *
     * @param $options
     * @return $this
     */
    public function setOptions($options)
    {
        foreach ($options as $key=>$value)
        {
            $key  = str_replace('_', ' ', $key);
            $key = ucwords($key);
            $key = str_replace(' ', '', $key);
            if(method_exists($this, 'set' . $key)) {
                $this->{'set' . $key}($value);
            }
        }
        return $this;
    }
}