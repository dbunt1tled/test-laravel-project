<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 06.06.18
 * Time: 22:38
 */

namespace App\UseCases\Adverts;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Http\Requests\Adverts\SearchRequest;
use Elasticsearch\Client;
use Illuminate\Database\Query\Expression;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class SearchService
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(?Category $category, ?Region $region, SearchRequest $request, int $perPage, int $page):SearchResult
    {
        $values = array_filter((array)$request->input('attrs'), function ($value) {
            return !empty($value['equals']) || !empty($value['from']) || !empty($value['to']);
        });

        $response = $this->client->search([
            'index' => 'app',
            'type' => 'adverts',
            'body' => [
                '_source' => ['id'],
                'from' => ($page - 1) * $perPage,
                'size' => $perPage,
                'sort' => empty($request['text']) ? [
                    ['published_at' => ['order' => 'desc']],
                ] : [],
                'aggs' => [//аггрегация количество объявлений в группе
                    'group_by_region' => [
                        'terms' => [
                            'field' => 'regions',
                        ],
                    ],
                    'group_by_category' => [
                        'terms' => [
                            'field' => 'categories',
                        ],
                    ],
                ],
                'query' => [
                    'bool' => [
                        'must' => array_merge(//эти проверки должны быть обязательны
                            [
                                ['term' => ['status' => Advert::STATUS_ACTIVE]],
                            ],
                            array_filter([
                                $category ? ['term' => ['categories' => $category->id]] : false,
                                $region ? ['term' => ['regions' => $region->id]] : false,
                                !empty($request['text']) ? ['multi_match' => [//мульти поиск по нескольким полям
                                    'query' => $request['text'],
                                    'fields' => ['title^3','content'],//тайтл с весом 3 потом контент
                                ]] : false,
                            ]),
                            array_map(function ($value, $id) {
                                return [
                                    'nested' => [//проверки для вложенный элементов
                                        'path' => 'values',
                                        'query' => [
                                            'bool' => [
                                                'must' => array_values(array_filter([
                                                    ['match' => ['values.attribute' => $id]],
                                                    !empty($value['equals']) ? ['match' => ['values.value_string' => $value['equals']]] : false,
                                                    !empty($value['from']) ? ['range' => ['values.value_int' => ['gte' => $value['from']]]] : false,
                                                    !empty($value['to']) ? ['range' => ['values.value_int' => ['lte' => $value['to']]]] : false,
                                                    !empty($request['text']) ? ['match' => ['values.value_string' => $request['text']]] : false,
                                                    !empty($request['text']) ? ['match' => ['values.value_int' => $request['text']]] : false,/**/
                                                ])),
                                            ],
                                        ],
                                    ],
                                ];
                            }, $values, array_keys($values))
                        ),
                    ],
                ],
            ],
        ]);
        $ids = array_column($response['hits']['hits'], '_id');

        if($ids){
            $items = Advert::active()
                           ->with(['category', 'region'])
                           ->whereIn('id',$ids)
                           ->orderBy(new Expression('FIELD(id,' . implode(',', $ids) . ')'))
                           ->get();
            $pagination = new LengthAwarePaginator($items, $response['hits']['total'], $perPage, $page);
        }else {
            $pagination = new LengthAwarePaginator([], 0, $perPage, $page);
        }

        return new SearchResult(
            $pagination,
            array_column($response['aggregations']['group_by_region']['buckets'], 'doc_count', 'key'),
            array_column($response['aggregations']['group_by_category']['buckets'], 'doc_count', 'key')
        );

    }
}