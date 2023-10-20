const AppTemplate = `
	<div class="control-section" id="forms-index" style="background-image: url(${BASE}/public/images/etapa_bonus.png)">
		<div class="col">
			<div>
				<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12 text-center" style="padding: 3% 0">
					<div class="row col-xs-12 col-sm-12 col-lg-12 col-md-12">
						<div class="col-xs-12 col-sm-6 col-lg-7 col-md-7"></div>
						<div class="col-xs-12 col-sm-4 col-lg-4 col-md-4 text-center">
							<div style="color: white; font-size: 16px;">
								O apocalipse zumbi é um tema popular na cultura contemporânea, explorando um cenário fictício onde uma epidemia misteriosa transforma pessoas em mortos-vivos. Esse pesadelo imagina um mundo em colapso, onde a sociedade é dominada pelo caos e pelo desespero. A luta pela sobrevivência se torna a única prioridade, à medida que os sobreviventes enfrentam constantemente zumbis famintos por carne humana.
								Nesse cenário pós-apocalíptico, os recursos são escassos, e a confiança é um bem raro. Grupos de sobreviventes se unem para defender suas vidas, muitas vezes fortificando locais para resistir aos ataques dos zumbis.
								Além do perigo iminente dos mortos-vivos, o apocalipse zumbi serve como uma metáfora para questões sociais e morais, explorando como a humanidade reagiria em face do colapso da civilização. Essas histórias oferecem uma visão intrigante da natureza humana sob pressão extrema e continuam a cativar a imaginação do público devido à tensão constante e à oportunidade de considerar como agiríamos em um mundo onde os mortos retornam para assombrar os vivos.
							</div>
						</div>
						<div class="col-xs-12 col-sm-2 col-lg-1 col-md-1"></div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12 text-center" style="padding: 3% 0">
					<div class="row col-xs-12 col-sm-12 col-lg-12 col-md-12" style="">
						<div class="col-xs-12 col-sm-1 col-lg-1 col-md-1"></div>
						<div class="col-xs-12 col-sm-6 col-lg-6 col-md-6" style="margin-top: 50px;">
							<div style="color: white; font-size: 16px;">
								O pato Anas platyrhynchos, conhecido como pato-mudo, é uma espécie de ave aquática comum em todo o mundo. 
								Com seu corpo robusto, pernas curtas e bico largo, é facilmente identificável. Sua plumagem varia de tons de marrom, verde e azul. 
								Notável por sua adaptabilidade, é encontrado em lagos, rios e áreas urbanas. 
								Ambos os sexos têm plumagem semelhante, mas os machos exibem cores vibrantes durante o acasalamento. 
								São aves migratórias que percorrem grandes distâncias para reprodução. 
								Desempenham um papel crucial nos ecossistemas aquáticos, dispersando sementes e controlando populações de insetos. 
								No entanto, a conservação de seus habitats é essencial para sua sobrevivência e para a diversidade da vida aquática.
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-lg-4 col-md-4 text-center" id="img_pato">
							<img src="${BASE}/public/images/pato.jpg" style="width: 400px;"/>
						</div>
						<div class="col-xs-12 col-sm-1 col-lg-1 col-md-1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
`;

/* ANOTAÇÕES
*/

Vue.component("AppVue", {
  template: AppTemplate,
  	data() {
    	return {
		}
	},
	methods: {
	}, 
	mounted() {
	},
});