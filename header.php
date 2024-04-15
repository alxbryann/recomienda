<!DOCTYPE html>
    <html>
    <style>
    input[type=text], select {
        width:40%;
        padding:12px 20px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type=submit] {
        width:20%;
        background-color: #4CAF50;
        color: white;
        padding:14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type=password], select {
        width:40%;
        padding:12px 20px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type=email], select {
        width:40%;
        padding:12px 20px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type=submit]:hover {
        background-color: #45a049;
    }

    div {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 300px;
    
    }
    
    </style>
        <head>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>    
            <title><?=$title ?? 'Inicio' ?></title>
        </head>
        <body>