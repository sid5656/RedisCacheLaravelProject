<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    // Test that the project list API returns paginated results with correct structure and count (with Sanctum auth)
    public function it_returns_a_paginated_list_of_projects()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        // Arrange: create 15 projects
        \App\Models\Project::factory()->count(15)->create();

        // Act: call the index endpoint with auth
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/projects');

        // Assert: check for pagination and data
        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ])
            ->assertJsonCount(10, 'data'); // default per page is 10
    }
    
    #[\PHPUnit\Framework\Attributes\Test]
    // Test that a project can be created via the store API (with Sanctum auth)
    public function it_can_store_a_project()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'project_name' => 'Test Project',
            // Add other required fields here
        ];

        // Act: send POST request to create a project with auth
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/projects', $data);

        // Assert: check response and database
        $response->assertStatus(201)
            ->assertJsonFragment(['project_name' => 'Test Project']);
        $this->assertDatabaseHas('projects', ['project_name' => 'Test Project']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    // Test that a single project can be retrieved via the show API (with Sanctum auth)
    public function it_can_show_a_project()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        // Arrange: create a project
        $project = \App\Models\Project::factory()->create();

        // Act: send GET request to show the project with auth
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/projects/' . $project->id);

        // Assert: check response contains project ID
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $project->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    // Test that a project can be updated via the update API (with Sanctum auth)
    public function it_can_update_a_project()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        // Arrange: create a project
        $project = \App\Models\Project::factory()->create();
        $data = [
            'project_name' => 'Updated Project',
            // Add other updatable fields here
        ];

        // Act: send PUT request to update the project with auth
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson('/api/projects/' . $project->id, $data);

        // Assert: check response and database
        $response->assertStatus(200)
            ->assertJsonFragment(['project_name' => 'Updated Project']);
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'project_name' => 'Updated Project']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    // Test that a project can be deleted via the destroy API (with Sanctum auth)
    public function it_can_delete_a_project()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        // Arrange: create a project
        $project = \App\Models\Project::factory()->create();

        // Act: send DELETE request to delete the project with auth
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson('/api/projects/' . $project->id);

        // Assert: check response and database
        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
