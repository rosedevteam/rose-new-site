<?php

namespace Modules\User\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Arr;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Product\Models\Product;
use Modules\User\Models\Billing;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;
use Verta;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('view-users');
        $this->seo()->setTitle('کاربران');
        try {
            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');
            $role_id = request('role');
            $search = request('search');
            $count = request('count', 50);
            $wallet_balance = request('wallet_balance');
            $wallet_search_type = request('wallet_search_type');
            $from = request('from');
            $to = request('to');
            $exact = request('exact', false);
            $productQuery = request('products');
            $except_products = request('except_products');
            $orderType = request('orderType');
            $orderStatus = request('orderStatus');

            $products = Product::all();
            $roles = Role::all()->select('name', 'id');

            $users = User::with('roles');

            if ($role_id) {
                $users = $users->whereHas('roles', function ($query) use ($role_id) {
                    return $query->where('role_id', $role_id);
                });
            }
            if ($to) {
                $to2 = Verta::parseFormat('Y/m/d', $to)->toCarbon();
                $users = $users->where('created_at', '<=', $to2);
            }
            if ($from) {
                $from2 = Verta::parseFormat('Y/m/d', $from)->toCarbon();
                $users = $users->where('created_at', '>=', $from2);
            }
            if ($wallet_balance) {
                $users = $users->join('wallets', 'users.id', '=', 'wallets.user_id')
                    ->where('wallets.balance', $wallet_search_type, $wallet_balance)
                    ->select('users.*')
                    ->distinct();
            }
            if ($orderStatus) {
                $users = $users->join('orders', 'users.id', '=', 'orders.user_id')
                    ->where('orders.status', $orderStatus)
                    ->select('users.*')
                    ->distinct();
            }
            if ($orderType) {
                switch ($orderType) {
                    case 'has_orders':
                        $users = $users->whereHas('orders');
                        break;
                    case 'just_free_orders':
                        $users = $users->join('orders', 'users.id', '=', 'orders.user_id')
                            ->where('orders.price' , 0)
                            ->select('users.*')
                            ->distinct();
                        break;
                    case 'just_non_free_orders':
                        $users = $users->join('orders', 'users.id', '=', 'orders.user_id')
                            ->where('orders.price' , '>', 0)
                            ->select('users.*')
                            ->distinct();
                        break;
                    case 'without_orders':
                        $users = $users->whereDoesntHave('orders');
                        break;
                }
            }

            $users = $users->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
                ->when($orderStatus, function ($query) use ($orderStatus) {
                    return $query->where('orders.status', $orderStatus);
                })
                ->groupBy('users.id')
                ->select('users.*')
                ->distinct();

            if ($exact) {
                // todo check the queries
                $users = $users->whereIn('order_product.product_id', $productQuery)
                    ->groupBy('users.id')
                    ->havingRaw('COUNT(DISTINCT order_product.product_id) = ?', [count($productQuery)]);

            } else {

                $users = $users->when($except_products, function ($query) use ($except_products) {
                        $query->whereNotIn('order_product.product_id', $except_products);
                    })
                    ->when($productQuery, function ($query) use ($productQuery) {
                        $query->whereIn('order_product.product_id', $productQuery);
                    })
                    ->groupBy('users.id')
                    ->select('users.*')
                    ->distinct();
            }

            if ($search) {
                $users = $users->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            }

            $users = $users->orderBy($sort_by, $sort_direction);
            $users = $users->paginate($count)->withQueryString();

            return view('user::admin.index', compact(
                'users',
                'roles',
                'search',
                'sort_direction',
                'sort_by',
                'role_id',
                'count',
                'wallet_balance',
                'wallet_search_type',
                'products',
                'from',
                'to',
                'productQuery',
                'orderType',
                'except_products',
                'exact',
                'orderStatus'
            ));
        } catch (\Throwable $th) {
            dd($th->getMessage());
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        Gate::authorize('create-users');

        $data = $request->validate([
            'first_name' => 'bail|string|max:255',
            'last_name' => 'bail|nullable|string|max:255',
            "phone" => ['bail', 'required', 'string', 'unique:users,phone', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
        ]);

        try {

            $user = User::query()->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'creator_id' => auth()->user()->id,
            ]);

            $user->assignRole('مشتری');
            $after = Arr::except($user->toArray(), ['password']);

            self::log($user, compact('after'), 'ساخت کاربر');
            alert()->success("موفق", "کاربر با موفقیت ساخته شد");

            return redirect(route('admin.users.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function edit(User $user)
    {
        Gate::authorize('view-users');
        try {

            $orders = null;
            $billing = null;
            $roles = Role::all()->select('name', 'id');
            $canEdit = Gate::allows('update', $user);
            $canSetRole = Gate::allows('setRole', $user);
            $canDelete = Gate::allows('delete', $user);

            if (Gate::allows('view-orders')) {
                $orders = $user->orders()->orderByDesc('created_at')->get();
            }
            if (Gate::allows('view-billings')) {
                $billing = Billing::orderByDesc('created_at')->first();
            }

            return view('user::admin.edit', compact('user', 'orders', 'billing', 'roles', 'canEdit', 'canSetRole', 'canDelete'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(User $user)
    {
        Gate::authorize('update', $user);
        $userData = request()->validate([
            'first_name' => 'bail|nullable|string|max:255',
            'last_name' => 'bail|nullable|string|max:255',
            'email' => 'bail|nullable|string|email',
        ]);
        try {

            $billingData = null;
            $userData = array_filter($userData, function ($value) {
                return !is_null($value);
            });
            if (!is_null($billingData)) {
                $billingData = request()->validate([
                    'address' => 'bail|nullable|string|max:255',
                    'city' => 'bail|nullable|string|max:255',
                    'province' => 'bail|nullable|string|max:255',
                    'postal_code' => 'bail|nullable|string|digits:10',
                ]);
                $billingData = array_filter($billingData, function ($value) {
                    return !is_null($value);
                });
                $before = $user->billing()->first()->toArray();
                $user->billing()->update($billingData);
                $after = $user->billing()->first()->toArray();
                self::log($user, compact('after', 'before'), 'ویرایش اطلاعات صورتحساب کاربر');
            }

            $before = Arr::except($user->toArray(), ['password']);
            $user->update($userData);
            $after = Arr::except($user->toArray(), ['password']);

            self::log($user, compact('before', 'after'), 'ویرایش کاربر');
            alert()->success("موفق", "با موفقیت انجام شد");

            return redirect(route('admin.users.edit', $user));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);
        try {

            $before = Arr::except($user->toArray(), ['password']);
            $user->delete();

            self::log(null, compact('before'), 'حذف کاربر');
            alert()->success("موفق", "کاربر حذف شد");

            return redirect(route('admin.users.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function setRole(User $user)
    {
        Gate::authorize('setRole', $user);
        try {

            $data = request()->validate([
                'role_id' => 'bail|required|string|exists:roles,id',
            ]);
            $role = Role::where('id', $data['role_id'])->first()->name;
            if ($role == 'super-admin') {
                abort(403);
            }

            $before = $user->getRoleNames();
            $user->syncRoles($role);
            $after = $user->getRoleNames();

            self::log($user, compact('before', 'after'), 'ویرایش نقش');
            alert()->success('موفق', 'ویرایش نقش با موفقیت انجام شد');

            return back();
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
