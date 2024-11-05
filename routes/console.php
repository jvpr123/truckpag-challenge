<?php

use App\Console\Commands\ImportOpenFoodData;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ImportOpenFoodData::getDefaultName())->daily();
