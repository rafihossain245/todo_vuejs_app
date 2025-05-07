<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_task_can_be_created_with_valid_attributes()
    {
        $task = Task::create([
            'title' => 'Test Task',
            'body' => 'Test Description',
            'completed' => false,
            'user_id' => $this->user->id
        ]);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Test Task', $task->title);
        $this->assertEquals('Test Description', $task->body);
        $this->assertFalse($task->completed);
    }

    public function test_task_completion_status_can_be_toggled()
    {
        $task = Task::create([
            'title' => 'Test Task',
            'body' => 'Test Description',
            'completed' => false,
            'user_id' => $this->user->id
        ]);

        $task->completed = true;
        $task->save();

        $this->assertTrue($task->completed);
    }

    public function test_task_belongs_to_user()
    {
        $task = Task::create([
            'title' => 'Test Task',
            'body' => 'Test Description',
            'completed' => false,
            'user_id' => $this->user->id
        ]);

        $this->assertInstanceOf(User::class, $task->user);
        $this->assertEquals($this->user->id, $task->user->id);
    }

    public function test_task_requires_title()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Task::create([
            'body' => 'Test Description',
            'completed' => false,
            'user_id' => $this->user->id
        ]);
    }
} 