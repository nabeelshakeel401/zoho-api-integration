## Project Setup
    -> Backend
        - composer install
    -> Frontend
        - npm install

## Start Project
    -> Backend
        - phr arisan serve
    -> Frontend
        npm run dev

## Environment
    #Self-Client - A self test application is preferrable for the API integration
        ZOHO_CLIENT_ID - the client_id received from ZOHO developer console
        ZOHO_CLIENT_SECRET - the client_scret received from ZOHO developer console
        ZOHO_SELF_CODE - the code generated upon the creation of the Self Client App (only usable once)
        ZOHO_REFRESH_TOKEN - the refresh token received when using the code for the first time to fetch token from ZOHO API
        ZOHO_CACHE_TOKEN_VAR - an internal variable name for storing the application token