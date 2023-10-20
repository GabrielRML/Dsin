const AppTemplate = `
	<div class="control-section">
		<div id="main">
			<div class='grid col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center' style="margin-top: 15px;">
				<h2 style="color: white;">Localizar Pato</h2>
			</div>
			<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row' style="margin-bottom: 40px;">
				<div class='col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3'></div>
				<div class='col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex flex-column justify-content-center'>
					<span style="color: white;">Selecione o Pato *</span>
					<select class="form-select" aria-label="Situação" @change="event_select" v-model='input.PATO_LOCALIZADO'>
						<option v-for='x in patos' :value="x"> {{x.NOME}} </option>
					</select>
				</div>
				<div class='col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3'</div>
			</div>
			<div v-if="seliciona_pato == '1'" class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row' style="margin-bottom: 20px;">
				<div class="col-sm-12 col-md-2"></div>
				<div class="col-sm-12 col-md-4">
					<div id="card" style="background-color: black; border: 1px solid white;" class="card">
						<div  class="card-body row">
							<div style="color: white;" class="text-center"><b>Pato - Anas platyrhynchos</b></div>
							<div style="margin-top: 1%; margin-bottom: 2%;" class="text-center">
								<img src="${BASE}public/images/pega_pato.jpg" style="width: 200px;"/>
							</div>
							<div style="margin-top: -20px; color: white;">
								<p class="mt-4"> <b>Força: {{ input.PATO_LOCALIZADO.FORCA ?? '' }}</b></p>
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
					<div id="card" style="background-color: black; border: 1px solid white;" class="card">
						<div  class="card-body row">
							<div style="color: white;" class="text-center"><b>Zumbi</b></div>
							<div style="margin-top: 1%; margin-bottom: 2%;" class="text-center">
								<img src="${BASE}public/images/img_zumbi.jpg" style="width: 213px;"/>
							</div>
							<div style="margin-top: -20px; color: white;">
								<p class="mt-4"> <b>Idade:</b></p>
							</div>
							<div style="margin-top: -20px; color: white;">
								<p class="mt-4"> <b>Peso:</b></p>
							</div>
							<div style="margin-top: -20px; color: white;">
								<p class="mt-4"> <b>Altura:</b></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-2"></div>
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
			seliciona_pato: '0'
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
      axios.post(BASE + '/localizar_pato/getRandomHospedeiro')
      .then(resp => {
        console.log(resp)
      })
    },

		event_select(args){
			console.log(args);
			if(args.type == "change"){
				if(this.input.PATO_LOCALIZADO == '0'){
					this.seliciona_pato = '0';
					return;
				} else {
					this.seliciona_pato = '1';
					this.condicao();
					return;
				}
			} else {
				this.seliciona_pato = '0';
				return;
			}
		},
		condicao(){
			console.log("aqui");
		}
	}, 
	mounted() {
		this.getPatos();
    this.getRandomHospedeiro();
	},
});