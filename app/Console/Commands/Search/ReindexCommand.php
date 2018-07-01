<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 25.06.18
 * Time: 22:55
 */

namespace App\Console\Commands\Search;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Banner\Banner;
use App\Services\Search\AdvertIndexer;
use App\Services\Search\BannerIndexer;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    protected $signature = 'search:reindex';
    private $adverts;
    private $banners;

    public function __construct(AdvertIndexer $adverts, BannerIndexer $banner)
    {
        parent::__construct();
        $this->adverts = $adverts;
        $this->banners = $banner;
    }

    public function handle(): bool
    {
        $this->adverts->clear();
        foreach (Advert::active()->orderBy('id')->cursor() as $advert) {
            $this->adverts->index($advert);
        }
        $this->banners->clear();
        foreach (Banner::active()->orderBy('id')->cursor() as $banner) {
            $this->banners->index($banner);
        }
        return true;
    }
}