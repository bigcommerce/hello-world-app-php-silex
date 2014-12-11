# Bigcommerce Sample App: Hello World in PHP and Silex

## Prerequisites
* A web server such as MAMP or Apache. A localhost address will work fine for the hello world app.
* PHP
* [Composer](https://getcomposer.org/doc/00-intro.md "Composer")

## Installing
1. Fork the repo (optional).
2. Clone the repo.

        git clone https://github.com/bigcommerce/hello-world-app-php-silex
3. Use Composer to install the dependencies.

        php composer.phar install
4. Visit https://developer.bigcommerce.com.
5. Click **Log In**.
6. Provide your credentials at the prompt (same as you use to log into your store).
7. Click **My Apps**.
8. Click **Create an app**.
9. Provide a name for your app at the prompt.
10. Click **Next>** through **App Summary**, **Details**, and **Launch Bar**: no entries required.
11. On the **Technical** page, type **http://localhost:8000/auth/callback** into the **Auth Callback URL** field.
12. Select some OAuth scope other than the defaults.
13. Click **Save and close**.

## Setting environment variables
1. Hover over your new app in the **My Apps** dashboard.
2. Click **View Client ID**.
3. Use the method appropriate to your operating system and web server software to add the following environment variables.

        BC_AUTH_SERVICE=https://login.bigcommerce.com
        BC_CLIENT_ID=<contents of Client ID field>
        BC_CLIENT_SECRET=<contents of Client Secret field>
4. Restart the software or the entire host as needed to set the environment variables.

## Running the app
1. Log into your store and go to your control panel.
2. Click **Apps** in the left-hand navigation bar.
3. Click **My Drafts** in the top navigation bar.
4. Click the sample app. It will have the name that you assigned it in the developer portal.
5. Click the **Install** button.
6. At the prompt, click **Confirm**.
7. Click through the browser warning about the self-signed certificate, if applicable.
8. Copy the path inside the browser address bar and paste it into a text editor. The string between **oauth?code=** and **&** is your OAuth key. The string between **stores%** and **&** is your store hash. Using these values, you can proceed to make calls to the Bigcommerce Stores API.