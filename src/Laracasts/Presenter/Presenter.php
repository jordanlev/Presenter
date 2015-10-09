<?php namespace Laracasts\Presenter;

abstract class Presenter implements \Illuminate\Contracts\Routing\UrlRoutable {

	/**
	 * @var mixed
	 */
	protected $entity;

	/**
	 * @param $entity
	 */
	function __construct($entity)
	{
		$this->entity = $entity;
	}

	/**
	 * Allow for property-style retrieval
	 *
	 * @param $property
	 * @return mixed
	 */
	public function __get($property)
	{
		if (method_exists($this, $property))
		{
			return $this->{$property}();
		}

		return $this->entity->{$property};
	}

	/**
	 * Support `isset` for property-style retrieval (needed for Twig templates)
	 * 
	 * @param $property
	 * @return boolean
	 */
	public function __isset($property) {
		return isset($this->entity->{$property});
	}
	
	/**
	 * Allow presenter objects to be passed into the 'route' method and have its id extracted
	 */
	public function getRouteKey() {
		return $this->entity->getAttribute($this->getRouteKeyName());
	}
	public function getRouteKeyName() {
		return $this->entity->getKeyName();
	}
} 
