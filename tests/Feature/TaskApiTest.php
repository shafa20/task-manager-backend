<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use PHPUnit\Framework\Attributes\Test;

class TaskApiTest extends TestCase
{
   
    use WithFaker;

    #[Test]
    public function it_can_list_tasks_with_pagination_and_filter()
    {
        Task::factory()->count(30)->create([
            'status' => 'Pending',
            'description' => 'This is a pending task for pagination testing.'
        ]);
        Task::factory()->count(20)->create([
            'status' => 'Completed',
            'description' => 'This is a completed task for pagination testing.'
        ]);

        // Paginated response
        $response = $this->getJson('/api/tasks?page=2&per_page=10');
        $response->assertStatus(200)
                 ->assertJsonStructure(['current_page','data','per_page','total']);

        // Unpaginated response (should be array)
        $response = $this->getJson('/api/tasks?status=Completed');
        $response->assertStatus(200);
        $responseData = $response->json();
        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);
        foreach ($responseData as $task) {
            $this->assertEquals('Completed', $task['status']);
        }
    }

    #[Test]
    public function it_can_search_tasks_by_name()
    {
        Task::factory()->create([
            'name' => 'Unique Task Name',
            'status' => 'Pending',
            'description' => 'A unique pending task for search functionality.'
        ]);
        Task::factory()->create([
            'name' => 'Another Task',
            'status' => 'Pending',
            'description' => 'Another pending task for search test coverage.'
        ]);

        $response = $this->getJson('/api/tasks?search=Unique');
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Unique Task Name']);
    }

    #[Test]
    public function it_can_create_a_task_with_validation()
    {
        $data = [
            'name' => 'New Task',
            'description' => 'Testing create',
            'status' => 'Pending',
        ];
        $response = $this->postJson('/api/tasks', $data);
        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'New Task']);

        $response = $this->postJson('/api/tasks', [ 'name' => '', 'status' => '' ]);
        $response->assertStatus(422)
                 ->assertJsonStructure(['message','errors']);
    }

    #[Test]
    public function it_can_update_a_task_with_validation()
    {
        $task = Task::factory()->create(['status' => 'Pending']);
        $data = [
            'name' => 'Updated Task',
            'description' => 'Updated',
            'status' => 'Completed',
        ];
        $response = $this->putJson("/api/tasks/{$task->id}", $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Task']);

        $response = $this->putJson("/api/tasks/{$task->id}", [ 'name' => '', 'status' => '' ]);
        $response->assertStatus(422)
                 ->assertJsonStructure(['message','errors']);
    }

    #[Test]
    public function it_can_show_a_task_and_handle_not_found()
    {
        $task = Task::factory()->create([
            'name' => 'Show Task',
            'description' => 'Show Task Desc',
            'status' => 'Pending',
        ]);
        // Should return the correct task
        $response = $this->getJson("/api/tasks/{$task->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $task->id,
                     'name' => 'Show Task',
                     'description' => 'Show Task Desc',
                     'status' => 'Pending',
                 ]);
        // Should return 404 for not found
        $response = $this->getJson('/api/tasks/99999');
        $response->assertStatus(404)
                 ->assertJsonFragment(['message' => 'Task not found']);
    }

    #[Test]
    public function it_can_delete_a_task_and_handle_not_found()
    {
        $task = Task::factory()->create();
        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Task deleted successfully']);

        $response = $this->deleteJson('/api/tasks/99999');
        $response->assertStatus(404)
                 ->assertJsonFragment(['message' => 'Task not found']);
    }
}
