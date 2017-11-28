<?php # -*- coding: utf-8 -*-

namespace Inpsyde\GoogleTagManager\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ElementNotFoundException;
use PaulGibbs\WordpressBehatExtension\Context\RawWordpressContext;

/**
 * Class PluginContext
 *
 * @package Inpsyde\GoogleTagManager\Tests\Behat
 */
class PluginContext extends RawWordpressContext implements Context {

	/**
	 * @Then I am on the plugins-page
	 */
	public function iAmOnThePluginsPage() {

		$this->visitPath( '/wp-admin/plugins.php' );
	}

	/**
	 * @Then /^I activate the plugin "(?P<pluginSlug>[^"]+)"$/
	 */
	public function iActivateThePlugin( $pluginSlug ) {

		$page = $this->getSession()
			->getPage();

		$element = sprintf(
			"[data-slug='%s'] .activate a",
			$pluginSlug
		);

		$findName = $page->find( "css", $element );
		if ( ! $findName ) {
			throw new ElementNotFoundException( $this->getSession(), 'anchor', 'data-slug', $element );
		} else {
			$findName->click();
		}
	}

	/**
	 * @Then /^I deactivate the plugin "(?P<pluginSlug>[^"]+)"$/
	 */
	public function iDeactivateThePlugin( $pluginSlug ) {

		$page = $this->getSession()
			->getPage();

		$element = sprintf(
			"[data-slug='%s'] .deactivate a",
			$pluginSlug
		);

		$findName = $page->find( "css", $element );
		if ( ! $findName ) {
			throw new ElementNotFoundException( $this->getSession(), 'anchor', 'data-slug', $element );
		} else {
			$findName->click();
		}
	}

	/**
	 * @Given /^The plugin "(?P<pluginSlug>[^"]+)" is activated$/
	 */
	public function thePluginIsActivated( $pluginSlug ) {

		$this->getDriver()
			->activatePlugin( $pluginSlug );
	}

	/**
	 * @Given /^The plugin "(?P<pluginSlug>[^"]+)" is deactivated$/
	 */
	public function thePluginIsDeactivated( $pluginSlug ) {

		$this->getDriver()
			->deactivatePlugin( $pluginSlug );
	}

}
