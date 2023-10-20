# Documentação do projeto

- Introdução:
  
  O Sistema de Cadastro de Hospedeiros de Zumbis (SCHZ) é uma solução inovadora projetada para registrar e categorizar zumbis com base em suas preferências quando ainda eram humanos. 
  A ideia central é que os gostos musicais,  gosto por jogos e a paixão por esportes de um indivíduo quando vivo podem influenciar as características físicas e habilidades do zumbi resultante. 
  Com isso, o SCHZ visa entender e prever o potencial de força, velocidade e outros atributos que um zumbi pode possuir.

- Estrutura do Projeto:
  
    Projeto com estrutura MVC, em vue js
  
    Funções Principais do MVC em Vue:
  
    Models:
    Representam a estrutura de dados e a lógica de negócios.
    Contêm regras de validação e funções CRUD.
  
    Views:
    Responsáveis pela interface do usuário e visualização dos dados.
    Em Vue, as views geralmente são componentes .vue que contêm uma combinação de template, script e estilo.
  
    Controllers:
    Intermediam a comunicação entre Models e Views.
    Processam entradas do usuário, fazem as devidas interações com os Models e retornam a saída para as Views.
    Ao seguir essa estrutura MVC, o projeto se beneficia de uma separação clara de responsabilidades, facilitando a manutenção, escalabilidade e compreensão do código.
  
- Calculo feito para os status do hospedeiro (velocidade, força, etc.)

  -> * Por envolver esforço físico e ganho de resistência e por melhorar a auto-estima, aumenta tanto velocidade, força e inteligência.
    Caso idade < 18
    --> Caso para cada tipo de esporte que o hospedeiro praticar, faço aumento de 3% em força,velocidade e 4% em inteligência.
    Caso idade < 30 
    --> Caso para cada tipo de esporte que o hospedeiro praticar, faço aumento de 6% em força,velocidade e 6% em inteligência.
    Caso idade > 30 
    --> Caso para cada tipo de esporte que o hospedeiro praticar, faço aumento de 4% em força,velocidade e 5% em inteligência.
    Caso idade > 60
    --> Caso para cada tipo de esporte que o hospedeiro praticar, faço aumento de 2% em força,velocidade e 1% em inteligência.
  
  /* Caso o hospedeiro pratique pelo menos um esporte */
  
  -> * Por envolver mais raciocínio aumenta somente a inteligência.
    Caso idade < 18
    --> Caso para cada jogo que o hospedeiro 4% em inteligência.
    Caso idade < 30 
    --> Caso para cada jogo que o hospedeiro 6% em inteligência.
    Caso idade > 30 
    --> Caso para cada jogo que o hospedeiro 5% em inteligência.
    Caso idade > 60
    --> Caso para cada jogo que o hospedeiro 1% em inteligência.
  
  /* Caso o hospedeiro pratique pelo menos um genero de musical */
  -> * Por a dança envolver mais coordenção motora aumenta a velocidade ex:(QTD_GENERO_MUSICAL * (0.4)) e um pouco de força ex:(QTD_GENERO_MUSICAL * (0.4 /2))
    Caso idade < 18
    --> Caso para cada genero musical do hospedeiro 3% em velocidade e 1.5% em força.
    Caso idade < 30 
    --> Caso para cada genero musical do hospedeiro 5% em velocidade e 2.5% em força.
    Caso idade > 30 
    --> Caso para cada genero musical do hospedeiro 3% em velocidade e 1.5% em força.
    Caso idade > 60
    --> Caso para cada genero musical do hospedeiro 2% em velocidade e 1% em força.
    /* Como é calculado os atributos do hospedeiro */
  
  	Para cada item selecionado (Jogo Preferigo, Gosto Musical, Esportes Praticados) possúi os atributos pré definidos pelo sistema onde
  O usuário do sistema tem permissão para alterar esses atributos em Manutenção Esporte, Manutenção Gosto Musical ou Manutenção de Jogos,
  após isso é realizado uma média para definir os valores dos atributos.
  Ex: 
  								          Velocidade	  Força	   Inteligência 
  	-> Gosto Musical : 	        10		      59		  30
  	-> Pratica qual esporte: 		70		      50	  	39
  	-> Jogo preferido: 				  02		      02		  40
  	
  	Média -> Velocidade: (10+70+02)/3 = 27;
  	Média -> Força: (59+50+02)/3 = 37;
  	Média -> Inteligência: (30+39+40)/3 = 35;
  	
  	No exemplo ilustra uma base de com foi a logica para realizar o desafio.
  	Porém a conta pode ficar mais pois o Hospedeiro pode ter mais de um Gosto Musical, pode Pratica mais de um esporte e pode ter mais de
  um jogo preferido.
  
  /*Como é feito o calculo para definir a velocidade inicial antes de aplicar as condições de idade */
  
  	Para realizar a conta é realizado o IMC do hospedeiro /(X.PESO / (X.ALTURA * X.ALTURA)
  	Pós obiter o valor do IMC é verificado o quanto esse hospedeiro esta acima IMC saúdavel, então é pego essa informação em %
  		-> ((PESO / (ALTURA * ALTURA) - 29.9) / 29.9) * 100;
  	Depois de saber o quanto % esse hospedeiro está de seu IMC saudavel, é feita a conta com a média da velocidade para saber o quanto ela
  	recebe de buf;
  	MEDIA_VELOCIDADE - (MEDIA_VELOCIDADE * (ROUND(((PESO / (ALTURA * ALTURA) - 29.9) / 29.9) * 100))/100)
  	
  	
  /*Condições para pegar o zumbi */
  --> Para o zumbi são as mesmas das condições da idade e do IMC.
  --> O Pato é comparado com os atributos do zumbi para gerar a melhor rota de fuga e O sistema deverá equipar os patos com ataques que explorem os pontos fracos e eliminem os zumbis.

- Testes:
  
  Para fazer executar o teste no projeto, primeiro tem que criar as tabelas do banco. Ao abrir o código, na pasta config irá colocar todas as informações do banco que você
  acabou de criar, por exemplo criamos o projeto usando xammp, então na nossa URL colocamos o localhost “/” o caminho onde esta o projeto. Terá que alterar também o caminho
  na pasta “public/js/libs.js”, da mesma maneira que alterou na config. Depois disso é só ligar o xampp ou ligar oque foi escolhido por você, e abrir o localhost “/” o caminho do seu projeto. 

- Conclusão e Contato:
  
  Após um período de desenvolvimento intenso e meticuloso, temos o prazer de anunciar a conclusão do nosso Sistema MVC em Vue.js para o Cadastro de Hospedeiros de Zumbis. 
  Este projeto foi concebido com a visão de criar uma plataforma robusta e intuitiva para entender melhor as ameaças potenciais em um cenário pós-apocalíptico, categorizando 
  zumbis com base em suas preferências quando ainda eram humanos.
  
  Destaques do Projeto:
  
  Estrutura MVC Robusta: A implementação do padrão MVC (Model-View-Controller) no Vue.js garantiu uma arquitetura de software limpa e modular. 
  Isso facilita a escalabilidade do projeto, bem como futuras manutenções.
  
  Intuitividade do Usuário: Com uma interface de usuário bem projetada, o sistema é acessível até mesmo para indivíduos sem experiência técnica. 
  Cada componente da UI foi projetado pensando na usabilidade e na experiência do usuário.
  
  Análise Avançada: O sistema não apenas registra zumbis, mas também analisa suas habilidades potenciais. Esta análise aprofundada proporciona insights valiosos que podem ser 
  cruciais para estratégias de sobrevivência.
  
  Flexibilidade e Expansão: Com uma base sólida agora em vigor, existe um vasto potencial para expansão. Seja integrando com outras ferramentas, adicionando novos atributos 
  de zumbis ou implementando algoritmos de IA para previsões mais precisas.

/*---------------------------------------------------------------------------------------------------*/
Gostaríamos de expressar nossa profunda gratidão a todos os envolvidos neste projeto e, claro, aos colaboradores da empresa DSIN, que são a razão de todo nosso esforço.
Em um mundo onde a ameaça dos zumbis é real, nosso Sistema de Cadastro de Hospedeiros de Zumbis é mais do que apenas um software; é uma ferramenta vital para garantir a sobrevivência e prosperidade da humanidade. E estamos orgulhosos de fazer parte desta missão.
para entrar em contato conosco, envie-nos um e-mail: carloseduardotupa19@gmail.com, gabrielmirandaricardo@gmail.com
