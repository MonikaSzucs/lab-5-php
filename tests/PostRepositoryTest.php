<?php

require_once __DIR__ . '/../src/Repositories/PostRepository.php';
require_once __DIR__ . '/../src/Models/Post.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

use src\Repositories\PostRepository;
use src\Models\Post;

class PostRepositoryTest extends TestCase {

	private PostRepository $postRepository;

	/**
	 * Runs before each test
	 */
	protected function setUp(): void {
		parent::setUp();
		$this->postRepository = new PostRepository();
		$this->postRepository->beginDbTransaction(); // starts db transaction
	}

	/**
	 * Runs after each test
	 */
	protected function tearDown(): void {
		parent::tearDown();
		// roll back db trasnactions
		$this->postRepository->rollBackTransaction();
	}

	public function testPostCreation() {
		$post = $this->postRepository->savePost('test', 'body');
		$this->assertEquals('test', $post->title);
		$this->assertEquals('body', $post->body);
	}

	// Starting here and below
	public function testPostRetrieval() {
		// TODO test the "get" methods in the PostRepository class
		// Create a new post to retrieve
		$createdPost = $this->postRepository->savePost('retrieve title', 'retrieve body');
		
		// Retrieve the post by ID
		$retrievedPost = $this->postRepository->getPostById($createdPost->id);
		
		// Assert the retrieved post matches the created post
		$this->assertInstanceOf(Post::class, $retrievedPost); // checks if we did get a post, aka not a false
		$this->assertNotEmpty($createdPost->title);
		$this->assertNotEmpty($createdPost->body);
		$this->assertEquals($createdPost->id, $retrievedPost->id);
		$this->assertEquals($createdPost->title, $retrievedPost->title);
		$this->assertEquals($createdPost->body, $retrievedPost->body);
		
		// Retrieve all posts and check the created post is in the list
		$allPosts = $this->postRepository->getAllPosts();
		$this->assertIsArray($allPosts);
		$this->assertNotEmpty($allPosts);
		$this->assertContainsOnlyInstancesOf(Post::class, $allPosts);

		print_r("inside the array: ");
		print_r($allPosts);
		print_r(" *** inside created post: ");
		print_r($createdPost);
		//$this->assert
		//$this->assertContains([$createdPost], $allPosts);
		// Check that the created post is in the list of all posts
		$found = false;
		foreach ($allPosts as $post) {
			if ($post->id == $createdPost->id &&
				$post->title == $createdPost->title &&
				$post->body == $createdPost->body &&
				$post->created_at == $createdPost->created_at &&
				$post->updated_at == $createdPost->updated_at) {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found, 'Created post was not found in the list of all posts.');
	}

	public function testPostUpdate() {
		// TODO create a post, update the title and body, and check that you get the expected title and body
		// Create a new post to update
		$createdPost = $this->postRepository->savePost('original title', 'original body');
		
		// Update the post
		$updated = $this->postRepository->updatePost($createdPost->id, 'updated title', 'updated body');
		$this->assertTrue($updated);
		
		// Retrieve the updated post
		$updatedPost = $this->postRepository->getPostById($createdPost->id);
		
		// Assert the post was updated
		$this->assertInstanceOf(Post::class, $updatedPost);
		$this->assertEquals('updated title', $updatedPost->title);
		$this->assertEquals('updated body', $updatedPost->body);
	}

	public function testPostDeletion() {
		// TODO: delete a post by ID and check that it isn't in the database anymore
		$createdPost = $this->postRepository->savePost('delete title', 'delete body');
		
		// Delete the post
		$deleted = $this->postRepository->deletePostById($createdPost->id);
		$this->assertTrue($deleted);
		
		// Assert the post is no longer in the database
		$retrievedPost = $this->postRepository->getPostById($createdPost->id);
		$this->assertFalse($retrievedPost);
	}
}
