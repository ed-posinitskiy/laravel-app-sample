<?php
/**
 * File contains Class CrudResponseModel
 *
 * @since  13.12.2017
 * @author Alexandra Fedotova <afedotova.kappa@gmail.com>
 */

namespace App\Http\Response\Ajax;

/**
 * Class CrudResponseModel
 *
 * @package App\Http\Response\Ajax
 * @author  Alexandra Fedotova <afedotova.kappa@gmail.com>
 */
class CrudResponseModel extends UpdateResponseModel
{
    const CREATED_KEY = 'created';
    const DELETED_KEY = 'deleted';
    const UPDATED_KEY = 'updated';

    /**
     * CrudResponseModel constructor.
     *
     * @param mixed  $data
     * @param string $message
     */
    public function __construct($data, $message)
    {
        parent::__construct($data, $message);
        $this->type = static::TYPE_CRUD;
    }

    /**
     * @param mixed  $entity
     * @param string $message
     *
     * @return static
     */
    public static function withCreated($entity, string $message)
    {
        $data = [
            static::CREATED_KEY => $entity,
        ];
        return new static($data, $message);
    }

    /**
     * @param mixed  $entity
     * @param string $message
     *
     * @return static
     */
    public static function withUpdated($entity, string $message)
    {
        $data = [
            static::UPDATED_KEY => $entity,
        ];
        return new static($data, $message);
    }

    /**
     * @param mixed  $entity
     * @param string $message
     *
     * @return static
     */
    public static function withDeleted($entity, string $message)
    {
        $data = [
            static::DELETED_KEY => $entity,
        ];
        return new static($data, $message);
    }

    /**
     * @param mixed  $created
     * @param mixed  $deleted
     * @param string $message
     *
     * @return static
     */
    public static function withCreatedAndDeleted($created, $deleted, string $message)
    {
        $data = [
            static::CREATED_KEY => $created,
            static::DELETED_KEY => $deleted,
        ];
        return new static($data, $message);
    }
}
