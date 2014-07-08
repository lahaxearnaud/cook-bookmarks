<?php
namespace Codeception\Module;

// here you can define custom functions for ninja

class NinjaHelper extends \Codeception\Module
{

    protected $path = 'api/v1/';
    private $token = '';

    public function login($username, $password)
    {
        $rest = $this->getModule('REST');

        $rest->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');

        $rest->sendPost('auth', array(
            'username' => $username,
            'password' => $password
        ));
        $rest->seeResponseCodeIs(200);
        $rest->seeResponseIsJson();
        $rest->seeResponseContains("token");
        $this->token = $rest->grabDataFromJsonResponse('token');

    }

    public function call($path, $method = 'GET', array $params = array(), $httpCode = 200, $isJson = true)
    {
        $rest = $this->getModule('REST');

        $method = 'send' . ucfirst($method);

        $rest->haveHttpHeader('X-Auth-Token', $this->token);
        $rest->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');

        $rest->{$method}($this->path.$path, $params);
        $rest->seeResponseCodeIs($httpCode);

        if ($isJson) {
            $rest->seeResponseIsJson();
        }
    }

    /**
     * @param callable $closure
     *                          - Fist param ApiHelper
     *                          - Second param WS response
     *
     * @param bool $jsonDecode
     */
    public function validateResponseWithClosure(\Closure $closure, $jsonDecode = true)
    {
        $rest     = $this->getModule('REST');
        $response = $rest->grabResponse();
        if ($jsonDecode) {
            $response = json_decode($response, true);
        }

        $closure($this, $response);
    }

	public function isType($name, $format, $value, $parameter = '', $allowEmpty = false, $allowNull = false)
    {

        if (!$allowNull) {
            $this->assertTrue(!is_null($value), $name . ': can not be null');
        }

        if (!$allowEmpty) {
            $this->assertTrue(!empty($value) || $value === 0 || $value === false, $name . ': can not be empty');
        }

        $displayErrorValue = var_export($value, true);

        switch ($format) {
            case 'INTEGER':
                $this->assertTrue(is_int($value) || ctype_digit($value), $name . ': is not an integer (' . $displayErrorValue . ')');
                break;

            case 'FLOAT':
            case 'DOUBLE':
                $this->assertTrue(strval(doubleval($value)) == strval($value), $name . ': is not a double (' . $displayErrorValue . ')');
                break;

            case 'ARRAY':
                $this->assertTrue(is_array($value), $name . ': is not an array (' . $displayErrorValue . ')');
                break;

            case 'STRING':
                $this->assertTrue(is_string($value), $name . ': is not a string (' . $displayErrorValue . ')');
                break;

            case 'BOOLEAN':
                $this->assertTrue(is_bool($value), $name . ': is not a boolean (' . $displayErrorValue . ')');
                break;

            case 'REGEX':
                $matches = false;
                preg_match($parameter, $value, $matches);

                $this->assertTrue(is_array($matches) && count($matches) > 0, $name . ':does not match the regex : ' . $parameter . ' (' . $displayErrorValue . ')');
                break;

            case 'EMAIL':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_EMAIL) !== false, $name . ': is not an email (' . $displayErrorValue . ')');
                break;

            case 'URL':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_URL) !== false, $name . ': is not an url (' . $displayErrorValue . ')');
                break;

            case 'IP':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_IP) !== false, $name . ': is not an ip (' . $displayErrorValue . ')');
                break;

            case 'DATE':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_REGEXP, array(
                    "options" => array(
                        "regexp" => '/(\d{4})-(\d{2})-(\d{2})/'
                    )
                )) !== false, $name . ': is not a date (' . $displayErrorValue . ')');
                break;

            case 'DATETIME':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_REGEXP, array(
                    "options" => array(
                        "regexp" => '(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})'
                    )
                )) !== false, $name . ': is not a datetime (' . $displayErrorValue . ')');
                break;

            default:
                $this->assertTrue(false, 'Format ' . $format . ' not found');
                break;
        }
    }
}
