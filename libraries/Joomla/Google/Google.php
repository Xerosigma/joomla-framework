<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Google
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Google;

defined('JPATH_PLATFORM') or die;

use Joomla\Registry\Registry;

/**
 * Joomla Platform class for interacting with the Google APIs.
 *
 * @property-read  Data   $data    Google API object for data.
 * @property-read  Embed  $embed   Google API object for embed generation.
 *
 * @package     Joomla.Platform
 * @subpackage  Google
 * @since       12.3
 */
class Google
{
	/**
	 * @var    Registry  Options for the Google object.
	 * @since  12.3
	 */
	protected $options;

	/**
	 * @var    Auth  The authentication client object to use in sending authenticated HTTP requests.
	 * @since  12.3
	 */
	protected $auth;

	/**
	 * @var    Data  Google API object for data request.
	 * @since  12.3
	 */
	protected $data;

	/**
	 * @var    Embed  Google API object for embed generation.
	 * @since  12.3
	 */
	protected $embed;

	/**
	 * Constructor.
	 *
	 * @param   Registry  $options  Google options object.
	 * @param   Auth      $auth     The authentication client object.
	 *
	 * @since   12.3
	 */
	public function __construct(Registry $options = null, Auth $auth = null)
	{
		$this->options = isset($options) ? $options : new Registry;
		$this->auth  = isset($auth) ? $auth : new Auth\Oauth2($this->options);
	}

	/**
	 * Method to create Data objects
	 *
	 * @param   string    $name     Name of property to retrieve
	 * @param   Registry  $options  Google options object.
	 * @param   Auth      $auth     The authentication client object.
	 *
	 * @return  Data  Google data API object.
	 *
	 * @since   12.3
	 */
	public function data($name, $options = null, $auth = null)
	{
		if ($this->options && !$options)
		{
			$options = $this->options;
		}

		if ($this->auth && !$auth)
		{
			$auth = $this->auth;
		}

		switch (strtolower($name))
		{
			case 'plus':
				return new Data\Plus($options, $auth);

			case 'picasa':
				return new Data\Picasa($options, $auth);

			case 'adsense':
				return new Data\Adsense($options, $auth);

			case 'calendar':
				return new Data\Calendar($options, $auth);

			default:
				return null;
		}
	}

	/**
	 * Method to create Embed objects
	 *
	 * @param   string    $name     Name of property to retrieve
	 * @param   Registry  $options  Google options object.
	 *
	 * @return  Embed  Google embed API object.
	 *
	 * @since   12.3
	 */
	public function embed($name, $options = null)
	{
		if ($this->options && !$options)
		{
			$options = $this->options;
		}

		switch (strtolower($name))
		{
			case 'maps':
				return new Embed\Maps($options);

			case 'analytics':
				return new Embed\Analytics($options);

			default:
				return null;
		}
	}

	/**
	 * Get an option from the Google instance.
	 *
	 * @param   string  $key  The name of the option to get.
	 *
	 * @return  mixed  The option value.
	 *
	 * @since   12.3
	 */
	public function getOption($key)
	{
		return $this->options->get($key);
	}

	/**
	 * Set an option for the Google instance.
	 *
	 * @param   string  $key    The name of the option to set.
	 * @param   mixed   $value  The option value to set.
	 *
	 * @return  Google  This object for method chaining.
	 *
	 * @since   12.3
	 */
	public function setOption($key, $value)
	{
		$this->options->set($key, $value);

		return $this;
	}
}
