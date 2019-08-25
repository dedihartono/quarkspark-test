<?php
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
        $this->createUser();
    }

    /**
     * create user role user
     *
     * @return void
     */
    protected function createUser()
    {
        factory(App\User::class, 5)->create();
    }

    /**
     * create user role admin
     *
     * @return void
     */
    protected function createAdmin()
    {
        $model = new \App\User;
        $model->name = 'admin';
        $model->email = 'admin@example.com';
        $model->isAdmin = 1;
        $model->password = password_hash('123456', PASSWORD_BCRYPT);
        $model->remember_token = str_random(10);
        $model->save();
    }
}
