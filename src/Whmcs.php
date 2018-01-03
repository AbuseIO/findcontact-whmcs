<?php

namespace AbuseIO\FindContact;

use AbuseIO\Models\Account;
use AbuseIO\Models\Contact;
use Gufy\WhmcsPhp\Config;
use Gufy\WhmcsPhp\Whmcs as Finder;
use Log;

/**
 * Class Whmcs
 * @package AbuseIO\FindContact
 */
class Whmcs
{
    private $finder;

    /**
     * Whmcs constructor.
     */
    public function __construct()
    {
        $this->initFinder();
    }


    /**
     * Get the abuse email address registered for this ip.
     * @param  string $ip IPv4 Address
     * @return mixed Returns contact object or false.
     */
    public function getContactByIp($ip)
    {
        $result = false;

        try {
            $result = $this->_getContactWithData(
                $this->_getContactDataForIp($ip)
            );
        } catch (\Exception $e) {
            Log::debug("Error while talking to the Whmcs Stat API : " . $e->getMessage());
        }
        return $result;
    }

    /**
     * Get the email address registered for this domain.
     * @param  string $domain Domain name
     * @return mixed Returns contact object or false.
     */
    public function getContactByDomain($domain)
    {
        $result = false;

        try {
            $result = $this->getContactWithData(
                $this->_getContactDataForDomain($domain)
            );
        } catch (\Exception $e) {
            Log::debug("Error while talking to the Whmcs Stat API : " . $e->getMessage());
        }
        return $result;
    }

    /**
     * Get the email address registered for this ip.
     * @param  string $id ID/Contact reference
     * @return mixed Returns contact object or false.
     */
    public function getContactById($id)
    {
        return false;
    }

    /**
     * search the ip using the plesk api and if found, return the abuse mailbox and network name
     *
     * @param $ip
     * @return array
     */
    private function _getContactDataForIp($ip)
    {
        return false;
    }

    /**
     * search the domain using the plesk api and if found, return the abuse mailbox and network name
     *
     * @param $ip
     * @return array
     */
    private function _getContactDataForDomain($domain)
    {
        return $this->getContactDataForQuery('DomainWhois', ['domain' => $domain]);
    }

    /**
     * @throws \Exception
     */
    private function initFinder()
    {
        $baseUrl = config("Findcontact.findcontact-whmcs.base_url");
        $username = config("Findcontact.findcontact-whmcs.username");
        $password = config("Findcontact.findcontact-whmcs.password");

        if (empty($baseUrl)) {
            throw new \Exception('please set the base_url in the config of whmcs findcontact');
        }

        if (empty($username)) {
            throw new \Exception('please set the username in the config of whmcs findcontact');
        }

        if (empty($password)) {
            throw new \Exception('please set the password in th config of whmcs findcontact');
        }

        $config = new Config([
            'baseUrl'  => $baseUrl,
            'username' => 'your_username',
            'password' => 'your_password'
        ]);


        $this->finder = new Finder($config);
    }

    /**
     * @param $data
     * @return Contact
     */
    private function getContactWithData($data)
    {
        // construct new contact
        $result = new Contact();
        $result->name = $data['name'];
        $result->reference = $data['name'];
        $result->email = $data['email'];
        $result->enabled = true;
        $result->auto_notify = config("Findcontact.findcontact-whmcs.auto_notify");
        $result->account_id = Account::getSystemAccount()->id;
        $result->api_host = '';
        return $result;
    }

    private function getContactDataForQuery($command, $params)
    {
        $data = [];
        $name = null;
        $email = null;

        $userInfo = $this->finder->execute($command, $params);

        /*
         *
         * {
         *
         *    "result": "success",
         *    "Registrant": "{\"First_Name\":\"Test\",\"Last_Name\":\"Client\",\"Organisation_Name\":null,\"Job_Title\":null,\"Email\":\"test@testemail.com\",\"Address_1\":\"123 Test Street\",\"Address_2\":\"\",\"City\":\"Test\",\"State\":\"Test\",\"Postcode\":\"TE5 5ST\",\"Country\":GB,\"Phone\":\"+44.1234567890\"}"
         * }
         */


        // only create a result data if both email and name are set
        if (!is_null($userInfo->Registrant->Client) && !is_null($userInfo->Registrant->Email)) {
            $data['name'] = $userInfo->Registrant->Client;
            $data['email'] = $userInfo->Registrant->Email;
        }

        return $data;
    }
}
