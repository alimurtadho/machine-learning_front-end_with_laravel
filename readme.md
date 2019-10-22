# AIMED

[![Build Status](https://travis-ci.org/nikhil-pandey/AIMed.svg?branch=master)](https://travis-ci.org/nikhil-pandey/AIMed)

## Introduction

This web application has the following features:
- predict heart disease and diabetes.
- create an account and login.
- update their profile and password.
- read the latest news from twitter.
- publish and view published datasets by other members.
- publish code and view published codes for a particular dataset.
- participate in discussions.
- upvote and downvote news, datasets and code.
- subscribe or unsubscribe to newsletters. 

## Installation

1. Clone the repository or download zip
    ```bash
    git clone https://github.com/nikhil-pandey/aimed
    ```
2. Install composer dependencies
    ```bash
    cd aimed
    composer install --prefer-dist
    ```

3. Copy the `.env.example` file to `.env`

4. Set configurations in `.env`. Other than basic database and queue configurations you will need to provide Twitter API keys, Amazon S3 Storage API keys and Mail Chimp API keys.

5. Generate App Key
    ```bash
    php artisan key:generate
    ```
6. Create database and populate test data.
    ```bash
    php artisan migrate
    php artisan db:seed
    ```
## Screenshots
![Imgur](https://i.imgur.com/3aIgEFx.png)

## Live Demo
[Click Here](https://aimed.nikhil.com.np)

## ML
[Machine Learning Portion](https://github.com/nikhil-pandey/fyp-ml)

## Read Full Report
[Click Here](https://nikhil.com.np/storage/aimed.pdf)

## [License](LICENSE)
This project is open-sourced under the [MIT license](LICENSE)
