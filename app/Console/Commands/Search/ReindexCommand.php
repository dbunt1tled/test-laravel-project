<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 25.06.18
 * Time: 22:55
 */

namespace App\Console\Commands\Search;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Value;
use App\Services\Search\AdvertIndexer;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    protected $signature = 'search:reindex';
    private   $indexer;

    public function __construct(AdvertIndexer $indexer)
    {
        parent::__construct();
        $this->indexer = $indexer;
    }

    public function handle(): bool
    {
        foreach (Advert::active()->orderBy('id')->cursor() as $advert) {
            $this->indexer->index($advert);
        }
        return true;
    }
}