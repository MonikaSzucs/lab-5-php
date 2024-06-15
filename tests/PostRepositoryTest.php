<?php

require_once __DIR__ . '/../src/Repositories/PostRepository.php';
require_once __DIR__ . '/../src/Models/Post.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

use src\Repositories\PostRepository;

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

	public function testPostRetrieval() {
		// TODO test the "get" methods in the PostRepository class
		//$this->assertTrue(true);
	}

	public function testPostUpdate() {
		// TODO create a post, update the title and body, and check that you get the expected title and body
	}

	public function testPostDeletion() {
		// TODO: delete a post by ID and check that it isn't in the database anymore
	}
}
