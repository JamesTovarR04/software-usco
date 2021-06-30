<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Registro</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Hola {{ $name }}</h1>
    <h3>Queremos saber saber si perteneces a uno de nuestros programas.</h3>
    <p>Envianos la última cohorte que hayas matriculado en la universidad:</p>
    <input id="input-cohorte" type="number" name="cohorte" value="{{ $cohorte }}" />
    <button onclick="sendData()">Enviar</button>
    <script>
        const sendData = async () => {
            const cohorte = document.getElementById('input-cohorte').value;
            let response = await fetch('/api/myprogram?cohorte='+cohorte,{
                method: 'GET',
                credentials: 'same-origin',
                accept: 'application/json',
            })
            
            let status = response.status;
            switch (status) {
                case 200:
                    const data = await response.json();
                    alert('Tu programas es ' + data.Program);
                    window.location.href = "/student";
                break;
                case 422: alert('Ingresa la cohorte'); break;
                case 403: 
                    alert('No perteneces a los programas de software');
                    window.location.replace("/auth/logout"); break;
                break;
                default: alert('Ocurrió un error, intentalo de nuevo.'); break;
            }
        }
    </script>
</body>
</html>