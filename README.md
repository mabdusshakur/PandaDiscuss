# PandaDiscuss

PandaDiscuss is a simple chat application built with Laravel Reverb. This project demonstrates how to implement a real-time chat system using WebSockets over API. It serves as a great learning resource for understanding API integration and real-time communication.

## Features

-   Real-time messaging
-   Notification system
-   WebSocket integration with Laravel Reverb
-   Simple and intuitive interface

## Installation Guide

-   Clone the repository
-   Run `composer install`
-   Run `npm install`
-   Run `npm run build`
-   Run `cp .env.example .env`
-   Run `php artisan key:generate`
-   Set your database credentials in the `.env` file
-   Run `php artisan migrate`
-   Run `php artisan serve`
-   Run `php artisan reverb:start`
-   Run `php artisan queue:work` - only if you want to use the queue system, by default i have disabled it on `.env` file `QUEUE_CONNECTION=sync` you can change it to `QUEUE_CONNECTION=database` or `QUEUE_CONNECTION=redis` as per your requirement

-   Run `npm run dev`
