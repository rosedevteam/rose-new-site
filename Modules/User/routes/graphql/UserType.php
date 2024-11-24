<?php

namespace graphql;


use GraphQL\Type\Definition\Type;
use Modules\User\Models\User;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A user',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'alias' => 'user_id',
            ],
            'first_name' => [
                'type' => Type::string(),
            ],
            'last_name' => [
                'type' => Type::string(),
            ],
            'phone' => [
                'type' => Type::string(),
            ],
            'email' => [
                'type' => Type::string(),
            ],
            'birthday' => [
                'type' => Type::string(),
            ],
            'avatar' => [
                'type' => Type::string(),
            ],
            'created_at' => [
                'type' => Type::string(),
            ],
            'updated_at' => [
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return User::query()->where('id', $args['id'])->get();
        }
        if (isset($args['first_name'])) {
            return User::query()->where('first_name', $args['first_name'])->get();
        }
        if (isset($args['last_name'])) {
            return User::query()->where('last_name', $args['last_name'])->get();
        }
        if (isset($args['phone'])) {
            return User::query()->where('phone', $args['phone'])->get();
        }
        if (isset($args['email'])) {
            return User::query()->where('email', $args['email'])->get();
        }
        if (isset($args['created_at'])) {
            return User::query()->where('created_at', $args['created_at'])->get();
        }
        if (isset($args['updated_at'])) {
            return User::query()->where('updated_at', $args['updated_at'])->get();
        }
        return User::all();
    }
}
