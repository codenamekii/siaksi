<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;

abstract class BaseStatsWidget extends BaseWidget
{
  protected static ?int $sort = 0;
}