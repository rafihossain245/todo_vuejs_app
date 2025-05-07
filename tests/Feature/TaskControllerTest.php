<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_create_task()
    {
        $response = $this->actingAs($this->user)->postJson('/api/tasks', [
            'title' => 'New Task',
            'body' => 'Task Description',
            'completed' => false
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'body',
                'completed',
                'user_id',
                'created_at',
                'updated_at'
            ])
            ->assertJson([
                'title' => 'New Task',
                'body' => 'Task Description',
                'completed' => false,
                'user_id' => $this->user->id
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task',
            'user_id' => $this->user->id
        ]);
    }

    public function test_user_can_view_their_tasks()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'id' => $task->id,
                'title' => $task->title
            ]);
    }

    public function test_user_can_update_task()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Original Task',
            'body' => 'Original Description',
            'completed' => false
        ]);

        $response = $this->actingAs($this->user)->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Task',
            'body' => 'Updated Description',
            'completed' => true
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Task',
                'body' => 'Updated Description',
                'completed' => true
            ]);
    }

    public function test_user_can_delete_task()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_access_other_users_tasks()
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $response = $this->actingAs($this->user)->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(403);
    }
} 