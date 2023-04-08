<?php

namespace App\Http\Controllers;

use App\Events\EntityCreated;
use App\Jobs\ProcessImage;
use App\Listeners\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        Log::info('a job is dispatched to queue.!');

        $job = new ProcessImage();

        dispatch($job);

        return view('index');
    }
}
