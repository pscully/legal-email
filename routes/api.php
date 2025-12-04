<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

// WordPress webhook endpoint to mark invitees as accepted when they sign up
Route::post('/webhooks/signup-accepted', [WebhookController::class, 'signupAccepted']);
