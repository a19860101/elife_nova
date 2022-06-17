<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        $categories = \App\Models\Category::all();
        // $result = [];
    ?>
    @foreach($categories as $category)
    <?php $result = $category ?>
    {{$result->title}}
    {{$result->id}}
    @endforeach
</body>
</html>
