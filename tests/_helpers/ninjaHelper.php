<?php
namespace Codeception\Module;

// here you can define custom functions for ninja
use Codeception\Util\Debug;


class NinjaHelper extends \Codeception\Module
{

    protected $path = 'api/v1/';
    private $token = '';

    public function login ($username, $password)
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

    public function call ($path, $method = 'GET', array $params = array(), $httpCode = 200, $isJson = TRUE)
    {
        $rest = $this->getModule('REST');

        $method = 'send' . ucfirst($method);

        $rest->haveHttpHeader('X-Auth-Token', $this->token);
        $rest->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');

        $rest->{$method}($this->path . $path, $params);
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
    public function validateResponseWithClosure (\Closure $closure, $jsonDecode = TRUE)
    {
        $rest     = $this->getModule('REST');
        $response = $rest->grabResponse();
        if ($jsonDecode) {
            $response = json_decode($response, TRUE);
        }

        $this->debug($response);

        $closure($this, $response);
    }

    public function isType ($name, $format, $value, $parameter = '', $allowEmpty = FALSE, $allowNull = FALSE)
    {

        if (!$allowNull) {
            $this->assertTrue(!is_null($value), $name . ': can not be null');
        }

        if (!$allowEmpty) {
            $this->assertTrue(!empty($value) || $value === 0 || $value === FALSE, $name . ': can not be empty');
        }

        $displayErrorValue = var_export($value, TRUE);

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
                $matches = FALSE;
                preg_match($parameter, $value, $matches);

                $this->assertTrue(is_array($matches) && count($matches) > 0, $name . ':does not match the regex : ' . $parameter . ' (' . $displayErrorValue . ')');
                break;

            case 'EMAIL':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_EMAIL) !== FALSE, $name . ': is not an email (' . $displayErrorValue . ')');
                break;

            case 'URL':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_URL) !== FALSE, $name . ': is not an url (' . $displayErrorValue . ')');
                break;

            case 'IP':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_IP) !== FALSE, $name . ': is not an ip (' . $displayErrorValue . ')');
                break;

            case 'DATE':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_REGEXP, array(
                        "options" => array(
                            "regexp" => '/(\d{4})-(\d{2})-(\d{2})/'
                        )
                    )) !== FALSE, $name . ': is not a date (' . $displayErrorValue . ')');
                break;

            case 'DATETIME':
                $this->assertTrue(filter_var($value, FILTER_VALIDATE_REGEXP, array(
                        "options" => array(
                            "regexp" => '(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})'
                        )
                    )) !== FALSE, $name . ': is not a datetime (' . $displayErrorValue . ')');
                break;

            default:
                $this->assertTrue(FALSE, 'Format ' . $format . ' not found');
                break;
        }
    }

    public function isEquals ($name, $expected, $value)
    {
        $this->assertEquals($value, $value, 'Expected that ' . print_r($name, TRUE) . ' equals ' . $expected . ' but was ' . print_r($value, TRUE));
    }


    public function isHyperMedia($action, $result)
    {
        $this->isType('_links', 'ARRAY', $result['_links']);
        $this->isType('_links.'.$action, 'ARRAY', $result['_links'][$action]);
        $this->isType('_links.'.$action.'.url', 'URL', $result['_links'][$action]['url']);
        $this->isType('_links.'.$action.'.method', 'STRING', $result['_links'][$action]['method']);
    }

}
