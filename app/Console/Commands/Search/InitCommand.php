<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 25.06.18
 * Time: 22:55
 */

namespace App\Console\Commands\Search;

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class InitCommand extends Command
{
    protected $signature = 'search:init';
    private $client;

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    public function handle()
    {
        $this->initAdverts();
        $this->initBanners();
    }

    public function initBanners():bool
    {
        try {
            $this->client->indices()->delete([
                'index' => 'banners',
            ]);
        } catch (Missing404Exception $e) {}

        $this->client->indices()->create([
            'index' => 'banners',
            'body' => [
                'mappings' => [
                    'banner' => [
                        '_source' => [
                            'enabled' => true,
                        ],
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'status' => [
                                'type' => 'keyword',
                            ],
                            'format' => [
                                'type' => 'keyword',
                            ],
                            'categories' => [
                                'type' => 'integer',
                            ],
                            'regions' => [
                                'type' => 'integer',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        return true;
    }
    public function initAdverts(): bool
    {
        try {
            $this->client->indices()->delete([
                    'index' => 'app',
                ]);
        } catch (Missing404Exception $e) {}

        $this->client->indices()->create([
            'index' => 'app',
            'body'  => [
                'mappings' => [
                    'adverts' => [
                        '_source'    => [
                            'enabled' => true,// false возвращаются только id's, true - возвращается контент и id's
                        ],
                        'properties' => [// указывается поля и типы для сохранения
                             'id'           => [
                                 'type' => 'integer',
                             ],
                             'published_at' => [
                                 'type' => 'date',
                             ],
                             'title' => [
                                 'type' => 'text',
                                 'analyzer' => 'super',
                             ],
                             'content' => [
                                 'type' => 'text',
                             ],
                             'price' => [
                                 'type' => 'integer',
                             ],
                             'status' => [
                                 'type' => 'keyword',//просто хранить без индексации стравнивается по равенству а не по like (поскольку оно у нас текстовое)
                             ],
                             'categories' => [
                                'type' => 'integer',
                             ],
                             'regions' => [
                                 'type' => 'integer',
                             ],
                             'values' => [
                                 'type' => 'nested',//тип вложенный элемент
                                 'properties' => [
                                     'attribute' => [
                                         'type' => 'integer',
                                     ],
                                     'value_string' => [
                                         'type' => 'keyword',
                                     ],
                                     'value_int' => [
                                         'type' => 'integer',
                                     ],
                                 ],
                             ],
                        ],
                    ],
                ],
                'settings' => [//Настройки Ларавел по умолчанию ничего не меняли просто показали список
                    'analysis' => [
                        'char_filter' => [
                            'replace' => [
                                'type' => 'mapping',
                                'mappings' => [
                                    '&=> and '
                                ],
                            ],
                        ],
                        'filter' => [
                            'word_delimiter' => [
                                'type' => 'word_delimiter',
                                'split_on_numerics' => false,
                                'split_on_case_change' => true,
                                'generate_word_parts' => true,
                                'generate_number_parts' => true,
                                'catenate_all' => true,
                                'preserve_original' => true,
                                'catenate_numbers' => true,
                            ],
                            'trigrams' => [
                                'type' => 'ngram',//фильтр берет текст разбивает по три буквы
                                'min_gram' => 3,
                                'max_gram' => 6,
                            ],
                        ],
                        'analyzer' => [
                            'default' => [
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                    'replace',
                                ],
                                'tokenizer' => 'whitespace',
                                'filter' => [
                                    'lowercase',
                                    'word_delimiter',
                                ],
                            ],
                            'super' => [
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                    'replace',
                                ],
                                'tokenizer' => 'whitespace',
                                'filter' => [
                                    'lowercase',
                                    'word_delimiter',
                                    'trigrams'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        return true;
    }
}