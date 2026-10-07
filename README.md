# PHP Business Template

A multi-page PHP starter website with reusable layouts, a session-based demo login/register flow, protected dashboard and profile pages, a contact form, and a custom 404 page.

## Run locally

From this directory, run:

```powershell
php -S localhost:8000 router.php
```

Then open `http://localhost:8000`.

Accounts are stored only in the current PHP session. Replace this demo storage with a database before using it in production.

## Google sign-in setup

The Google buttons use the OAuth 2.0 server flow. Create a Google OAuth web client, add the callback URL as an authorised redirect URI, and provide these environment variables to PHP:

```powershell
$env:GOOGLE_CLIENT_ID = "your-client-id.apps.googleusercontent.com"
$env:GOOGLE_CLIENT_SECRET = "your-client-secret"
$env:GOOGLE_REDIRECT_URI = "http://localhost:8000/google-callback.php"
php -S localhost:8000 router.php
```

Use the included `.env.example` as a reference. Do not commit your client secret. The callback verifies the OAuth state, exchanges the one-time code server-side, and uses Google's verified profile response to start the site session.
