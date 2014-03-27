<?php namespace Davispeixoto\LaravelSalesforce;

use Davispeixoto\ForceDotComToolkitForPhp\SforceEnterpriseClient as Client;
use Illuminate\Config\Repository;

class Salesforce {
	protected static $sfh;
	protected static $instance;
	
	public static function factory(Repository $configExternal)
	{
		if (empty(self::$sfh) || empty($self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
			try {
				self::$sfh = new Client();
				self::$sfh->createConnection(__DIR__.'/Wsdl/enterprise.wsdl.xml');
				self::$sfh->login($configExternal->get('username') , $configExternal->get('password') . $configExternal->get('token'));
			} catch (Exception $e) {
				Log::error($e->getMessage());
				throw $e;
			}
		}
		
		return self::$instance;
	}
	
	/*
	 * Enterprise client functions
	 */
	public static function create($sObjects, $type)
	{
		return self::$sfh->create($sObjects, $type);
	}
	
	public static function update($sObjects, $type, $assignment_header = NULL, $mru_header = NULL)
	{
		return self::$sfh->update($sObjects, $type, $assignment_header, $mru_header);
	}
	
	public static function upsert($ext_Id, $sObjects, $type = 'Contact')
	{
		return self::$sfh->upsert($ext_Id, $sObjects, $type);
	}
	
	public function merge($mergeRequest, $type)
	{
		return self::$sfh->merge($mergeRequest, $type);
	}
	
	/*
	 * Base Client functions
	 */
	public static function getNamespace()
	{
		return self::$sfh->getNamespace();
	}
	
	public static function printDebugInfo()
	{
		return self::$sfh->printDebugInfo();
	}
	
	public static function createConnection($wsdl, $proxy = NULL, $soap_options = array())
	{
		return self::$sfh->createConnection($wsdl, $proxy, $soap_options);
	}
	
	public static function setCallOptions($header)
	{
		return self::$sfh->setCallOptions($header);
	}
	
	public static function login($username, $password)
	{
		return self::$sfh->login($username, $password);
	}
	
	public static function logout()
	{
		return self::$sfh->logout();
	}
	
	public static function invalidateSessions()
	{
		return self::$sfh->invalidateSessions();
	}
	
	public static function setEndpoint($location)
	{
		return self::$sfh->setEndpoint($location);
	}
	
	public static function setAssignmentRuleHeader($header)
	{
		return self::$sfh->setAssignmentRuleHeader($header);
	}
	
	public static function setEmailHeader($header)
	{
		return self::$sfh->setEmailHeader($header);
	}
	
	public static function setLoginScopeHeader($header)
	{
		return self::$sfh->setLoginScopeHeader($header);
	}
	
	public static function setMruHeader($header)
	{
		return self::$sfh->setMruHeader($header);
	}
	
	public static function setSessionHeader($id)
	{
		return self::$sfh->setSessionHeader($id);
	}
	
	public static function setUserTerritoryDeleteHeader($header)
	{
		return self::$sfh->setUserTerritoryDeleteHeader($header);
	}
	
	public static function setQueryOptions($header)
	{
		return self::$sfh->setQueryOptions($header);
	}
	
	public static function setAllowFieldTruncationHeader($header)
	{
		return self::$sfh->setAllowFieldTruncationHeader($header);
	}
	
	public static function setLocaleOptions($header)
	{
		return self::$sfh->setLocaleOptions($header);
	}
	
	public static function setPackageVersionHeader($header)
	{
		return self::$sfh->setPackageVersionHeader($header);
	}
	
	public static function getSessionId()
	{
		return self::$sfh->getSessionId();
	}
	
	public static function getLocation()
	{
		return self::$sfh->getLocation();
	}
	
	public static function getConnection()
	{
		return self::$sfh->getConnection();
	}
	
	public static function getFunctions()
	{
		return self::$sfh->getFunctions();
	}
	
	public static function getTypes()
	{
		return self::$sfh->getTypes();
	}
	
	public static function getLastRequest()
	{
		return self::$sfh->getLastRequest();
	}
	
	public static function getLastRequestHeaders()
	{
		return self::$sfh->getLastRequestHeaders();
	}
	
	public static function getLastResponse()
	{
		return self::$sfh->getLastResponse();
	}
	
	public static function getLastResponseHeaders()
	{
		return self::$sfh->getLastResponseHeaders();
	}
	
	public static function sendSingleEmail($request)
	{
		return self::$sfh->sendSingleEmail($request);
	}
	
	public static function sendMassEmail($request)
	{
		return self::$sfh->sendMassEmail($request);
	}
	
	public static function convertLead($leadConverts)
	{
		return self::$sfh->convertLead($leadConverts);
	}
	
	public static function delete($ids)
	{
		return self::$sfh->delete($ids);
	}
	
	public static function undelete($ids)
	{
		return self::$sfh->undelete($ids);
	}
	
	public static function emptyRecycleBin($ids)
	{
		return self::$sfh->emptyRecycleBin($ids);
	}
	
	public static function processSubmitRequest($processRequestArray)
	{
		return self::$sfh->processSubmitRequest($processRequestArray);
	}
	
	public static function processWorkitemRequest($processRequestArray)
	{
		return self::$sfh->processWorkitemRequest($processRequestArray);
	}
	
	public static function describeGlobal()
	{
		return self::$sfh->describeGlobal();
	}
	
	public static function describeLayout($type, array $recordTypeIds = NULL)
	{
		return self::$sfh->describeLayout($type, $recordTypeIds);
	}
	
	public static function describeSObject($type)
	{
		return self::$sfh->describeSObject($type);
	}
	
	public static function describeSObjects($arrayOfTypes)
	{
		return self::$sfh->describeSObjects($arrayOfTypes);
	}
	
	public static function describeTabs()
	{
		return self::$sfh->describeTabs();
	}
	
	public static function describeDataCategoryGroups($sObjectType)
	{
		return self::$sfh->describeDataCategoryGroups($sObjectType);
	}
	
	public static function describeDataCategoryGroupStructures(array $pairs, $topCategoriesOnly)
	{
		return self::$sfh->describeDataCategoryGroupStructures($pairs, $topCategoriesOnly);
	}
	
	public static function getDeleted($type, $startDate, $endDate)
	{
		return self::$sfh->getDeleted($type, $startDate, $endDate);
	}
	
	public static function getUpdated($type, $startDate, $endDate)
	{
		return self::$sfh->getUpdated($type, $startDate, $endDate);
	}
	
	public static function query($query)
	{
		return self::$sfh->query($query);
	}
	
	public static function queryMore($queryLocator)
	{
		return self::$sfh->queryMore($queryLocator);
	}
	
	public static function queryAll($query, $queryOptions = NULL)
	{
		return self::$sfh->queryAll($query, $queryOptions);
	}
	
	public static function retrieve($fieldList, $sObjectType, $ids)
	{
		return self::$sfh->retrieve($fieldList, $sObjectType, $ids);
	}
	
	public static function search($searchString)
	{
		return self::$sfh->search($searchString);
	}
	
	public static function getServerTimestamp()
	{
		return self::$sfh->getServerTimestamp();
	}
	
	public static function getUserInfo()
	{
		return self::$sfh->getUserInfo();
	}
	
	public static function setPassword($userId, $password)
	{
		return self::$sfh->setPassword($userId, $password);
	}
	
	public static function resetPassword($userId)
	{
		return self::$sfh->resetPassword($userId);
	}
}
?>
