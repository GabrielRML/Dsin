const AppTemplate = `
	<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
		<div id='main' style='padding: 2%'>
			<div class='grid row text-center' style="margin-top: 15px;">
				<h2 class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>Localizar Pato</h2>
			</div>
			<div class='row' style="margin-bottom: 40px;">
				<div class='col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3'></div>
				<div class='col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex flex-column justify-content-center'>
					<span style="color: white;">Selecione o Pato *</span>
					<select class="form-select" aria-label="Situação" @change="event_select" v-model='input.PATO_LOCALIZADO'>
						<option v-for='x in patos' :value="x"> {{x.NOME}} </option>
					</select>
				</div>
				<div class='col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3'></div>
				<div v-if="input.PATO_LOCALIZADO != null && zumbiRandom.length > 0" class='col-12 col-sm-12 col-md-12 col-lg-12' style="margin-bottom: 20px;">
					<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center' style='margin: 2% 0'>
						<h4>Analise Realizada pelo Sistema de Chip</h4>
						<p v-html='this.analise()'></p>
					</div>

					<div class='row'>
						<div class="col-sm-12 col-md-2"></div>
						<div class="col-sm-12 col-md-4">
							<div id="card" style="background-color: rgb(2 6 23); border: 1px solid white;" class="card">
								<div  class="card-body row">
									<div style="color: white;" class="text-center"><b>Pato - Anas platyrhynchos</b></div>
									<div style="margin-top: 1%; margin-bottom: 2%;" class="text-center">
										<img src="${BASE}/public/images/pato.jpg" style="width: 200px;"/>
									</div>
									<div style="margin-top: -20px; color: white;">
										<p class="mt-4"> <b>Força: <span v-bind:class="{ classModoTurbo: modoTurbo }" >{{ input.PATO_LOCALIZADO.FORCA ?? '' }}</span></b></p>
									</div>
									<div style="margin-top: -20px; color: white;">
										<p class="mt-4"> <b>Velocidade: {{ input.PATO_LOCALIZADO.VELOCIDADE ?? '' }}</b></p>
									</div>
									<div style="margin-top: -20px; color: white;">
										<p class="mt-4"> <b>Inteligência: {{ input.PATO_LOCALIZADO.INTELIGENCIA ?? '' }}</b></p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-4">
							<div id="card" style="background-color: rgb(2 6 23); border: 1px solid white;" class="card">
								<div  class="card-body row">
									<div style="color: white;" class="text-center"><b>Zumbi</b></div>
									<div style="margin-top: 1%; margin-bottom: 2%;" class="text-center">
										<img src="${BASE}/public/images/img_zumbi.png" style="width: 213px;"/>
									</div>
									<div style="margin-top: -20px; color: white;">
										<p class="mt-4"> <b>Força: {{ zumbiRandom[0].FORCA }}</b></p>
									</div>
									<div style="margin-top: -20px; color: white;">
										<p class="mt-4"> <b>Velocidade: {{ zumbiRandom[0].VELOCIDADE }}</b></p>
									</div>
									<div style="margin-top: -20px; color: white;">
										<p class="mt-4"> <b>Inteligência: {{ zumbiRandom[0].INTELIGENCIA }}</b></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-2"></div>

					<div class='row col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>

						<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center' style='margin: 2% 0'>
							<h4>Ação Recomendada pelo Algoritimo do Sistema</h4>
							<p v-html='textAux'></p>
						</div>

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
			input: {
				PATO_LOCALIZADO: null
			},
			patos: [],
			zumbiRandom: [],
			modoTurbo: false,
			textAux: ''
		}
	},
	methods: {

		getPatos(){
			axios.post(BASE + "/localizar_pato/getPatos")
			.then((resp) => {
				if (resp.data.code == 1) {
					this.patos = resp.data.data;
					return;
				}
				if (resp.data.code == 0) {
					this.patos = [{'CODPATO': 0, 'NOME': 'Nenhum Registro Encontrado.'}];
					return;
				}
				this.patos = [];
			})
		},

		getRandomHospedeiro() {
			return new Promise ((resolve, reject) => {
				axios.post(BASE + '/localizar_pato/getRandomHospedeiro')
				.then(resp => {
					resolve(resp);
				})
				.catch(error => {
					reject(error); 
				  });
			})
		},

		event_select(args){
			console.log(args);
			if(args.type == "change"){
				if(!this.input.PATO_LOCALIZADO){
					return;
				} else {
					this.getRandomHospedeiro()
					.then(resp => {
						if (resp.data.code == 1) {
							this.zumbiRandom = resp.data.data;
						}
					})
					.then(() => {
						this.condicao();
					})
					return;
				}
			} else {
				return;
			}
		},

		analise() {

			let zumbiForca = this.zumbiRandom[0].FORCA;
			let zumbiVelocidade = this.zumbiRandom[0].VELOCIDADE;
			let zumbiInteligencia = this.zumbiRandom[0].INTELIGENCIA;

			let hopForca = this.input.PATO_LOCALIZADO.FORCA;
			let hopVelocidade = this.input.PATO_LOCALIZADO.VELOCIDADE;
			let hosInteligencia = this.input.PATO_LOCALIZADO.INTELIGENCIA;

			let text = 'O sistema está fazendo uma analise dos atributos dos Zumbi, identificando os pontos FORTES e FRACOS.';
			let pontosFortes = '';
			let pontosFracos = '';

			if (zumbiForca > hopForca) {
				pontosFortes = pontosFortes + 'O Zumbi possúi um nível de força superior a do Pato.</br>';
			} else if (zumbiForca < hopForca) {
				pontosFracos = pontosFracos + 'O Zumbi possúi um nível de força baixo, pode se explorar essa vantagem.</br>';
			}

			if (zumbiVelocidade > hopVelocidade) {
				pontosFortes = pontosFortes + 'O Zumbi possúi um nível de velocidade superior então correr não é uma boa opção.</br>';
			} else if (zumbiVelocidade < hopVelocidade) {
				pontosFracos = pontosFracos + 'O Zumbi possúi um nível de velocidade inferior, pode criar uma vantagem caso precise fugir.</br>';
			}

			if (zumbiInteligencia > hosInteligencia) {
				pontosFortes = pontosFortes + 'O Zumbi tem um nível de Inteligência elevado, um provável fan de jogos então ele pode ter estratégias escondidas.</br>';
			} else if (zumbiInteligencia < hosInteligencia) {
				pontosFracos = pontosFracos + 'O Zumbi tem um nível de Inteligencia baixo use isso para fazer Baiter e ele se perder.</br>';
			}

			return text + '</br>' + '<span style="color: red;">-> Pontos Fracos</span></br>' + (pontosFracos.length == 0 ? 'Nenhum ponto fraco encontrado TENHA BASTENTE CUIDADO COM A DECISÃO QUE TOMAR !!!</br>' : pontosFracos) + '<span style="color: red;">-> Pontos Fortes</span></br>' + (pontosFortes.length == 0 ? 'Nenhum ponto forte encontrado APROVEITE !!!' : pontosFortes);

		},

		condicao(){

			let zumbiForca = this.zumbiRandom[0].FORCA;
			let zumbiVelocidade = this.zumbiRandom[0].VELOCIDADE;
			let zumbiInteligencia = this.zumbiRandom[0].INTELIGENCIA;

			let hopForca = this.input.PATO_LOCALIZADO.FORCA;
			let hopVelocidade = this.input.PATO_LOCALIZADO.VELOCIDADE;
			let hopInteligencia = this.input.PATO_LOCALIZADO.INTELIGENCIA;

			// Verifica se o zumbi é mais perigoso
			if (zumbiForca > hopForca && zumbiVelocidade > hopVelocidade && zumbiInteligencia > hopInteligencia) {
				// correr e levantar voo
				this.textAux = 'Zumbi tem um nível muito acima do Pato ' + `<span style='color: blue;'>${this.input.PATO_LOCALIZADO.NOME}</span>` + ', ele esta ficando sem opções, sua única saída é Lenvantar Vôo !!!!<br>Volte para base para treinamento.';
				return;
			}

			// VELOCIDADE DO ZUMBI FOR MAIOR
			if(zumbiVelocidade > hopVelocidade){
				this.textAux = 'Zumbi ' +   `<span style='color: red;'>${this.zumbiRandom[0].NOME}</span>` + ' tem a Velocidade maior do que o Pato, para o Pato ' + `<span style='color: blue;'>${this.input.PATO_LOCALIZADO.NOME}</span>` + 'eliminar o Zumbi ' + `<span style='color: red;'>${this.zumbiRandom[0].NOME}</span>` + ', a sua única saída é MONTAR UMA ARMADILHA!!<br>Assim eliminando o Zumbi.';
				return;
				// montar armadilha
			}

			// FORÇA DO ZUMBI FOR MAIOR
			if(zumbiForca > hopForca){
				this.textAux = 'Zumbi tem a Força maior do que o Pato, para o Pato ' + `<span style='color: blue;'>${this.input.PATO_LOCALIZADO.NOME}</span>` + 'eliminar o Zumbi ' + `<span style='color: red;'>${this.zumbiRandom[0].NOME}</span>` + ', a sua única saída é ativar o MODO TURBOOOO!!!!<br>Duplicando a Força do Pato e eliminando o Zumbi.';
				this.input.PATO_LOCALIZADO.FORCA = parseInt(this.input.PATO_LOCALIZADO.FORCA) * 2;
				this.modoTurbo = true;
				return;
				// modo turbo
			}

			// INTELIGÊNCIA DO ZUMBI FOR MAIOR
			if(zumbiInteligencia > hopInteligencia){
				this.textAux = 'Zumbi tem a Inteligência maior do que o Pato, para o Pato ' + `<span style='color: blue;'>${this.input.PATO_LOCALIZADO.NOME}</span>` + 'eliminar o Zumbi ' + `<span style='color: red;'>${this.zumbiRandom[0].NOME}</span>` + ', a sua única saída é dar um TIRO NA CABEÇA!!!!<br>Assim eliminando o Zumbi.';
				return;
				// tiro na cabeça
			}

			// ZUMBI TOTALMENTE INFERIOR AO PATO
			if(zumbiForca < hopForca && zumbiVelocidade < hopVelocidade && zumbiInteligencia < hopInteligencia){
				this.textAux = 'Zumbi tem um nível muito abaixo do que o Pato, para o Pato ' + `<span style='color: blue;'>${this.input.PATO_LOCALIZADO.NOME}</span>` + ' eliminar o Zumbi ' + `<span style='color: red;'>${this.zumbiRandom[0].NOME}</span>` + ', basta QUEIMAR O ZUMBI!!!!<br>Assim eliminando o Zumbi.';
				return;
			}
		}
	}, 
	mounted() {
		this.getPatos();
	},
});