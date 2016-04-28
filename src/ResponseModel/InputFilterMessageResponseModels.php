<?php

namespace Reliv\PipeRat\ResponseModel;

use Reliv\RcmApiLib\InputFilter\MessageParam;
use Zend\InputFilter\CollectionInputFilter;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

/**
 * Class InputFilterMessageResponseModels
 *
 * InputFilterMessageResponseModels
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\ResponseModel
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class InputFilterMessageResponseModels extends MessageResponseModels
{
    /**
     * @var string
     */
    protected $primaryType = 'inputFilter';

    /**
     * @var string
     */
    protected $primaryMessage = 'An Error Occurred';

    /**
     * @var string
     */
    protected $primarySource = 'validation';

    /**
     * @var string
     */
    protected $primaryCode = 'error';

    /**
     * @param InputFilter $inputFilter
     * @param string               $primaryMessage
     * @param array                $params
     */
    public function __construct(
        InputFilter $inputFilter,
        $primaryMessage = 'An Error Occurred',
        $params = []
    ) {
        $this->primaryMessage = $primaryMessage;
        $this->build($inputFilter, $params);
    }

    /**
     * build
     *
     * @param InputFilter $inputFilter
     * @param array                $params
     *
     * @return void
     */
    public function build(InputFilter $inputFilter, $params = [])
    {

        if ($inputFilter instanceof MessageParam) {
            $params = array_merge($inputFilter->getMessageParams(), $params);
        }

        $primaryMessageResponseModel = new MessageResponseModel(
            $this->primaryType,
            $this->primaryMessage,
            $this->primarySource,
            $this->primaryCode,
            true,
            $params
        );

        $this->add($primaryMessageResponseModel);

        $this->parseInputs($inputFilter);
    }

    /**
     * parseInputs
     *
     * @param mixed  $input
     * @param string $name
     *
     * @return void
     */
    protected function parseInputs($input, $name = '')
    {

        if (is_array($input)) {
            foreach ($input as $key => $subinput) {
                $fieldName = $this->getParseName($name, $key, $subinput);
                $this->parseInputs($subinput, $fieldName);
            }

            return;
        }

        if ($input instanceof CollectionInputFilter) {
            $inputs = $input->getInvalidInput();
            foreach ($inputs as $groupkey => $group) {
                $fieldName = $this->getParseName($name, $groupkey, $group);
                $this->parseInputs($group, $fieldName);
            }

            return;
        }

        if ($input instanceof InputFilter) {
            $inputs = $input->getInvalidInput();

            foreach ($inputs as $key => $subinput) {
                $fieldName = $this->getParseName($name, $key, $subinput);
                $this->parseInputs($subinput, $fieldName);
            }

            return;
        }

        $this->buildValidatorMessages($name, $input);
    }

    /**
     * getParseName
     *
     * @param $name
     * @param $key
     * @param $subinput
     *
     * @return string
     */
    protected function getParseName($name, $key, $subinput)
    {
        $fieldName = $key;
        if (method_exists($subinput, 'getName')) {
            $fieldName = $subinput->getName();
        }
        if ($name !== '') {
            $fieldName = $name . '-' . $fieldName;
        }

        return $fieldName;
    }

    /**
     * buildValidatorMessages
     *
     * @param                $fieldName
     * @param Input $input
     *
     * @return void
     */
    protected function buildValidatorMessages(
        $fieldName,
        Input $input
    ) {
        $validatorChain = $input->getValidatorChain();
        $validators = $validatorChain->getValidators();

        // We get the input messages because input does validations outside of the validators
        $allMessages = $input->getMessages();

        foreach ($validators as $fkey => $validatorData) {
            /** @var \Zend\Validator\AbstractValidator $validator */
            $validator = $validatorData['instance'];

            $params = [];

            if ($validator instanceof MessageParam) {
                $params = $validator->getMessageParams();
            }

            try {
                $messagesParams = $validator->getOption('messageParams');
                $params = array_merge(
                    $params,
                    $messagesParams
                );
            } catch (\Exception $exception) {
                // Do nothing
            }
            $inputMessages = $validator->getMessages();

            // Remove the messages from $allMessages as we get them from the validators
            $allMessages = array_diff($allMessages, $inputMessages);

            $this->buildMessageResponseModels($fieldName, $inputMessages, $params);
        }

        $params = [];

        if ($input instanceof MessageParam) {
            $params = $input->getMessageParams();
        }

        // get any remaining messages that did not come from validators
        $this->buildMessageResponseModels($fieldName, $allMessages, $params);
    }

    /**
     * buildMessageResponseModels
     *
     * @param string $fieldName
     * @param array  $inputMessages
     * @param array  $params
     *
     * @return MessageResponseModels
     */
    protected function buildMessageResponseModels(
        $fieldName,
        $inputMessages,
        $params = []
    ) {
        foreach ($inputMessages as $errorKey => $message) {
            ///
            $messageResponseModel = new ValidatorMessageResponseModel(
                $message,
                $fieldName,
                $errorKey,
                $params,
                null
            );

            $this->add($messageResponseModel);
        }
    }
}
