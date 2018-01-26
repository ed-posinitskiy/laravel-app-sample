<?php
/**
 * File contains Trait CompositeMessageRuleTrait
 *
 * @since  08.11.2017
 * @author Alexandra Fedotova <afedotova.kappa@gmail.com>
 */

namespace App\Validator;

/**
 * Trait CompositeMessageRuleTrait
 *
 * @package App\Validator
 * @author  Alexandra Fedotova <afedotova.kappa@gmail.com>
 */
trait CompositeMessageRuleTrait
{
    /**
     * @var string
     */
    protected $error = null;

    /**
     * @var array
     */
    protected $messageTemplates;

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @return null|string
     */
    protected function defineErrorMessage(): ?string
    {
        if (!isset($this->error) || !isset($this->messages[$this->error])) {
            return null;

        }
        return $this->messages[$this->error];
    }

    /**
     * @param string $error
     * @param array  $parameters
     */
    protected function error($error, array $parameters = [])
    {
        $this->error = $error;
        if (!isset($this->messageTemplates[$this->error])) {
            return;

        }
        $message = vsprintf($this->messageTemplates[$this->error], $parameters);
        $this->messages[$this->error] = $message;
    }
}