<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Device Not Registered!</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        html {
            background: #191919 -webkit-linear-gradient(top, #000 0%, #191919 100%) no-repeat;
            background: #191919 linear-gradient(to bottom, #000 0%, #191919 100%) no-repeat;
        }

        body {
            font-family: sans-serif;
            color: #FFF;
            text-align: center;
            font-size: 150%;
        }

        h1,
        h2 {
            font-weight: normal;
        }

        h1 {
            margin: 0 auto;
            padding: 0.15em;
            font-size: 10em;
            text-shadow: 0 2px 2px #000;
        }

        h2 {
            margin-bottom: 2em;
        }

        .btn-refresh {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-refresh:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>⚠</h1>
    <h2>The device you are using is not recognized.</h2>
    <p>Please contact management to fix this problem.</p>
    <button class="btn-refresh" onclick="reloadPage();">Try Again</button>
    <p class="desc">Your Device ID : {{ $device_id ?? '' }}</p>

</body>

</html>

<script>
    function reloadPage() {
        console.log("retryValidation");
        // window.location.reload();
    }
    // let macRegex = /([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})/g;
    // let text = 'My Wifi MAC Address is 2C:54:91:88:C9:E3 and my bluetooth MAC Address is 3D-F2-C9-A6-B3-4F';
    // let macPresent = macRegex.test(text);
    // let getMac = text.match(macRegex);

    // let colonOrHypenRegex = /[:-]/g;
    // let firstMacReplaced = getMac[0].replaceAll(colonOrHypenRegex, '');
    // console.log({
    //     macPresent,
    //     getMac,
    //     firstMacReplaced
    // })
</script>
