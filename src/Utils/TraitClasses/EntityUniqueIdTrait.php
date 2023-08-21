<?php
/**
 * Credits
 * Created by PhpStorm.
 * User: LANGANFIN Rogelio
 * Date: 02/01/2020
 * Time: 09:31
 */

namespace App\Utils\TraitClasses;


use Doctrine\ORM\Mapping as ORM;

trait EntityUniqueIdTrait
{

    #[ORM\Column(type: 'string', unique: true)]
    private $code;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}