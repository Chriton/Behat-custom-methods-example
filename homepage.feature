#In order to [benefit], as a [stakeholder] I want to [feature]

Feature: Homepage
	In order to administrate the site
	As an administrator
	I want to be able to access the CMS

	@javascript
	Scenario Outline: Main menu links redirect the user to the correct page
		Given I am logged "in"
		When I follow "<this_link>"
		And I wait for the page to load
		Then I should be on "<this_page>"
		Examples:
		|this_link              | this_page           |
		|Hotărâri               |/hotarari            |
		|Știri                  |/stiri               |
		|Pagini Statice         |/pagini              |
		|Cereri contact         |/contacte            |
		|Log-uri                |/loguri              |
		|Utilizatori            |/utilizatori         |

	@javascript
	Scenario: The main logo redirects the user to the CMS homepage
		Given I am logged "in"
		When I click on the site Logo
		Then I should be on homepage

	@javascript
	Scenario: User is able to access the "Edit user" page
		Given I am logged "in"
		When I click on the Edit user button
		Then I should see "Editare utilizator"