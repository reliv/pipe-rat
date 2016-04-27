<?php


namespace Reliv\PipeRat\ResponseModel;


/**
 * Class HttpStatusCodeMessageResponseModel
 *
 * LongDescHere
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

class HttpStatusCodeMessageResponseModel extends MessageResponseModel
{

    /**
     * @var int
     */
    protected $statusCode = 200;
    /**
     * @var array Reason Phrases
     */
    protected $reasonPhrases = [
            0 => 'Unknown Error',
            // INFORMATIONAL CODES
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            // SUCCESS CODES
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-status',
            208 => 'Already Reported',
            // REDIRECTION CODES
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy', // Deprecated
            307 => 'Temporary Redirect',
            // CLIENT ERROR
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Time-out',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested range not satisfiable',
            417 => 'Expectation Failed',
            418 => 'I am a teapot',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Unordered Collection',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            // SERVER ERROR
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Time-out',
            505 => 'HTTP Version not supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            511 => 'Network Authentication Required',
        ];

    /**
     * @param int $statusCode
     *
     * @throws \Exception
     */
    public function __construct(
        $statusCode = 200,
        $params = [],
        $primary = true
    ) {
        $this->setStatusCode($statusCode);
        $this->setParams($params);
        $this->setPrimary($primary);
    }

    /**
     * setStatusCode
     *
     * @param $statusCode
     *
     * @return void
     * @throws \Exception
     */
    public function setStatusCode($statusCode)
    {
        if (!$this->isValidStatusCode($statusCode)) {
            throw new \Exception("Status code {$statusCode} is not valid");
        }
        $this->statusCode = (int)$statusCode;

        $this->setType('httpStatus');
        $this->setValue($this->getReasonPhrase($statusCode));
        $this->buildSource($statusCode);
        $this->setCode((string)$statusCode);
    }

    /**
     * isValidStatusCode
     *
     * @param $statusCode
     *
     * @return bool
     */
    public function isValidStatusCode($statusCode)
    {
        return isset($this->reasonPhrases[$statusCode]);
    }

    /**
     * getReasonPhrase
     *
     * @param int $code
     *
     * @return mixed
     */
    public function getReasonPhrase($code)
    {
        $code = (int)$code;
        if (isset($this->reasonPhrases[$code])) {
            return $this->reasonPhrases[$code];
        }

        return $this->reasonPhrases[0];
    }

    /**
     * buildSource
     *
     * @param int $statusCode
     *
     * @return void
     */
    public function buildSource($statusCode)
    {
        $source = $this->getReasonPhrase($statusCode);
        $source = lcfirst(str_replace(" ", "", $source));
        $this->setSource($source);
    }
}
