<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Order\Models\Order;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;
use Modules\User\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $this->seedUsersAndPermissions();
        $this->seedProducts();
        $this->seedPosts();
        $this->seedOrders();
    }

    private function seedUsersAndPermissions(): void
    {
        Permission::create(['name' => 'admin-panel']);
        //
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'delete-users']);
        //
        Permission::create(['name' => 'view-daily-reports']);
        Permission::create(['name' => 'edit-daily-reports']);
        Permission::create(['name' => 'create-daily-reports']);
        Permission::create(['name' => 'delete-daily-reports']);
        //
        Permission::create(['name' => 'view-posts']);
        Permission::create(['name' => 'edit-posts']);
        Permission::create(['name' => 'create-posts']);
        Permission::create(['name' => 'delete-posts']);
        //
        Permission::create(['name' => 'view-comments']);
        Permission::create(['name' => 'edit-comments']);
        Permission::create(['name' => 'delete-comments']);
        //
        Permission::create(['name' => 'view-products']);
        Permission::create(['name' => 'edit-products']);
        Permission::create(['name' => 'create-products']);
        Permission::create(['name' => 'delete-products']);
        //

        Permission::create(['name' => 'view-orders']);
        Permission::create(['name' => 'edit-orders']);
        Permission::create(['name' => 'create-orders']);
        Permission::create(['name' => 'delete-orders']);
        //
        Permission::create(['name' => 'view-logs']);
        Permission::create(['name' => 'promote-user']);

        $customer = Role::create(['name' => 'مشتری']);
        $admin = Role::create(['name' => 'ادمین']);
        $writer = Role::create(['name' => 'نویسنده']);
        $support = Role::create(['name' => 'پشتیبان']);

        $admin->givePermissionTo(Permission::all());

        $writer->givePermissionTo([
            'admin-panel',
            'view-daily-reports',
            'create-daily-reports',
            'delete-daily-reports',
            'edit-daily-reports',
            'view-posts',
            'edit-posts',
            'create-posts',
            'delete-posts',
            'view-products',
            'edit-products',
            'create-products',
            'delete-products',
        ]);

        $support->givePermissionTo([
            'admin-panel',
            'view-users',
            'edit-users',
            'create-users',
            'delete-users',
            'view-comments',
            'edit-comments',
            'delete-comments',
            'view-orders',
            'edit-orders',
            'create-orders',
            'delete-orders',
        ]);

        $user1 = User::factory()->create([
            'first_name' => 'admin',
            'password' => bcrypt('admin'),
            'phone' => '123456789',
            'last_name' => 'admin',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user1->assignRole($superAdmin);

        $user2 = User::factory()->create([
            'first_name' => 'writer',
            'password' => bcrypt('writer'),
            'phone' => '111111111',
            'last_name' => 'writer',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user2->assignRole($writer);

        $user3 = User::factory()->create([
            'first_name' => 'support',
            'password' => bcrypt('support'),
            'phone' => '333333333',
            'last_name' => 'support',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user3->assignRole($support);

        $user4 = User::factory()->create([
            'first_name' => 'customer',
            'password' => bcrypt('customer'),
            'phone' => '222222222',
            'last_name' => 'customer',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user4->assignRole($customer);
    }

    private function seedProducts(): void
    {
        $product1 = Product::factory()->create([
            'title' => "هخشصذدلهخصشلد",
            'author_id' => 1,
            'price' => 2000000,
            'short_description' => "هشذلحهشذسلشخسلدشسجخیلدشسجخلدشخسهیلجخیشسدخجهدذشسجخدذجشخسیدهذشسدذخهجش",
            'sale_price' => 1500000,
            'content' => "asdfn;onasgA",
            'status' => 'public',
            'comment_status' => 1,
            'image' => "asdijbnag",
            'url' => "asdbniadsg",
            'spot_player_key' => null
        ]);
        $product2 = Product::factory()->create([
            'title' => "هخشصذدلهخصشلد",
            'author_id' => 1,
            'price' => 2000000,
            'short_description' => "هشذلحهشذسلشخسلدشسجخیلدشسجخلدشخسهیلجخیشسدخجهدذشسجخدذجشخسیدهذشسدذخهجش",
            'sale_price' => 1900000,
            'content' => "asdfn;onasgA",
            'status' => 'draft',
            'comment_status' => 0,
            'image' => "asdijbnag",
            'url' => "asdbniadsg",
            'spot_player_key' => null
        ]);
        $product3 = Product::factory()->create([
            'title' => "شسیمتهلدشل",
            'author_id' => 3,
            'price' => 3000000,
            'short_description' => "شسذهل",
            'sale_price' => 1500000,
            'content' => "asdfn;onasgA",
            'status' => 'hidden',
            'comment_status' => 1,
            'image' => "asdijbnag",
            'url' => "asdbniadsg",
            'spot_player_key' => null
        ]);
        $product4 = Product::factory()->create([
            'title' => "هخشصذدلهخصشلد",
            'author_id' => 2,
            'price' => 2000000,
            'short_description' => "هشذلحهشذسلشخسلدشسجخیلدشسجخلدشخسهیلجخیشسدخجهدذشسجخدذجشخسیدهذشسدذخهجش",
            'sale_price' => 1500000,
            'content' => "asdfn;onasgA",
            'status' => 'public',
            'comment_status' => 0,
            'image' => "asdijbnag",
            'url' => "asdbniadsg",
            'spot_player_key' => null
        ]);
    }

    private function seedPosts(): void
    {
        $post1 = Post::factory()->create([
            'author_id' => 1,
            'title' => "شهسیذل",
            'content' => "asdkjasdg",
            'status' => 'public',
            'comment_status' => 0,
            'url' => "asdbniadssdfg"
        ]);
        $post2 = Post::factory()->create([
            'author_id' => 2,
            'title' => "شسهختیذدلهخ",
            'content' => "asdkjasdg",
            'status' => 'public',
            'comment_status' => 1,
            'url' => "sdgg"
        ]);
        $post3 = Post::factory()->create([
            'author_id' => 3,
            'title' => "شهسیذل",
            'content' => "asdkjasdg",
            'status' => 'public',
            'comment_status' => 0,
            'url' => "234sfeg"
        ]);
        $post4 = Post::factory()->create([
            'author_id' => 1,
            'title' => "شهسیذل",
            'content' => "asdkjasdg",
            'status' => 'public',
            'comment_status' => 0,
            'url' => "asdf"
        ]);
    }

    private function seedOrders(): void
    {
        $order1 = Order::factory()->create([
            'user_id' => 1,
            'product_id' => 1,
            'price' => 2000000,
            'status' => "completed",
            'payment_method' => 'shaparak'
        ]);

        $order2 = Order::factory()->create([
            'user_id' => 1,
            'product_id' => 2,
            'price' => 1000000,
            'status' => "cancelled",
            'payment_method' => 'shaparak'
        ]);

        $order3 = Order::factory()->create([
            'user_id' => 1,
            'product_id' => 3,
            'price' => 2000000,
            'status' => "pending",
            'payment_method' => 'card'
        ]);

        $order4 = Order::factory()->create([
            'user_id' => 1,
            'product_id' => 3,
            'price' => 2000000,
            'status' => "returned",
            'payment_method' => 'shaparak'
        ]);

    }
}
