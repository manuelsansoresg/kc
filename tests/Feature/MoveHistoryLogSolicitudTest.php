<?php

namespace Tests\Feature;

use App\Models\HistoryLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MoveHistoryLogSolicitudTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        HistoryLog::move(52, HistoryLog::SOLICITUD, HistoryLog::KC_CONTROL_DESK, null, false);
        $response->assertStatus(200);
    }
}
