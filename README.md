# Workflow - Symfony

Workflow symfony, um pacote para criar workflows que é surmpreendentemente simples e ao mesmo tempo versatil. Com poucas horas de estudo foi possivel imaginar diversas formas de implementação e casos de usos que não só ajudaria o dev a manter o codigo horganizado mas e aplicação bem organizada, mas também auxiliaria o usuário final com informações importantes sobre os processos que passam por várias etapas.

No meu estudo a idéa é usar o workflow, para acompanhar e garantir que o usuário cliente (customer) realmente passou pala confirmação de email e esta totalmente integrado ou não no sistema.

As transições e estatus forma pensadas para seguir o seguinte fluxo:
    Cadastro na plataforma -> Envio de email de bem vindo e confirmação de email -> Conta do novo cliete ativada -> Workflow Completo

Mas suponha-mos que ha usuários que estão criando várias contas atravé de bots ou programas automaticos, para algum tipo de fraude ou ataque ao sistema.

Através do workflow podemos identificar o estatus de cada usuário dentro desse fluxo de criação de conta, implementar diretrizes que ajudam a entender a fonte dos dados e em qual contexto estão sendo inseridos, de tal forma que seria possivel identificar um possivel problema e possibilitando que possa ser realizado algum tipo de alerta ao administrador do sistema para que o mesmo realize alguma ação manual como entrar em contado com o cliente e verificar se realmente ou falha no fluxo e gatantir o cadastro do cliente ou realizar bloqueio de ip dentro do dominio da aplicação para evitar novas interações.

Por exemplo se a nesse exemplo, adicionar um historico de estatus e transições, para que possa ser analizado o tempo médio que o cliente percorreu dentro desses fluxo e criar um alerta que os clientes que passaram por ele em menos de x minutos, devam ser visto como cadastros suspeitos e os que passam por o mesmo fluxo dentro da média esperada seja castro realmente validos e que automaticamente ficam disponiveis para uso imediato.

Em fim, o workflow realmente abre um leque de possibilidades para controle e consulta de fluxos, deixando na mão do dev usar todo o seu potencial e usa-lo da maneira que melhor auxilia o desenvolvimento ou gerenciamento do sistema.