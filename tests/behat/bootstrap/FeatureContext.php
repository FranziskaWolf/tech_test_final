<?php # -*- coding: utf-8 -*-

namespace Inpsyde\GoogleTagManager\Tests\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use PaulGibbs\WordpressBehatExtension\Context\RawWordpressContext;

/**
 * Define application features from the specific context.
 */
class FeatureContext extends RawWordpressContext implements SnippetAcceptingContext {

	/**
	 * @Then I click the :arg1 element
	 */
	public function iClickElement( $element ) {

		$page = $this->getSession()
			->getPage();

		$findName = $page->find( "css", $element );
		if ( ! $findName ) {
			throw new Exception( $element . " could not be found" );
		} else {
			$findName->click();
		}
	}

	/**
	 * @Then I should see the :selector tab is visible.
	 */
	public function iShouldSeeTheTabIsVisible( $selector ) {

		$page = $this->getSession()
			->getPage();

		$element = $page->find( "css", $selector );
		if ( ! $element ) {
			throw new Exception( $selector . " could not be found for selector '" . $selector . "'" );
		}

		$attribute = $element->getAttribute( 'aria-hidden' );
		if ( $attribute === 'true' ) {
			throw new Exception(
				$selector . " has not attribute aria-hidden='true'. Instead it is '" . $attribute . "'"
			);
		}
	}

}