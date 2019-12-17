<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);
// 头像假数据
    $avatars = [
              'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png',
              'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png',
              'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png',
              'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png',
              'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png',
              'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png',
];
        //make() 方法会将结果生成为 集合对象    each() 是 集合对象 提供的 方法，用来迭代集合中的内容并将其传递到回调函数中
        //use 是 PHP 中匿名函数提供的本地变量传递机制，匿名函数中必须通过 use 声明的引用，才能使用本地变量
        //makeVisible() 是 Eloquent 对象提供的方法，可以显示 User 模型 $hidden 属性里指定隐藏的字段，此操作确保入 库时数据库不会报错。
        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function ($user, $index)
            use ($faker, $avatars)
            {
                $user->avatar = $faker->randomElement($avatars);
            });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();
        // 插入到数据库中
        User::insert($user_array);
            // 单独处理第一个用户的数据
            $user = User::find(1);
            $user->name = 'Summer';
            $user->email = 'summer@example.com';
            $user->avatar = 'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png';
            $user->save();
    }
}
