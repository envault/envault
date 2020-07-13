# Installing Envault on Laravel Vapor

We'll being using Laravel Vapor in this post to simplify the installation process. Laravel Vapor differs from other platforms because it requires a CLI tool to deploy your project.

Before you can deploy Envault to Laravel Vapor, make sure you have a subscription. If you need to sign up, head to the [Envault Portal](https://portal.envault.dev/) and authorize GitHub before purchasing your lifetime subscription.

Next, after your purchase is completed, you will be invited to the private Envault repository and you're ready to begin.

We assume that you already have a Laravel Vapor account, along with a new team that has been linked to your AWS account. If you need help getting started with Laravel Vapor, we recommend following some tutorials._From your team dashboard, click the link to connect an AWS account. Next, you will use your AWS IAM user credentials to connect your account. Type your IAM username, and copy and paste the access key ID and secret key into the appropriate fields. Next, click the `Add` button to connect your AWS account.

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-vaY7MOhX8f.png?raw=true)

## Installing Laravel Vapor

Now let's get into how we can install Vapor in our Envault project. We're not going to get into the basics of how to set up Envault on your machine because we assume you know how to clone the repository and install the application locally.

The first thing you should make sure you do is make sure you are in the root of the project. What you are going to do is require the Vapor CLI by running the following command in your terminal:

```
composer require laravel/vapor-cli
```

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-40QZ6td3O9.png?raw=true)

You can make an alias to `/vendor/bin/vapor` so that you can run `vapor` in your terminal.

Now that we have the Vapor CLI added to our project, we can handle logging in to Vapor's service from the terminal. Enter the following command in your terminal and follow the on-screen prompts:

```
vapor login
```

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-kEXfI2i2uE.png?raw=true)

_You can see here that we have two factor authentication enabled. We recommend enabling this but it is not required._

Now that we have logged in to Vapor, we are authenticated and have a token. Next, we are going to install the Vapor core library. The Vapor core is the runtime needed to execute your Envault application on an AWS Lambda. You can install the Vapor core by using composer:

```
composer require laravel/vapor-core
```

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-JoVZK5jaOF.png?raw=true)

## Teams

Before we move on to anything else, let's do recap on Vapor teams. Teams are what group your projects. Everything in Vapor **_must_** be tied to a team. Fortunately, Vapor allows you to have unlimited teams, and each team can have unlimited AWS accounts. What this means is your Envault project can be separated from the rest of your AWS projects.

One thing that we need to do before we do anything else is check which team we are currently using for our Envault application. You can check the current Vapor team by running `vapor team:current` in your terminal.

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-8FBP5gWqJq.png?raw=true)

Now, as you can see here, I am currently using the Personal team. I have actually created a new team in my Vapor account called Envault. Let's switch to it by running `vapor team:switch` and then typing the team number we want to use.

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-48Gn6Rl4rR.png?raw=true)

Once we are using the appropriate team, we are ready to initialize our project by running `vapor init` in our terminal. Here we can set our project name and pick which region we want to run Envault from. For this post, we are using the default values.

_Notice that Vapor asks you if you wish to install the core library. This is a handy feature if you want to skip installing the core before initializing your project. We will skip this since we installed the core earlier._

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-ELqTfy1cOC.png?raw=true)

After initializing our project, Vapor will create a configuration file called `vapor.yml` in the project's root. This file is responsible for creating and maintaining all of the AWS infrastructure that will hold Envault together.

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-4dMs75vfZK.png?raw=true)

## Configuring Vapor

This section will briefly explore the `vapor.yml` configuration. There are certainly more advanced configuration options, and specific use cases, but we will focus on the basics for now. _You should treat this file with the utmost respect._

_**Do not** ever change the `id` variable in your configuration file!_

Within your configuration file, you can setup multiple environments for your project. Each developer on your team could even have their own environment. The name of your project simply helps identify the project in AWS.

The next line in each environment configuration is the amount of memory the Lambda can use _per request._ This is a very important variable to get right because it affects the cost of your AWS Lambda instances, and also the speed of each request. You will want to adjust this to suit your needs as time goes on, depending on how much your Envault application is used.

_AWS Lamba is priced per 100ms. If you were to drop your memory to 512 but your response time went up by 200-300ms, it may not be beneficial._

You can also configure how much CLI memory your application can use. This is for kernal tasks, like jobs and background workers. _This is independent of the main request memory._

One thing that we want change in our configuration file is the way we compile assets. Since Envault does not use NPM, we need to remove the following line from both the staging and production configurations:

```
npm ci && npm run dev && rm -rf node_modules
```

## Setting Up a Database

Envault needs a database to store your variables. Databases work a bit differently in Vapor than other deployment configurations. For this tutorial, we will be sticking with our favorite database server, which is MySQL.

The first thing we will do is head to Vapor, and then click Databases.

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-iO1SizuvC6.png?raw=true)

Next, we will click `Create database`.

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-5MLdVvSVQL.png?raw=true)

What we see here is the default network is selected for the region we configured our application to use. _Our database will be created inside of the same network the application is deployed._

For this tutorial, we are going to stick with the fixed sized database. We could have a lengthy debate about the pros and cons of fixed size vs. serverless databases, but for now, we will keep it simple and leave to fixed size. We are also going to use the cheapest option here, which is a micro instance. Finally, we are going to keep our database set to public.

_Take precaution using a public database for an application that manages sensitive information in a production environment. However, for demonstration purposes, we are not concerned about that here. Besides, it would take some 393 sextillion years to crack a Vapor password._

Now, once we click the `Create` button, Vapor will give us our database's username and password, and begin provisioning the database. Be sure to copy the username and password to a safe place, we are going to use it next. _This can take some time to setup, so be patient._

With our database setup and provisioning, we can now add it to our `vapor.yml` configuration file. All we need to do is add a new key to the desired environment (in this case, staging):

```
database: envault
```

Once the databased is provisioned, you have the option to create new database users. We won't be covering this in this tutorial, but just know you have the option to create users for your database if it is going to be shared.

Finally, we are ready to run our database migrations. Vapor makes it easy to run commands for each of your environments. Navigate back to your project dashboard, and click the staging environment. Next, click the `Commands` tab and then click `Run command`. We will use Laravel's default migration command with the `--force` flag:

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-q2gq6QmPrZ.png?raw=true)

## Setting Up Mail

Envault uses a passwordless authentication mechanism to sign you into the application. This means that you will enter your email address and receive a single use code to sign in to the application. In order for Envault to send these emails to you and your team, you need to configure Vapor with your email service credentials. For this tutorial, we are going to use Mailtrap.

Now, Vapor handles environment variables and secrets a bit differently. First, your `.env` file has a filesize limit of 4kb. Obviously this may be an issue, so Vapor introduces secrets, which are basically AWS key-value pairs that can be utilized in your application much like a traditional environment variable.

Since using a mail service is an integral part of running Envault, we will utilize Vapor's CLI to manage our mail variables. To get started, we need to pull the environment file for our staging environment:

```
vapor env:pull staging
```

This will create a new `.env.staging` file in Envault's root directory. We will need to update the mail values accordingly. Below is an example using Mailtrap:

```
MAIL_DRIVER=smtp
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=abcdefghij
MAIL_PASSWORD=1234567890
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=larry@envault.dev
MAIL_FROM_NAME="${APP_NAME}"
```

Next, we will need to push the updated environment file back up to our staging environment:

```
vapor env:push staging
```

## Creating Your Owner Account

To get started using Envault, you will need to create a default owner account. You will not be able to run the normal `php artisan make:user` command for your Vapor deployment. Instead, you will utilize a special version of the command which you can call from your project's dashboard in Vapor.

First, you will need to add the following to your `.env.staging` file:

```
USER_EMAIL=
USER_FIRST_NAME=
USER_LAST_NAME=
```

_Be sure to supply your own values here._

Navigate back to your project's dashboard and click the commands tab (see the section on setting up a database). Enter the following command and click the run button:

```
php artisan make:user -no
```

## Deploying Envault to Vapor

Now that you have taken care of the setup, deploying Envault to Vapor is relatively painless. In fact, it is as simple as running `vapor deploy staging` from your terminal.

The deployment process can take a few minutes at first. Once it finishes, you will have a unique URL which you can use to access your Envault. At this point, your Envault is ready to use! You can begin by entering the email you used for your default owner account and clicking the continue button. You will receive your special code which will sign you in to the application.

Congratulations! You have just deployed your own instance of Envault to a serverless environment using Laravel Vapor 🎉

![](https://github.com/envault/envault/blob/master/docs/installation/vapor/file-rSDua3hcQK.png?raw=true)
