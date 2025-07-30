<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'imageUrl' => "https://scontent-vie1-1.xx.fbcdn.net/v/t39.30808-6/517366348_122121656876922841_5383574795104151275_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=VrNfbZsJz5UQ7kNvwGue1aN&_nc_oc=AdlxDNAPhg8DDWSdLiu08J0Twi7kGngNlXL-_D3gKi7P6N0As0Gi5tafyWC-gTFqQZU&_nc_zt=23&_nc_ht=scontent-vie1-1.xx&_nc_gid=LspooCGyWHfireGU1SAs9Q&oh=00_AfRC6FUHyEGiBTj2IDFgloZ7krqEBSlYL7pqQ1FhoOKWkQ&oe=689055CF",
            'title' => "Elso post",
            'text' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
        ]);

        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            Post::create([
                'imageUrl' => "https://placehold.co/500x200",
                'title' => $faker->sentence(4),
                'text' => $faker->paragraphs(3, true),
            ]);
        }
    }
}
