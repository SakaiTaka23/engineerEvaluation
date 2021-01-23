@component('mail::message')
# Results

<div>Thank You for using EngineerEvaluation!</div>
<div>The values are only from public repos</div>
<br>

# {{ $result->name }}
@component('mail::table')
| Element | Value |
| :-------------: |:-------------:|
| Public Repo | {{ $result->public_repo}} |
| Contributions | {{ $result->commit_sum }} |
| Issues | {{ $result->issues }} |
| Pull Requests | {{ $result->pull_requests }} |
| Star | {{ $result->star_sum }} |
| Followers | {{ $result->followers }} |
@endcomponent

@component('mail::panel')
Your Rank
{{ $result->user_rank }}
@endcomponent

〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜
<br>
Engineer Evaluation

Made by
<br>
SakaiTaka23
<br>
Repository
<br>
<a href='https://github.com/SakaiTaka23/engineerEvaluation'>https://github.com/SakaiTaka23/engineerEvaluation</a>
<br>
〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜
@endcomponent
