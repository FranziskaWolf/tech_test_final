<?php declare( strict_types=1 ); # -*- coding: utf-8 -*-

namespace Inpsyde\GoogleTagManager;

use Inpsyde\GoogleTagManager\Core\BootableProviderInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * @package Inpsyde\GoogleTagManager
 */
final class GoogleTagManager extends Container {

	const ACTION_BOOT = 'inpsyde-google-tag-manager.boot';

	/**
	 * @var bool
	 */
	private $booted = FALSE;

	/**
	 * @var array
	 */
	private $providers = [];

	/**
	 * Registers a service provider.
	 *
	 * @param ServiceProviderInterface $provider A ServiceProviderInterface instance
	 * @param array                    $values   An array of values that customizes the provider
	 *
	 * @return GoogleTagManager
	 */
	public function register( ServiceProviderInterface $provider, array $values = [] ) {

		$this->providers[] = $provider;
		$provider->register( $this );

		foreach ( $values as $key => $value ) {
			$this[ $key ] = $value;
		}

		return $this;
	}

	/**
	 * Boots all service providers.
	 *
	 * This method is automatically called by handle(), but you can use it
	 * to boot all service providers when not handling a request.
	 *
	 * @return bool
	 */
	public function boot(): bool {

		if ( $this->booted ) {
			return FALSE;
		}
		$this->booted = TRUE;

		/**
		 * Fires right before GoogleTagManager gets bootstrapped.
		 *
		 * Hook here to register custom service providers.
		 *
		 * @param GoogleTagManager
		 */
		\do_action( self::ACTION_BOOT, $this );

		foreach ( $this->providers as $provider ) {
			if ( $provider instanceof BootableProviderInterface ) {
				$provider->boot( $this );
			}
		}

		return TRUE;
	}

	/**
	 * @return array
	 */
	public function providers(): array {

		return $this->providers;
	}

}