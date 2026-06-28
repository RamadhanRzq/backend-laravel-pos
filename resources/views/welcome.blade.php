<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RacaPoS</title>

    @php
        $quotes = [
            "Focus on your customers. Let RacaPoS handle the rest.",
            "Great businesses are built on great systems.",
            "Every transaction tells a story.",
            "Speed, accuracy, and simplicity.",
            "Small improvements every day lead to remarkable results.",
            "Empowering your business, one sale at a time.",
            "Success begins with organized operations.",
            "Behind every successful store is a reliable POS.",
            "Work smarter, sell faster.",
            "Efficiency is doing things right. Effectiveness is doing the right things."
        ];
    @endphp

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html,body{
            width:100%;
            height:100%;
            overflow:hidden;
            background:#ffffff;
            font-family:
                Inter,
                SF Pro Display,
                Helvetica Neue,
                Arial,
                sans-serif;
        }

        body{
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .container{
            width:100%;
            text-align:center;
            padding:40px;
        }

        .logo{
            font-weight:900;
            font-size:clamp(90px, 18vw, 260px);
            line-height:.9;
            letter-spacing:-8px;
            color:#111;
            user-select:none;
        }

        .quote{
            margin-top:42px;
            font-size:clamp(18px,1.5vw,28px);
            color:#777;
            font-style:italic;
            font-weight:300;
        }

        @media(max-width:768px){

            .logo{
                font-size:28vw;
                letter-spacing:-4px;
            }

            .quote{
                margin-top:28px;
                font-size:18px;
                padding:0 20px;
            }

        }
    </style>

</head>
<body>

<div class="container">

    <h1 class="logo">
        RacaPoS
    </h1>

    <p class="quote">
        "{{ $quotes[array_rand($quotes)] }}"
    </p>

</div>

</body>
</html>