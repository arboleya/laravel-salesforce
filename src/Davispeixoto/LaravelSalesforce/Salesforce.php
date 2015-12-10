<?php namespace Davispeixoto\LaravelSalesforce;

use Davispeixoto\ForceDotComToolkitForPhp\SforceEnterpriseClient as Client;
use Exception;
use Illuminate\Config\Repository;

/**
 * Class Salesforce
 *
 * Provides an easy binding to Salesforce
 * on Laravel 4 applications through SOAP
 * Data Integration.
 *
 * @package Davispeixoto\LaravelSalesforce
 */
class Salesforce
{

    /**
     * @var \Davispeixoto\ForceDotComToolkitForPhp\SforceEnterpriseClient sfh The Salesforce Handler
     */
    public $sfh;

    /**
     * The constructor.
     *
     * Authenticates into Salesforce according to
     * the provided credentials and WSDL file
     *
     * @param Repository $configExternal
     * @throws SalesforceException
     */
    public function __construct(Repository $configExternal)
    {
        session_start();

        $wsdl = $configExternal->get('laravel-salesforce::wsdl');

        if (empty($wsdl)) {
            $wsdl = __DIR__ . '/Wsdl/enterprise.wsdl.xml';
        }
        
        $username = $configExternal->get('laravel-salesforce::username');
        $password = $configExternal->get('laravel-salesforce::password');
        $token = $configExternal->get('laravel-salesforce::token');

        $this->sfh = new Client();
        $this->sfh->createConnection($wsdl);


        // here we'll first try to activate a previous connection, so subsequent
        // calls will not have to login again and again, keeping SalesForce
        // login limites under control

        try {

            // checks if some other login was cached
            $location_isset = isset($_SESSION['sforce_location']);
            $sessionid_isset = isset($_SESSION['sforce_sessionid']);

            // if yes...
            if($location_isset or $sessionid_isset) {

                // restores previous
                $this->sfh->setEndpoint($_SESSION['sforce_location']);
                $this->sfh->setSessionHeader($_SESSION['sforce_sessionid']);

            // otherwise..
            } else {

                // logs in
                $this->sfh->login($username, $password . $token);

                // and cache login data
                $_SESSION['sforce_location'] = $this->sfh->getLocation();
                $_SESSION['sforce_sessionid'] = $this->sfh->getSessionId();
            }

        } catch (Exception $e) {
            throw new SalesforceException('Exception at Constructor' . $e->getMessage() . "\n\n" . $e->getTraceAsString());
        }
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->sfh, $method), $args);
    }

    /*
     * Debugging functions
     */

    /**
     * @return mixed
     */
    public function dump()
    {
        return print_r($this, true);
    }
}
