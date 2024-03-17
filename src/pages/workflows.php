<h3> # Dash - Workflows </h3>

<a href="/customers">Customers</a>

<table>

    <thead>

        <tr>

            <td> Id </td>
            <td> Name </td>
            <td> Status </td>
            <td> Subject </td>
            <td> Subject Id </td>
            <td> Actions </td>

        </tr>

    </thead>

    <tbody>

        <?php foreach ($workflows as $workflow) : ?>

            <tr>

                <?php foreach ($workflow->getAttributes() as $attribute) : ?>

                    <td> <?php echo $workflow->{$attribute} ?> </td>

                <?php endforeach ; ?>

                <td>
                    
                    <?php $customWorkflow = $workflow->load($workflow->id) ?>
                    <?php foreach ($customWorkflow->getAvaiableTransitions() as $transition) :  ?>
                        
                        <a href="<?php echo $workflow->getUrlTransition($transition) ?>"> 
                            <?php echo $customWorkflow->labels[$transition] ?> 
                        </a>
                            
                    <?php endforeach ; ?>

                </td>

            </tr>

        <?php endforeach ; ?>

    </tbody>

</table>