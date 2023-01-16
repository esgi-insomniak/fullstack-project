# Vue JS Starter - Insomniak

## Installation with Docker

- ```docker-compose build```
- ```docker-compose up -d```

If there is no `node_modules` folder at `root` in terminal write : ```yarn && yarn dev```

## Installation without Docker 

- Install npm packages : ```yarn```
- ```yarn dev```
## Access front 

- http://localhost:8080

## Custom FormKit 

In `./src/helpers/formkit/theme.js` you can change the css for the inputs with tailwindcss

## Router

From `./src/router/index.js` by default there is 3 routes [`Home`, `Login`, `Register`], to add route's security add : ```beforeEnter: (to, from, next) => {
    // your conditions here ...
}```

# Fusion with Api Platform

- Don't do it 😡