<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Plus activity
 *
 * @package    Eden
 * @category   google
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Google_Plus_Activity extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_ACTIVITY_LIST		= 'https://www.googleapis.com/plus/v1/people/%s/activities/%s';
	const URL_ACTIVITY_GET		= 'https://www.googleapis.com/plus/v1/activities/%s';
	const URL_ACTIVITY_SEARCH	= 'https://www.googleapis.com/plus/v1/activities';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_pageToken		= NULL;
	protected $_maxResults		= NULL;
	protected $_orderBy			= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token 	= $token;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Set page token
	 *
	 * @param string
	 * @return array
	 */
	public function setPageToken($pageToken) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_pageToken = $pageToken;
		
		return $this;
	}
	
	/**
	 * The maximum number of people to include in the response, 
	 * used for paging.
	 *
	 * @param integer
	 * @return this
	 */
	public function setMaxResults($maxResults) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_maxResults = $maxResults;
		
		return $this;
	}
	
	/**
	 * Sort activities by relevance to the user, most relevant first.
	 *
	 * @return this
	 */
	public function orderByBest() {
		$this->_orderBy = 'best';
		
		return $this;
	}
	
	/**
	 * Sort activities by published date, most recent first.
	 *
	 * @return this
	 */
	public function orderByRecent() {
		$this->_orderBy = 'recent';
		
		return $this;
	}
	
	/**
	 * Get activity list of user
	 *
	 * @param string
	 * @return array
	 */
	 public function getList($userId = self::ME) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		//populate fields
		$query = array(	
			self::MAX_RESULTS	=> $this->_maxResults,	//optional
			SELF::PAGE_TOKEN	=> $this->_pageToken);	//optional
		
		return $this->_getResponse(sprintf(self::URL_ACTIVITY_LIST, $userId, self::PUBLIC_DATA), $query);
	 }
	
	/**
	 * Get an activity
	 *
	 * @param string
	 * @return array
	 */
	 public function getSpecific($activityId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		 
		 return $this->_getResponse(sprintf(self::URL_ACTIVITY_GET, $activityId));
	 } 
	 
	/**
	 * Search public activities
	 *
	 * @param string|integer
	 * @return array
	 */
	public function search($queryString) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		
		//populate fields
		$query = array(
			self::QUERY_STRING	=> $queryString,
			self::PAGE_TOKEN	=> $this->_pageToken,	//optional
			self::MAX_RESULTS	=> $this->_maxResults,	//optional
			self::ORDER			=> $this->_orderBy);	//optional
		
		return $this->_getResponse(self::URL_ACTIVITY_SEARCH, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}