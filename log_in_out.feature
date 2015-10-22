#In order to [benefit], as a [stakeholder] I want to [feature]

	Feature: Log in/out
		In order to administrate the site
		As an administrator
		I want to be able to access the CMS

	@javascript
	Scenario: Access the CMS homepage
		Given I am on homepage
		Then I should see "Autentificare"

	@javascript
	Scenario: Log in with incorrect username and password
		Given I am on homepage
		When I log in with "test" and "test"
		Then I should be logged "out"

	@javascript
	Scenario: Log in with correct username and password
		Given I am logged "out"
		When I choose to log "in"
		Then I should be logged "in"

	@javascript
	Scenario: User is able to log out
		Given I am logged "in"
		When I choose to log "out"
		Then I should be logged "out"





