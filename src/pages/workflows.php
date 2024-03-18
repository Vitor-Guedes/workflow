<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workflows</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
   
    <div class="container mx-auto flex justify-around">
        <h2 class="text-3xl text-blue-700"> Workflows </h2>

        <a class="text-blue-700 no-underline hover:underline" href="/customers">Clientes</a>
    </div>

    <div class="container mx-auto mt-5">

        <table class="table-fixed w-full text-center">

            <thead class="border-b border-black">

                <tr>

                    <th> Id </th>
                    <th> Name </th>
                    <th> Status </th>
                    <th> Alvo </th>
                    <th> Alvo Id </th>
                    <th> Ações </th>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($workflows as $workflow) : ?>

                    <tr>

                        <?php $customWorkflow = $workflow->load($workflow->id) ?>

                        <?php foreach ($workflow->getAttributes() as $attribute) : ?>

                            <td> <?php echo in_array($attribute, ['status', 'subject_class']) ? $customWorkflow->{"{$attribute}Format"}() : $workflow->{$attribute} ?> </td>

                        <?php endforeach ; ?>

                        <td>
                            
                            <?php foreach ($customWorkflow->getAvaiableTransitions() as $transition) :  ?>
                                
                                <a class="text-blue-700 no-underline hover:underline" href="<?php echo $workflow->getUrlTransition($transition) ?>"> 
                                    <?php echo $customWorkflow->labels[$transition] ?> 
                                </a>
                                    
                            <?php endforeach ; ?>

                        </td>

                    </tr>

                <?php endforeach ; ?>

            </tbody>

        </table>

    </div>

   
</body>
</html>