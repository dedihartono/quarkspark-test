<?php
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCategory();
    }

    /**
     * create user role admin
     *
     * @return void
     */
    protected function createCategory()
    {
        $model = new \App\Category;
        $model->name = 'BOOK';
        $model->save();
    }
}
