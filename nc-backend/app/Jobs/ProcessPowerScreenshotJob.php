<?php

namespace App\Jobs;

use App\Models\Player;
use App\Services\PowerScreenshotService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessPowerScreenshotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $player;
    
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function handle(PowerSCreenshotService $service)
    {
        $fullPath = Storage::disk('public')->path($this->player->power_screenshot_path);
        $extractedPower = $service->extractPower($fullPath);

        if($extractedPower)
        {
            $this->player->update([
                'power' => $extractedPower,
                'power_is_processed' => true,
            ]);
        }
    }
}
