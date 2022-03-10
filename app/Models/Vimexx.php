<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vimexx extends Model
{
    const URL_API       = 'https://api.vimexx.nl';
    const URL_LOGIN     = 'https://api.vimexx.nl';



    public $class = 'vimexx';
    public $User;
    public $Password;
    public $Setting1;
    public $Setting2;
    public $Setting3;

    public $Error;
    public $Warning;
    public $Success;
    public $Period = 1;
    public $registrarHandles = array();

    public $values          = "";

    public $loginAuthToken  = "";

    public $apiUrl          = "";
    public $apiUrlLogin     = "";
    private $ClassName;

    public $version = [
        'name' => "Vimexx",
        'api_version'     => "1.0 REST API",
        'date'            => "2018-08-23",
        'wefact_version'  => "5.0.0",
        'autorenew'       => true,
        'handle_support'  => true,
        'cancel_direct'   => true,
        'cancel_expire'   => true,
        'dev_logo'		=> 'https://www.vimexx.nl/img/header/navigation-bar/vimexx_logo.svg',
        'dev_author'		=> 'Vimexx B.V.',
        'dev_website'		=> 'https://www.vimexx.nl/',
        'dev_email'		=> 'support@vimexx.nl',
        'domain_support'  => true,
        'ssl_support'   	=> false,
        'dns_management_support' => true,
        'dns_templates_support' => true,
        'dns_records_support' => true,
        'settings' => [
            'setting1'    => [
            'type'      => 'input',
            'label'     => 'Client ID',
            ],
            'setting2'    => [
            'type'      => 'textarea',
            'label'     => 'Client Key',
            ],
            'setting3'    => [
            'type'      => 'input',
            'label'     => 'API Url',
            ]],
        'site_version'   => '.nl'
    ];

    function __construct() {
        $this->ClassName = __CLASS__;

        $this->Error = array();
        $this->Warning = array();
        $this->Success = array();
    }

    /**
     * Get class version information.
     *
     * @return array()
     */
    static function getVersionInformation()
    {
        require_once("3rdparty/domain/vimexx/version.php");
        return $version;
    }

    /**
     *
     */
    function setApi_debug()
    {
        $this->debug = true;
    }

    /**
     * @param $outputresult
     */
    function setApi_output($outputresult)
    {
        $this->output = $outputresult;
    }

    /**
     * get url
     */
    function fetchUrl($baseUrl, $requestUri, $urlType = self::URL_API)
    {
        $baseUrl    = rtrim($baseUrl, '/');
        $requestUri = ltrim($requestUri, '/');

        switch ($urlType) {
            case self::URL_LOGIN:
                return $baseUrl . '/auth/token';
                break;

            default:
            case self::URL_API:
                if ($this->Testmode == '1') {
                    return $this->endpoint = $baseUrl . '/testapi/v1/' . $requestUri;
                } else {
                    return $this->endpoint = $baseUrl . '/api/v1/' . $requestUri;
                }
                break;
        }
    }

    /**
     * Request an API token
     *
     * @return mixed
     */
    function requestAccessToken($authUrl)
    {
        if (!isset($this->loginAuthToken) || empty($this->loginAuthToken)) {
            $data = array(
                'grant_type' => 'password',
                'client_id' => '2004',
                'client_secret' => 'o8Ycs7SdMTaqiKoioMwOcIZ2EEo8AeCPkwJB5zAd',
                'username' => 'bert@vbdesign.be',
                'password' => '3OwBDg3J5suF',
                'scope' => 'whmcs-access',
            );

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'charset' => 'utf-8'
            ]);

            curl_setopt($ch, CURLOPT_URL, 'https://api.vimexx.nl/auth/token');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, "Vimexx-WEFACT api agent at ".gethostname());

            $response     = curl_exec($ch);

            curl_close($ch);

            $responseData = json_decode((string)$response, true);

            if (!empty($responseData)) {
                $this->loginAuthToken = $responseData['access_token'];
            }
        }

        return $this->loginAuthToken;
    }

    /**
     * @param $requesttype
     * @param $request
     * @param array $data
     * @return array|mixed
     */
    function request($requestType, $request, $data = array())
    {
        

        $authUrl    = $this->fetchUrl($this->Setting3, '/auth/token', self::URL_LOGIN);
        $apiUrl     = $this->fetchUrl($this->Setting3, $request, self::URL_API);

        $data = [
            'body'          => $data,
            'version'       => $this->version['wefact_version']
        ];

        $accessToken = $this->requestAccessToken($authUrl);

        if (empty($accessToken)) {
            $error = array();
            $error['error']['message']  = 'Request failed';

            return json_encode($error);
        }

        $ch         = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer ' . $accessToken,
        ]);
       

        curl_setopt($ch, CURLOPT_URL, 'https://api.vimexx.nl/api/v1'.$request);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestType);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Vimexx-WEFACT api agent at ".gethostname());

        $result     = curl_exec($ch);
        
        $httpcode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($this->debug) {
            $debugdata      = array(
                'requesttype'   => $requestType,
                'url'           => $apiUrl,
                'postdata'      => $data,
                'result'        => $result,
                'httpcode'      => $httpcode
            );

            var_dump($debugdata);
        }

        $codes = array('200', '201', '202', '400', '401', '404');

        $result = json_decode($result, true);
        $result['httpcode'] = $httpcode;

        if (in_array($httpcode, $codes)) {
            if (is_array($result['message'])) {
                $result['message'] = implode("<br />", $result['message']);
            }

            return $result;
        } else {
            $error              = array();
            $error['result']    = false;
            $error['message']   = 'Request failed!';
            $error['data']      = [];
            return $error;
        }
    }

    /**
     * Check whether a domain is already regestered or not.
     *
     * @param 	string	 $domain	The name of the domain that needs to be checked.
     * @return 	boolean 			True if free, False if not free, False and $this->Error[] in case of error.
     */
    function checkDomain($domainName)
    {
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('POST', '/wefact/domain/available', [
            'sld' => $domainSplit[0],
            'tld' => $domainSplit[1]
        ]);
        

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        }

        if(isset($response['data']['available']) && $response['data']['available'] == true) {
            return "Beschikbaar";
        } else {
            return "Niet beschikbaar";
        }
    }

    /**
     * Register a new domain
     *
     * @param 	string	$domainName		The domainname that needs to be registered.
     * @param 	array	$nameservers	The nameservers for the new domain.
     * @param 	array	$whois			The customer information for the domain's whois information.
     * @return 	bool					True on success; False otherwise.
     */
    function registerDomain($domainName, $nameservers = array(), $whois = null)
    {
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('POST', '/wefact/domain/register', [
            'sld' => $domainSplit[0],
            'tld' => $domainSplit[1]
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return true;
        }
    }

    /**
     * Transfer a domain to the given user.
     *
     * @param 	string 	$domainName		The demainname that needs to be transfered.
     * @param 	array	$nameservers	The nameservers for the tranfered domain.
     * @param 	array	$whois			The contact information for the new owner, admin, tech and billing contact.
     * @return 	bool					True on success; False otherwise;
     */
    function transferDomain($domainName, $nameservers = array(), $whois = null, $authcode = "")
    {
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('POST', '/wefact/domain/transfer', [
            'sld'   => $domainSplit[0],
            'tld'   => $domainSplit[1],
            'token' => $authcode
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return true;
        }
    }

    /**
     * Extend a domain for several years
     * This function is currently not used in WeFact Hosting
     *
     * @param 	string 	$domainName		The name of the domain you want to extend.
     * @param 	int		$years		    The number of year the domain should be extended.
     * @return	bool				    True if the domain was extended succesfully; False otherwise;
     */
    function extendDomain($domainName, $years)
    {
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('POST', '/wefact/domain/extend', [
            'sld'       => $domainSplit[0],
            'tld'       => $domainSplit[1],
            'years'     => $years,
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return true;
        }
    }

    /**
     * Delete a domain
     *
     * @param 	string $domain		The name of the domain that you want to delete.
     * @param 	string $delType     end|now
     * @return	bool				True if the domain was succesfully removed; False otherwise;
     */
    function deleteDomain($domain, $delType = 'end')
    {
        return $this->setDomainAutoRenew($domain, false);
    }

    /**
     * Get all available information of the given domain
     *
     * @param 	mixed 	$domain		The domain for which the information is requested.
     * @return	array				The array containing all information about the given domain
     */
    function getDomainInformation($domainName)
    {
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('POST', '/wefact/domain', [
            'sld'       => $domainSplit[0],
            'tld'       => $domainSplit[1]
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return array(
                'Domain' => $domainName,
                'Information' => array(
                    'nameservers' => $response['data']['nameservers'],
                    'expiration_date' => $response['data']['expiration_date']
                )
            );
        }
    }

    /**
     * Get a list of all the domains.
     *
     * @param 	string 	$contactHandle		The handle of a contact, so the list could be filtered (usefull for updating domain whois data)
     * @return	array						A list of all domains available in the system.
     */
    function getDomainList($contactHandle = "")
    {
        if ($contactHandle != "") {
            $this->Error[] = 'Het filteren op een contact is momenteel niet mogelijk';
        }

        $response = $this->request('POST', '/wefact/domains');

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        }

        $domainsList = array();

        foreach ($response['data']['domains'] as $domainInformation) {
            $nameservers = array();

            foreach ($domainInformation['nameservers'] as $ns) {
                if (isset($ns['ns1'])) {
                    array_push($nameservers, $ns['ns1']);
                }

                if (isset($ns['ns2'])) {
                    array_push($nameservers, $ns['ns2']);
                }

                if (isset($ns['ns3'])) {
                    array_push($nameservers, $ns['ns3']);
                }
            }

            $whois = new Whois();

            if ($domainInformation['contact']['id'] == null) {
                $whois->ownerHandle         = '1';
            } else {
                $whois->ownerHandle         = $domainInformation['contact']['id'];

                $whois->ownerSex            = 'm';
                $whois->ownerInitials       = $domainInformation['contact']['firstname'];
                $whois->ownerSurName        = $domainInformation['contact']['surname'];
                $whois->ownerCompanyName    = $domainInformation['contact']['company'];

                $whois->ownerAddress        = $domainInformation['contact']['street'].' '.$domainInformation['contact']['housenumber'];
                $whois->ownerZipCode        = $domainInformation['contact']['zipcode'];
                $whois->ownerCity           = $domainInformation['contact']['city'];
                $whois->ownerCountry        = $domainInformation['contact']['country'];

                $whois->ownerPhoneNumber    = $domainInformation['contact']['phone'];
                $whois->ownerEmailAddress   = $domainInformation['contact']['email'];
            }

            $whois->adminHandle = '1';
            $whois->techHandle = '1';

            $domain = array();
            $domain['Domain'] = $domainInformation['domain'];
            $domain['Information'] = array(
                'nameservers' => $nameservers,
                'whois' => $whois,
                'expiration_date' => $domainInformation['expiration_date'],
                'registration_date' => $domainInformation['registration_date']
            );

            array_push($domainsList, $domain);
        }
        return $domainsList;
    }

    /**
     * Change the lock status of the specified domain.
     *
     * @param 	string 	$domainName	The domain to change the lock state for
     * @param 	bool 	$lock		The new lock state (True|False)
     * @return	bool				True is the lock state was changed succesfully
     */
    function lockDomain($domainName, $lock = true)
    {
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('PUT', '/wefact/domain', [
            'sld'   => $domainSplit[0],
            'tld'   => $domainSplit[1],
            'lock'  => $lock
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return true;
        }
    }

    /**
     * Change the autorenew state of the given domain. When autorenew is enabled, the domain will be extended.
     *
     * @param 	string	$domainName		The domainname to change the autorenew setting for,
     * @param 	bool	$autorenew		The new autorenew setting (True = On|False = Off)
     * @return	bool					True when the setting is succesfully changed; False otherwise
     */
    function setDomainAutoRenew($domainName, $autorenew = true)
    {
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('PUT', '/wefact/domain', [
            'sld'           => $domainSplit[0],
            'tld'           => $domainSplit[1],
            'auto_renew'    => $autorenew
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return true;
        }
    }

    /**
     * Update the domain Whois data, but only if no handles are used by the registrar.
     *
     * @param mixed $domain
     * @param mixed $whois
     * @return boolean True if succesfull, false otherwise
     */
    function updateDomainWhois($domainName, $whois)
    {
        $domainSplit = explode('.', $domainName, 2);

        if ($domainSplit[1] == 'be') {
            $this->Error[] = 'Voor een .be domeinnaam moet de EPP code eerst ingevuld zijn. Deze functie wordt momenteel nog niet ondersteund.';
            return false;
        } else {
            $registrantId = $whois->{'ownerRegistrarHandle'};

            if (empty($registrantId)) {
                $registrantId = $this->createContact($whois);
            }

            $adminId = $whois->{'adminRegistrarHandle'};

            if (empty($adminId)) {
                $adminId = $this->createContact($whois, HANDLE_ADMIN);
            }

            $techId = $whois->{'techRegistrarHandle'};

            if (empty($techId)) {
                $techId = $this->createContact($whois, HANDLE_TECH);
            }

            $response = $this->request('PUT', '/wefact/contacts', [
                'sld'               => $domainSplit[0],
                'tld'               => $domainSplit[1],
                'contacts'          => [
                    'registrant'    => $registrantId,
                    'admin'         => $adminId,
                    'tech'          => $techId
                ]
            ]);

            if (!$response['result']) {
                $this->Error[] = $response['message'];
                return false;
            } else {
                $this->registrarHandles['owner'] = $registrantId;
                return true;
            }
        }
    }

    /**
     * get domain whois handles
     *
     * @param mixed $domain
     * @return array with handles
     */
    function getDomainWhois($domainName){
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('PUT', '/wefact/domain', [
            'sld'   => $domainSplit[0],
            'tld'   => $domainSplit[1]
        ]);

        if(!$response['result'])
        {
            $this->Error[] = $response['error']['message'];
            return false;
        }else{

            $contacts = array();

            $contacts['ownerHandle']    = '1';
            $contacts['adminHandle'] 	= '1';
            $contacts['techHandle'] 	= '1';

            return $contacts;
        }
    }

    /**
     * Get EPP code/token
     *
     * @param $domainName
     * @return bool|string
     */
    function getToken($domainName)
    {
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('POST', '/wefact/domain/token', [
            'sld'       => $domainSplit[0],
            'tld'       => $domainSplit[1],
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            if ($domainSplit[1] == 'be') {
                return 'EPP code will be sent by email';
            } else {
                return $response['data'];
            }
        }
    }

    /**
     * Create a new whois contact
     *
     * @param 	array		 $whois		The whois information for the new contact.
     * @param 	mixed 	 	 $type		The contact type. This is only used to access the right data in the $whois object.
     * @return	bool					Handle when the new contact was created succesfully; False otherwise.
     */
    function createContact($whois, $type = HANDLE_OWNER) {

        // Determine which contact type should be found
        switch($type) {
            case HANDLE_OWNER:	$prefix = "owner"; 	break;
            case HANDLE_ADMIN:	$prefix = "admin"; 	break;
            case HANDLE_TECH:	$prefix = "tech"; 	break;
            default:			$prefix = ""; 		break;

        }

        $whois->getParam($prefix,'Address');

        $countryCode = $whois->{$prefix.'Country'};

        if(strlen($countryCode) > 2)
        {
            $countryCode = str_replace('EU-', '', $countryCode);
        }

        if(strlen($countryCode) != 2)
        {
            $countryCode = 'NL';
        }

        $sStreet = $whois->{$prefix.'Address'};
        $iNumber = filter_var($sStreet, FILTER_SANITIZE_NUMBER_INT);
        $sStreet = str_replace($iNumber, '', $sStreet);
        $companyName = $whois->{$prefix.'CompanyName'};

        // registrant information
        $contactDetails = array();
        $contactDetails['company'] = $companyName;
        $contactDetails['company_or_private'] = (!empty($companyName)) ? 'company' : 'private';
        $contactDetails['company_type'] = $whois->{$prefix.'LegalForm'};
        $contactDetails['firstname'] = $whois->{$prefix.'Initials'};
        $contactDetails['lastname'] =  $whois->{$prefix.'SurName'};
        $contactDetails['email'] = $whois->{$prefix.'EmailAddress'};
        $contactDetails['phone'] = $whois->{$prefix.'PhoneNumber'};
        $contactDetails['fax'] = $whois->{$prefix.'FaxNumber'};
        $contactDetails['street'] = $sStreet;
        $contactDetails['housenumber'] = $iNumber;
        $contactDetails['number_addition'] = $whois->{$prefix.'StreetNumberAddon'};
        $contactDetails['zipcode'] = $whois->{$prefix.'ZipCode'};
        $contactDetails['city'] = $whois->{$prefix.'City'};
        $contactDetails['country'] = $countryCode;

        $response = $this->request('PUT', '/wefact/contact', [
            'contact' => $contactDetails
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return $response['data']['contact_id'];
        }
    }

    /**
     *
     * Update the whois information for the given contact person.
     *
     * @param string $handle	The handle of the contact to be changed.
     * @param array $whois The new whois information for the given contact.
     * @param mixed $type The of contact. This is used to access the right fields in the whois array
     * @return
     */
    function updateContact($handle, $whois, $type = HANDLE_OWNER)
    {
        switch($type) {
            case HANDLE_OWNER:	$prefix = "owner"; 	break;
            case HANDLE_ADMIN:	$prefix = "admin"; 	break;
            case HANDLE_TECH:	$prefix = "tech"; 	break;
            default:			$prefix = ""; 		break;

        }

        $whois->getParam($prefix,'Address');

        $countryCode = $whois->{$prefix.'Country'};

        if (strlen($countryCode) > 2) {
            $countryCode = str_replace('EU-', '', $countryCode);
        }

        if (strlen($countryCode) != 2) {
            $countryCode = 'NL';
        }

        $sStreet = $whois->{$prefix.'Address'};
        $iNumber = filter_var($sStreet, FILTER_SANITIZE_NUMBER_INT);
        $sStreet = str_replace($iNumber, '', $sStreet);

        $contact = [
            'id'            => $handle,
            'firstname'     => $whois->{$prefix.'Initials'},
            'lastname'      => $whois->{$prefix.'SurName'},
            'company'       => $whois->{$prefix.'CompanyName'},
            'email'         => $whois->{$prefix.'EmailAddress'},
            'street'        => $sStreet,
            'housenumber'   => $iNumber,
            'city'          => $whois->{$prefix.'City'},
            'zipcode'       => $whois->{$prefix.'ZipCode'},
            'country'       => $countryCode,
            'phone'         => $whois->{$prefix.'PhoneNumber'},
            'fax'           => $whois->{$prefix.'FaxNumber'},
        ];

        /*        if (isset($requestParams['extra_options']) && count($requestParams['extra_options'])) {
                    $contact = array_merge($contact, $requestParams['extra_options']);
                }*/

        $response = $this->request('PUT', '/wefact/contact', [
            'contact'       => $contact,
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return $handle;
        }
    }

    /**
     * delete a contact
     *
     * @param(array) information availabe about the requested contact.
     * @return bool
     */
    function deleteContact ($handle)
    {
        $response = $this->request('DELETE', '/contact', [
            'contact_id' => $handle
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get information availabe of the requested contact.
     *
     * @param string $handle The handle of the contact to request.
     * @return array Information available about the requested contact.
     */
    function getContact($handle)
    {
        $response = $this->request('POST', '/wefact/contact', [
            'contact_id' => $handle
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        }else{
            $whois 	= new whois();

            // The contact is found
            $whois->ownerCompanyName 	= $response['contact']['company'];
            $whois->ownerInitials		= $response['contact']['firstname'];
            $whois->ownerSurName		= $response['contact']['surname'];
            $whois->ownerAddress 		= $response['contact']['street'].' '.$response['contact']['number'];
            $whois->ownerZipCode 		= $response['contact']['zipcode'];
            $whois->ownerCity 			= $response['contact']['city'];
            $whois->ownerCountry 		= $response['contact']['country'];
            $whois->ownerPhoneNumber	= $response['contact']['phone'];
            $whois->ownerEmailAddress	= $response['contact']['email'];

            return $whois;
        }
    }


    /**
     * Get the handle of a contact.
     *
     * @param array $whois The whois information of contact
     * @param string $type The type of person. This is used to access the right fields in the whois object.
     * @return string handle of the requested contact; False if the contact could not be found.
     */
    function getContactHandle($whois = array(), $type = HANDLE_OWNER) {

        // Determine which contact type should be found
        switch($type) {
            case HANDLE_OWNER:  $prefix = "owner";  break;
            case HANDLE_ADMIN:  $prefix = "admin";  break;
            case HANDLE_TECH:   $prefix = "tech";   break;
            default:            $prefix = "";       break;
        }

        $response = $this->request('POST', '/wefact/contact', [
            'contact_id' => $prefix
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get a list of contact handles available
     *
     * @param string $surname Surname to limit the number of records in the list.
     * @return array List of all contact matching the $surname search criteria.
     */
    function getContactList($surname = "") {
        $response = $this->request('POST', '/wefact/contacts');

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            $contactsList = array();

            foreach($response['data'] as $contact) {
                $contactHandle = array();
                $contactHandle['Handle'] = $contact['id'];
                $contactHandle['Sex'] = ''; // Not provided in Versio API
                $contactHandle['Initials'] = $contact['firstname'];
                $contactHandle['SurName'] = $contact['lastname'];
                $contactHandle['CompanyName'] = $contact['company'];

                $contactHandle['Address'] = $contact['street'].' '.$contact['housenumber'];
                $contactHandle['ZipCode'] = $contact['zipcode'];
                $contactHandle['City'] = $contact['city'];
                $contactHandle['Country'] = $contact['country'];

                $contactHandle['PhoneNumber'] = $contact['phone'];
                $contactHandle['EmailAddress'] = $contact['email'];

                $contactsList[] = $contactHandle;
            }
            return $contactsList;
        }
    }
    /**
     * Update the nameservers for the given domain.
     *
     * @param string $domain The domain to be changed.
     * @param array $nameservers The new set of nameservers.
     * @return bool True if the update was succesfull; False otherwise;
     */
    function updateNameServers($domainName, $nameserverList = array())
    {
        $domainSplit = explode('.', $domainName, 2);

        $nameservers = array();

        if (!$nameserverList['ns1'] == null) {
            $nameservers[] = array('ns' => $nameserverList['ns1'], 'nsip' => '');
        }

        if (!$nameserverList['ns2'] == null) {
            $nameservers[] = array('ns' => $nameserverList['ns2'], 'nsip' => '');
        }

        if (!$nameserverList['ns3'] == null) {
            $nameservers[] = array('ns' => $nameserverList['ns3'], 'nsip' => '');
        }

        $response = $this->request('PUT', '/wefact/nameservers', [
            'sld'           => $domainSplit[0],
            'tld'           => $domainSplit[1],
            'nameservers'   => $nameservers,
            'name'          => 'wefact-' . $domainSplit[0] . '.' . $domainSplit[1]
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return true;
        }
    }

    /**
     * Optional function to check the status of a registration or transfer, see appendix B of documentation
     *
     * @param mixed $domain
     * @param mixed $pendingInfo
     * @return
     */
    function doPending($domain, $pendingInfo){

        $response = $this->request('GET', '/domains/'.$domain);

        if($response['error'])
        {
            $this->Error[] = $response['error']['message'];
            return 'pending';
        }else{

            switch($response['domainInfo']['status']){
                case 'OK':
                    $this->Success[] = "Domeinnaam '".$domain."' is succesvol aangevraagd.";
                    return true;
                    break;

                case 'PENDING':
                    return 'pending';
                    break;

                case 'INACTIVE':
                    $this->Error[] = "Domeinnaam '".$domain."' aangevraag is mislukt.";
                    return false;
                    break;

                case 'PENDING_TRANSFER':
                    return 'pending';
                    break;

                default:
                    return 'pending';
            }
        }
    }

    /**
     * Get the DNS zone of a domain
     *
     * @param $domainName
     * @return array|bool
     */
    function getDNSZone($domainName)
    {
        $domainSplit = explode('.', $domainName, 2);

        $response = $this->request('POST', '/wefact/dns', [
            'sld'       => $domainSplit[0],
            'tld'       => $domainSplit[1],
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            $record_type = 'records';
            $i = 0;
            $dns_zone = array();

            foreach($response['data']['dns_records'] as $records) {
                $dns_zone[$record_type][$i]['name']     = $records['name'];
                $dns_zone[$record_type][$i]['type']     = $records['type'];
                $dns_zone[$record_type][$i]['value']    = $records['content'];
                $dns_zone[$record_type][$i]['priority'] = $records['prio'];
                $dns_zone[$record_type][$i]['ttl']      = 1440;

                $i++;
            }

            # geef waarde terug
            return $dns_zone;
        }
    }

    /**
     * save a dns zone
     *
     * @param $domainName
     * @param $dnsZone
     * @return bool
     */
    function saveDNSZone($domainName, $dnsZone)
    {
        $domainSplit    = explode('.', $domainName, 2);
        $dnsRecords     = array();

        foreach($dnsZone['records'] as $records) {
            if (in_array(strtoupper($records['type']), ['SPF', 'SOA', 'NS'])) {
                continue;
            }

            if ($records['name'] == null) {
                $name = $domainName . '.';
            } else {
                $name = $records['name'] . '.' . $domainName . '.';
            }

            if ($records['priority'] == '') {
                $records['priority'] = 0;
            }

            $dnsRecords[] = array(
                'type'      => $records['type'],
                'name'      => $name,
                'content'   => $records['value'],
                'prio'      => $records['priority'],
                'ttl'       => $records['ttl']
            );
        }

        $response = $this->request('PUT', '/wefact/dns', [
            'sld'           => $domainSplit[0],
            'tld'           => $domainSplit[1],
            'dns_records'   => $dnsRecords
        ]);

        if (!$response['result']) {
            $this->Error[] = $response['message'];
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get all the dns templates
     *
     * @return array|bool
     */
    function getDNSTemplates(){

        $response = $this->request('GET', '/dnstemplates');

        if($response['error'])
        {
            $this->Error[] = $response['error']['message'];
            return false;
        }else{

            $dns_templates = [];
            $teller = 1;
            foreach($response['dnstemplatesList'] as $template)
            {
                $dns_templates['templates'][$teller]['id'] = $template['id'];
                $dns_templates['templates'][$teller]['name'] = $template['name'];;
                $teller++;
            }
            return $dns_templates;
        }
    }

    /**
     * getSyncData()
     * Check domain information for one or more domains
     * @param mixed $list_domains	Array with list of domains. Key is domain, value must be filled.
     * @return mixed $list_domains
     */
    function getSyncData($domainList)
    {
        $maxDomainToCheck   = 10;
        $checkedDomains     = 0;

        // Check domain one for one
        foreach($domainList as $domainName => $value)
        {
            $domainSplit = explode('.', $domainName, 2);

            $response = $this->request('POST', '/wefact/domain', [
                'sld'       => $domainSplit[0],
                'tld'       => $domainSplit[1],
            ]);

            if(!$response['result']) {
                $domainList[$domainName]['Status']    = 'error';
                $domainList[$domainName]['Error_msg'] = $response['message'];

                continue;
            }

            // extend the list_domains array with data from the registrar
            $domainList[$domainName]['Information']['nameservers']        = $response['data']['nameservers'];
            $domainList[$domainName]['Information']['expiration_date']    = $response['data']['expiration_date'];
            $domainList[$domainName]['Information']['auto_renew']         = "" . (integer)$response['data']['auto_extend'];
            $domainList[$domainName]['Information']['lock']         	  = false;
            $domainList[$domainName]['Status']                            = 'success';

            // Increment counter
            $checkedDomains++;

            // Stop loop after max domains
            if ($checkedDomains > $maxDomainToCheck) {
                break;
            }
        }

        // Return list  (domains which aren't completed with data, will be synced by a next cronjob)
        return $domainList;
    }
}
