const AppTemplate = `
<div id="main">

  <div class='grid col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center'>
    <h2>Hospedeiros</h2>
  </div>

  <div class='grid col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>

    <div class='headGrid'>
      <button type="button" @click='openModal("Novo")' class="btn btn-primary"><i class="fa-solid fa-plus fa-lg"></i>&nbsp&nbspAdicionar</button>
      <button type="button" @click='openModal("Editar")' class="btn btn-secondary"><i class="fa-solid fa-pen-to-square fa-lg"></i>&nbsp&nbspEditar</button>
      <button type="button" @click='openModal("Excluir")' class="btn btn-danger"><i class="fa-solid fa-trash fa-lg"></i>&nbsp&nbspExcluir</button>
    </div>

    <div class='thead'>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Sequência</span></div>
      <div class='col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2'><span>Nome</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Idade</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Sexo</span></div>
      <div class='col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2'><span>Peso</span></div>
      <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'><span>Altura</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Tipo Sangui.</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Status</span></div>
    </div>

    <div class='tbody'>
      <div v-if='dataSourceTable.length == 0' class='esportes' style='margin: 1% 0'>
        <span>Nenhum dado para carregar.</span>
      </div>
      <div v-else v-for='data in dataSourceTable' class='esportes' :id='(data.CODHOSPEDEIRO)' @click='hospedeiroSelecionado(data)'>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.CODHOSPEDEIRO}}</div>
        <div class='col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2'>{{data.NOME}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.IDADE}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.SEXO}}</div>
        <div class='col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2'>{{data.PESO}}</div>
        <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'>{{data.ALTURA}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.TIPO_SANGUINEO}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.NOMESTATUS}}</div>
      </div>
    </div>

  </div>

  <Modal ref='Modal' :width='800'>
    <h4 slot='header'>{{modalHeader}}</h4>

    <div slot='main'>
      <div>
        <div class='row'>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="nome" class="form-control-label">Nome *</label>
              <input type="text" class="form-control" id="nome" placeholder=" " v-model='dados.NOME'>
            </div>
          </div>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex flex-column justify-content-center'>
            <span>Selecione o Sexo do Hospedeiro *</span>
            <select class="form-select" aria-label="Sexo" v-model='dados.SEXO'>
              <option v-for='item in dataSourceSexo' :value="item.CODSEXO"> {{item.NOME}} </option>
            </select>
          </div>

        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="idade" class="form-control-label">Idade *</label>
              <input type="number" class="form-control" id="idade" placeholder=" " v-model='dados.IDADE'>
            </div>
          </div>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="peso" class="form-control-label">Peso(Kg) *</label>
              <input type="number" class="form-control" id="peso" placeholder=" " v-model='dados.PESO'>
            </div>
          </div>
        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="altura" class="form-control-label">Altura(m) *</label>
              <input type="number" class="form-control" id="altura" placeholder=" " v-model='dados.ALTURA'>
            </div>
          </div>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex flex-column justify-content-center'>
            <span>Selecione o Tipo Sanguíneo do Hospedeiro *</span>
            <select class="form-select" aria-label="Tipo Sanguíneo" v-model='dados.TIPO_SANGUINEO'>
              <option v-for='item in dataSourceTipoSanguineo' :value="item.NOME"> {{item.NOME}} </option>
            </select>
          </div>
        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex flex-column justify-content-center'>
            <span>Selecione o Status do Hospedeiro *</span>
            <select class="form-select" aria-label="Situação" v-model='dados.CODSTATUS'>
              <option v-for='item in dataSourceStatus' :value="item.CODSTATUS"> {{item.NOME}} </option>
            </select>
          </div>
        </div>

      </div>
    </div>

    <div slot='footer'>
      <div class='button'>
        <button type='button' v-for="b in button" :class='b.class' @click="b.action()">
          {{ b.NOME }}
        </button>
      </div>
    </div>

    </Modal>

</div>

`;

Vue.component("AppVue", {
  template: AppTemplate,
  data() {
    return {
      acao: '',
      button: '',
      dataSourceTable: [],
      dataSourceSexo: [{'CODSEXO': 0, 'NOME': 'Feminino'},{'CODSEXO': 1, 'NOME': 'Masculino'}],
      dataSourceTipoSanguineo: [{ "NOME": "A+" },{ "NOME": "A-" },{ "NOME": "B+" },{ "NOME": "B-" },{ "NOME": "AB+" },{ "NOME": "AB-" },{ "NOME": "O+" },{ "NOME": "O-" }],
      dataSourceStatus: [],
      hospedeiroManipulando: {},
      modalHeader: '',
      dados: {
        CODHOSPEDEIRO: null,
        NOME: null,
        SEXO: null,
        IDADE: null,
        PESO: null,
        ALTURA: null,
        TIPO_SANGUINEO: null,
        CODSTATUS: null
      }
    }

  },
  methods: {
    getHospedeiros() {
      axios.post(BASE + '/hospedeiro/getHospedeiros')
      .then(resp => {
        if (resp.data.code == 1) {
          this.dataSourceTable = resp.data.data;
          return;
        }
        this.dataSourceTable = [];
      })
    },

    getStatus() {
      return new Promise((resolve, reject) => {
        axios.post( BASE + '/hospedeiro/getStatus' )
          .then(response => {
            resolve(response.data);
          })
          .catch(error => {
            reject(error); 
          });
      });
    },

    hospedeiroSelecionado(element) {
      // Verifica se tem um contato já selecionado para remover o estilo
      if (this.hospedeiroManipulando.CODHOSPEDEIRO) {
        document.getElementById(this.hospedeiroManipulando.CODHOSPEDEIRO).classList.remove('ItemSelecionado');
      }

      this.hospedeiroManipulando = element;

      document.getElementById(element.CODHOSPEDEIRO).classList.add('ItemSelecionado');
    },

    openModal(acao) {
      this.acao = acao;

      if (this.acao == 'Novo') {

        this.$refs.Modal.show();
        this.modalHeader = 'Novo';
        this.button = [
          {NOME: 'Salvar', action: this.Operacao, class: 'btn btn-outline-primary'},
          {NOME: 'Fechar', action: this.closeModal, class: 'btn btn-outline-danger'}
        ];

        this.getStatus().then(resp => {
          console.log(resp)
          if (resp.code == 1) {
            this.dataSourceStatus = resp.data;
            return;
          }
        });

        return;
      }

      if (this.acao == 'Editar') {

        if (!this.hospedeiroManipulando.CODHOSPEDEIRO) {
          alert('Por Favor, Selecione um registro.')
          return;
        }

        this.$refs.Modal.show();
        this.modalHeader = 'Editar';
        this.button = [
          {NOME: 'Salvar', action: this.Operacao, class: 'btn btn-outline-primary'},
          {NOME: 'Fechar', action: this.closeModal, class: 'btn btn-outline-danger'}
        ];

        this.dados.CODHOSPEDEIRO = this.hospedeiroManipulando.CODHOSPEDEIRO;
        this.dados.NOME = this.hospedeiroManipulando.NOME;
        this.dados.IDADE  = this.hospedeiroManipulando.IDADE;
        this.dados.SEXO = this.hospedeiroManipulando.SEXO;
        this.dados.PESO = this.hospedeiroManipulando.PESO;
        this.dados.ALTURA  = this.hospedeiroManipulando.ALTURA;
        this.dados.TIPO_SANGUINEO = this.hospedeiroManipulando.TIPO_SANGUINEO;

        this.getStatus().then(resp => {
          console.log(resp)
          if (resp.code == 1) {
            this.dataSourceStatus = resp.data;
            return;
          }
        }).then(() => {this.dados.CODSTATUS = this.hospedeiroManipulando.CODSTATUS;});

        return;
      }

      if (this.acao == 'Excluir') {

        if (!this.hospedeiroManipulando.CODHOSPEDEIRO) {
          alert('Por Favor, Selecione um registro.')
          return;
        }

        this.dados.CODHOSPEDEIRO = this.hospedeiroManipulando.CODHOSPEDEIRO;

        const msg = `Deseja excluir o Hospedeiro: ${this.hospedeiroManipulando.NOME} / Seq.: ${this.hospedeiroManipulando.CODHOSPEDEIRO} ?`;
        
        if (confirm(msg))
          this.Operacao();
          this.getHospedeiros();
          return;
      }

    },

    Operacao() {
      
      if (this.acao == 'Editar' || this.acao == 'Novo') {
        // Valida campos obrigatorios
        if (!this.dados.NOME || this.dados.NOME < 5) {
          alert('Por Favor, Coloque um nome com mais de 5 caracteres.');
          return;
        }

        if (!this.dados.SEXO) {
          alert('Por Favor, Selecione um Sexo para o Hospedeiro.');
          return;
        }

        if (!this.dados.IDADE || this.dados.IDADE < 1) {
          alert('Por Favor, Coloque uma idade, a Idade não pode ser menor que 0.');
          return;
        }

        if (!this.dados.ALTURA || this.dados.ALTURA < 0 || this.dados.ALTURA > 3) {
          alert('A Altura tem que ser maior que 0 e tem um limite de 3 metros.');
          return;
        }

        if (!this.dados.TIPO_SANGUINEO) {
          alert('Por Favor, Selecione um Tipo Sanguíneo para o Hospedeiro.');
          return;
        }

        if (!this.dados.CODSTATUS) {
          alert('Por Favor, Selecione um Status para o Hospedeiro.');
          return;
        }
      }

      axios.post(BASE + '/hospedeiro/Operacao', {'dados': this.dados, 'acao': this.acao} )
      .then(resp => {
        if (resp.data.code == 1) {
          this.getHospedeiros();
          this.closeModal();
        }
        alert(resp.data.msg);
        return;
      })
    },

    limparCampos() {
      for (var campo in this.dados) {
        this.dados[campo] = null;
      }
      this.dados.POSSUI_CHIP = true;
      this.button = null;
      this.modalHeader = null;
    },

    closeModal() {
      this.$refs.Modal.hide();
      this.limparCampos();
    },
  },
  mounted: function(){
    this.getHospedeiros();
  }
});