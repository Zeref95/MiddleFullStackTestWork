<?php

namespace App\Console\Commands;

use App\Models\Lesson;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateFakeDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CreateFakeDataCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    private function generateUsers(int $count, string $roleSlug):void
    {
        User::factory($count)->create([
            'role_id' => Role::where('slug', $roleSlug)->value('id'),
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->generateUsers(2000, Role::ROLE_USER);
        $this->generateUsers(4, Role::ROLE_ADMIN);
        User::factory()->create([
            'role_id' => Role::where('slug', Role::ROLE_ADMIN)->value('id'),
            'email' => 'admin@admin.com',
        ]);

        Lesson::factory(27)->create();

        $lessons = Lesson::all()->pluck('id');
        foreach (User::ofRole(Role::ROLE_USER)->get() as $user) {
            $usersLessons = $lessons->shuffle()->slice(0, random_int(1,20));
            $user->lessons()->sync($usersLessons);
        }

        $this->info('Success');

        return Command::SUCCESS;
    }
}
