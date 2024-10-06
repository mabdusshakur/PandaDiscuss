<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{

    /**
     * This controller is only responsible for rendering the Inertia pages.
     * @file app/Http/Controllers/Frontend/PageController.php
     */

    public function homePage(): Response
    {
        return Inertia::render('HomePage');
    }

    public function dashboardPage(): Response
    {
        return Inertia::render('Dashboard/DashboardPage');
    }

    public function profilePage(): Response
    {
        return Inertia::render('Profile/ProfilePage');
    }

    public function loginPage(): Response
    {
        return Inertia::render('Auth/LoginPage');
    }

    public function verifyPage(): Response
    {
        return Inertia::render('Auth/VerifyPage');
    }
}