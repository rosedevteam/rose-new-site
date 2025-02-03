<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Analytics\Models\company;
use Modules\Analytics\Models\index;
use Modules\Category\Models\Category;
use Modules\Comment\Models\Comment;
use Modules\Discount\Models\Discount;
use Modules\Menu\Models\Menu;
use Modules\Order\Models\Order;
use Modules\Payment\Models\Payment;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;
use Modules\Referral\Models\Referral;
use Modules\User\Models\User;
use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Models\WalletTransaction;
use phpDocumentor\Reflection\File;
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
        $this->seedWallet();
//        $this->seedPayments();
        $this->seedComments();
        $this->seedMenu();
        $this->seedCategories();
//        $this->seedDiscounts();
//        $this->seedIndices();
//        $this->seedCompanies();
    }

    private function seedUsersAndPermissions()
    {
        // permission format: {action}-{model}
        Permission::create(['name' => 'admin-panel']);
        //
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);
        //
        Permission::create(['name' => 'view-billings']);
        Permission::create(['name' => 'create-billings']);
        Permission::create(['name' => 'edit-billings']);
        Permission::create(['name' => 'delete-billings']);
        //
        Permission::create(['name' => 'view-daily-reports']);
        Permission::create(['name' => 'create-daily-reports']);
        Permission::create(['name' => 'edit-daily-reports']);
        Permission::create(['name' => 'delete-daily-reports']);
        //
        Permission::create(['name' => 'view-posts']);
        Permission::create(['name' => 'create-posts']);
        Permission::create(['name' => 'edit-posts']);
        Permission::create(['name' => 'delete-posts']);
        //
        Permission::create(['name' => 'view-products']);
        Permission::create(['name' => 'create-products']);
        Permission::create(['name' => 'edit-products']);
        Permission::create(['name' => 'delete-products']);
        //
        Permission::create(['name' => 'view-job-offers']);
        Permission::create(['name' => 'create-job-offers']);
        Permission::create(['name' => 'edit-job-offers']);
        Permission::create(['name' => 'delete-job-offers']);
        //
        Permission::create(['name' => 'view-categories']);
        Permission::create(['name' => 'create-categories']);
        Permission::create(['name' => 'edit-categories']);
        Permission::create(['name' => 'delete-categories']);
        //
        Permission::create(['name' => 'view-orders']);
        Permission::create(['name' => 'create-orders']);
        Permission::create(['name' => 'edit-orders']);
        Permission::create(['name' => 'delete-orders']);
        //
        Permission::create(['name' => 'view-menus']);
        Permission::create(['name' => 'create-menus']);
        Permission::create(['name' => 'edit-menus']);
        Permission::create(['name' => 'delete-menus']);
        //
        Permission::create(['name' => 'view-discounts']);
        Permission::create(['name' => 'create-discounts']);
        Permission::create(['name' => 'edit-discounts']);
        Permission::create(['name' => 'delete-discounts']);
        //
        Permission::create(['name' => 'view-podcasts']);
        Permission::create(['name' => 'create-podcasts']);
        Permission::create(['name' => 'edit-podcasts']);
        Permission::create(['name' => 'delete-podcasts']);
        //
        Permission::create(['name' => 'view-student-reports']);
        Permission::create(['name' => 'create-student-reports']);
        Permission::create(['name' => 'edit-student-reports']);
        Permission::create(['name' => 'delete-student-reports']);
        //
        Permission::create(['name' => 'view-wallet-transactions']);
        Permission::create(['name' => 'create-wallet-transactions']);
        Permission::create(['name' => 'edit-wallet-transactions']);
        Permission::create(['name' => 'delete-wallet-transactions']);
        //
        Permission::create(['name' => 'view-comments']);
        Permission::create(['name' => 'edit-comments']);
        Permission::create(['name' => 'delete-comments']);
        //
        Permission::create(['name' => 'view-job-applications']);
        Permission::create(['name' => 'edit-job-applications']);
        Permission::create(['name' => 'delete-job-applications']);
        //
        Permission::create(['name' => 'edit-page']);
        Permission::create(['name' => 'create-page']);
        //
        Permission::create(['name' => 'manage-roles']);
        Permission::create(['name' => 'assign-roles']);
        //
        Permission::create(['name' => 'manage-channels']);
        Permission::create(['name' => 'create-channels']);
        Permission::create(['name' => 'view-channel-members-count']);
        Permission::create(['name' => 'edit-channel-subscriptions']);
        //
        Permission::create(['name' => 'manage-subscriptions']);
        //
        Permission::create(['name' => 'view-reserves']);
        Permission::create(['name' => 'sendSMS-reserves']);
        //
        Permission::create(['name' => 'view-carts']);
        //
        Permission::create(['name' => 'view-statistics']);
        //
        Permission::create(['name' => 'view-logs']);
        //
        Permission::create(['name' => 'create-licence']);
        Permission::create(['name' => 'view-licence']);

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
            'phone' => '09121230374',
            'last_name' => 'رجب زاده',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user1->assignRole($superAdmin);

        $user2 = User::factory()->create([
            'first_name' => 'ارشیا',
            'password' => bcrypt('admin'),
            'phone' => '09399080252',
            'last_name' => 'رحیمی',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        $user2->assignRole($superAdmin);


        $json = \File::get(database_path() . '/users.json');
        $users = json_decode($json, true, flags: JSON_UNESCAPED_UNICODE);

        foreach ($users as $user) {
            if(!User::where('phone' , $user['user_login'])->exists()){
                $cust = User::factory()->create([
                    'id' => $user['user_id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'] == "" ? null : $user['last_name'],
                    'phone' => $user['user_login'],
                    'email' => $user['user_email'] == "" ? null : $user['user_email'],
                    'birthday' => null,
                    'created_at' => $user['user_registered'],
                ]);
                $cust->assignRole($customer);
            }

        }
    }

    private function seedProducts()
    {
        $file = \File::get(database_path() . '/products.json');
        $products = json_decode($file, true, JSON_UNESCAPED_UNICODE);
        Product::factory()->create([
            'id' => '15361',
            'user_id' => 1,
            'title' => 'تست',
            'short_description' => 'تست',
            'price' => 0,
            'slug' => '15361',
            'status' => 'draft',
            'comment_status' => 0
        ]);
        Product::factory()->create([
            'id' => '15375',
            'user_id' => 1,
            'title' => 'تست',
            'short_description' => 'تست',
            'price' => 0,
            'slug' => '15375',
            'status' => 'draft',
            'comment_status' => 0
        ]);
        Product::factory()->create([
            'id' => '14553',
            'user_id' => 1,
            'title' => 'مصاحبه استخدامی رشته حسابداری',
            'short_description' => 'تست',
            'price' => 0,
            'slug' => '14553',
            'status' => 'draft',
            'comment_status' => 0
        ]);
        Product::factory()->create([
            'id' => '15405',
            'user_id' => 1,
            'title' => 'مصاحبه استخدامی رشته حسابداری',
            'short_description' => 'تست',
            'price' => 0,
            'slug' => '15405',
            'status' => 'draft',
            'comment_status' => 0
        ]);
        Product::factory()->create([
            'id' => '15852',
            'user_id' => 1,
            'title' => 'تست',
            'short_description' => 'تست',
            'price' => 0,
            'slug' => '15852',
            'status' => 'draft',
            'comment_status' => 0
        ]);
        Product::factory()->create([
            'id' => '23042',
            'user_id' => 1,
            'title' => 'تست',
            'short_description' => 'تست',
            'price' => 0,
            'slug' => '23042',
            'status' => 'draft',
            'comment_status' => 0
        ]);
        Product::factory()->create([
            'id' => '26625',
            'user_id' => 1,
            'title' => 'تست',
            'short_description' => 'تست',
            'price' => 0,
            'slug' => '26625',
            'status' => 'draft',
            'comment_status' => 0
        ]);
        foreach ($products as $product) {
            switch ($product['post_status']) {
                case 'publish':
                    $product['post_status'] = 'public';
                    break;
                case 'private':
                    $product['post_status'] = 'hidden';
            }
            Product::factory()->create([
                'id' => $product['ID'],
                'user_id' => 1,
                'title' => $product['post_title'],
                'short_description' => $product['post_excerpt'],
                'price' => 0,
                'slug' => $product['ID'],
                'status' => $product['post_status'],
                'comment_status' => $product['comment_status'] == 'open' ? 1 : 0,
                'created_at' => $product['post_date'],
                'updated_at' => $product['post_modified'],
            ]);
        }
    }

    private function seedPosts()
    {
        $json = \File::get(database_path() . '/posts.json');
        $data = json_decode($json, true, flags: JSON_UNESCAPED_UNICODE);

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

    private function seedOrders()
    {
        $file = \File::get(database_path() . '/orders.json');
        $orders = json_decode($file, true, flags: JSON_UNESCAPED_UNICODE);
        foreach ($orders as $order) {

            if ($order['user_id'] == 0) continue;
            $spotdata = unserialize($order['spot_player']);
            switch ($order['order_status']) {
                case 'wc-completed':
                    $order['order_status'] = 'completed';
                    break;

                case 'wc-pending' || 'wc-processing':
                    $order['order_status'] = 'pending';
                    break;
                case 'wc-cancelled' || 'wc-failed':
                    $order['order_status'] = 'cancelled';
                    break;
            }
            $item = Order::factory()->create([
                'id' => $order['order_id'],
                'user_id' => $order['user_id'],
                'price' => $order['order_total'],
                'status' => $order['order_status'],
                'spot_player_id' => $spotdata['_id'] ?? null,
                'spot_player_licence' => $spotdata['key'] ?? null,
                'spot_player_watermark' => $spotdata['watermark']['texts'][0]['text'] ?? null,
            ]);

            $item->products()->attach(explode(',' , $order['product_ids']));
        }
    }

    private function seedWallet()
    {
        $file = \File::get(database_path() . '/wallet.json');
        $wallets = json_decode($file, true, flags: JSON_UNESCAPED_UNICODE);
        foreach ($wallets as $wallet) {
            $user = User::where('id' , $wallet['user_id'])->first();
            if (!$user) continue;
            $user->wallet->transactions()->create([
                'user_id' => 1,
                'description' => $wallet['details'],
                'type' => $wallet['type'],
                'amount' => round($wallet['amount']),
                'created_at' => $wallet['date'],
            ]);
        }
    }
    private function seedPayments()
    {
        $payment1 = Payment::factory()->create([
            'resnumber' => 'dqwfAF',
            'order_id' => 1,
            'status' => 1
        ]);
    }

    private function seedComments()
    {
        $comment1 = Comment::factory()->create([
            'user_id' => 1,
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
            'user_id' => 1,
            'commentable_id' => 2,
            'commentable_type' => 'Modules\\Product\\Models\\Product',
            'status' => 'rejected',
            'content' => "asvdnawn;wgn;iweagbqiugi",
        ]);

        $comment4 = Comment::factory()->create([
            'user_id' => 1,
            'commentable_id' => 2,
            'commentable_type' => 'Modules\\Product\\Models\\Product',
            'status' => 'approved',
            'parent_id' => 1,
            'content' => "پاسخ",
        ]);

    }

    private function seedMenu()
    {
        Menu::factory()->create([
            'title' => 'صفحه نخست',
            'user_id' => 1,
            'slug' => "/",
            'parent_id' => null,
            'order' => 0,
            'icon' => null,
            'subtitle' => null,
        ]);
        Menu::factory()->create([
            'title' => 'دوره ها',
            'user_id' => 1,
            'slug' => "#",
            'parent_id' => null,
            'order' => 1,
            'icon' => null,
            'subtitle' => null,
        ]);
        Menu::factory()->create([
            'title' => 'آموزش ها',
            'user_id' => 1,
            'slug' => "#",
            'parent_id' => null,
            'order' => 2,
            'icon' => null,
            'subtitle' => null,
        ]);
        Menu::factory()->create([
            'title' => 'گزارش روزانه بازار',
            'user_id' => 1,
            'slug' => "/گزارشات-روزانه-بازار",
            'parent_id' => null,
            'order' => 3,
            'icon' => null,
            'subtitle' => null,
        ]);
        Menu::factory()->create([
            'title' => 'تحلیل دانشپذیران',
            'user_id' => 1,
            'slug' => "/تحلیل-های-دانشپذیران",
            'parent_id' => null,
            'order' => 4,
            'icon' => null,
            'subtitle' => null,
        ]);
        Menu::factory()->create([
            'title' => 'ارتباط با ما',
            'user_id' => 1,
            'slug' => "#",
            'parent_id' => null,
            'order' => 5,
            'icon' => null,
            'subtitle' => null,
        ]);
        Menu::factory()->create([
            'title' => 'امتیازدهی',
            'user_id' => 1,
            'slug' => "#",
            'parent_id' => null,
            'order' => 6,
            'icon' => null,
            'subtitle' => null,
        ]);
        Menu::factory()->create([
            'title' => 'دوره های آموزشی',
            'user_id' => 1,
            'slug' => "/products",
            'parent_id' => 2,
            'order' => 0,
            'icon' => 'graduate-hat-square.svg',
            'subtitle' => 'لیست دوره های آموزشی ویدیویی رز',
        ]);
        Menu::factory()->create([
            'title' => 'بازنشستگی در ۷ سال',
            'user_id' => 1,
            'slug' => "/retirement-in-7-years",
            'parent_id' => 2,
            'order' => 1,
            'icon' => 'target-goal.svg',
            'subtitle' => 'مسیر درست زندگی!',
        ]);
        Menu::factory()->create([
            'title' => 'وبلاگ',
            'user_id' => 1,
            'slug' => "/blog",
            'parent_id' => 3,
            'order' => 0,
            'icon' => 'programming-code-list.svg',
            'subtitle' => 'مقالات عملی',
        ]);
        Menu::factory()->create([
            'title' => 'پادکست',
            'user_id' => 1,
            'slug' => "/podcast",
            'parent_id' => 3,
            'order' => 1,
            'icon' => 'headphones.svg',
            'subtitle' => 'فایل های صوتی آموزشی',
        ]);
        Menu::factory()->create([
            'title' => 'درباره ما',
            'user_id' => 1,
            'slug' => "/about",
            'parent_id' => 6,
            'order' => 1,
            'icon' => 'News-Bookmark-1.svg',
            'subtitle' => 'آشنایی با مجموعه آموزشی رز',
        ]);
        Menu::factory()->create([
            'title' => 'همکاری با ما',
            'user_id' => 1,
            'slug' => "/همکاری-با-ما",
            'parent_id' => 6,
            'order' => 2,
            'icon' => 'star-review-1.svg',
            'subtitle' => 'جهت همکاری با محموعه در زمینه های مختلف',
        ]);
        Menu::factory()->create([
            'title' => 'تماس با ما',
            'user_id' => 1,
            'slug' => "/contact",
            'parent_id' => 6,
            'order' => 3,
            'icon' => 'Headphones-Customer-support-1.svg',
            'subtitle' => 'راههای ارتباطی مخموعه آموزشی رز',
        ]);
        Menu::factory()->create([
            'title' => 'هم مسیر',
            'user_id' => 1,
            'slug' => "/ham-masir",
            'parent_id' => 7,
            'order' => 1,
            'icon' => 'crystal.svg',
            'subtitle' => 'آشنایی با جزییات هم مسیر',
        ]);
    }

    private function seedCategories()
    {
        Category::factory()->create([
            'type' => 'joboffer',
            'name' => 'بازار های مالی',
            'user_id' => 1,
        ]);
        Category::factory()->create([
            'type' => 'joboffer',
            'name' => 'مارکتینگ',
            'user_id' => 1,
        ]);
        Category::factory()->create([
            'type' => 'post',
            'name' => 'بورس',
            'user_id' => 1,
        ]);
        Category::factory()->create([
            'type' => 'post',
            'name' => 'مقالات',
            'user_id' => 1,
        ]);
        Category::factory()->create([
            'type' => 'product',
            'name' => 'رایگان',
            'user_id' => 1,
        ]);
        Category::factory()->create([
            'type' => 'product',
            'name' => 'حضوری',
            'user_id' => 1,
        ]);
    }

    public function seedDiscounts()
    {
        $discount = Discount::factory()->create([
            'user_id' => 1,
            'code' => 'pedar1403',
            'type' => 'amount',
            'amount' => 1000000,
            'is_active' => 1,
            'limit' => 6,
            'expires_at' => now()->addDays(3),
        ]);
        $discount->products()->attach(Product::all());

        $discount->discountRecords()->create([
            'user_id' => 1,
            'order_id' => 1,
            'discount_id' => 1
        ]);
        $discount->discountRecords()->create([
            'user_id' => 1,
            'order_id' => 1,
            'discount_id' => 1
        ]);
        $discount->discountRecords()->create([
            'user_id' => 1,
            'order_id' => 1,
            'discount_id' => 1
        ]);
        $discount->discountRecords()->create([
            'user_id' => 1,
            'order_id' => 1,
            'discount_id' => 1
        ]);
        $discount->discountRecords()->create([
            'user_id' => 1,
            'order_id' => 1,
            'discount_id' => 1
        ]);
    }

    private function seedCompanies()
    {
        $json = \File::get(database_path() . '/companies.json');
        $data = json_decode($json, true, flags: JSON_UNESCAPED_UNICODE);

        foreach ($data as $item) {
            Company::create($item);
        }
    }

    private function seedIndices()
    {
        $json = \File::get(database_path() . '/indices.json');
        $data = json_decode($json, true, flags: JSON_UNESCAPED_UNICODE);

        foreach ($data as $item) {
            Index::create($item);
        }
    }

    private function seedReferral()
    {
        $referral = Referral::factory()->create([
            'user_id' => 1,
            'code' => rand(1000, 9999),
            'limit' => 10
        ]);
        $referral1 = Referral::factory()->create([
            'user_id' => 1,
            'code' => rand(1000, 9999),
            'limit' => 10
        ]);
        $referral2 = Referral::factory()->create([
            'user_id' => 1,
            'code' => rand(1000, 9999),
            'limit' => 10
        ]);

        $referral->usages()->create([
            'referral_id' => 1,
            'used_by' => 1,
            'signed_up' => 1,
            'has_bought' => 0
        ]);
        $referral->usages()->create([
            'referral_id' => 1,
            'used_by' => 5,
            'signed_up' => 1,
            'has_bought' => 0
        ]);
    }
}
