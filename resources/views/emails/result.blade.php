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
        <div>{{ $result->public_repo }}</div>
        <div>{{ $result->commit_sum }}</div>
        <div>{{ $result->issues }}</div>
        <div>{{ $result->pull_requests }}</div>
        <div>{{ $result->star_sum }}</div>
        <div>{{ $result->followers }}</div>
        <div>{{ $result->user_rank }}</div>
    </body>

</html>
