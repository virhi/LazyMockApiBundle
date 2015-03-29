<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 29/03/15
 * Time: 11:00
 */

namespace Virhi\LazyMockApiBundle\Mock\Application\Specification;

use Virhi\Component\Specification\SpecificationInterface;

class ImportMockSpecification implements SpecificationInterface
{
    /**
     *
     * @return boolean
     */
    public function isSatisfiedBy($mockToImport)
    {
        $result = false;
        if (is_array($mockToImport) && $this->checkRequest($mockToImport) && $this->checkResponse($mockToImport)) {
            $result = true;
        }
        return $result;
    }

    /**
     * @param array $mockToImport
     * @return bool
     */
    protected function checkRequest(array $mockToImport)
    {
        $result    = false;
        $needField = array(
            'url'     => false,
            'method'  => false,
            'content' => true,
        );

        if (array_key_exists('request', $mockToImport) && $this->check($needField, $mockToImport['request'] )) {
            $result = true;
        }
        return $result;
    }

    /**
     * @param array $mockToImport
     * @return bool
     */
    protected function checkResponse(array $mockToImport)
    {
        $result    = false;
        $needField = array(
            'status'  => false,
            'content' => true,
        );

        if (array_key_exists('response', $mockToImport) && $this->check($needField, $mockToImport['response'] )) {
            $result = true;
        }

        return $result;

    }

    /**
     * @param array $needField
     * @param array $input
     * @return bool
     */
    protected function check(array $needField, array $input)
    {
        $result    = false;
        foreach ($needField as $fieldname => $canBeEmpty) {

            if (array_key_exists($fieldname, $input)) {
                if ($canBeEmpty && ($input[$fieldname] === null || $input[$fieldname] === '') ) {
                    $result = true;
                } elseif (false === $canBeEmpty && $input[$fieldname] !== null && $input[$fieldname] !== '') {
                    $result = true;
                }
            }

            if (false === $result) {
                break;
            }
        }
        return $result;
    }

}