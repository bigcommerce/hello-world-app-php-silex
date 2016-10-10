# BigCommerce Sample App: PHP

This is a small Silex application that implements the OAuth callback flow for BigCommerce [Single Click Apps][single_click_apps]
and uses the [BigCommerce API][api_client] to pull a list of products on a BigCommerce store. For information on how to develop apps
for BigCommerce stores, see our [Developer Portal][devdocs].

We hope this sample gives you a good starting point for building your next killer app! What follows are steps specific
to running and installing this sample application.

## Prerequisites
* A web server such as MAMP or Apache. A localhost address will work fine for the hello world app.
* PHP
* [Composer](https://getcomposer.org/doc/00-intro.md "Composer")

### Registering the app with BigCommerce
1. Create a trial store on [BigCommerce](https://www.bigcommerce.com/)
2. Go to the [Developer Portal][devportal] and log in by going to "My Apps"
3. Click the button "Create an app", enter a name for the new app, and then click "Create"
4. You don't have to fill out all the details for your app right away, but you do need
to provide some core details in section 4 (Technical). Note that if you are just getting
started, you can use `localhost` for your hostname, but ultimately you'll need to host your
app on the public Internet.
  * _Auth Callback URL_: `https://<app hostname>/bigcommerce/callback`
  * _Load Callback URL_: `https://<app hostname>/bigcommerce/load`
  * _Uninstall Callback URL_: `https://<app hostname>/bigcommerce/uninstall`
  * _Remove User Callback URL_: `https://<app hostname>/bigcommerce/remove-user` (if enabling your app for multiple users)
5. Enable the _Products - Read Only_ scope under _OAuth scopes_, which is what this sample app needs.
6. Click `Save & Close` on the top right of the dialog.
7. You'll now see your app in a list in the _My Apps_ section of Developer Portal. Hover over it and click
_View Client ID_. You'll need these values in the next step.

### Getting Started
1. Fork the repo (optional).
2. Clone the repo.

        git clone https://github.com/bigcommerce/hello-world-app-php-silex
3. Use Composer to install the dependencies.

        php composer.phar install
4. Use the method appropriate to your operating system and web server software to add the following environment variables.

        BC_AUTH_SERVICE=https://login.bigcommerce.com
        BC_CLIENT_ID=<contents of Client ID field>
        BC_CLIENT_SECRET=<contents of Client Secret field>
4. Restart the software or the entire host as needed to set the environment variables.

### Hosting the app
In order to install this app in a BigCommerce store, it must be hosted on the public Internet. You can get started in development and use `localhost` in your URLs, but ultimately you will need to host it somewhere to use the app anywhere other than your development system. One easy option is to put it on Heroku.

#### Heroku
_Note: It is assumed that you already have a Heroku account, have the Heroku toolbelt installed, and have authenticated with
the toolbelt. See [Heroku][toolbelt] for details._

* Create a new Heroku app: `heroku create <appname>`
* Push the project to Heroku: `git push heroku master -u`
* Set `APP_URL` in .env to `https://<appname>.herokuapp.com`
* Add the `heroku-config` plugin: `heroku plugins:install git://github.com/ddollar/heroku-config.git`
* Push the local environment variables to heroku: `heroku config:push`

In the [BigCommerce Developer Portal][devportal], you'll need to update the app's callback URLs:

* _Auth Callback URL_: `https://<appname>.herokuapp.com/auth/bigcommerce/callback`
* _Load Callback URL_: `https://<appname>.herokuapp.com/load`
* _Uninstall Callback URL_: `https://<appname>.herokuapp.com/uninstall`

### Installing the app in your trial store
* Login to your trial store
* Go to the Marketplace and click _My Drafts_. Find the app you just created and click it.
* A details dialog will open. Click _Install_ and the draft app will be installed in your store.


[single_click_apps]: https://developer.bigcommerce.com/api/#building-oauth-apps
[api_client]: https://github.com/bigcommerce/bigcommerce-api-php
[devdocs]: https://developer.bigcommerce.com
[devportal]: https://devtools.bigcommerce.com
[toolbelt]: https://toolbelt.heroku.com
