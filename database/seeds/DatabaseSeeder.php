<?php

use App\Category;
use App\Code;
use App\Dataset;
use App\User;
use App\Thread;
use App\Reply;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run ()
    {
        $images = [
            'https://kaggle2.blob.core.windows.net/datasets-images/1038/1883/50d921c031e8ee78408d431c30c0cdfc/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/310/684/3503c6c827ca269cc00ffa66f2a9c207/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/1043/1893/fcca99b3f795f30a0875cce2a971b196/dataset-thumbnail.png',
            'https://kaggle2.blob.core.windows.net/datasets-images/23/23/default-backgrounds/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/358/750/9f6e32bb96b7d8db72aa31a317c01ec8/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/815/1504/1a8fadfe0e523a49d40da5e4902803b2/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/1013/1830/64414f2cb16ad6882b989dbd9287ce34/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/893/1631/b233e76a75228c8362daf5ffd2ddd7d5/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/138/287/229bfb5d3dd1a49cc5ac899c45ca2213/dataset-thumbnail.png',
            'https://kaggle2.blob.core.windows.net/datasets-images/1016/1835/92cd32845bdba1870b331e71808bdbdd/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/63/141/e5591c2bbb5997993769650c8bf5ab79/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/1031/1871/ea012a8a686fcade20c5ca4952522676/dataset-thumbnail.png',
            'https://kaggle2.blob.core.windows.net/datasets-images/19/19/default-backgrounds/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/1026/1855/c5798b10623c348175e83b18ff8cfb14/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/128/270/d149695d1f9a97ec54cf673be6430ad7/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/1028/1864/102bca7c623c870b222d6d986fc0fd88/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/801/1483/0a5da3675b60c2b7605858ed45715c0c/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/306/666/d68d599bfe6995fa5772df1e82c4e83c/dataset-thumbnail.jpg',
            'https://kaggle2.blob.core.windows.net/datasets-images/284/617/f00b8c63f63ceb4b34d809447aa38e7e/dataset-thumbnail.jpeg',
            'https://kaggle2.blob.core.windows.net/datasets-images/740/1375/a89c95a0416a46f635e9b73a4b6abce8/dataset-thumbnail.jpg',
        ];

        if ( ! App\User::count()) {
            $users = create('App\User', [], 10);
        }

        $role = \App\Role::create([
            'name' => 'Admin'
        ]);

        User::first()->attachRole($role);

        for ($i = 0; $i <= 19; $i++) {
            $dataset = create('App\Dataset', ['user_id' => User::inRandomOrder()->first()->id]);
            try{ $dataset->addMediaFromUrl($images[$i])->toMediaCollection(); }catch(Exception $e) {}
        }

        create('App\Code', ['dataset_id' => function() { return Dataset::inRandomOrder()->first()->id; }, 'user_id' => function() { return User::inRandomOrder()->first()->id; }], 100);
        $names = ['General', 'Questions and Answers', 'News', 'Datasets', 'Code'];
        foreach($names as $name){
            create('App\Category', ['name' => $name]);
        }
        create('App\Thread', ['category_id' => function() { return Category::inRandomOrder()->first()->id; }, 'user_id' => function() { return User::inRandomOrder()->first()->id; }], 30);
        create('App\Reply', ['thread_id' => function() { return Thread::inRandomOrder()->first()->id; }, 'user_id' => function() { return User::inRandomOrder()->first()->id; }], 200);
    }
}
