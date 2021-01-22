<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function setTask(string $name): void
    {
        DB::table('users')->create(['name'=>$name]);
    }

    public function setUserStats(string $name,int $publicRepo, int $commitSum, int $issues, int $pullRequests, int $starSum, int $followers): void
    {
        DB::table('users')->where('name',$name)
        ->update([
            'public_repo'=>$publicRepo,
            'commit_sum'=>$commitSum,
            'issues'=>$issues,
            'pull_requests'=>$pullRequests,
            'star_sum'=>$starSum,
            'followers'=>$followers
            ]);
    }

    public function setUserRank(string $name,string $rank): void
    {
        DB::table('users')->where('name',$name)
        ->update([
            'user_rank'=>$rank
            ]);
    }
}
