<?php

declare(strict_types=1);

namespace App\PostBundle\Domain\DTO\Response;

use App\PostBundle\Domain\Entity\Post;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: self::class,
    properties: [
        new OA\Property(property: 'items', description: 'Посты', type: 'array', items: new OA\Items(
            ref: new Model(
                type: Post::class, groups: ['default']
            )
        )),
        new OA\Property(property: 'pagination', description: 'Пагинация', type: 'array', items: new OA\Items(
            properties: [
                new OA\Property('currentPage', description: 'Текущая страница', type: 'integer'),
                new OA\Property('totalItems', description: 'Всего элементов', type: 'integer'),
                new OA\Property('totalPages', description: 'Всего страниц', type: 'integer'),
            ]
        ))
    ]
)]
readonly class GetPostByFilterResponse implements \JsonSerializable
{
    /**
     * @var array<Post>
     */
    private array $items;

    private array $pagination;

    public function __construct(
        array $items,
        array $pagination
    ) {
        $this->items = $items;
        $this->pagination = $pagination;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): array
    {
        return $this->pagination;
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => $this->getItems(),
            'pagination' => $this->getPagination(),
        ];
    }
}