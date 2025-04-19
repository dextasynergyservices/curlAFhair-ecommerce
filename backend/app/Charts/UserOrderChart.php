<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class UserOrderChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct($dates = [], $orderCounts = [])
    {
        parent::__construct();

        // If no data, set empty labels and datasets
        if (empty($dates) || empty($orderCounts)) {
            $this->labels([]);
            $this->dataset('Orders', 'line', [])->backgroundColor('rgba(255, 255, 255, 0)'); // Empty dataset
        } else {
            // Set dynamic labels (dates)
            $this->labels($dates);

            // Set dynamic dataset for order counts
            $this->dataset('Orders', 'line', $orderCounts)
                ->backgroundColor('rgba(75, 192, 192, 0.2)') // Background color
                ->borderColor('rgba(75, 192, 192, 1)') // Line color
                ->fill(false);
        }
    }
}
