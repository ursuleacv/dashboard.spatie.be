<?php

namespace App\Services\InstagramHistory;

use App\Events\Instagram\PhotoFetched;
use Spatie\Valuestore\Valuestore;

class InstagramHistory
{
    /** @var \Spatie\Valuestore\Valuestore */
    protected $valuestore;

    public function __construct()
    {
        $this->valuestore = Valuestore::make(storage_path('app/instagramHistory.json'));
    }

    public function handle(PhotoFetched $event)
    {
        $this->addPhoto($event->photo);
    }

    public function addPhoto(array $photo)
    {
        $photos = $this->valuestore->get('photos', []);

        array_unshift($photos, $photo);

        $photos = array_slice($photos, 0, 50);

        $this->valuestore->put('photos', $photos);
    }

    public function getPhotos(): array
    {
        return $this->valuestore->get('photos', []);
    }

    public static function getHighestId(): int
    {
        return collect(static::all())
            ->sortByDesc('id')
            ->first()['id'] ?? 0;
    }

    public static function all(): array
    {
        return (new static())->getPhotos();
    }
}
