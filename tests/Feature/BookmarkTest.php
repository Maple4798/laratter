<?php

namespace Tests\Feature;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    // Tweetをブックマークできることを確認
    public function test_can_bookmark_a_tweet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweet = Tweet::factory()->create();

        $this->post(route('bookmarks.store', $tweet));

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);
    }

    // Tweetのブックマークを解除できることを確認
    public function test_can_remove_a_bookmark(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweet = Tweet::factory()->create();

        $user->bookmarks()->attach($tweet);

        $this->delete(route('bookmarks.destroy', $tweet));

        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);
    }

    // ブックマークしたTweetが一覧に表示されることを確認
    public function test_displays_bookmarked_tweets(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweet = Tweet::factory()->create();

        $user->bookmarks()->attach($tweet);

        $response = $this->get(route('bookmarks.index'));

        $response->assertStatus(200);
        $response->assertSee($tweet->tweet);
        $response->assertSee($tweet->user->name);
    }
}