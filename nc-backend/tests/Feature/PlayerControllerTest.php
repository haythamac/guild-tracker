<?php

namespace Tests\Feature;

use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        Player::factory()->count(3)->create();
        $response = $this->getJson('/api/players');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_show()
    {
        $player = Player::factory()->create();
        $response = $this->getJson("/api/players/{$player->id}");
        $response->assertStatus(200)->assertJson(['id' => $player->id]);
    }

    public function test_store()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('power_screenshot.jpg');

        $data = [
            'ign' => 'TestPlayer',
            'level' => 10,
            'class' => 'Warrior',
            'power_screenshot' => $file,
        ];

        $response = $this->postJson('/api/players', $data);
        $response->assertStatus(201)->assertJson(['ign' => 'TestPlayer']);
        $this->assertFileExists(Storage::disk('public')->path('power_screenshots/' . $file->hashName()));
    }

    public function test_update()
    {
        $player = Player::factory()->create();
        $data = ['level' => 20];
        $response = $this->putJson("/api/players/{$player->id}", $data);
        $response->assertStatus(200)->assertJson($data);
    }

    public function test_destroy()
    {
        $player = Player::factory()->create();
        $response = $this->deleteJson("/api/players/{$player->id}");
        $response->assertStatus(204);
    }

    public function test_process_power_screenshot()
    {
        $player = Player::factory()->create(['power_screenshot_path' => 'path/to/screenshot.png']);
        $response = $this->postJson("/api/players/{$player->id}/process-power");
        $response->assertStatus(200);
    }
}
