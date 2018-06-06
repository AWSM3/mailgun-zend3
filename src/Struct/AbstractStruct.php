<?php
/**
 * AbstractStruct.php
 */
declare(strict_types=1);

/** @namespace */
namespace ZendMailgun\Struct;

/**
 * Class AbstractStruct
 * @package ZendMailgun\Struct
 */
abstract class AbstractStruct implements \IteratorAggregate
{
    /**
     * Create a Struct from an associative array.
     *
     * @param array $data   associative array array('property'=>data)
     * @param bool  $filter (optional) if true, $data array keys which are not defined as properties in the Struct will
     *                      be ignored
     *
     * @return AbstractStruct
     */
    public static function fromArray(array $data, $filter = false)
    {
        $class = get_called_class();
        $object = new static();

        foreach ($data as $key => $value) {
            if (!$filter || property_exists($class, $key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }

    /**
     * Retrieve an external iterator.
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     *
     * @throws \ReflectionException
     * @return \Traversable an instance of an object implementing Iterator or Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }

    /**
     * @throws \ReflectionException
     * @return array associative array of property=>value pairs
     */
    public function toArray()
    {
        $array = [];
        try {
            $reflection = new \ReflectionClass($this);
        } catch (\Exception $e) {
            return $array;
        }
        foreach ($reflection->getProperties() as $property) {
            $value = $this->{$property->getName()};
            if (null !== $value) {
                $array[$property->getName()] = $value;
            }
        }

        return $array;
    }
}
