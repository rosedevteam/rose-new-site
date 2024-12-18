<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Models\Category;
use Modules\Comment\Models\Comment;
use Modules\JobApplication\Models\JobApplication;
use Modules\JobOffer\Models\JobOffer;
use Modules\Menu\Models\Menu;
use Modules\Order\Models\Order;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;
use Modules\User\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $this->seedUsersAndPermissions();
        $this->seedPosts();
        $this->seedProducts();
        $this->seedOrders();
        $this->seedComments();
        $this->seedMenu();

    }

    private function seedUsersAndPermissions(): void
    {
        Permission::create(['name' => 'admin-panel']);
        //
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'delete-users']);
        Permission::create(['name' => 'restore-users']);
        //
        Permission::create(['name' => 'view-billings']);
        Permission::create(['name' => 'edit-billings']);
        Permission::create(['name' => 'create-billings']);
        Permission::create(['name' => 'delete-billings']);
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
        Permission::create(['name' => 'view-job-offers']);
        Permission::create(['name' => 'edit-job-offers']);
        Permission::create(['name' => 'create-job-offers']);
        Permission::create(['name' => 'delete-job-offers']);
        //
        Permission::create(['name' => 'view-job-applications']);
        Permission::create(['name' => 'edit-job-applications']);
        Permission::create(['name' => 'delete-job-applications']);
        //
        Permission::create(['name' => 'view-orders']);
        Permission::create(['name' => 'edit-orders']);
        Permission::create(['name' => 'create-orders']);
        Permission::create(['name' => 'delete-orders']);
        //
        Permission::create(['name' => 'view-menus']);
        Permission::create(['name' => 'edit-menus']);
        Permission::create(['name' => 'create-menus']);
        Permission::create(['name' => 'delete-menus']);
        //
        Permission::create(['name' => 'view-discounts']);
        Permission::create(['name' => 'edit-discounts']);
        Permission::create(['name' => 'create-discounts']);
        Permission::create(['name' => 'delete-discounts']);
        //
        Permission::create(['name' => 'set-role']);
        Permission::create(['name' => 'view-logs']);

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
            'first_name' => 'فرشاد',
            'password' => bcrypt('admin'),
            'phone' => '09125342039',
            'last_name' => 'رجب زاده',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user1->assignRole($admin);

        $user2 = User::factory()->create([
            'first_name' => 'writer',
            'password' => bcrypt('writer'),
            'phone' => '09122222222',
            'last_name' => 'writer',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user2->assignRole($writer);

        $user3 = User::factory()->create([
            'first_name' => 'support',
            'password' => bcrypt('support'),
            'phone' => '09123333333',
            'last_name' => 'support',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user3->assignRole($support);

        $user4 = User::factory()->create([
            'first_name' => 'customer',
            'password' => bcrypt('customer'),
            'phone' => '09124444444',
            'last_name' => 'customer',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user4->assignRole($customer);

        $user5 = User::factory()->create([
            'first_name' => 'ارشیا',
            'last_name' => 'رحیمی',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
            'phone' => '09399080252',
            'password' => null,
        ]);

        $user5->assignRole($admin);
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
            'slug' => "asdbniaskgadsg",
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
            'slug' => "asdbniadsg",
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
            'slug' => "aognasdgnasdbniadsg",
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
            'slug' => "asdbni234234adsg",
            'spot_player_key' => null
        ]);
    }

    private function seedPosts(): void
    {
        $json = \File::get(database_path() . '/posts.json');
        $data =  json_decode($json, true);

        foreach ($data as $item) {
            Post::create([
                'author_id' => 1,
                'title' => $item['title'],
                'content' => $item['content'],
                'status' => ($item['status'] == 'publish') ? 'public' : 'draft' ,
                'slug' => $item['slug'],
                'comment_status' => $item['comment_status'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ]);
        }
        $post1 = Post::factory()->create([
            'author_id' => 1,
            'title' => "شهسیذل",
            'content' => "asdkjasdg",
            'status' => 'public',
            'comment_status' => 0,
            'slug' => "asdbniadssasjgasgdfg"
        ]);
        $post2 = Post::factory()->create([
            'author_id' => 2,
            'title' => "شسهختیذدلهخ",
            'content' => "asdkjasdg",
            'status' => 'public',
            'comment_status' => 1,
            'slug' => "sdgg"
        ]);
        $post3 = Post::factory()->create([
            'author_id' => 3,
            'title' => "شهسیذل",
            'content' => "asdkjasdg",
            'status' => 'public',
            'comment_status' => 0,
            'slug' => "234sfegasofaw4"
        ]);
        $post4 = Post::factory()->create([
            'author_id' => 1,
            'title' => "شهسیذل",
            'content' => "asdkjasdg",
            'status' => 'public',
            'comment_status' => 0,
            'slug' => "asdf029340420"
        ]);
    }

    private function seedOrders(): void
    {
        $order1 = Order::factory()->create([
            'user_id' => 1,
            'price' => 2000000,
            'status' => "completed",
            'payment_method' => 'shaparak'
        ]);
        $order1->products()->attach([1, 2, 3]);

        $order2 = Order::factory()->create([
            'user_id' => 1,
            'price' => 1000000,
            'status' => "cancelled",
            'payment_method' => 'shaparak'
        ]);
        $order2->products()->attach([2]);

        $order3 = Order::factory()->create([
            'user_id' => 1,
            'price' => 2000000,
            'status' => "pending",
            'payment_method' => 'card'
        ]);
        $order3->products()->attach([3]);

        $order4 = Order::factory()->create([
            'user_id' => 1,
            'price' => 2000000,
            'status' => "returned",
            'payment_method' => 'shaparak'
        ]);
        $order4->products()->attach([1]);

    }

    private function seedComments(): void
    {
        $comment1 = Comment::factory()->create([
            'author_id' => 2,
            'commentable_id' => 1,
            'commentable_type' => '\\Modules\\Product\\Models\\Product',
            'status' => 'approved',
            'content' => "alskgong;qwbegqwbegipbqg",
        ]);
        $comment2 = Comment::factory()->create([
            'author_id' => 1,
            'commentable_id' => 1,
            'commentable_type' => '\\Modules\\Product\\Models\\Product',
            'status' => 'pending',
            'content' => "alskgong;qwbegqwbegipbqg",
        ]);

        $comment3 = Comment::factory()->create([
            'author_id' => 3,
            'commentable_id' => 2,
            'commentable_type' => '\\Modules\\Product\\Models\\Product',
            'status' => 'rejected',
            'content' => "asvdnawn;wgn;iweagbqiugi",
        ]);

        $parent = Category::factory()->create([
            'author_id' => 1,
            'name' => 'team',
            'is_parent' => true,
        ]);

        $category1 = Category::factory()->create([
            'author_id' => 1,
            'name' => 'بازار های مالی',
        ]);
        $category1->parent()->attach($parent->id);

        $category2 = Category::factory()->create([
            'author_id' => 1,
            'name' => 'مارگتینگ',
        ]);
        $category2->parent()->attach($parent->id);

        $c = JobOffer::factory()->create([
            'author_id' => 1,
            'title' => 'akjbfipasbug',
            'content' => 'asjdbg',
            'type' => 'afbaisdgb',
            'status' => 'active',
        ]);
        $c->categories()->attach($category1->id);

        $resume = JobApplication::factory()->create([
            'joboffer_id' => 1,
            'full_name' => "akjnga aoaiog",
            'email' => 'akjngaaoaiog@gmail.com',
            'phone' => '12546982365',
            'resume' => 'adfjka',
            'description' => null,
            'status' => 'pending',
        ]);
    }

    private function seedMenu()
    {
        Menu::factory()->create([
           'title' => 'صفحه نخست',
           'author_id' => 1,
           'link' => "#",
           'parent_id' => null,
           'order' => 0,
           'icon' => '#',
           'subtitle' => null,
       ]);
        Menu::factory()->create([
            'title' => 'دوره ها',
            'author_id' => 1,
            'link' => "#",
            'parent_id' => null,
            'order' => 1,
            'icon' => '#',
            'subtitle' => null,
        ]);
    }

}
