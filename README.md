# HowTheyVote.eu

[HowTheyVote.eu](https://howtheyvote.eu) allows anyone to easily find out how Members of the European Parliament vote in plenary.

Although the results of roll-call votes are generally available on the website of the European Parliament, it is rather difficult to find out what MEPs voted on or how a particular vote turned out. This is because the necessary information has to be gathered from various websites of the Parliament. HowTheyVote.eu automatically scrapes information from multiple official sources and presents them in a simple UI.

## Development Setup

We use Docker for our development setup. This setup is intended for development purposes only!

1. Make sure ports 3306, 5000 and 8000 are free.
2. Install `docker` and `docker-compose`. You can find instruction on how to install Docker on the [Docker website](https://docs.docker.com/get-docker/).
3. Run `docker-compose run app composer install` inside the cloned folder.
4. Run `docker-compose up`.
5. Create `.env` files based on `scrapers/.env.example` and `app/.env.example`.
6. When creating a fresh development environment with a clean DB, execute `php artisan migrate`, `php artisan db:seed --class=GroupSeeder`, and `php artisan db:seed --class=TermSeeder` inside the `app` container (e.g. with `docker-compose exec`).
7. Run `php artisan scout:import '\App\VotingList'` to initialize the search index.

### Database Dumps

We provide a dump in the `mariadb/dump` directory that can be imported using `mariadb/dump/import_database.sh`. 
If you have scraped data the `mariadb/dump/export_database.sh` script can be used to create a new dump.

To familiarize yourself with the schema of the database, the models in `app/app/*.php` are a good starting point. 

## Production Deployment

We’re using [Ansible](https://ansible.org) to manage server provisioning and deployment to production environments. Currently, the Ansible playbook `ansible/site.yml` supports deploying EP-Votes to a fresh [Uberspace 7](https://uberspace.de) account.

1. Install Ansible 2.10 or later. Update `ansible/hosts` and the respective host variables.
2. Run `ansible-playbook -i ansible/hosts --ask-vault-pass ansible/site.yml` to set up the Uberspace and deploy the application.
3. Run `ansible-playbook -i ansible/hosts --ask-vault-pass ansible/meilisearch.yml` to compile and configure the MeiliSearch search server. This may take some time and it’s *not* necessary to run this playbook on every deployment. 

## Related Work

* [**Parltrack**](https://github.com/parltrack/parltrack) is an open source project that improves access to information about legislative processes, including (but not limited to) vote results.

* [**abgeordnetenwatch.eu**](https://www.abgeordnetenwatch.de/eu/abstimmungen) is a German NGO that allows citizen to publicly ask questions elected representatives in the federal and state parliaments as well as the European Parliament questions. abgeordnetenwatch.eu also includes voting records for editorially selected votes in the European Parliament. Those are however limited to German MEPs.

* [**VoteWatch Europe**](https://votewatch.eu) maintains a database of vote results for the current and many past legislatures. However, not all vote results are publicly accessible.

## Licenses

This software is licensed under [GPLv3](https://www.gnu.org/licenses/gpl-3.0.en.html). Data exports accessible via the web interface on <HowTheyVote.eu> and database dumps are made available under the [Creative Commons Attribution License 4.0](https://creativecommons.org/licenses/by/4.0/).

The contents of the database are sourced from the [plenary minutes](https://www.europarl.europa.eu/plenary/en/minutes.html) of the European Parliament, [MEP profiles](http://europarl.europa.eu/meps/en/home) on the Parliament’s website, and the [Legislative Observatory](https://oeil.secure.europarl.europa.eu/oeil/home/home.do).

---

This work is sponsored by the [Federal Ministry of Education and Research](https://bmbf.de) in the 9th round of the [Prototype Fund](https://prototypefund.de/) (Reference: 01IS21818).

<img src="./docs/logo-bmbf.svg" alt="Federal Ministry of Education and Research" height="200" />
