<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FillMovesTable implements ShouldQueue
{
    use Queueable;

    protected array $moves;

    /**
     * Create a new job instance.
     */
    public function __construct(array $moves)
    {
        $this->moves = $moves;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->moves as $move) {

        }
    }
}
