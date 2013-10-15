# Fresh Smiles

An application to connect to Freshdesk's Survey API and stores the data in a MySQL backend. There's also a template and functions to display the results on a pretty page. Inspired by [Smiley from 37 Signals](http://smiley.37signals.com).

## Requirements
1. PHP
2. MySQL
3. Cron

## Installation
1. Setup a MySQL Table using /scrips/schema.sql
2. Copy /inc/config-sample.php to /inc/config.php (local or private deployment)
3. Copy /inc/smiley-config-sample.php to /inc/smiley-config.php (local or private deployment)
4. Setup /scripts/cron.php to run via cronjob (1 hour or more)

## Deployment
1. Setup Project with DeployHQ
2. Setup config files in DeployHQ (config.php & smiley-config.php)
3. Deploy Project
4. Profit

## Modules
Built with:
  - [FreshDesk Rest](https://github.com/phikai/freshdesk-rest) by phikai (Forked from [blak3r](https://github.com/blak3r/freshdesk-solutions))
  
## License
Licensed under the MIT Licnese, see [LICENSE](license)

## Contributing
If you'd like to contribute to the project feel free to submit issues or pull requests to the project.

## Example
[ZippyKid Customer Happiness Report](http://smiley.zippykid.com)
