<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPowerScreenshotJob;
use App\Models\Player;
use App\Services\PowerScreenshotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{

    protected $powerScreenshotService;

    public function __construct(PowerScreenshotService $powerScreenshotService)
    {
        $this->powerScreenshotService = $powerScreenshotService;
    }

    public function index()
    {
        return Player::all();
    }

    public function show(Player $player)
    {
        return $player;
    }

    public function store(Request $request)
    {

        // Validate the request
        $request->validate([
            'ign' => 'required|string|max:255',
            'level' => 'nullable|integer',
            'class' => 'nullable|string|max:50',
            'power_screenshot' => 'nullable|image|max:2048',
            'power' => 'nullable|integer',
        ]); 

        $playerData = $request->only(['ign', 'level', 'class', 'power']);

        // Handle power screenshot if provided
        if($request->hasFile('power_screenshot')) {
            $path = $request->file('power_screenshot')->store('power_screenshots', 'public');
            $playerData['power_screenshot_path'] = $path;

            if(!$request->has('power')) {
                $fullPath = Storage::disk('public')->path($path);
                $extractedPower = $this->powerScreenshotService->extractPower($fullPath);

                if($extractedPower)
                {
                    $playerData['power'] = $extractedPower;
                    $playerData['power_is_processed'] = true;
                }
            } else {
                // If power was manually provided, mark as processed
                $playerData['power_is_processed'] = true;
            }
        }

        $player = Player::create($playerData);
        return $player;
    }

    


    public function update(Request $request, Player $player)
    {
        $request->validate([
            'ign' => 'sometimes|max:255',
            'level' => 'integer',
            'class' => 'string|max:255',
            'power' => 'integer',
            'guild' => 'string|max:255',
            'status' => 'string|max:50',
            'power_screenshot' => 'nullable|image|max:2048',
        ]);
        
        $playerData = $request->only(['ign', 'level', 'class', 'power', 'guild', 'status']);

        // Handle power screenshot if provided
        if($request->hasFile('power_screenshot')) {
            // Delete old screenshot if exists
            if($player->power_screenshot_path) {
                Storage::disk('public')->delete($player->power_screenshot_path);
            }

            $path = $request->file('power_screenshot')->store('power_screenshots', 'public');
            $playerData['power_screenshot_path'] = $path;

            // If power was not manually provided, extract it from screenshot
            if(!$request->has('power')) {
                $fullPath = Storage::disk('public')->path($path);
                $extractedPower = $this->powerScreenshotService->extractPower($fullPath);

                if($extractedPower)
                {
                    $playerData['power'] = $extractedPower;
                    $playerData['power_is_processed'] = true;
                } else {
                    $playerData['power_is_processed'] = false;
                }
            } else {
                // If power was manually provided, mark as processed
                $playerData['power_is_processed'] = true;
            }
        } elseif ($request->has('power')) {
            // If power was manually provided, mark as processed
            $playerData['power_is_processed'] = true;
        }

        if ($request->hasFile('power_screenshot') && !$request->has('power')) {
            $path = $request->file('power_screenshot')->store('power_screenshots', 'public');
            $playerData['power_screenshot_path'] = $path;
            
            // Dispatch job to process the power screenshot
            ProcessPowerScreenshotJob::dispatch($player);
        }
        
        $player->update($playerData);
        return $player;
    }


    public function destroy(Player $player)
    {
        // Delete the screenshot if it exists
        if ($player->power_screenshot_path) {
            Storage::disk('public')->delete($player->power_screenshot_path);
        }

        $player->delete();
        return response()->noContent();
    }

    public function processPowerScreenshot(Player $player)
    {
        if(!$player->power_screenshot_path) {
            return response()->json(['message' => 'No screenshot to process'], 400);
        }

        $fullPath = Storage::disk('public')->path($player->power_screenshot_path);

        // Process the screenshot and extract data
        $extractedPower = $this->powerScreenshotService->extractPower($fullPath);

        if($extractedPower)
        {
            $player->update([
                'power' => $extractedPower,
                'power_is_processed' => true,
            ]);
        }

        return $player;
    }
}
