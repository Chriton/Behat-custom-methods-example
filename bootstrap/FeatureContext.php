<?php
/**
 * Created by PhpStorm.
 * User: chriton
 * Date: 01.07.2015
 * Time: 17:15
  */


use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
	/**
	 * Initializes context.
	 * Every scenario gets its own context object.
	 *
	 * @param array $parameters context parameters (set them up through behat.yml)
	 */

	const USERNAME = "doru@test.com";
	const PASSWORD = "tester";

	public function __construct(array $parameters)
	{
		//Initialize your context here
	}

	/**
	 * @param string $username
	 * @param string $password
	 * @throws Exception
	 */
	private function log_in($username = self::USERNAME, $password = self::PASSWORD)
	{
		try
			{
				$this->fillField("email", $username);
				$this->fillField("password", $password);
				$this->pressButton("Autentifică");
				$this->jqueryWait();
			}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * @throws Exception
	 */
	private function log_out()
	{
		try
		{
			$this->clickLink("Deautentificare");
			$this->jqueryWait();
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * @param int $duration
	 */
	private function jqueryWait($duration = 1000)
	{
		$this->getSession()->wait($duration, '(
		document.readyState == \'complete\'					&&
		typeof $ != \'undefined\'							&&
		!$.active											&&
		$(\'#page\').css(\'display\') == \'block\'			&&
		$(\'.loading-mask\').css(\'display\') == \'none\'	&&
		$(\'.jstree-loading\').length == 0
		)');

		//"document.readyState == 'complete'",           // Page is ready
		//"typeof $ != 'undefined'",                     // jQuery is loaded
		//"!$.active",                                   // No ajax request is active
		//"$('#page').css('display') == 'block'",        // Page is displayed (no progress bar)
		//"$('.loading-mask').css('display') == 'none'", // Page is not loading (no black mask loading page)
		//"$('.jstree-loading').length == 0",            // Jstree has finished loading
	}

	/**
	 * @Given /^I am logged "([^"]*)"$/
	 */
	public function iAmLogged($option)
	{
		$this->getSession()->visit($this->locatePath('/'));
		$this->jqueryWait();

		switch ($option)
		{
			case "in":
				$xpath_link = "//*[contains(text(), 'Autentificare')]";
				$result = $this->getSession()->getPage()->find('xpath', $xpath_link);

				//if we find the text 'Autentificare' in the page, this means we are logged out, so we log in
				if($result != null)
					{
					$this->log_in();
					}

				break;

			case "out":
				$xpath_link = "//*[contains(text(), 'Deautentificare')]";
				$result = $this->getSession()->getPage()->find('xpath', $xpath_link);

				//if we find the text 'Deautentificare' in the page, this means we are logged in, so we log out
				if($result != null)
					{
					$this->log_out();
					}

				break;

			default:
				//to do
		}
	}

	/**
	 * @When /^I choose to log "([^"]*)"$/
	 */
	public function iChooseToLog($option)
	{
		switch ($option)
		{
			case "in":
				$this->log_in();
				break;
			case "out":
				$this->log_out();
				break;
			default:
				//to do
		}
	}


	/**
	 * @When /^I log in with "([^"]*)" and "([^"]*)"$/
	 */
	public function iLogInWithAnd($username, $password)
	{
		$this->log_in($username,$password);
	}

	/**
	 * @Then /^I should be logged "([^"]*)"$/
	 */
	public function iShouldBeLogged($option)
	{
		$this->jqueryWait();
		switch ($option)
		{
			case "in":
				$this->assertPageContainsText("Deautentificare");
				break;
			case "out":
				$this->assertPageContainsText("Autentificare");
				break;
			default:
				//to do
		}
	}

	/**
	 * @When /^I click on the site Logo$/
	 */
	public function iClickOnTheSiteLogo()
	{
		try
		{
		$searched_element = ".navbar-brand";
		$find = $this->getSession()->getPage()->find('css', $searched_element);

			if($find == null)
				throw new Exception("The css element '$searched_element' was not found!");
			else
				$find->click();
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * @When /^I click on the Edit user button$/
	 */
	public function iClickOnTheEditUserButton()
	{
		$this->jqueryWait();
		try
		{
			$xpath_link = "//*[@title='Editează utilizator']";
			$button = $this->getSession()->getPage()->find('xpath', $xpath_link);

			if($button == null)
				throw new Exception("The xpath '$xpath_link' was not found!");
			else
				{
				$button->click();
				$this->jqueryWait();
				}

		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * @Given /^I wait for the page to load$/
	 */
	public function iWaitForThePageToLoad()
	{
		sleep(2);
	}
}



