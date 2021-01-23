<!DOCTYPE html>
<html lang='ja'>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <title>Document</title>
    </head>

    <body>
        <div>{{ $result->name }}</div>
        <div>{{ $reuslt->public_repo }}</div>
        <div>{{ $reuslt->commit_sum }}</div>
        <div>{{ $reuslt->issues }}</div>
        <div>{{ $reuslt->pull_requests }}</div>
        <div>{{ $reuslt->star_sum }}</div>
        <div>{{ $reuslt->followers }}</div>
        <div>{{ $reuslt->user_rank }}</div>
    </body>

</html>
