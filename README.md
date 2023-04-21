# OctoberCMS SAML SSO Plugin

Repository for October CMS SAML SSO Plugin.
SAML 2.0 Single Sign On (SSO) Authentication for OctoberCMS by miniOrange

About
SSO for OctoberCMS allows users residing at SAML 2.0 compliant Identity Provider to log in to your OctoberCMS website. We support all known IdPs - ADFS, Azure AD, Google Apps, Keycloak, Okta, Salesforce, Shibboleth, SimpleSAMLphp, OpenAM, Centrify, Ping, RSA, IBM, Oracle, OneLogin, Bitium, WSO2, NetIQ, miniOrange, etc. Refer [guide](https://plugins.miniorange.com/october-cms-saml-single-sign-on-sso#setupguides) to set up the plugin with your IdP.

SSO Plugin acts as a SAML 2.0 Service Provider which can be configured to establish the trust between the plugin and various SAML 2.0 supported Identity Providers to securely authenticate the user to the October CMS via SSO.

If you require any Single Sign-On application or need any help with installing this plugin, please feel free to email us at info@xecurify.com or [contact us](http://miniorange.com/contact).

Features:

- Easily Configure the Identity Provider by providing just the SAML login URL, IDP Entity ID, and Certificate.

- Easily integrate the login link with your OctoberCMS site using SSO Button Component. Just drop it in a desirable place on your site.

- Automatic user registration for 10 users after login if the user is not already registered with your site.

- Standard Attribute Mapping maps the response to your Users' username and email credentials.

- Supports both Backend and Frontend authentication.

Requirements
This plugin requires the [RainLab.User](https://octobercms.com/plugin/rainlab-user) plugin to be installed in your OctoberCMS instance.

This plugin also supports the [Buddies](https://octobercms.com/plugin/lovata-buddies).[Contact us](info@xecurify.com) for the supported version.

**Managing users**
The plugin depends on and automatically integrates with the user management provided by RainLab.User plugin. All users are created and authenticated based on email address received in NameID through the SAML 2.0 SP plugin, and can be seen in the Users view provided by the RainLab.User plugin.

**Plugin settings**
This plugin creates a Main menu item Single Sign On found at the main nav bar at the top of the page. This menu has four side menu items - Plugin Settings, Upgrade, Account, and Support. Plugin settings allow the configuration of SAML settings. You will be able to see three tabs - IdP Settings, SP Settings, and Attribute Mapping - which are explained in detail below.

**IdP Settings**
In this tab, you are supposed to fill in the Single Sign On endpoints/URLs/details supplied by your Identity Provider.

**IDP Name ** : This field is not critical to the functionality of the plugin and is provided only for your convenience.
**IDP Entity ID** : This is the first of the required fields for working functionality and is provided by your Identity Provider. Also known as IDP Issuer ID.
**SAML Login URL** : This is the second of the required fields for working functionality and is provided by your Identity Provider. Also known as Single Sign On URL.
**SAML x509 Certificate** : This is the third of the required fields for working functionality and is provided by your Identity Provider.
Make sure to click Save.

All the three required fields are critical to SAML Authentication and the Test Configuration feature provided at the bottom of the page should be used to make sure your configurations are correct. Make sure to hit Save before clicking Test Configuration

SP Settings
This tab automatically generates and provides you with the minimum endpoints that you need to provide to your Identity Provider - SP Entity ID also known as Audience URI or SP Issuer ID and ACS URL also known as Single Sign On URL. The Download Certificate link can be used to download the SP's public certificate in case the Identity Provider requires it.

Attribute Mapping
This tab is disabled in the free version. However, you will be able to see "NameID" as the default value in the Username and Email fields. The value received in NameID will be stored against the User's username and email while creating a new user.

Upgrade
On the left-hand side pane, you will see the Upgrade menu. Here you can compare the features of the Free version with the Premium version of the plugin.

Support
On the left-hand side pane, you will see the Support menu. Using the form on this page you can send us at MiniOrange Security Software a query regarding technical difficulties or a premium upgrade. You will have to enter your name and phone (optional) to send us mail. We are committed to providing you with the highest quality of support through emails, screen share & plugin troubleshooting. Drop us a mail at info@xecurify.com to schedule a call.

Account
On the left-hand side pane, you will see the Account menu. You can register to miniOrange for upgrade and query. You will have to enter a valid email address and a password and nothing more to quickly register for free with miniOrange to access the support form.

SSO Button Component
The SSO Button can be placed on any page and clicking it will start the Single Sign On flow. For ease of understanding to the end user, place it on the same page as your login/account form provided by User plugin but it's totally upto you and the placement of this button does not affect the functionality in any way. The working of the SSO Button does not depend on another component being present on the same page.

Backend SSO
Admin/backend users can Single Sign On into the backend using the same SAML configuration. They will be authenticated against email address registered under their backend account. A "Single Sign On" button will be automatically generated on the backend login screen.

Premium Features
You can upgrade to the premium version of this plugin for the following features.

Advanced Attribute Mapping
-Configurable SAML request binding type
-SAML Single Logout
-Force Authentication and Auto-Redirect to IdP
-Signed Response and Assertion
many more..
If you are looking for any special use case or customization drop us a mail at info@xecurify.com.

You can reach us at info@xecurify.com to upgrade to premium.
