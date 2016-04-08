<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class TrackTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test Track 'added_desc' order by scope.
     *
     * @return void
     */
    public function testScopeDynamicOrderByAddedDesc()
    {
        factory(App\Track::class)->create([
            'added_at' => Carbon::now()->subWeek()
        ]);
        factory(App\Track::class)->create([
            'added_at' => Carbon::now()
        ]);

        $tracks = App\Track::dynamicOrderBy('added_desc')->get();

        $this->assertEquals($tracks[0]->id, 2);
        $this->assertEquals($tracks[1]->id, 1);
    }

    /**
     * Test Track 'added_asc' order by scope.
     *
     * @return void
     */
    public function testScopeDynamicOrderByAddedAsc()
    {
        factory(App\Track::class)->create([
            'added_at' => Carbon::now()->subWeek()
        ]);
        factory(App\Track::class)->create([
            'added_at' => Carbon::now()
        ]);

        $tracks = App\Track::dynamicOrderBy('added_asc')->get();

        $this->assertEquals($tracks[0]->id, 1);
        $this->assertEquals($tracks[1]->id, 2);
    }

    /**
     * Test Track 'album' order by scope.
     *
     * @return void
     */
    public function testScopeDynamicOrderByAlbum()
    {
        $album1 = factory(App\Album::class)->create([
            'name' => 'ZZZ'
        ]);
        $album2 = factory(App\Album::class)->create([
            'name' => 'AAA'
        ]);
        $track1 = factory(App\Track::class)->create([
            'album_id' => $album1->id
        ]);
        $track2 = factory(App\Track::class)->create([
            'album_id' => $album2->id
        ]);

        $tracks = App\Track::dynamicOrderBy('album')->get();

        $this->assertEquals($tracks[0]->id, 2);
        $this->assertEquals($tracks[0]->name, $track2->name);
        $this->assertEquals($tracks[1]->id, 1);
        $this->assertEquals($tracks[1]->name, $track1->name);
    }

    /**
     * Test Track 'artist' order by scope.
     *
     * @return void
     */
    public function testScopeDynamicOrderByArtist()
    {
        $artist1 = factory(App\Artist::class)->create([
            'name' => 'ZZZ'
        ]);
        $artist2 = factory(App\Artist::class)->create([
            'name' => 'AAA'
        ]);
        factory(App\Track::class)->create([
            'artist_id' => $artist1->id
        ]);
        factory(App\Track::class)->create([
            'artist_id' => $artist2->id
        ]);

        $tracks = App\Track::dynamicOrderBy('artist')->get();

        $this->assertEquals($tracks[0]->id, 2);
        $this->assertEquals($tracks[1]->id, 1);
    }

    /**
     * Test Track 'name' order by scope.
     *
     * @return void
     */
    public function testScopeDynamicOrderByName()
    {
        factory(App\Track::class)->create([
            'name' => 'ZZZ'
        ]);
        factory(App\Track::class)->create([
            'name' => 'AAA'
        ]);

        $tracks = App\Track::dynamicOrderBy('name')->get();

        $this->assertEquals($tracks[0]->id, 2);
        $this->assertEquals($tracks[1]->id, 1);
    }

    /**
     * Test Track 'year_desc' order by scope.
     *
     * @return void
     */
    public function testScopeDynamicOrderByYearDesc()
    {
        $album1 = factory(App\Album::class)->create([
            'released_at' => Carbon::now()->subYear()
        ]);
        $album2 = factory(App\Album::class)->create([
            'released_at' => Carbon::now()
        ]);
        $track1 = factory(App\Track::class)->create([
            'album_id' => $album1->id
        ]);
        $track2 = factory(App\Track::class)->create([
            'album_id' => $album2->id
        ]);

        $tracks = App\Track::dynamicOrderBy('year_desc')->get();

        $this->assertEquals($tracks[0]->id, 2);
        $this->assertEquals($tracks[1]->id, 1);
    }

    /**
     * Test Track 'year_desc' order by scope.
     *
     * @return void
     */
    public function testScopeDynamicOrderByYearAsc()
    {
        $album1 = factory(App\Album::class)->create([
            'released_at' => Carbon::now()->subYear()
        ]);
        $album2 = factory(App\Album::class)->create([
            'released_at' => Carbon::now()
        ]);
        $track1 = factory(App\Track::class)->create([
            'album_id' => $album1->id
        ]);
        $track2 = factory(App\Track::class)->create([
            'album_id' => $album2->id
        ]);

        $tracks = App\Track::dynamicOrderBy('year_asc')->get();

        $this->assertEquals($tracks[0]->id, 1);
        $this->assertEquals($tracks[1]->id, 2);
    }

    /**
     * Test Track 'random' order by scope.
     *
     * Can't really test random order, so just check it brings back results
     * 
     * @return void
     */
    public function testScopeDynamicOrderByRandom()
    {
        $track1 = factory(App\Track::class)->create();
        $track2 = factory(App\Track::class)->create();

        $tracks = App\Track::dynamicOrderBy('random')->get();

        $this->assertEquals($tracks->count(), 2);
    }
}
