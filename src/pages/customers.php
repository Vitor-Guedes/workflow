<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <div class="container mx-auto flex justify-around">
        <h2 class="text-3xl text-blue-700"> Lista de Clientes </h2>

        <a class="text-blue-700 no-underline hover:underline" href="/">Workflows</a>
    </div>

    <div class="container mx-auto mt-5 flex justify-around">
        
        <form action="/customers/store" method="post">
            
            <div class="w-96 flex mb-2">
                <label class="w-32" for="name">Nome:</label>
                <input class="w-64 border p-1" name="name" id="name" placeholder="Nome do Cliente" type="text">
            </div>

            <div class="w-96 flex mb-2">
                <label class="w-32" for="email">Email:</label>
                <input class="w-64 border p-1" name="email" id="email" placeholder="Email do Cliente" type="text">
            </div>

            <div class="w-96 flex justify-center">
                <button class="rounded-md bg-blue-700 text-white p-2" type="submit">Salvar</button>
            </div>

        </form>

    </div>

    <div class="container mx-auto mt-5">

        <table class="table-fixed w-full text-center">

            <thead class="border-b border-black">

                <tr>

                    <th> Id </th>
                    <th> Nome </th>
                    <th> Email </th>

                </tr>


            </thead>

            <tbody>

                <?php foreach ($customers as $customer) : ?>

                    <tr>

                        <td> <?php echo $customer->id ?> </td>
                        <td> <?php echo $customer->name ?> </td>
                        <td> <?php echo $customer->email ?> </td>

                    </tr>

                <?php endforeach ; ?>

            </tbody>

        </table>

    </div>
</body>
</html>