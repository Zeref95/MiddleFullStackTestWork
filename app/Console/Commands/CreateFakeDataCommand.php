<?php

namespace App\Console\Commands;

use App\Models\Lesson;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roles = Role::all();
         User::factory(2000)->create([
             'role_id' => $roles->where('slug', Role::ROLE_USER)->value('id'),
         ]);
        User::factory(4)->create([
            'role_id' => $roles->where('slug', Role::ROLE_ADMIN)->value('id'),
        ]);
        Lesson::factory(27)->create();

        return Command::SUCCESS;
    }
}
