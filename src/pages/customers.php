<h3> # Lista de Clientes </h3>

<table>

    <thead>

        <tr>

            <td> id </td>
            <td> name </td>
            <td> email </td>

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

<hr>

<form action="/customers/store" method="post">
    
    <label for="name">Nome:</label>
    <input name="name" id="name" placeholder="Nome do Cliente" type="text">
    <label for="email">Email:</label>
    <input name="email" id="email" placeholder="Email do Cliente" type="text">
    <button type="submit">Salvar</button>

</form>

<hr>

<a href="/">Workflows</a>