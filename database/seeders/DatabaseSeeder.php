<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Comment\Models\Comment;
use Modules\Menu\Models\Menu;
use Modules\Order\Models\Order;
use Modules\Payment\Models\Payment;
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
        $this->seedPayments();
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
        Permission::create(['name' => 'view-categories']);
        Permission::create(['name' => 'edit-categories']);
        Permission::create(['name' => 'create-categories']);
        Permission::create(['name' => 'delete-categories']);
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
        Permission::create(['name' => 'view-student-reports']);
        Permission::create(['name' => 'edit-student-reports']);
        Permission::create(['name' => 'create-student-reports']);
        Permission::create(['name' => 'delete-student-reports']);
        //
        Permission::create(['name' => 'set-roles']);
        Permission::create(['name' => 'view-logs']);
        //
        Permission::create(['name' => 'edit-page']);
        Permission::create(['name' => 'create-page']);

        $customer = Role::create(['name' => 'مشتری']);
        $admin = Role::create(['name' => 'ادمین']);
        $writer = Role::create(['name' => 'نویسنده']);
        $support = Role::create(['name' => 'پشتیبان']);
        $superAdmin = Role::create(['name' => 'super-admin']);

        $admin->givePermissionTo(Permission::all());
        $superAdmin->givePermissionTo(Permission::all());

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

        $user5->assignRole($superAdmin);
    }

    private function seedProducts(): void
    {
        $product1 = Product::factory()->create([
            'title' => "دوره تخصصی FIS",
            'user_id' => 1,
            'price' => 11000000,
            'short_description' => "",
            'sale_price' => 5460000,
            'content' => "test",
            'status' => 'draft',
            'comment_status' => 1,
            'image' => "",
            'slug' => "dore-fis",
            'duration'=> '+۴۰ ساعت',
            'spot_player_key' => '619636a27ff03979c37fc360'
        ]);
        $product2 = Product::factory()->create([
            'title' => "مسیر ثروت ساز با آموزش طلا و نقره",
            'user_id' => 1,
            'price' => 3000000,
            'short_description' => "",
            'sale_price' => 1299000,
            'content' => "",
            'status' => 'draft',
            'comment_status' => 0,
            'image' => "",
            'slug' => "masir-servat-saz",
            'duration'=> '+۴۰ ساعت',
            'spot_player_key' => '6210b0b5637d0950ee5ea2bb'
        ]);
        $product3 = Product::factory()->create([
            'title' => "مینی دوره مدیریت بحران مالی",
            'user_id' => 1,
            'price' => 0,
            'short_description' => "شسذهل",
            'sale_price' => null,
            'content' => "",
            'status' => 'public',
            'comment_status' => 1,
            'image' => "asdijbnag",
            'slug' => "modirat-mali",
            'duration'=> '+۴۰ ساعت',
            'spot_player_key' => null
        ]);
        $product4 = Product::factory()->create([
            'title' => "دوره حسابدار نخبه",
            'user_id' => 1,
            'price' => 13000000,
            'short_description' => "نه تنها در کشور ما بلکه در تمامی کشورهای دنیا ، افرادی  که اگاهی و دانش در مسائل مالی دارند از درآمد بالایی برخوردارند و  مجموعه آموزشی رز مفتخر است به صورت کامل و جامع …",
            'sale_price' => 4599000,
            'content' => "",
            'status' => 'public',
            'comment_status' => 1,
            'image' => "",
            'slug' => "hesabdar-nokhbe",
            'duration'=> '+۴۰ ساعت',
            'spot_player_key' => '635faca3dc6fbb9779bf0164'
        ]);

        $product5 = Product::factory()->create([
            'title' => "دوره تخصصی FAC ( بنیادی ارز دیجیتال )",
            'user_id' => 1,
            'price' => 13000000,
            'short_description' => "نه تنها در کشور ما بلکه در تمامی کشورهای دنیا ، افرادی  که اگاهی و دانش در مسائل مالی دارند از درآمد بالایی برخوردارند و  مجموعه آموزشی رز مفتخر است به صورت کامل و جامع …",
            'sale_price' => 4360000,
            'content' => "",
            'status' => 'draft',
            'comment_status' => 1,
            'image' => "",
            'slug' => "fac-course",
            'duration'=> '+۴۰ ساعت',
            'spot_player_key' => null
        ]);

        $product6 = Product::factory()->create([
            'title' => "دوره جامع بنیادی بورس (FIS + افزایش سرمایه)",
            'user_id' => 1,
            'price' => 17950000,
            'short_description' => "نه تنها در کشور ما بلکه در تمامی کشورهای دنیا ، افرادی  که اگاهی و دانش در مسائل مالی دارند از درآمد بالایی برخوردارند و  مجموعه آموزشی رز مفتخر است به صورت کامل و جامع …",
            'sale_price' => 9498000,
            'content' => "",
            'status' => 'draft',
            'comment_status' => 1,
            'image' => "",
            'slug' => "dore-jame",
            'duration'=> '+۴۰ ساعت',
            'spot_player_key' => null
        ]);

        $product7 = Product::factory()->create([
            'title' => "مدیریت زندگی مالی (FLM)",
            'user_id' => 1,
            'price' => 8000000,
            'short_description' => "در دنیای پرشتاب و پیچیده بازارهای مالی، معامله‌گری صرفاً به دانش و علم مالی محدود نمی‌شود، قدرت ذهن و هوش روانشناختی نقشی اساسی در کسب سود و پرهیز از ضرر و همچنین موفقیت …",
            'sale_price' => 2990000,
            'content' => "",
            'status' => 'public',
            'comment_status' => 1,
            'image' => "",
            'slug' => "flm-course",
            'duration'=> '+۴۰ ساعت',
            'spot_player_key' => '65e56b64f0db10220b5b8758'
        ]);



    }

    private function seedPosts(): void
    {
        $json = \File::get(database_path() . '/posts.json');
        $data = json_decode($json, true);

        foreach ($data as $item) {
            Post::create([
                'user_id' => 1,
                'title' => $item['title'],
                'content' => $item['content'],
                'status' => ($item['status'] == 'publish') ? 'public' : 'draft',
                'slug' => urldecode($item['slug']),
                'comment_status' => $item['comment_status'] == 'open',
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ]);
        }
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
            'status' => "completed",
            'payment_method' => 'shaparak',
            'spot_player_licence' => 'SADFasfsfgaergaer',
            'spot_player_id' => '234dfgrth',
            'spot_player_log' => 'لایسنس با موفقیت ساخته شد',
            'spot_player_watermark' => '09125342039',
        ]);
        $order2->products()->attach([1]);

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

    private function seedPayments()
    {
        $payment1 = Payment::factory()->create([
            'resnumber' => 'dqwfAF',
            'order_id' => 1,
            'status' => 1
        ]);
    }

    private function seedComments(): void
    {
        $comment1 = Comment::factory()->create([
            'user_id' => 2,
            'commentable_id' => 1,
            'commentable_type' => 'Modules\\Product\\Models\\Product',
            'status' => 'approved',
            'content' => "alskgong;qwbegqwbegipbqg",
        ]);
        $comment2 = Comment::factory()->create([
            'user_id' => 1,
            'commentable_id' => 1,
            'commentable_type' => 'Modules\\Product\\Models\\Product',
            'status' => 'pending',
            'content' => "alskgong;qwbegqwbegipbqg",
        ]);

        $comment3 = Comment::factory()->create([
            'user_id' => 3,
            'commentable_id' => 2,
            'commentable_type' => 'Modules\\Product\\Models\\Product',
            'status' => 'rejected',
            'content' => "asvdnawn;wgn;iweagbqiugi",
        ]);

    }

    private function seedMenu()
    {
        Menu::factory()->create([
            'title' => 'صفحه نخست',
            'user_id' => 1,
            'slug' => "#",
            'parent_id' => null,
            'order' => 0,
            'icon' => '#',
            'subtitle' => null,
        ]);
        Menu::factory()->create([
            'title' => 'دوره ها',
            'user_id' => 1,
            'slug' => "#",
            'parent_id' => null,
            'order' => 1,
            'icon' => '#',
            'subtitle' => null,
        ]);
    }

}
