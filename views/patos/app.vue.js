const AppTemplate = `
<div id="main">

  <div class='grid col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center'>
    <h2>Manutenção dos Patos</h2>
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
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Força</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Velocidade</span></div>
      <div class='col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2'><span>Inteligência</span></div>
      <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'><span>Descriçao</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Status</span></div>
      <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'><span>Possui Chip</span></div>
    </div>

    <div class='tbody'>
      <div v-if='dataSourceTable.length == 0' class='esportes' style='margin: 1% 0'>
        <span>Nenhum dado para carregar.</span>
      </div>
      <div v-else v-for='data in dataSourceTable' class='esportes' :id='(data.CODPATO)' @click='patoSelecionado(data)'>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.CODPATO}}</div>
        <div class='col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2'>{{data.NOME}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.FORCA}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.VELOCIDADE}}</div>
        <div class='col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2'>{{data.INTELIGENCIA}}</div>
        <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'>{{data.DESCRICAO}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.NOMESTATUS}}</div>
        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>{{data.POSSUI_CHIP}}</div>
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

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="forca" class="form-control-label">Força *</label>
              <input type="number" class="form-control" id="forca" placeholder=" " max='1' min='100' v-model='dados.FORCA'>
            </div>
          </div>

        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="velociodade" class="form-control-label">Velocidade *</label>
              <input type="number" class="form-control" id="velociodade" placeholder=" " max='1' min='100' v-model='dados.VELOCIDADE'>
            </div>
          </div>

          <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
            <div class="form-group">
              <label for="inteligencia" class="form-control-label">Inteligência *</label>
              <input type="number" class="form-control" id="inteligencia" placeholder=" " max='1' min='100' v-model='dados.INTELIGENCIA'>
            </div>
          </div>
        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>
            <div class="form-group">
              <label for="descricao" class="form-control-label">Descrição</label>
              <textarea class="form-control" id="descricao" rows="3" required v-model='dados.DESCRICAO'></textarea>
            </div>
          </div>
        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex flex-column justify-content-center'>
            <span>Selecione o Status do Pato *</span>
            <select class="form-select" aria-label="Situação" v-model='dados.CODSTATUS'>
              <option v-for='item in dataSourceStatus' :value="item.CODSTATUS"> {{item.NOME}} </option>
            </select>
          </div>
        </div>

        <div class='row' style='margin-top: 2%;'>
          <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex justify-content-center'>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="possui_chip" v-model='dados.POSSUI_CHIP'>
              <label class="form-check-label" for="possui_chip">Possui Chip?</label>
            </div>
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
      dataSourceStatus: [],
      patoManipulando: {},
      showModal: false,
      modalHeader: '',
      dados: {
        CODPATO: null,
        NOME: null,
        FORCA: null,
        VELOCIDADE: null,
        INTELIGENCIA: null,
        DESCRICAO: null,
        POSSUI_CHIP: true,
        CODSTATUS: null
      }
    }

  },
  methods: {
    getPatos() {
      axios.post(BASE + '/patos/getPatos')
      .then(resp => {
        this.dataSourceTable = resp.data;
      })
    },

    getStatus() {
      return new Promise((resolve, reject) => {
        axios.post( BASE + '/patos/getStatus' )
          .then(response => {
            resolve(response.data);
          })
          .catch(error => {
            reject(error); 
          });
      });
    },

    patoSelecionado(element) {
      // Verifica se tem um contato já selecionado para remover o estilo
      if (this.patoManipulando.CODPATO) {
        document.getElementById(this.patoManipulando.CODPATO).classList.remove('ItemSelecionado');
      }

      this.patoManipulando = element;

      document.getElementById(element.CODPATO).classList.add('ItemSelecionado');
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
          if (resp.code == 1) {
            this.dataSourceStatus = resp.data;
            return;
          }
        });

        return;
      }

      if (this.acao == 'Editar') {

        if (!this.patoManipulando.CODPATO) {
          alert('Por Favor, Selecione um registro.')
          return;
        }

        this.$refs.Modal.show();
        this.modalHeader = 'Editar';
        this.button = [
          {NOME: 'Salvar', action: this.Operacao, class: 'btn btn-outline-primary'},
          {NOME: 'Fechar', action: this.closeModal, class: 'btn btn-outline-danger'}
        ];

        this.dados.CODPATO = this.patoManipulando.CODPATO;
        this.dados.NOME = this.patoManipulando.NOME;
        this.dados.FORCA  = this.patoManipulando.FORCA;
        this.dados.VELOCIDADE = this.patoManipulando.VELOCIDADE;
        this.dados.INTELIGENCIA = this.patoManipulando.INTELIGENCIA;
        this.dados.DESCRICAO  = this.patoManipulando.DESCRICAO;
        this.dados.CODSTATUS  = this.patoManipulando.CODSTATUS;
        this.dados.POSSUI_CHIP  = this.patoManipulando.POSSUI_CHIP == 'S' ? true : false;

        console.log(this.patoManipulando)

        return;
      }

      if (this.acao == 'Excluir') {

        if (!this.patoManipulando.CODPATO) {
          alert('Por Favor, Selecione um registro.')
          return;
        }

        const msg = `Deseja excluir o Pato: ${this.patoManipulando.NOME} / Seq.: ${this.patoManipulando.CODPATO} ?`;
        
        if (!confirm(msg))
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

        if (!this.dados.FORCA || this.dados.FORCA < 1 || this.dados.FORCA > 100) {
          alert('Limete de Força de 1 a 100.');
          return;
        }

        if (!this.dados.VELOCIDADE || this.dados.VELOCIDADE < 1 || this.dados.VELOCIDADE > 100) {
          alert('Limete de Velocidade de 1 a 100.');
          return;
        }

        if (!this.dados.INTELIGENCIA || this.dados.INTELIGENCIA < 1 || this.dados.INTELIGENCIA > 100) {
          alert('Limete de Inteligência de 1 a 100.');
          return;
        }

        if (!this.dados.CODSTATUS) {
          alert('Por Favor, Selecione um status para o Pato.');
          return;
        }
      }

      axios.post(BASE + '/patos/Operacao', {'dados': this.dados, 'acao': this.acao} )
      .then(resp => {
        if (resp.data.code == 1) {
          this.getPatos();
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
    this.getPatos();
  }
});