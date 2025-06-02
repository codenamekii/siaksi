<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

abstract class BaseStatsWidget extends StatsOverviewWidget
{
  protected static ?int $sort = 1;
  protected int | string | array $columnSpan = 'full';

  /**
   * Get the heading for the widget
   */
  public function getHeading(): ?string
  {
    return static::getWidgetHeading();
  }

  /**
   * Override this method in child classes instead of using $heading property
   */
  protected static function getWidgetHeading(): ?string
  {
    return null;
  }

  /**
   * Create a stat with standardized styling
   */
  protected function createStat(
    string $label,
    string $value,
    ?string $description = null,
    ?string $descriptionIcon = null,
    ?string $color = null,
    ?string $icon = null,
    ?array $chart = null
  ): Stat {
    $stat = Stat::make($label, $value)
      ->description($description)
      ->descriptionIcon($descriptionIcon, $this->getIconPosition())
      ->color($color ?? 'primary');

    if ($icon) {
      $stat->icon($icon);
    }

    if ($chart) {
      $stat->chart($chart);
    }

    return $stat;
  }

  /**
   * Get icon position for description
   */
  protected function getIconPosition(): string
  {
    return 'before'; // or 'after'
  }

  /**
   * Format number with Indonesian number format
   */
  protected function formatNumber(int $number): string
  {
    if ($number >= 1000000) {
      return number_format($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
      return number_format($number / 1000, 1) . 'K';
    }

    return number_format($number);
  }

  /**
   * Get color based on percentage
   */
  protected function getPercentageColor(float $percentage): string
  {
    if ($percentage >= 80) {
      return 'success';
    } elseif ($percentage >= 60) {
      return 'warning';
    } else {
      return 'danger';
    }
  }

  /**
   * Get trend icon based on change
   */
  protected function getTrendIcon(float $change): string
  {
    if ($change > 0) {
      return 'heroicon-m-arrow-trending-up';
    } elseif ($change < 0) {
      return 'heroicon-m-arrow-trending-down';
    } else {
      return 'heroicon-m-minus';
    }
  }

  /**
   * Get trend color based on change
   */
  protected function getTrendColor(float $change): string
  {
    if ($change > 0) {
      return 'success';
    } elseif ($change < 0) {
      return 'danger';
    } else {
      return 'gray';
    }
  }

  /**
   * Calculate percentage
   */
  protected function calculatePercentage(int $value, int $total): float
  {
    if ($total === 0) {
      return 0;
    }

    return round(($value / $total) * 100, 1);
  }

  /**
   * Get chart data for last 6 months
   */
  protected function getMonthlyChart(string $model, string $dateColumn = 'created_at'): array
  {
    $data = [];

    for ($i = 5; $i >= 0; $i--) {
      $date = now()->subMonths($i);
      $count = $model::whereYear($dateColumn, $date->year)
        ->whereMonth($dateColumn, $date->month)
        ->count();

      $data[] = $count;
    }

    return $data;
  }

  /**
   * Get recent activity description
   */
  protected function getRecentActivityDescription(string $model, string $dateColumn = 'created_at'): string
  {
    $thisMonth = $model::whereYear($dateColumn, now()->year)
      ->whereMonth($dateColumn, now()->month)
      ->count();

    $lastMonth = $model::whereYear($dateColumn, now()->subMonth()->year)
      ->whereMonth($dateColumn, now()->subMonth()->month)
      ->count();

    if ($lastMonth === 0) {
      return $thisMonth > 0 ? "+{$thisMonth} bulan ini" : "Belum ada data bulan ini";
    }

    $change = $thisMonth - $lastMonth;
    $percentage = round(($change / $lastMonth) * 100);

    if ($change > 0) {
      return "+{$change} ({$percentage}%) dari bulan lalu";
    } elseif ($change < 0) {
      return "{$change} ({$percentage}%) dari bulan lalu";
    } else {
      return "Sama dengan bulan lalu";
    }
  }

  /**
   * Get status badge color
   */
  protected function getStatusColor(string $status): string
  {
    return match (strtolower($status)) {
      'aktif', 'published', 'approved', 'unggul', 'a' => 'success',
      'draft', 'pending', 'baik', 'b' => 'warning',
      'nonaktif', 'inactive', 'rejected', 'c' => 'danger',
      'archived', 'expired' => 'gray',
      default => 'primary'
    };
  }

  /**
   * Get days until deadline
   */
  protected function getDaysUntilDeadline(\DateTime $deadline): int
  {
    $now = new \DateTime();
    $interval = $now->diff($deadline);

    return $interval->invert ? -$interval->days : $interval->days;
  }

  /**
   * Format deadline description
   */
  protected function formatDeadlineDescription(int $days): array
  {
    if ($days < 0) {
      return [
        'text' => abs($days) . ' hari terlambat',
        'color' => 'danger',
        'icon' => 'heroicon-m-exclamation-triangle'
      ];
    } elseif ($days === 0) {
      return [
        'text' => 'Jatuh tempo hari ini',
        'color' => 'warning',
        'icon' => 'heroicon-m-clock'
      ];
    } elseif ($days <= 7) {
      return [
        'text' => $days . ' hari lagi',
        'color' => 'warning',
        'icon' => 'heroicon-m-clock'
      ];
    } elseif ($days <= 30) {
      return [
        'text' => $days . ' hari lagi',
        'color' => 'primary',
        'icon' => 'heroicon-m-calendar'
      ];
    } else {
      return [
        'text' => $days . ' hari lagi',
        'color' => 'success',
        'icon' => 'heroicon-m-calendar'
      ];
    }
  }
}