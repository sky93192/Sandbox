<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Scroll project</title>
    <script>
        var offset = 0;
        var holdload = false;
        console.dir(window);
        console.dir(document);
        $(document).ready(function() {
            scrollLoad(8);
        });
        $(window).scroll(function () {
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 100) {
                scrollLoad(3);
            }
        })

        function scrollLoad(num) {
            if (!holdload) {
                var holder = {
                    'item_load': num, 'offset': offset
                };
                console.log(holder);
                holdload = true;
                $.ajax({
                    url: "api.php"
                    , type: "POST"
                    , data: holder
                    , dataType: "json"
                    , success: function (data) {
                        console.log(data);
                        for (var i = 0; i < data.content.length; i++) {
                            offset++;
                            var item = data.content[i];
                            var html = '<div class="article">' + item.id + ' ' + item.content + ' ' + item.date + ' </div>';
                            $('#main').append(html);
                        }
                        holdload = false;
                        if (data.content.length == 0) {
                            holdload = true;
                        }
                    }
                })
            }
        }
    </script>
    <style>
        .article {
            border: 1px solid black;
            margin: 0 auto;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div id="main"></div>
</body>
</html>