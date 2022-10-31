
# ECF_Project


## Run Locally

Clone the project

```bash
  git clone git@github.com:pyann0/ECF_Project.git
```

Go to the project directory

```bash
  cd ECF_Project
```

Install dependencies

```bash
  composer install
  npm install --force
```

Start the server

```bash
  npm run start
```


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

Change the `DATABASE_URL` for your own DATABASE URL

Change `APP_ENV` to `dev`


## Create Database
Execute this to create the database and the migration 
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
Load fixtures 
```
php bin/console doctrine:fixtures:load
```


## Open the project
You can now open the project
To connect use:
administrator account:
email: admin@admin.com
mdp: motdepasseadmin

partner account:
email: partenaire1@partenaire.com 
mdp: motdepassepartenaire

structure account:
email: structure1@partenaire1.com
mdp: motdepassestructure

you can replace the 1 in the email address with a number between 1 and 6
